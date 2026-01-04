<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Activity;
use App\Models\AdminMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            'degree' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,fasilitator,peserta',
            'institution' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

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
            'degree' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'role' => 'required|in:admin,fasilitator,peserta',
            'status' => 'required|in:active,suspended,inactive',
            'institution' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

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

        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                $rowData = array_combine($header, $row);
                
                User::create([
                    'name' => $rowData['nama'] ?? '',
                    'degree' => $rowData['gelar'] ?? '',
                    'email' => $rowData['email'] ?? '',
                    'phone' => $rowData['nomor_wa'] ?? '',
                    'password' => Hash::make('password123'),
                    'role' => $request->role,
                    'status' => 'active',
                ]);
            }
            
            DB::commit();
            return redirect()->route('super-admin.users')->with('success', 'Import berhasil');
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
        return view('super-admin.activities.index', compact('activities'));
    }

    public function createActivity()
    {
        $programs = Program::where('status', 'active')->get();
        return view('super-admin.activities.create', compact('programs'));
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

        return redirect()->route('super-admin.activities')->with('success', 'Kegiatan berhasil dibuat');
    }

    public function editActivity(Activity $activity)
    {
        $programs = Program::where('status', 'active')->get();
        return view('super-admin.activities.edit', compact('activity', 'programs'));
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

        return redirect()->route('super-admin.activities')->with('success', 'Kegiatan berhasil diupdate');
    }

    public function deleteActivity(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('super-admin.activities')->with('success', 'Kegiatan berhasil dihapus');
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
}
