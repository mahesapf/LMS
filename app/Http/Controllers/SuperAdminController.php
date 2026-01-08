<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Activity;
use App\Models\AdminMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_admins' => User::where('role', 'admin')->count(),
            'total_fasilitators' => User::where('role', 'fasilitator')->count(),
            'total_participants' => User::where('role', 'peserta')->count(),
            'total_programs' => Program::count(),
            'total_activities' => Activity::count(),
        ];
        
        return view('super-admin.dashboard', compact('stats'));
    }

    // User Management
    public function users(Request $request)
    {
        $role = $request->get('role', 'all');
        
        $query = User::where('role', '!=', 'super_admin');
        
        if ($role !== 'all') {
            $query->where('role', $role);
        }
        
        $users = $query->latest()->paginate(20);
        
        return view('super-admin.users.index', compact('users', 'role'));
    }

    public function createUser()
    {
        return view('super-admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,fasilitator,peserta',
            'nik' => 'nullable|size:16|regex:/^[0-9]{16}$/',
            'gelar' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:20',
            'email_belajar_id' => 'nullable|email',
            'jabatan' => 'nullable|string|max:255',
            'nip_nipy' => 'nullable|string|max:50',
            'pangkat' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:20',
            'npsn' => 'nullable|string|max:20',
            'instansi' => 'nullable|string|max:255',
            'kcd' => 'nullable|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'provinsi_peserta' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'alamat_lengkap' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|in:SMA/SMK,D3,S1,S2,S3',
            'jurusan' => 'nullable|string|max:255',
            'foto_3x4' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'surat_tugas' => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:png|max:1024',
        ]);

        // Handle file uploads
        if ($request->hasFile('foto_3x4')) {
            $validated['foto_3x4'] = $request->file('foto_3x4')->store('peserta/foto', 'public');
        }

        if ($request->hasFile('surat_tugas')) {
            $validated['surat_tugas'] = $request->file('surat_tugas')->store('peserta/surat-tugas', 'public');
        }

        if ($request->hasFile('tanda_tangan')) {
            $validated['tanda_tangan'] = $request->file('tanda_tangan')->store('peserta/tanda-tangan', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'active';

        User::create($validated);

        return redirect()->route('super-admin.users')->with('success', 'User berhasil dibuat');
    }

    public function editUser(User $user)
    {
        return view('super-admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,fasilitator,peserta',
            'status' => 'required|in:active,suspended,inactive',
            'nik' => 'nullable|size:16|regex:/^[0-9]{16}$/',
            'gelar' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:20',
            'email_belajar_id' => 'nullable|email',
            'jabatan' => 'nullable|string|max:255',
            'nip_nipy' => 'nullable|string|max:50',
            'pangkat' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:20',
            'npsn' => 'nullable|string|max:20',
            'instansi' => 'nullable|string|max:255',
            'kcd' => 'nullable|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'provinsi_peserta' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'alamat_lengkap' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|in:SMA/SMK,D3,S1,S2,S3',
            'jurusan' => 'nullable|string|max:255',
            'foto_3x4' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'surat_tugas' => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:png|max:1024',
        ]);

        // Handle file uploads
        if ($request->hasFile('foto_3x4')) {
            // Delete old file if exists
            if ($user->foto_3x4) {
                Storage::disk('public')->delete($user->foto_3x4);
            }
            $validated['foto_3x4'] = $request->file('foto_3x4')->store('peserta/foto', 'public');
        }

        if ($request->hasFile('surat_tugas')) {
            // Delete old file if exists
            if ($user->surat_tugas) {
                Storage::disk('public')->delete($user->surat_tugas);
            }
            $validated['surat_tugas'] = $request->file('surat_tugas')->store('peserta/surat-tugas', 'public');
        }

        if ($request->hasFile('tanda_tangan')) {
            // Delete old file if exists
            if ($user->tanda_tangan) {
                Storage::disk('public')->delete($user->tanda_tangan);
            }
            $validated['tanda_tangan'] = $request->file('tanda_tangan')->store('peserta/tanda-tangan', 'public');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('super-admin.users')->with('success', 'User berhasil diupdate');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('super-admin.users')->with('success', 'User berhasil dihapus');
    }

    public function suspendUser(User $user)
    {
        $user->update(['status' => 'suspended']);
        return redirect()->back()->with('success', 'User berhasil disuspend');
    }

    public function activateUser(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', 'User berhasil diaktifkan');
    }

    public function importUsers()
    {
        return view('super-admin.users.import');
    }

    public function processImportUsers(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'role' => 'required|in:admin,fasilitator,peserta',
        ]);

        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file));
        $header = array_shift($data);
        
        // Normalize header names (lowercase, remove spaces)
        $header = array_map(function($h) {
            $h = trim($h);
            $h = str_replace(['"', "'"], '', $h); // Remove quotes
            $h = strtolower($h);
            $h = str_replace(' ', '_', $h); // Replace space with underscore
            
            // Handle common variations
            if (in_array($h, ['nama', 'nama_lengkap', 'name'])) return 'nama_lengkap';
            if (in_array($h, ['nik', 'nip'])) return 'nik';
            if (in_array($h, ['email', 'e-mail'])) return 'email';
            
            return $h;
        }, $header);

        DB::beginTransaction();
        try {
            $imported = 0;
            $skipped = 0;
            
            foreach ($data as $row) {
                if (empty(array_filter($row))) continue; // Skip empty rows
                
                $rowData = array_combine($header, $row);
                
                // Clean data
                $nama = trim($rowData['nama_lengkap'] ?? '');
                $email = trim($rowData['email'] ?? '');
                $nik = trim($rowData['nik'] ?? '');
                
                // Skip if nama is empty, dash, or email is empty
                if (empty($nama) || $nama === '-' || empty($email)) {
                    $skipped++;
                    continue;
                }
                
                // Check if email already exists
                if (User::where('email', $email)->exists()) {
                    $skipped++;
                    continue;
                }
                
                // Skip if NIK is just dash or invalid format
                if ($nik === '-' || $nik === '0') {
                    $nik = null;
                }
                
                // Validate NIK if provided (should be 16 digits)
                if ($nik && strlen($nik) != 16) {
                    $nik = null; // Set to null if not 16 digits
                }
                
                // Use NIK as password, or default to 'password123' if NIK is empty
                $password = $nik ? $nik : 'password123';
                
                User::create([
                    'name' => $nama,
                    'email' => $email,
                    'nik' => $nik,
                    'password' => Hash::make($password),
                    'role' => $request->role,
                    'status' => 'active',
                ]);
                $imported++;
            }
            
            DB::commit();
            
            $message = "Import berhasil: {$imported} pengguna ditambahkan";
            if ($skipped > 0) {
                $message .= ", {$skipped} data dilewati (email sudah terdaftar atau data tidak lengkap)";
            }
            
            return redirect()->route('super-admin.users')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    // Program Management
    public function programs()
    {
        $programs = Program::with('creator')->latest()->paginate(20);
        return view('super-admin.programs.index', compact('programs'));
    }

    public function createProgram()
    {
        return view('super-admin.programs.create');
    }

    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $validated['created_by'] = auth()->id();

        Program::create($validated);

        return redirect()->route('super-admin.programs')->with('success', 'Program berhasil dibuat');
    }

    public function editProgram(Program $program)
    {
        return view('super-admin.programs.edit', compact('program'));
    }

    public function updateProgram(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $program->update($validated);

        return redirect()->route('super-admin.programs')->with('success', 'Program berhasil diupdate');
    }

    public function deleteProgram(Program $program)
    {
        $program->delete();
        return redirect()->route('super-admin.programs')->with('success', 'Program berhasil dihapus');
    }

    // Activity Management
    public function activities()
    {
        $activities = Activity::with(['program', 'creator'])->latest()->paginate(20);
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return view('super-admin.activities.index', compact('activities', 'routePrefix'));
    }

    public function createActivity()
    {
        $programs = Program::where('status', 'active')->get();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return view('super-admin.activities.create', compact('programs', 'routePrefix'));
    }

    public function storeActivity(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch' => 'nullable|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'funding_source' => 'nullable|in:DIPA,PNBP,APBD,BOS,Other',
            'funding_source_other' => 'nullable|required_if:funding_source,Other|string|max:255',
            'status' => 'required|in:planned,ongoing,completed,cancelled',
        ]);

        $validated['created_by'] = auth()->id();

        Activity::create($validated);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.activities')->with('success', 'Kegiatan berhasil dibuat');
    }

    public function editActivity(Activity $activity)
    {
        $programs = Program::where('status', 'active')->get();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return view('super-admin.activities.edit', compact('activity', 'programs', 'routePrefix'));
    }

    public function updateActivity(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch' => 'nullable|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'funding_source' => 'nullable|in:DIPA,PNBP,APBD,BOS,Other',
            'funding_source_other' => 'nullable|required_if:funding_source,Other|string|max:255',
            'status' => 'required|in:planned,ongoing,completed,cancelled',
        ]);

        $activity->update($validated);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.activities')->with('success', 'Kegiatan berhasil diupdate');
    }

    public function deleteActivity(Activity $activity)
    {
        $activity->delete();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.activities')->with('success', 'Kegiatan berhasil dihapus');
    }

    // Admin Mapping
    public function adminMappings()
    {
        $mappings = AdminMapping::with(['admin', 'program', 'activity', 'assignedBy'])->latest()->paginate(20);
        return view('super-admin.admin-mappings.index', compact('mappings'));
    }

    public function createAdminMapping()
    {
        $admins = User::where('role', 'admin')->where('status', 'active')->get();
        $programs = Program::where('status', 'active')->get();
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])->get();
        
        return view('super-admin.admin-mappings.create', compact('admins', 'programs', 'activities'));
    }

    public function storeAdminMapping(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'activity_id' => 'nullable|exists:activities,id',
            'status' => 'required|in:in,out',
            'assigned_date' => 'nullable|date',
        ]);

        $validated['assigned_by'] = auth()->id();

        if ($validated['status'] === 'out') {
            $validated['removed_date'] = now();
        }

        AdminMapping::create($validated);

        return redirect()->route('super-admin.admin-mappings')->with('success', 'Admin mapping berhasil dibuat');
    }

    public function updateAdminMappingStatus(AdminMapping $mapping, $status)
    {
        $mapping->update([
            'status' => $status,
            'removed_date' => $status === 'out' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Status mapping berhasil diupdate');
    }

    // Class Management
    public function classes(Request $request)
    {
        $query = \App\Models\Classes::with(['activity', 'creator']);
        
        if ($request->has('activity_id')) {
            $query->where('activity_id', $request->activity_id);
        }
        
        $classes = $query->latest()->paginate(20);
        $activities = Activity::all();
        
        // Detect route prefix based on user role
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        
        return view('super-admin.classes.index', compact('classes', 'activities', 'routePrefix'));
    }

    public function createClass()
    {
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])->get();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return view('super-admin.classes.create', compact('activities', 'routePrefix'));
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:open,closed,completed',
        ]);

        $validated['created_by'] = auth()->id();

        \App\Models\Classes::create($validated);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index')->with('success', 'Kelas berhasil dibuat');
    }

    public function editClass(\App\Models\Classes $class)
    {
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])->get();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return view('super-admin.classes.edit', compact('class', 'activities', 'routePrefix'));
    }

    public function updateClass(Request $request, \App\Models\Classes $class)
    {
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:open,closed,completed',
        ]);

        $class->update($validated);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index')->with('success', 'Kelas berhasil diupdate');
    }

    public function deleteClass(\App\Models\Classes $class)
    {
        $class->delete();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index')->with('success', 'Kelas berhasil dihapus');
    }

    public function showClass(\App\Models\Classes $class)
    {
        $class->load(['activity', 'participantMappings.participant', 'fasilitatorMappings.fasilitator']);
        
        // Get validated participants for this activity who are not yet in any class
        $availableParticipants = \App\Models\User::where('role', 'peserta')
            ->where('status', 'active')
            ->whereHas('registrations', function($query) use ($class) {
                $query->where('activity_id', $class->activity_id)
                    ->where('status', 'validated')
                    ->whereNull('class_id');
            })
            ->get();
        
        // Get available fasilitators (who are not yet in this class)
        $availableFasilitators = \App\Models\User::where('role', 'fasilitator')
            ->where('status', 'active')
            ->whereDoesntHave('fasilitatorMappings', function($query) use ($class) {
                $query->where('class_id', $class->id)
                    ->where('status', 'in');
            })
            ->get();
        
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        
        return view('super-admin.classes.show', compact('class', 'availableParticipants', 'availableFasilitators', 'routePrefix'));
    }

    public function removeParticipant(\App\Models\Classes $class, \App\Models\ParticipantMapping $participant)
    {
        // Update registration to remove class_id
        \App\Models\Registration::where('user_id', $participant->participant_id)
            ->where('class_id', $class->id)
            ->update(['class_id' => null]);
        
        // Delete participant mapping
        $participant->delete();
        
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.show', $class)
            ->with('success', 'Peserta berhasil dikeluarkan dari kelas');
    }

    public function assignParticipantToClass(Request $request, \App\Models\Classes $class)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:users,id',
        ]);

        // Check if participant is already in a class for this activity
        $existingMapping = \App\Models\ParticipantMapping::where('participant_id', $validated['participant_id'])
            ->whereHas('class', function($query) use ($class) {
                $query->where('activity_id', $class->activity_id);
            })
            ->first();

        if ($existingMapping) {
            return redirect()->back()->with('error', 'Peserta sudah terdaftar di kelas lain untuk kegiatan ini');
        }

        // Update registration with class_id
        \App\Models\Registration::where('user_id', $validated['participant_id'])
            ->where('activity_id', $class->activity_id)
            ->where('status', 'validated')
            ->update(['class_id' => $class->id]);

        // Create participant mapping
        \App\Models\ParticipantMapping::create([
            'class_id' => $class->id,
            'participant_id' => $validated['participant_id'],
            'enrolled_date' => now(),
            'assigned_by' => auth()->id(),
            'status' => 'active',
        ]);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.show', $class)
            ->with('success', 'Peserta berhasil ditambahkan ke kelas');
    }

    public function assignFasilitatorToClass(Request $request, \App\Models\Classes $class)
    {
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        
        try {
            $validated = $request->validate([
                'fasilitator_id' => 'required|exists:users,id',
            ]);

            // Check if fasilitator is already in this class
            $existingMapping = \App\Models\FasilitatorMapping::where('fasilitator_id', $validated['fasilitator_id'])
                ->where('class_id', $class->id)
                ->where('status', 'in')
                ->first();

            if ($existingMapping) {
                return redirect()->route($routePrefix . '.classes.show', $class)
                    ->with('error', 'Fasilitator sudah terdaftar di kelas ini');
            }

            // Create fasilitator mapping
            \App\Models\FasilitatorMapping::create([
                'class_id' => $class->id,
                'fasilitator_id' => $validated['fasilitator_id'],
                'assigned_date' => now(),
                'assigned_by' => auth()->id(),
                'status' => 'in',
            ]);

            return redirect()->route($routePrefix . '.classes.show', $class)
                ->with('success', 'Fasilitator berhasil ditambahkan ke kelas');
                
        } catch (\Exception $e) {
            return redirect()->route($routePrefix . '.classes.show', $class)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function removeFasilitatorFromClass(\App\Models\Classes $class, \App\Models\FasilitatorMapping $fasilitator)
    {
        // Update status to out and set removed date
        $fasilitator->update([
            'status' => 'out',
            'removed_date' => now(),
        ]);
        
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.show', $class)
            ->with('success', 'Fasilitator berhasil dikeluarkan dari kelas');
    }
}
