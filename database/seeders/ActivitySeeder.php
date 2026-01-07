<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a program first
        $program = Program::first();
        
        if (!$program) {
            $program = Program::create([
                'name' => 'Program Peningkatan Mutu Pendidikan',
                'description' => 'Program untuk meningkatkan kualitas pendidikan di sekolah',
                'status' => 'active',
                'created_by' => 1, // Super Admin
            ]);
        }

        // Get super admin user
        $superAdmin = \App\Models\User::where('role', 'super_admin')->first();
        if (!$superAdmin) {
            $superAdmin = \App\Models\User::find(1);
        }

        $activities = [
            [
                'program_id' => $program->id,
                'name' => 'Pelatihan Kurikulum Merdeka',
                'description' => 'Pelatihan implementasi Kurikulum Merdeka untuk guru dan kepala sekolah. Peserta akan mempelajari strategi pembelajaran yang berpusat pada siswa.',
                'batch' => 'Batch 1',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(33),
                'financing_type' => 'APBN',
                'apbn_type' => 'BOS Reguler',
                'registration_fee' => 0,
                'status' => 'planned',
                'created_by' => $superAdmin->id,
            ],
            [
                'program_id' => $program->id,
                'name' => 'Workshop Penilaian Autentik',
                'description' => 'Workshop tentang teknik penilaian autentik dan penyusunan instrumen penilaian yang efektif.',
                'batch' => 'Batch 2',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(47),
                'financing_type' => 'APBN',
                'apbn_type' => 'BOS Kinerja',
                'registration_fee' => 250000,
                'status' => 'planned',
                'created_by' => $superAdmin->id,
            ],
            [
                'program_id' => $program->id,
                'name' => 'Sosialisasi Standar Nasional Pendidikan',
                'description' => 'Sosialisasi mengenai standar nasional pendidikan dan implementasinya di sekolah.',
                'batch' => 'Batch 1',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(16),
                'financing_type' => 'APBN',
                'apbn_type' => 'DIPA',
                'registration_fee' => 0,
                'status' => 'planned',
                'created_by' => $superAdmin->id,
            ],
            [
                'program_id' => $program->id,
                'name' => 'Pelatihan Teknologi Pembelajaran',
                'description' => 'Pelatihan penggunaan teknologi dalam pembelajaran untuk meningkatkan engagement siswa.',
                'batch' => 'Angkatan 2024',
                'start_date' => Carbon::now()->addDays(60),
                'end_date' => Carbon::now()->addDays(64),
                'financing_type' => 'Non-APBN',
                'apbn_type' => null,
                'registration_fee' => 500000,
                'status' => 'planned',
                'created_by' => $superAdmin->id,
            ],
            [
                'program_id' => $program->id,
                'name' => 'Bimbingan Teknis Akreditasi Sekolah',
                'description' => 'Bimbingan teknis persiapan akreditasi sekolah dan pemenuhan standar akreditasi.',
                'batch' => 'Batch 3',
                'start_date' => Carbon::now()->addDays(20),
                'end_date' => Carbon::now()->addDays(22),
                'financing_type' => 'APBN',
                'apbn_type' => 'BOS Reguler',
                'registration_fee' => 150000,
                'status' => 'planned',
                'created_by' => $superAdmin->id,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
