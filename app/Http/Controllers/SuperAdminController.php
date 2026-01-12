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

        // Load user data for edit modal
        $editUser = null;
        if ($request->has('edit')) {
            $editUser = User::find($request->get('edit'));
        }

        return view('super-admin.users.index', compact('users', 'role', 'editUser'));
    }

    public function createUser()
    {
        return redirect()->route('super-admin.users');
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
        return redirect()->route('super-admin.users', ['edit' => $user->id]);
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
        $user->forceDelete();
        return redirect()->route('super-admin.users')->with('success', 'User berhasil dihapus permanent dari database');
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
        // Redirect ke users index (modal sudah ada di halaman tersebut)
        return redirect()->route('super-admin.users');
    }

    public function processImportUsers(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
            'role' => 'required|in:admin,fasilitator,peserta',
        ]);

        $file = $request->file('file');

        // Check if file extension is csv
        if ($file->getClientOriginalExtension() !== 'csv') {
            return back()->with('error', 'File harus berformat CSV');
        }

        try {
            $data = array_map('str_getcsv', file($file));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membaca file CSV. Pastikan file tidak corrupt dan menggunakan encoding UTF-8.');
        }

        if (empty($data)) {
            return back()->with('error', 'File CSV kosong atau tidak valid.');
        }

        $header = array_shift($data);

        if (empty($header)) {
            return back()->with('error', 'File CSV tidak memiliki header yang valid.');
        }

        // Normalize header names (lowercase, remove spaces, strip BOM)
        $header = array_map(function($h) {
            $h = preg_replace('/^\xEF\xBB\xBF/', '', $h); // Strip UTF-8 BOM
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

            // Validasi kolom required
            if (!in_array('nama_lengkap', $header)) {
                return back()->with('error', 'Kolom "Nama Lengkap" atau "nama_lengkap" tidak ditemukan di file CSV.');
            }
            if (!in_array('email', $header)) {
                return back()->with('error', 'Kolom "Email" tidak ditemukan di file CSV.');
            }

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
    public function programs(Request $request)
    {
        $programs = Program::with('creator')->latest()->paginate(20);

        // Load program data for edit modal
        $editProgram = null;
        if ($request->has('edit')) {
            $editProgram = Program::find($request->get('edit'));
        }

        return view('super-admin.programs.index', compact('programs', 'editProgram'));
    }

    public function createProgram()
    {
        return redirect()->route('super-admin.programs');
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
        return redirect()->route('super-admin.programs', ['edit' => $program->id]);
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
        $program->forceDelete();
        return redirect()->route('super-admin.programs')->with('success', 'Program berhasil dihapus permanent dari database');
    }

    // Activity Management
    public function activities(Request $request)
    {
        $activities = Activity::with(['program', 'creator'])->latest()->paginate(20);
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        $programs = Program::where('status', 'active')->get();

        $editActivity = null;
        if ($request->has('edit')) {
            $editActivity = Activity::find($request->get('edit'));
        }

        return view('super-admin.activities.index', compact('activities', 'routePrefix', 'programs', 'editActivity'));
    }

    public function createActivity()
    {
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.activities');
    }

    public function storeActivity(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch' => 'nullable|string|max:50',
            'financing_type' => 'nullable|string|max:255',
            'apbn_type' => 'nullable|string|max:255',
            'registration_fee' => 'nullable|numeric|min:0',
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
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.activities', ['edit' => $activity->id]);
    }

    public function updateActivity(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch' => 'nullable|string|max:50',
            'financing_type' => 'nullable|string|max:255',
            'apbn_type' => 'nullable|string|max:255',
            'registration_fee' => 'nullable|numeric|min:0',
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
        $activity->forceDelete();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.activities')->with('success', 'Kegiatan berhasil dihapus permanent dari database');
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

        // Load data for edit modal if present
        $editClass = null;
        if ($request->has('edit')) {
            $editClass = \App\Models\Classes::find($request->get('edit'));
        }

        return view('super-admin.classes.index', compact('classes', 'activities', 'routePrefix', 'editClass'));
    }

    public function createClass()
    {
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index');
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:open,closed,completed',
            'stages' => 'nullable|array',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.description' => 'nullable|string',
            'stages.*.order' => 'required|integer',
            'stages.*.start_date' => 'nullable|date',
            'stages.*.end_date' => 'nullable|date|after_or_equal:stages.*.start_date',
            'stages.*.status' => 'required|in:not_started,ongoing,completed',
        ]);

        $validated['created_by'] = auth()->id();

        $class = \App\Models\Classes::create($validated);

        // Create stages if provided
        if (isset($validated['stages']) && is_array($validated['stages'])) {
            foreach ($validated['stages'] as $stageData) {
                $class->stages()->create($stageData);
            }
        }

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index')->with('success', 'Kelas berhasil dibuat' . (isset($validated['stages']) ? ' dengan ' . count($validated['stages']) . ' tahap' : ''));
    }

    public function editClass(\App\Models\Classes $class)
    {
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index', ['edit' => $class->id]);
    }

    public function updateClass(Request $request, \App\Models\Classes $class)
    {
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:open,closed,completed',
            'stages' => 'nullable|array',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.description' => 'nullable|string',
            'stages.*.order' => 'required|integer',
            'stages.*.start_date' => 'nullable|date',
            'stages.*.end_date' => 'nullable|date|after_or_equal:stages.*.start_date',
            'stages.*.status' => 'required|in:not_started,ongoing,completed',
        ]);

        $class->update($validated);

        // Sync stages - delete old ones and create new ones
        if (isset($validated['stages']) && is_array($validated['stages'])) {
            // Delete existing stages
            $class->stages()->delete();

            // Create new stages
            foreach ($validated['stages'] as $stageData) {
                $class->stages()->create($stageData);
            }
        }

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index')->with('success', 'Kelas berhasil diupdate');
    }

    public function deleteClass(\App\Models\Classes $class)
    {
        $class->forceDelete();
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.index')->with('success', 'Kelas berhasil dihapus permanent dari database');
    }

    public function showClass(Request $request, \App\Models\Classes $class)
    {
        $class->load(['activity.adminMappings.admin', 'participantMappings.participant', 'fasilitatorMappings.fasilitator', 'stages']);
        
        // Get filter parameters
        $selectedProvinsi = $request->get('provinsi');
        $selectedKabKota = $request->get('kab_kota');
        $selectedKecamatan = $request->get('kecamatan');
        
        // Normalize filters
        $selectedProvinsiNormalized = $selectedProvinsi
            ? preg_replace('/\s+|_+/', '', strtolower(trim($selectedProvinsi)))
            : null;
        $selectedKabKotaNormalized = $selectedKabKota
            ? preg_replace('/\s+|_+/', '', strtolower(trim($selectedKabKota)))
            : null;
        $selectedKecamatanNormalized = $selectedKecamatan
            ? preg_replace('/\s+|_+/', '', strtolower(trim($selectedKecamatan)))
            : null;

        $kecamatanStatuses = ['validated', 'payment_uploaded', 'payment_validated', 'approved', 'accepted', 'belum ditentukan', 'belum_ditentukan'];

        // Load registrations yang sudah di-assign ke kelas ini (untuk ditampilkan sebagai peserta)
        $assignedRegistrations = \App\Models\Registration::with(['user', 'teacherParticipants'])
            ->where('activity_id', $class->activity_id)
            ->where('class_id', $class->id)
            ->whereIn('status', $kecamatanStatuses)
            ->get();

        // Collect all teacher participants from assigned registrations
        $teacherParticipants = collect();
        foreach ($assignedRegistrations as $reg) {
            // Add kepala sekolah if exists
            if ($reg->jumlah_kepala_sekolah > 0 && $reg->nama_kepala_sekolah) {
                $teacherParticipants->push([
                    'registration_id' => $reg->id,
                    'nama_sekolah' => $reg->nama_sekolah,
                    'nama_lengkap' => $reg->nama_kepala_sekolah,
                    'nip' => $reg->nik_kepala_sekolah ?? '-',
                    'email' => $reg->email,
                    'kecamatan' => $reg->kecamatan,
                    'status' => $reg->status,
                    'jabatan' => 'Kepala Sekolah',
                    'teacher_id' => null, // kepala sekolah from registration, not teacher_participants table
                    'is_kepala_sekolah' => true,
                ]);
            }

            // Add guru/teachers from teacher_participants
            foreach ($reg->teacherParticipants as $teacher) {
                $teacherParticipants->push([
                    'registration_id' => $reg->id,
                    'nama_sekolah' => $reg->nama_sekolah,
                    'nama_lengkap' => $teacher->nama_lengkap,
                    'nip' => $teacher->nip ?? '-',
                    'email' => $teacher->email,
                    'kecamatan' => $reg->kecamatan,
                    'status' => $reg->status,
                    'jabatan' => 'Guru',
                    'teacher_id' => $teacher->id,
                    'is_kepala_sekolah' => false,
                ]);
            }
        };

        // Sync registrations yang punya user_id ke participant_mappings
        foreach ($assignedRegistrations as $reg) {
            // Create mapping for original user_id (if exists)
            if ($reg->user_id) {
                $exists = \App\Models\ParticipantMapping::where('class_id', $class->id)
                    ->where('participant_id', $reg->user_id)
                    ->exists();
                if (!$exists) {
                    \App\Models\ParticipantMapping::create([
                        'class_id' => $class->id,
                        'participant_id' => $reg->user_id,
                        'enrolled_date' => now(),
                        'assigned_by' => auth()->id(),
                        'status' => 'in',
                    ]);
                }
            }

            // Create mapping for kepala sekolah (if has user_id)
            if ($reg->kepala_sekolah_user_id) {
                $exists = \App\Models\ParticipantMapping::where('class_id', $class->id)
                    ->where('participant_id', $reg->kepala_sekolah_user_id)
                    ->exists();
                if (!$exists) {
                    \App\Models\ParticipantMapping::create([
                        'class_id' => $class->id,
                        'participant_id' => $reg->kepala_sekolah_user_id,
                        'enrolled_date' => now(),
                        'assigned_by' => auth()->id(),
                        'status' => 'in',
                    ]);
                }
            }

            // Create mappings for all teachers with user_id
            foreach ($reg->teacherParticipants as $teacher) {
                if ($teacher->user_id) {
                    $exists = \App\Models\ParticipantMapping::where('class_id', $class->id)
                        ->where('participant_id', $teacher->user_id)
                        ->exists();
                    if (!$exists) {
                        \App\Models\ParticipantMapping::create([
                            'class_id' => $class->id,
                            'participant_id' => $teacher->user_id,
                            'enrolled_date' => now(),
                            'assigned_by' => auth()->id(),
                            'status' => 'in',
                        ]);
                    }
                }
            }
        }

        // Normalize any legacy participant mapping statuses for this class
        \App\Models\ParticipantMapping::where('class_id', $class->id)
            ->whereNotIn('status', ['in', 'move', 'out'])
            ->update(['status' => 'in']);

        // Build base query for filter options
        $baseFilterQuery = \App\Models\Registration::where('activity_id', $class->activity_id)
            ->whereIn('status', $kecamatanStatuses)
            ->whereNull('class_id');

        // Daftar provinsi untuk dropdown filter
        $provinsiQuery = clone $baseFilterQuery;
        $provinsiOptions = $provinsiQuery->whereNotNull('provinsi')
            ->distinct()
            ->orderBy('provinsi')
            ->pluck('provinsi');

        // Daftar kabupaten/kota untuk dropdown filter (filtered by provinsi if selected)
        $kabKotaQuery = clone $baseFilterQuery;
        if ($selectedProvinsiNormalized) {
            $kabKotaQuery->whereRaw('LOWER(REPLACE(REPLACE(TRIM(provinsi)," ",""),"_","")) = ?', [$selectedProvinsiNormalized]);
        }
        $kabKotaOptions = $kabKotaQuery->whereNotNull('kab_kota')
            ->distinct()
            ->orderBy('kab_kota')
            ->pluck('kab_kota');

        // Daftar kecamatan untuk dropdown filter (filtered by provinsi and kab_kota if selected)
        $kecamatanQuery = clone $baseFilterQuery;
        if ($selectedProvinsiNormalized) {
            $kecamatanQuery->whereRaw('LOWER(REPLACE(REPLACE(TRIM(provinsi)," ",""),"_","")) = ?', [$selectedProvinsiNormalized]);
        }
        if ($selectedKabKotaNormalized) {
            $kecamatanQuery->whereRaw('LOWER(REPLACE(REPLACE(TRIM(kab_kota)," ",""),"_","")) = ?', [$selectedKabKotaNormalized]);
        }
        $kecamatanOptions = $kecamatanQuery->whereNotNull('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');

        // Available registrations with all filters applied
        $availableRegistrationsQuery = \App\Models\Registration::with('user')
            ->where('activity_id', $class->activity_id)
            ->whereIn('status', $kecamatanStatuses)
            ->whereNull('class_id');

        if ($selectedProvinsiNormalized) {
            $availableRegistrationsQuery->whereRaw('LOWER(REPLACE(REPLACE(TRIM(provinsi)," ",""),"_","")) = ?', [$selectedProvinsiNormalized]);
        }
        if ($selectedKabKotaNormalized) {
            $availableRegistrationsQuery->whereRaw('LOWER(REPLACE(REPLACE(TRIM(kab_kota)," ",""),"_","")) = ?', [$selectedKabKotaNormalized]);
        }
        if ($selectedKecamatanNormalized) {
            $availableRegistrationsQuery->whereRaw('LOWER(REPLACE(REPLACE(TRIM(kecamatan)," ",""),"_","")) = ?', [$selectedKecamatanNormalized]);
        }

        $availableRegistrations = $availableRegistrationsQuery->get();

        // Peserta/guru/kepsek yang punya registrasi tervalidasi dan belum masuk kelas, difilter lokasi jika dipilih
        $availableParticipants = \App\Models\User::with(['registrations' => function($query) use ($class) {
                $query->where('activity_id', $class->activity_id);
            }])
            ->whereIn('role', ['peserta', 'guru', 'kepala_sekolah'])
            ->whereHas('registrations', function($query) use ($class, $selectedProvinsiNormalized, $selectedKabKotaNormalized, $selectedKecamatanNormalized, $kecamatanStatuses) {
                $query->where('activity_id', $class->activity_id)
                    ->whereIn('status', $kecamatanStatuses)
                    ->whereNull('class_id');
                if ($selectedProvinsiNormalized) {
                    $query->whereRaw('LOWER(REPLACE(REPLACE(TRIM(provinsi)," ",""),"_","")) = ?', [$selectedProvinsiNormalized]);
                }
                if ($selectedKabKotaNormalized) {
                    $query->whereRaw('LOWER(REPLACE(REPLACE(TRIM(kab_kota)," ",""),"_","")) = ?', [$selectedKabKotaNormalized]);
                }
                if ($selectedKecamatanNormalized) {
                    $query->whereRaw('LOWER(REPLACE(REPLACE(TRIM(kecamatan)," ",""),"_","")) = ?', [$selectedKecamatanNormalized]);
                }
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

        return view('super-admin.classes.show', compact(
            'class',
            'assignedRegistrations',
            'teacherParticipants',
            'availableRegistrations',
            'availableParticipants',
            'availableFasilitators',
            'routePrefix',
            'provinsiOptions',
            'kabKotaOptions',
            'kecamatanOptions',
            'selectedProvinsi',
            'selectedKabKota',
            'selectedKecamatan'
        ));
    }

    public function removeParticipant(\App\Models\Classes $class, \App\Models\ParticipantMapping $participant)
    {
        // Update registration to remove class_id
        \App\Models\Registration::where('user_id', $participant->participant_id)
            ->where('class_id', $class->id)
            ->update(['class_id' => null]);

        // Delete participant mapping
        $participant->forceDelete();

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
            'status' => 'in',
        ]);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.show', $class)
            ->with('success', 'Peserta berhasil ditambahkan ke kelas');
    }

    public function assignParticipantsByLocation(Request $request, \App\Models\Classes $class)
    {
        $validated = $request->validate([
            'provinsi' => 'nullable|string',
            'kab_kota' => 'nullable|string',
            'kecamatan' => 'nullable|string',
        ]);

        // At least one filter must be provided
        if (empty($validated['provinsi']) && empty($validated['kab_kota']) && empty($validated['kecamatan'])) {
            return redirect()->back()->with('error', 'Minimal satu filter harus dipilih');
        }

        // Normalize filters
        $provinsiNormalized = !empty($validated['provinsi']) 
            ? preg_replace('/\s+|_+/', '', strtolower(trim($validated['provinsi'])))
            : null;
        $kabKotaNormalized = !empty($validated['kab_kota'])
            ? preg_replace('/\s+|_+/', '', strtolower(trim($validated['kab_kota'])))
            : null;
        $kecamatanNormalized = !empty($validated['kecamatan'])
            ? preg_replace('/\s+|_+/', '', strtolower(trim($validated['kecamatan'])))
            : null;

        $statuses = ['validated', 'payment_uploaded', 'payment_validated', 'approved', 'accepted', 'belum ditentukan', 'belum_ditentukan'];

        // Find all eligible registrations by location filters
        $eligibleRegistrations = \App\Models\Registration::where('activity_id', $class->activity_id)
            ->whereIn('status', $statuses)
            ->whereNull('class_id');

        if ($provinsiNormalized) {
            $eligibleRegistrations->whereRaw('LOWER(REPLACE(REPLACE(TRIM(provinsi)," ",""),"_","")) = ?', [$provinsiNormalized]);
        }
        if ($kabKotaNormalized) {
            $eligibleRegistrations->whereRaw('LOWER(REPLACE(REPLACE(TRIM(kab_kota)," ",""),"_","")) = ?', [$kabKotaNormalized]);
        }
        if ($kecamatanNormalized) {
            $eligibleRegistrations->whereRaw('LOWER(REPLACE(REPLACE(TRIM(kecamatan)," ",""),"_","")) = ?', [$kecamatanNormalized]);
        }

        $eligibleRegistrations = $eligibleRegistrations->get();

        if ($eligibleRegistrations->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada peserta yang tersedia dengan filter tersebut');
        }

        $countAdded = 0;

        // Update registrations to set class_id
        foreach ($eligibleRegistrations as $reg) {
            $reg->update(['class_id' => $class->id]);
            $countAdded++;

            // Create mapping for original user_id (if exists)
            if ($reg->user_id) {
                $alreadyMapped = \App\Models\ParticipantMapping::where('class_id', $class->id)
                    ->where('participant_id', $reg->user_id)
                    ->exists();

                if (!$alreadyMapped) {
                    \App\Models\ParticipantMapping::create([
                        'class_id' => $class->id,
                        'participant_id' => $reg->user_id,
                        'enrolled_date' => now(),
                        'assigned_by' => auth()->id(),
                        'status' => 'in',
                    ]);
                }
            }

            // Create mapping for kepala sekolah (if has user_id)
            if ($reg->kepala_sekolah_user_id) {
                $alreadyMapped = \App\Models\ParticipantMapping::where('class_id', $class->id)
                    ->where('participant_id', $reg->kepala_sekolah_user_id)
                    ->exists();

                if (!$alreadyMapped) {
                    \App\Models\ParticipantMapping::create([
                        'class_id' => $class->id,
                        'participant_id' => $reg->kepala_sekolah_user_id,
                        'enrolled_date' => now(),
                        'assigned_by' => auth()->id(),
                        'status' => 'in',
                    ]);
                }
            }

            // Create mappings for all teachers with user_id
            foreach ($reg->teacherParticipants as $teacher) {
                if ($teacher->user_id) {
                    $alreadyMapped = \App\Models\ParticipantMapping::where('class_id', $class->id)
                        ->where('participant_id', $teacher->user_id)
                        ->exists();

                    if (!$alreadyMapped) {
                        \App\Models\ParticipantMapping::create([
                            'class_id' => $class->id,
                            'participant_id' => $teacher->user_id,
                            'enrolled_date' => now(),
                            'assigned_by' => auth()->id(),
                            'status' => 'in',
                        ]);
                    }
                }
            }
        }

        // Build success message
        $locationParts = [];
        if (!empty($validated['provinsi'])) $locationParts[] = ucwords(strtolower($validated['provinsi']));
        if (!empty($validated['kab_kota'])) $locationParts[] = ucwords(strtolower($validated['kab_kota']));
        if (!empty($validated['kecamatan'])) $locationParts[] = ucwords(strtolower($validated['kecamatan']));
        $locationStr = implode(' > ', $locationParts);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.show', $class)
            ->with('success', $countAdded . ' pendaftaran dari ' . $locationStr . ' berhasil ditambahkan ke kelas');
    }

    // Keep old method for backward compatibility
    public function assignParticipantsByKecamatan(Request $request, \App\Models\Classes $class)
    {
        return $this->assignParticipantsByLocation($request, $class);
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

    public function removeTeacherParticipant(\App\Models\Classes $class, $teacherId)
    {
        $teacher = \App\Models\TeacherParticipant::findOrFail($teacherId);
        $registration = $teacher->registration;

        // Delete the teacher participant
        $teacher->forceDelete();

        // Check if registration has no more teacher participants and no kepala sekolah
        if ($registration->teacherParticipants()->count() == 0 && $registration->jumlah_kepala_sekolah == 0) {
            // Remove class_id from registration
            $registration->update(['class_id' => null]);
        }

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.show', $class)
            ->with('success', 'Peserta berhasil dikeluarkan dari kelas');
    }

    public function removeKepalaSekolah(\App\Models\Classes $class, $registrationId)
    {
        $registration = \App\Models\Registration::findOrFail($registrationId);

        // Set jumlah kepala sekolah to 0
        $registration->update(['jumlah_kepala_sekolah' => 0]);

        // Check if registration has no more participants (both kepala sekolah and teachers)
        if ($registration->teacherParticipants()->count() == 0 && $registration->jumlah_kepala_sekolah == 0) {
            // Remove class_id from registration
            $registration->update(['class_id' => null]);
        }

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';
        return redirect()->route($routePrefix . '.classes.show', $class)
            ->with('success', 'Kepala sekolah berhasil dikeluarkan dari kelas');
    }

    public function assignAdminToActivity(Request $request, \App\Models\Classes $class)
    {
        try {
            $validated = $request->validate([
                'admin_id' => 'required|exists:users,id',
            ]);

            // Check if admin exists
            $admin = \App\Models\User::where('id', $validated['admin_id'])
                ->where('role', 'admin')
                ->where('status', 'active')
                ->first();

            if (!$admin) {
                return redirect()->back()->with('error', 'Admin tidak ditemukan atau tidak aktif');
            }

            // Check if admin is already assigned to this activity
            $existingMapping = \App\Models\AdminMapping::where('admin_id', $validated['admin_id'])
                ->where('activity_id', $class->activity_id)
                ->where('status', 'active')
                ->first();

            if ($existingMapping) {
                return redirect()->back()->with('error', 'Admin sudah ditugaskan ke kegiatan ini');
            }

            // Create admin mapping
            \App\Models\AdminMapping::create([
                'activity_id' => $class->activity_id,
                'admin_id' => $validated['admin_id'],
                'assigned_by' => auth()->id(),
                'assigned_date' => now(),
                'status' => 'active',
            ]);

            return redirect()->route('super-admin.classes.show', $class)
                ->with('success', 'Admin ' . $admin->name . ' berhasil ditambahkan ke kegiatan');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function removeAdminFromActivity(\App\Models\Classes $class, \App\Models\AdminMapping $adminMapping)
    {
        try {
            // Verify the admin mapping belongs to this activity
            if ($adminMapping->activity_id != $class->activity_id) {
                return redirect()->back()->with('error', 'Admin mapping tidak valid');
            }

            // Set status to inactive instead of deleting
            $adminMapping->update(['status' => 'inactive']);

            return redirect()->route('super-admin.classes.show', $class)
                ->with('success', 'Admin berhasil dihapus dari kegiatan');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
