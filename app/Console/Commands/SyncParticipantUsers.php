<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Registration;
use App\Models\TeacherParticipant;
use App\Models\ParticipantMapping;

class SyncParticipantUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'participants:sync-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync user_id to teacher_participants and registrations, then create participant_mappings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting user synchronization...');

        // Step 1: Sync TeacherParticipants with Users
        $this->info('Syncing teacher participants with users...');
        $teachersSynced = $this->syncTeacherParticipants();
        $this->info("Synced {$teachersSynced} teacher participants with user accounts");

        // Step 2: Sync Kepala Sekolah with Users
        $this->info('Syncing kepala sekolah with users...');
        $kepalaSekolahSynced = $this->syncKepalaSekolah();
        $this->info("Synced {$kepalaSekolahSynced} kepala sekolah with user accounts");

        // Step 3: Create ParticipantMappings for assigned classes
        $this->info('Creating participant mappings for assigned classes...');
        $mappingsCreated = $this->createParticipantMappings();
        $this->info("Created {$mappingsCreated} new participant mappings");

        $this->info('Synchronization completed successfully!');

        return Command::SUCCESS;
    }

    /**
     * Sync teacher participants with users based on email or NIK
     */
    private function syncTeacherParticipants()
    {
        $synced = 0;

        // Get all teacher participants without user_id
        $teachers = TeacherParticipant::whereNull('user_id')->with('registration')->get();

        foreach ($teachers as $teacher) {
            $user = null;

            // Try to find user by email first
            if ($teacher->email) {
                $user = User::where('email', $teacher->email)->first();
            }

            // If not found by email, try by NIK
            if (!$user && $teacher->nik) {
                $user = User::where('nik', $teacher->nik)->first();
            }

            // Update teacher_participant with user_id if found
            if ($user) {
                $teacher->update(['user_id' => $user->id]);

                // Update user with location data from registration if available and user doesn't have it
                if ($teacher->registration && !$user->province) {
                    $user->update([
                        'province' => $teacher->registration->provinsi,
                        'city' => $teacher->registration->kab_kota,
                        'district' => $teacher->registration->kecamatan,
                        'instansi' => $teacher->registration->nama_sekolah,
                        'alamat_sekolah' => $teacher->registration->alamat_sekolah,
                    ]);
                }

                $synced++;
            }
        }

        return $synced;
    }

    /**
     * Sync kepala sekolah with users based on email or NIK
     */
    private function syncKepalaSekolah()
    {
        $synced = 0;

        // Get all registrations with kepala sekolah but without kepala_sekolah_user_id
        $registrations = Registration::whereNull('kepala_sekolah_user_id')
            ->where('jumlah_kepala_sekolah', '>', 0)
            ->get();

        foreach ($registrations as $registration) {
            $user = null;

            // Try to find user by email first
            if ($registration->email) {
                $user = User::where('email', $registration->email)->first();
            }

            // If not found by email, try by NIK
            if (!$user && $registration->nik_kepala_sekolah) {
                $user = User::where('nik', $registration->nik_kepala_sekolah)->first();
            }

            // Update registration with kepala_sekolah_user_id if found
            if ($user) {
                $registration->update(['kepala_sekolah_user_id' => $user->id]);

                // Update user with location data from registration if available and user doesn't have it
                if (!$user->province) {
                    $user->update([
                        'province' => $registration->provinsi,
                        'city' => $registration->kab_kota,
                        'district' => $registration->kecamatan,
                        'instansi' => $registration->nama_sekolah,
                        'alamat_sekolah' => $registration->alamat_sekolah,
                    ]);
                }

                $synced++;
            }
        }

        return $synced;
    }

    /**
     * Create participant mappings for teachers and kepala sekolah in assigned classes
     */
    private function createParticipantMappings()
    {
        $created = 0;

        // Get first super admin as assigned_by default
        $superAdmin = User::where('role', 'super_admin')->first();
        $assignedBy = $superAdmin ? $superAdmin->id : 1;

        // Get all registrations that are assigned to a class
        $assignedRegistrations = Registration::whereNotNull('class_id')
            ->with('teacherParticipants')
            ->get();

        foreach ($assignedRegistrations as $registration) {
            $classId = $registration->class_id;

            // Create mapping for kepala sekolah if they have user_id
            if ($registration->kepala_sekolah_user_id) {
                $exists = ParticipantMapping::where('class_id', $classId)
                    ->where('participant_id', $registration->kepala_sekolah_user_id)
                    ->exists();

                if (!$exists) {
                    ParticipantMapping::create([
                        'class_id' => $classId,
                        'participant_id' => $registration->kepala_sekolah_user_id,
                        'enrolled_date' => now(),
                        'assigned_by' => $assignedBy,
                        'status' => 'in',
                    ]);
                    $created++;
                }
            }

            // Create mappings for all teachers in this registration
            foreach ($registration->teacherParticipants as $teacher) {
                if ($teacher->user_id) {
                    $exists = ParticipantMapping::where('class_id', $classId)
                        ->where('participant_id', $teacher->user_id)
                        ->exists();

                    if (!$exists) {
                        ParticipantMapping::create([
                            'class_id' => $classId,
                            'participant_id' => $teacher->user_id,
                            'enrolled_date' => now(),
                            'assigned_by' => $assignedBy,
                            'status' => 'in',
                        ]);
                        $created++;
                    }
                }
            }
        }

        return $created;
    }
}
