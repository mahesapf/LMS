<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Activity;
use App\Models\AdminMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentRequirement;
use App\Models\Document;
use App\Models\Stage;

class SuperAdminController extends Controller
{
    /**
     * Get the users route based on current user role
     */
    private function getUsersRoute()
    {
        return auth()->user()->role === 'super_admin' ? 'super-admin.users' : 'admin.users';
    }

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

        // Exclude super_admin and sekolah from user management
        $query = User::whereNotIn('role', ['super_admin', 'sekolah']);

        // Admin tidak bisa melihat/kelola user dengan role admin dan super_admin
        if (auth()->user()->role === 'admin') {
            $query->whereNotIn('role', ['admin', 'super_admin']);
        }

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(20);
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';

        // Load user data for edit modal
        $editUser = null;
        if ($request->has('edit')) {
            $editUser = User::find($request->get('edit'));

            // Prevent admin from editing admin or super_admin users
            if ($editUser && auth()->user()->role === 'admin' && in_array($editUser->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.users')->with('error', 'Anda tidak memiliki akses untuk mengelola user dengan role Admin atau Super Admin');
            }
        }

        return view('super-admin.users.index', compact('users', 'role', 'editUser', 'routePrefix'));
    }

    public function createUser()
    {
        return redirect()->route($this->getUsersRoute());
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|min:8|max:20',
            'role' => 'required|in:admin,fasilitator,peserta',
            // Data Identitas Pribadi
            'email_belajar' => 'nullable|email|max:50',
            'npsn' => 'nullable|size:8|regex:/^[0-9]{8}$/',
            'nip' => 'nullable|size:18|regex:/^[0-9]{18}$/',
            'nik' => 'nullable|size:16|regex:/^[0-9]{16}$/',
            'birth_place' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            // Data Kepegawaian
            'pns_status' => 'nullable|in:PNS,Non PNS',
            'rank' => 'nullable|string|max:50',
            'group' => 'nullable|string|max:10',
            'position_type' => 'nullable|in:Guru,Kepala Sekolah,Lainnya',
            'position' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:50',
            // Data Pendidikan
            'last_education' => 'nullable|in:SMA/SMK,D3,S1,S2,S3',
            'major' => 'nullable|string|max:50',
            // Data Kontak
            'phone' => 'nullable|string|max:16|regex:/^[0-9]{10,16}$/',
            'address' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'district' => 'nullable|string|max:50',
            // Data Dokumen
            'photo' => 'nullable|image|max:2048',
            'digital_signature' => 'nullable|image|max:1024',
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('participants/photos', 'public');
        }

        if ($request->hasFile('digital_signature')) {
            $validated['digital_signature'] = $request->file('digital_signature')->store('participants/signatures', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'active';

        User::create($validated);

        return redirect()->route($this->getUsersRoute())->with('success', 'User berhasil dibuat');
    }

    public function editUser(User $user)
    {
        // Prevent admin from editing admin or super_admin users
        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak memiliki akses untuk mengelola user dengan role Admin atau Super Admin');
        }

        return redirect()->route($this->getUsersRoute(), ['edit' => $user->id]);
    }

    public function updateUser(Request $request, User $user)
    {
        // Prevent admin from updating admin or super_admin users
        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak memiliki akses untuk mengelola user dengan role Admin atau Super Admin');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,fasilitator,peserta',
            'status' => 'required|in:active,suspended,inactive',
            // Data Identitas Pribadi
            'email_belajar' => 'nullable|email|max:50',
            'npsn' => 'nullable|size:8|regex:/^[0-9]{8}$/',
            'nip' => 'nullable|size:18|regex:/^[0-9]{18}$/',
            'nik' => 'nullable|size:16|regex:/^[0-9]{16}$/',
            'birth_place' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            // Data Kepegawaian
            'pns_status' => 'nullable|in:PNS,Non PNS',
            'rank' => 'nullable|string|max:50',
            'group' => 'nullable|string|max:10',
            'position_type' => 'nullable|in:Guru,Kepala Sekolah,Lainnya',
            'position' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:50',
            // Data Pendidikan
            'last_education' => 'nullable|in:SMA/SMK,D3,S1,S2,S3',
            'major' => 'nullable|string|max:50',
            // Data Kontak
            'phone' => 'nullable|string|max:16|regex:/^[0-9]{10,16}$/',
            'address' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'district' => 'nullable|string|max:50',
            // Data Dokumen
            'photo' => 'nullable|image|max:2048',
            'digital_signature' => 'nullable|image|max:1024',
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            // Delete old file if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('participants/photos', 'public');
        }

        if ($request->hasFile('digital_signature')) {
            // Delete old file if exists
            if ($user->digital_signature) {
                Storage::disk('public')->delete($user->digital_signature);
            }
            $validated['digital_signature'] = $request->file('digital_signature')->store('participants/signatures', 'public');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route($this->getUsersRoute())->with('success', 'User berhasil diupdate');
    }

    public function deleteUser(User $user)
    {
        // Prevent admin from deleting admin or super_admin users
        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak memiliki akses untuk mengelola user dengan role Admin atau Super Admin');
        }

        $user->forceDelete();
        return redirect()->route($this->getUsersRoute())->with('success', 'User berhasil dihapus permanent dari database');
    }

    public function bulkDeleteUsers(Request $request)
    {
        // Debug logging
        \Log::info('bulkDeleteUsers called', [
            'user_ids' => $request->user_ids,
            'request_method' => $request->method(),
            'all_data' => $request->all()
        ]);

        // Skip validation for debugging
        // $request->validate([
        //     'user_ids' => 'required|array',
        //     'user_ids.*' => 'exists:users,id',
        // ]);

        if (!$request->has('user_ids') || !is_array($request->user_ids)) {
            \Log::error('Invalid user_ids data', ['user_ids' => $request->user_ids]);
            return redirect()->back()->with('error', 'Data user tidak valid');
        }

        $userIds = $request->user_ids;

        // Get users to check permissions
        $users = User::whereIn('id', $userIds)->get();

        $deletedCount = 0;
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';

        foreach ($users as $user) {
            // Prevent admin from deleting admin or super_admin users
            if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'super_admin'])) {
                \Log::info('Skipping admin user', ['user_id' => $user->id, 'role' => $user->role]);
                continue;
            }

            // Prevent deleting super_admin users
            if ($user->role === 'super_admin') {
                \Log::info('Skipping super_admin user', ['user_id' => $user->id]);
                continue;
            }

            \Log::info('Deleting user', ['user_id' => $user->id, 'role' => $user->role]);
            $user->delete(); // Use soft delete instead of force delete
            $deletedCount++;
        }

        $message = $deletedCount > 0
            ? "{$deletedCount} user berhasil dihapus"
            : "Tidak ada user yang dapat dihapus";

        \Log::info('Bulk delete completed', ['deleted_count' => $deletedCount, 'message' => $message]);

        return redirect()->route($routePrefix . '.users', $request->only('role'))->with('success', $message);
    }

    public function bulkDeleteUsersPost(Request $request)
    {
        \Log::info('bulkDeleteUsersPost called', [
            'user_ids' => $request->user_ids,
            'method' => $request->method()
        ]);

        if (!$request->has('user_ids') || !is_array($request->user_ids)) {
            \Log::error('Invalid user_ids data', ['user_ids' => $request->user_ids]);
            return response()->json(['error' => 'Data user tidak valid'], 400);
        }

        $userIds = $request->user_ids;

        // Get users to check permissions
        $users = User::whereIn('id', $userIds)->get();

        $deletedCount = 0;
        $skippedCount = 0;
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';

        foreach ($users as $user) {
            // Prevent admin from deleting admin or super_admin users
            if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'super_admin'])) {
                \Log::info('Skipping admin user', ['user_id' => $user->id, 'role' => $user->role]);
                $skippedCount++;
                continue;
            }

            // Prevent deleting super_admin users
            if ($user->role === 'super_admin') {
                \Log::info('Skipping super_admin user', ['user_id' => $user->id]);
                $skippedCount++;
                continue;
            }

            \Log::info('Deleting user', ['user_id' => $user->id, 'role' => $user->role]);
            $user->delete(); // Use soft delete
            $deletedCount++;
        }

        $message = $deletedCount > 0
            ? "{$deletedCount} user berhasil dihapus"
            : "Tidak ada user yang dapat dihapus";

        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} user dilewati karena proteksi role)";
        }

        \Log::info('Bulk delete completed', [
            'deleted_count' => $deletedCount,
            'skipped_count' => $skippedCount,
            'message' => $message
        ]);

        return redirect()->route($routePrefix . '.users', $request->only('role'))->with('success', $message);
    }

    public function bulkDeleteTest(Request $request)
    {
        return response()->json([
            'message' => 'Bulk delete route is working',
            'method' => $request->method(),
            'data' => $request->all()
        ]);
    }

    public function suspendUser(User $user)
    {
        // Prevent admin from suspending admin or super_admin users
        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak memiliki akses untuk mengelola user dengan role Admin atau Super Admin');
        }

        $user->update(['status' => 'suspended']);
        return redirect()->back()->with('success', 'User berhasil disuspend');
    }

    public function activateUser(User $user)
    {
        // Prevent admin from activating admin or super_admin users
        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak memiliki akses untuk mengelola user dengan role Admin atau Super Admin');
        }

        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', 'User berhasil diaktifkan');
    }

    public function importUsers()
    {
        // Redirect ke users index (modal sudah ada di halaman tersebut)
        return redirect()->route($this->getUsersRoute());
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

            foreach ($data as $index => $row) {
                if (empty(array_filter($row))) continue; // Skip empty rows

                $rowData = array_combine($header, $row);

                // Clean data
                $nama = trim($rowData['nama_lengkap'] ?? '');
                $email = trim($rowData['email'] ?? '');
                $nik = trim($rowData['nik'] ?? '');

                \Log::info('Processing row', [
                    'index' => $index,
                    'nama' => $nama,
                    'email' => $email,
                    'nik' => $nik,
                    'raw_row' => $row,
                    'row_data' => $rowData
                ]);

                // Skip if nama is empty, dash, or email is empty
                if (empty($nama) || $nama === '-' || empty($email)) {
                    \Log::warning('Skipping due to empty data', ['nama' => $nama, 'email' => $email]);
                    $skipped++;
                    continue;
                }

                // Check if email already exists (excluding soft deleted)
                $existingUser = User::where('email', $email)->first();
                if ($existingUser) {
                    \Log::warning('Email already exists (active user), skipping', [
                        'email' => $email,
                        'existing_user_id' => $existingUser->id,
                        'existing_name' => $existingUser->name,
                        'deleted_at' => $existingUser->deleted_at
                    ]);
                    $skipped++;
                    continue;
                }

                // Validate NIK if provided (should be 16 digits)
                if ($nik && strlen($nik) != 16) {
                    $nik = null; // Set to null if not 16 digits
                }

                // Use NIK as password, or default to 'password123' if NIK is empty
                $password = $nik ? $nik : 'password123';

                // Check if user was soft deleted - restore instead of creating new
                $deletedUser = User::onlyTrashed()->where('email', $email)->first();
                if ($deletedUser) {
                    \Log::info('Restoring soft deleted user', [
                        'email' => $email,
                        'deleted_user_id' => $deletedUser->id,
                        'deleted_at' => $deletedUser->deleted_at
                    ]);

                    $deletedUser->restore();
                    $deletedUser->update([
                        'name' => $nama,
                        'nik' => $nik,
                        'password' => Hash::make($password),
                        'role' => $request->role,
                        'status' => 'active',
                    ]);
                    $imported++;
                    continue;
                }

                try {
                    User::create([
                        'name' => $nama,
                        'email' => $email,
                        'nik' => $nik,
                        'password' => Hash::make($password),
                        'role' => $request->role,
                        'status' => 'active',
                    ]);
                    $imported++;
                    \Log::info('User created successfully', ['email' => $email, 'name' => $nama]);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() == 23000) { // Duplicate entry error
                        \Log::warning('Duplicate entry caught, skipping', ['email' => $email, 'error' => $e->getMessage()]);
                        $skipped++;
                    } else {
                        \Log::error('Database error during import', ['email' => $email, 'error' => $e->getMessage()]);
                        throw $e; // Re-throw for other database errors
                    }
                }
            }

            DB::commit();

            $message = "Import berhasil: {$imported} pengguna ditambahkan";
            if ($skipped > 0) {
                $message .= ", {$skipped} data dilewati (email sudah terdaftar atau data tidak lengkap)";
            }

            \Log::info('Import completed', ['imported' => $imported, 'skipped' => $skipped]);

            return redirect()->route($this->getUsersRoute())->with('success', $message);
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
        // Redirect ke halaman programs (modal ditampilkan di sini)
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
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';

        // Provide data for create modal
        $admins = User::where('role', 'admin')->where('status', 'active')->get();
        $programs = Program::where('status', 'active')->get();
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])->get();

        return view('super-admin.admin-mappings.index', compact('mappings', 'routePrefix', 'admins', 'programs', 'activities'));
    }

    public function createAdminMapping()
    {
        // Redirect to index since create form is now a modal
        return redirect()->route('super-admin.admin-mappings');
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

    public function editAdminMapping(AdminMapping $mapping)
    {
        $admins = User::where('role', 'admin')->where('status', 'active')->get();
        $programs = Program::where('status', 'active')->get();
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])->get();

        return view('super-admin.admin-mappings.edit', compact('mapping', 'admins', 'programs', 'activities'));
    }

    public function updateAdminMapping(Request $request, AdminMapping $mapping)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'activity_id' => 'nullable|exists:activities,id',
            'status' => 'required|in:in,out',
            'assigned_date' => 'nullable|date',
        ]);

        if ($validated['status'] === 'out') {
            $validated['removed_date'] = now();
        } else {
            $validated['removed_date'] = null;
        }

        $mapping->update($validated);

        return redirect()->route('super-admin.admin-mappings')->with('success', 'Admin mapping berhasil diupdate');
    }

    public function deleteAdminMapping(AdminMapping $mapping)
    {
        $mapping->forceDelete();
        return redirect()->route('super-admin.admin-mappings')->with('success', 'Admin mapping berhasil dihapus permanent dari database');
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
        $assignedRegistrations = \App\Models\Registration::with(['user', 'teacherParticipants.user'])
            ->where('activity_id', $class->activity_id)
            ->where('class_id', $class->id)
            ->whereIn('status', $kecamatanStatuses)
            ->get();

        // Collect all teacher participants from assigned registrations
        $teacherParticipants = collect();
        foreach ($assignedRegistrations as $reg) {
            // Add kepala sekolah if exists
            if ($reg->jumlah_kepala_sekolah > 0 && $reg->nama_kepala_sekolah) {
                // Get kepala sekolah email from User if exists, otherwise use placeholder
                $kepalaSekolahEmail = '-';
                if ($reg->kepala_sekolah_user_id) {
                    $kepalaUser = \App\Models\User::find($reg->kepala_sekolah_user_id);
                    if ($kepalaUser) {
                        $kepalaSekolahEmail = $kepalaUser->email;
                    }
                }

                $teacherParticipants->push([
                    'registration_id' => $reg->id,
                    'nama_sekolah' => $reg->nama_sekolah,
                    'nama_lengkap' => $reg->nama_kepala_sekolah,
                    'nip' => $reg->nik_kepala_sekolah ?? '-',
                    'email' => $kepalaSekolahEmail,
                    'kecamatan' => $reg->kecamatan,
                    'status' => $reg->status,
                    'jabatan' => 'Kepala Sekolah',
                    'teacher_id' => null, // kepala sekolah from registration, not teacher_participants table
                    'is_kepala_sekolah' => true,
                ]);
            }

            // Add guru/teachers from teacher_participants
            foreach ($reg->teacherParticipants as $teacher) {
                // Get jabatan with priority: teacher_participants.jabatan > user.position_type > user.jabatan > default
                $jabatan = 'Guru'; // default

                // First check if jabatan is set directly in teacher_participants table
                if (!empty($teacher->jabatan)) {
                    $jabatan = $teacher->jabatan;
                }
                // Otherwise, try to get from related user if available
                elseif ($teacher->user_id && $teacher->user) {
                    $jabatan = $teacher->user->position_type
                        ?? $teacher->user->jabatan
                        ?? ($teacher->user->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Guru');
                }

                $teacherParticipants->push([
                    'registration_id' => $reg->id,
                    'nama_sekolah' => $reg->nama_sekolah,
                    'nama_lengkap' => $teacher->nama_lengkap,
                    'nip' => $teacher->nip ?? '-',
                    'email' => $teacher->email,
                    'kecamatan' => $reg->kecamatan,
                    'status' => $reg->status,
                    'jabatan' => $jabatan,
                    'teacher_id' => $teacher->id,
                    'is_kepala_sekolah' => ($jabatan === 'Kepala Sekolah'),
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

        // Get participant mappings yang tidak dari registrations (manually added)
        $manualParticipantIds = $assignedRegistrations->pluck('user_id')->merge(
            $assignedRegistrations->pluck('kepala_sekolah_user_id')
        )->merge(
            \App\Models\TeacherParticipant::whereIn('registration_id', $assignedRegistrations->pluck('id'))->pluck('user_id')
        )->filter();

        $manualParticipants = \App\Models\ParticipantMapping::with('participant')
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->whereNotIn('participant_id', $manualParticipantIds)
            ->get();

        // Add manual participants to teacherParticipants collection
        foreach ($manualParticipants as $mapping) {
            if ($mapping->participant) {
                // Determine jabatan from position_type, jabatan field, or role
                $jabatan = $mapping->participant->position_type
                    ?? $mapping->participant->jabatan
                    ?? ($mapping->participant->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Guru');

                $teacherParticipants->push([
                    'registration_id' => null,
                    'nama_sekolah' => $mapping->participant->institution ?? $mapping->participant->instansi ?? '-',
                    'nama_lengkap' => $mapping->participant->name,
                    'nip' => $mapping->participant->nip ?? '-',
                    'email' => $mapping->participant->email,
                    'kecamatan' => $mapping->participant->district ?? '-',
                    'status' => 'manual',
                    'jabatan' => $jabatan,
                    'teacher_id' => null,
                    'is_kepala_sekolah' => ($jabatan === 'Kepala Sekolah'),
                    'participant_mapping_id' => $mapping->id,
                    'is_manual' => true,
                ]);
            }
        }

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

        // Calculate total participants: individual teachers from registrations + individual participant mappings
        $totalParticipants = $teacherParticipants->count();

        // Use different view based on user role
        $view = $routePrefix === 'admin' ? 'admin.classes.show' : 'super-admin.classes.show';

        return view($view, compact(
            'class',
            'assignedRegistrations',
            'teacherParticipants',
            'totalParticipants',
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

    public function printClassAttendance(\App\Models\Classes $class)
    {
        $class->load(['activity', 'participantMappings.participant']);

        $kecamatanStatuses = ['validated', 'payment_uploaded', 'payment_validated', 'approved', 'accepted', 'belum ditentukan', 'belum_ditentukan'];

        $assignedRegistrations = \App\Models\Registration::with(['user', 'teacherParticipants.user'])
            ->where('activity_id', $class->activity_id)
            ->where('class_id', $class->id)
            ->whereIn('status', $kecamatanStatuses)
            ->get();

        $participants = collect();

        foreach ($assignedRegistrations as $reg) {
            if ($reg->jumlah_kepala_sekolah > 0 && $reg->nama_kepala_sekolah) {
                $participants->push([
                    'nama_lengkap' => $reg->nama_kepala_sekolah,
                    'nama_sekolah' => $reg->nama_sekolah,
                    'jabatan' => 'KS',
                ]);
            }

            foreach ($reg->teacherParticipants as $teacher) {
                // Get jabatan with priority: teacher_participants.jabatan > user.position_type > user.jabatan > default
                $jabatan = 'Guru'; // default

                // First check if jabatan is set directly in teacher_participants table
                if (!empty($teacher->jabatan)) {
                    $jabatan = $teacher->jabatan;
                }
                // Otherwise, try to get from related user if available
                elseif ($teacher->user_id && $teacher->user) {
                    $jabatan = $teacher->user->position_type
                        ?? $teacher->user->jabatan
                        ?? ($teacher->user->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Guru');
                }

                $participants->push([
                    'nama_lengkap' => $teacher->nama_lengkap,
                    'nama_sekolah' => $reg->nama_sekolah,
                    'jabatan' => $jabatan,
                ]);
            }
        }

        // Include manually added participants (participant_mappings) that are not represented in registrations
        $registrationUserIds = $assignedRegistrations->pluck('user_id')
            ->merge($assignedRegistrations->pluck('kepala_sekolah_user_id'))
            ->merge(\App\Models\TeacherParticipant::whereIn('registration_id', $assignedRegistrations->pluck('id'))->pluck('user_id'))
            ->filter();

        $manualParticipants = \App\Models\ParticipantMapping::with('participant')
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->whereNotIn('participant_id', $registrationUserIds)
            ->get();

        foreach ($manualParticipants as $mapping) {
            if ($mapping->participant) {
                // Determine jabatan from position_type, jabatan field, or role
                $jabatan = $mapping->participant->position_type
                    ?? $mapping->participant->jabatan
                    ?? ($mapping->participant->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Guru');

                $participants->push([
                    'nama_lengkap' => $mapping->participant->name,
                    'nama_sekolah' => $mapping->participant->institution ?? $mapping->participant->instansi ?? '-',
                    'jabatan' => $jabatan,
                ]);
            }
        }

        $participants = $participants
            ->filter(fn ($p) => !empty($p['nama_lengkap']))
            ->values();

        return view('super-admin.classes.attendance-print', compact('class', 'participants'));
    }

    public function fasilitatorDocuments(\App\Models\Classes $class)
    {
        $class->load(['activity', 'stages']);

        $generalRequirements = DocumentRequirement::forFasilitator()
            ->where('class_id', $class->id)
            ->whereNull('stage_id')
            ->orderBy('created_at')
            ->get();

        $stages = Stage::with(['documentRequirements' => function ($query) {
                $query->forFasilitator()->orderBy('created_at');
            }])
            ->where('class_id', $class->id)
            ->ordered()
            ->get();

        return view('super-admin.classes.fasilitator-documents', compact('class', 'stages', 'generalRequirements'));
    }

    public function storeFasilitatorDocumentRequirement(Request $request, \App\Models\Classes $class)
    {
        $validated = $request->validate([
            'stage_id' => 'nullable|exists:stages,id',
            'document_name' => 'required|string|max:255',
            'document_type' => 'nullable|string',
            'description' => 'nullable|string',
            'max_file_size' => 'nullable|integer|min:100',
            'is_required' => 'nullable|boolean',
            'template_file' => 'nullable|file|max:10240',
        ]);

        if (!empty($validated['stage_id'])) {
            Stage::where('id', $validated['stage_id'])
                ->where('class_id', $class->id)
                ->firstOrFail();
        }

        $templatePath = null;
        $templateName = null;
        if ($request->hasFile('template_file')) {
            $file = $request->file('template_file');
            $templatePath = $file->store('document-templates/fasilitator', 'public');
            $templateName = $file->getClientOriginalName();
        }

        DocumentRequirement::create([
            'class_id' => $class->id,
            'stage_id' => $validated['stage_id'] ?? null,
            'target_role' => DocumentRequirement::TARGET_FASILITATOR,
            'document_name' => $validated['document_name'],
            'document_type' => $validated['document_type'] ?? null,
            'description' => $validated['description'] ?? null,
            'max_file_size' => $validated['max_file_size'] ?? 5120,
            'is_required' => $request->has('is_required'),
            'template_file_path' => $templatePath,
            'template_file_name' => $templateName,
        ]);

        return redirect()->back()->with('success', 'Requirement dokumen fasilitator berhasil ditambahkan');
    }

    public function deleteFasilitatorDocumentRequirement(\App\Models\Classes $class, DocumentRequirement $requirement)
    {
        if ($requirement->class_id !== $class->id) {
            abort(403, 'Requirement tidak termasuk dalam kelas ini');
        }

        if ($requirement->target_role !== DocumentRequirement::TARGET_FASILITATOR) {
            abort(403, 'Requirement ini bukan untuk fasilitator');
        }

        $requirement->load('documents');
        foreach ($requirement->documents as $document) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();
        }

        if (!empty($requirement->template_file_path)) {
            Storage::disk('public')->delete($requirement->template_file_path);
        }

        $requirement->delete();

        return redirect()->back()->with('success', 'Requirement dokumen fasilitator berhasil dihapus');
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
                ->where('status', 'in')
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
                'status' => 'in',
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

            // Set status to out instead of deleting
            $adminMapping->update(['status' => 'out']);

            return redirect()->route('super-admin.classes.show', $class)
                ->with('success', 'Admin berhasil dihapus dari kegiatan');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Class Reports Management
    public function classReports(Request $request)
    {
        $search = $request->get('search');
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';

        $classes = \App\Models\Classes::with(['activity.program', 'fasilitatorMappings.fasilitator'])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('activity', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->withCount(['documents' => function ($query) {
                $query->whereHas('uploader', function ($q) {
                    $q->where('role', 'fasilitator');
                });
            }])
            ->latest()
            ->paginate(15);

        return view('super-admin.class-reports.index', compact('classes', 'search', 'routePrefix'));
    }

    public function showClassReports(\App\Models\Classes $class)
    {
        $class->load([
            'activity.program',
            'fasilitatorMappings.fasilitator',
            'documents.uploader',
            'documents.requirement'
        ]);

        // Dokumen laporan dari fasilitator
        $documents = $class->documents()
            ->with(['uploader', 'requirement'])
            ->whereHas('uploader', function ($query) {
                $query->where('role', 'fasilitator');
            })
            ->latest('uploaded_date')
            ->paginate(20, ['*'], 'doc_page');

        // Laporan Nilai
        $grades = \App\Models\Grade::where('class_id', $class->id)
            ->with(['participant', 'fasilitator'])
            ->orderBy('final_score', 'desc')
            ->paginate(20, ['*'], 'grade_page');

        // Laporan Pengumpulan Tugas
        $assignments = $class->documents()
            ->with(['uploader', 'requirement'])
            ->whereHas('uploader', function ($query) {
                $query->where('role', 'peserta');
            })
            ->latest('uploaded_date')
            ->paginate(20, ['*'], 'assignment_page');

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';

        return view('super-admin.class-reports.show', compact('class', 'documents', 'grades', 'assignments', 'routePrefix'));
    }

    public function downloadClassReport(\App\Models\Document $document)
    {
        if (!$document->file_path) {
            return redirect()->back()->with('error', 'File tidak ditemukan di database');
        }

        // Try different storage disks
        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        if (Storage::disk('local')->exists($document->file_path)) {
            return Storage::disk('local')->download($document->file_path, $document->file_name);
        }

        // Try without any disk prefix (default)
        if (Storage::exists($document->file_path)) {
            return Storage::download($document->file_path, $document->file_name);
        }

        // Check if file exists in public path directly
        $publicPath = public_path('storage/' . $document->file_path);
        if (file_exists($publicPath)) {
            return response()->download($publicPath, $document->file_name);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan: ' . $document->file_path);
    }
}
