<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Classes;
use App\Models\ParticipantMapping;
use App\Models\FasilitatorMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_participants' => User::where('role', 'peserta')->count(),
            'total_activities' => Activity::count(),
            'total_classes' => Classes::count(),
            'active_participants' => ParticipantMapping::where('status', 'in')->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    // Participant Management
    public function participants()
    {
        $participants = User::where('role', 'peserta')->latest()->paginate(20);
        return view('admin.participants.index', compact('participants'));
    }

    public function createParticipant()
    {
        return view('admin.participants.create');
    }

    public function storeParticipant(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'degree' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'email_belajar' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6',
            'npsn' => 'nullable|string|max:50',
            'nip' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:16',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'pns_status' => 'nullable|in:PNS,Non PNS',
            'rank' => 'nullable|string|max:100',
            'group' => 'nullable|string|max:50',
            'last_education' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:255',
            'position_type' => 'nullable|in:Guru,Kepala Sekolah,Lainnya',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'digital_signature' => 'nullable|image|max:1024',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'peserta';
        $validated['status'] = 'active';

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('participants/photos', 'public');
        }

        if ($request->hasFile('digital_signature')) {
            $validated['digital_signature'] = $request->file('digital_signature')->store('participants/signatures', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.participants')->with('success', 'Peserta berhasil dibuat');
    }

    public function editParticipant(User $participant)
    {
        return view('admin.participants.edit', compact('participant'));
    }

    public function updateParticipant(Request $request, User $participant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'degree' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email,' . $participant->id,
            'email_belajar' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,suspended,inactive',
            'npsn' => 'nullable|string|max:50',
            'nip' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:16',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'pns_status' => 'nullable|in:PNS,Non PNS',
            'rank' => 'nullable|string|max:100',
            'group' => 'nullable|string|max:50',
            'last_education' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:255',
            'position_type' => 'nullable|in:Guru,Kepala Sekolah,Lainnya',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'digital_signature' => 'nullable|image|max:1024',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('participants/photos', 'public');
        }

        if ($request->hasFile('digital_signature')) {
            $validated['digital_signature'] = $request->file('digital_signature')->store('participants/signatures', 'public');
        }

        $participant->update($validated);

        return redirect()->route('admin.participants')->with('success', 'Peserta berhasil diupdate');
    }

    public function deleteParticipant(User $participant)
    {
        $participant->delete();
        return redirect()->route('admin.participants')->with('success', 'Peserta berhasil dihapus');
    }

    public function suspendParticipant(User $participant)
    {
        $participant->update(['status' => 'suspended']);
        return redirect()->back()->with('success', 'Peserta berhasil disuspend');
    }

    // Activity Management
    public function activities()
    {
        $activities = Activity::with('program')->latest()->paginate(20);
        return view('admin.activities.index', compact('activities'));
    }

    // Class Management
    public function classes(Request $request)
    {
        $query = Classes::with(['activity', 'creator']);
        
        if ($request->has('activity_id')) {
            $query->where('activity_id', $request->activity_id);
        }
        
        $classes = $query->latest()->paginate(20);
        $activities = Activity::all();
        
        return view('admin.classes.index', compact('classes', 'activities'));
    }

    public function createClass()
    {
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])->get();
        return view('admin.classes.create', compact('activities'));
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

        Classes::create($validated);

        return redirect()->route('admin.classes')->with('success', 'Kelas berhasil dibuat');
    }

    public function editClass(Classes $class)
    {
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])->get();
        return view('admin.classes.edit', compact('class', 'activities'));
    }

    public function updateClass(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:open,closed,completed',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes')->with('success', 'Kelas berhasil diupdate');
    }

    public function deleteClass(Classes $class)
    {
        $class->delete();
        return redirect()->route('admin.classes')->with('success', 'Kelas berhasil dihapus');
    }

    // Participant Mapping
    public function mappingsIndex(Request $request)
    {
        $query = Classes::with(['activity', 'participantMappings.participant']);
        
        if ($request->has('activity_id') && $request->activity_id) {
            $query->where('activity_id', $request->activity_id);
        }
        
        if ($request->has('class_id') && $request->class_id) {
            $query->where('id', $request->class_id);
        }
        
        $classesWithMappings = $query->get();
        $activities = Activity::all();
        $classes = Classes::all();
        
        $stats = [
            'in' => ParticipantMapping::where('status', 'in')->count(),
            'move' => ParticipantMapping::where('status', 'move')->count(),
            'out' => ParticipantMapping::where('status', 'out')->count(),
        ];
        
        return view('admin.mappings.index', compact('classesWithMappings', 'activities', 'classes', 'stats'));
    }

    public function participantMappings(Classes $class)
    {
        $mappings = ParticipantMapping::with(['participant', 'assignedBy'])
            ->where('class_id', $class->id)
            ->latest()
            ->get();
            
        $availableParticipants = User::where('role', 'peserta')
            ->where('status', 'active')
            ->whereNotIn('id', $mappings->where('status', 'in')->pluck('participant_id'))
            ->get();
            
        return view('admin.mappings.participants', compact('class', 'mappings', 'availableParticipants'));
    }

    public function assignParticipant(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:users,id',
            'enrolled_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        ParticipantMapping::create([
            'participant_id' => $validated['participant_id'],
            'class_id' => $class->id,
            'status' => 'in',
            'enrolled_date' => $validated['enrolled_date'] ?? now(),
            'notes' => $validated['notes'] ?? null,
            'assigned_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Peserta berhasil ditambahkan ke kelas');
    }

    public function moveParticipant(Request $request, ParticipantMapping $mapping)
    {
        $validated = $request->validate([
            'new_class_id' => 'required|exists:classes,id|different:' . $mapping->class_id,
            'notes' => 'nullable|string',
        ]);

        ParticipantMapping::create([
            'participant_id' => $mapping->participant_id,
            'class_id' => $validated['new_class_id'],
            'status' => 'in',
            'previous_class_id' => $mapping->class_id,
            'enrolled_date' => now(),
            'moved_date' => now(),
            'notes' => $validated['notes'] ?? null,
            'assigned_by' => auth()->id(),
        ]);

        $mapping->update([
            'status' => 'move',
            'moved_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Peserta berhasil dipindahkan');
    }

    public function removeParticipant(ParticipantMapping $mapping)
    {
        $mapping->update([
            'status' => 'out',
            'removed_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Peserta berhasil dihapus dari kelas');
    }

    // Fasilitator Mapping
    public function fasilitatorMappings(Classes $class)
    {
        $mappings = FasilitatorMapping::with(['fasilitator', 'assignedBy'])
            ->where('class_id', $class->id)
            ->latest()
            ->get();
            
        $availableFasilitators = User::where('role', 'fasilitator')
            ->where('status', 'active')
            ->whereNotIn('id', $mappings->where('status', 'in')->pluck('fasilitator_id'))
            ->get();
            
        return view('admin.classes.fasilitators', compact('class', 'mappings', 'availableFasilitators'));
    }

    public function assignFasilitator(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'fasilitator_id' => 'required|exists:users,id',
            'assigned_date' => 'nullable|date',
        ]);

        FasilitatorMapping::create([
            'fasilitator_id' => $validated['fasilitator_id'],
            'class_id' => $class->id,
            'status' => 'in',
            'assigned_date' => $validated['assigned_date'] ?? now(),
            'assigned_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Fasilitator berhasil ditambahkan ke kelas');
    }

    public function removeFasilitator(FasilitatorMapping $mapping)
    {
        $mapping->update([
            'status' => 'out',
            'removed_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Fasilitator berhasil dihapus dari kelas');
    }

    // Document Requirements Management
    public function classDocuments(Classes $class)
    {
        $requirements = $class->documentRequirements()->with('documents.uploader')->get();
        return view('admin.classes.documents', compact('class', 'requirements'));
    }

    public function storeDocumentRequirement(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'nullable|string',
            'description' => 'nullable|string',
            'max_file_size' => 'nullable|integer|min:100',
            'is_required' => 'nullable|boolean',
        ]);

        \App\Models\DocumentRequirement::create([
            'class_id' => $class->id,
            'document_name' => $validated['document_name'],
            'document_type' => $validated['document_type'] ?? null,
            'description' => $validated['description'] ?? null,
            'max_file_size' => $validated['max_file_size'] ?? 5120,
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->back()->with('success', 'Requirement dokumen berhasil ditambahkan');
    }

    public function updateDocumentRequirement(Request $request, Classes $class, \App\Models\DocumentRequirement $requirement)
    {
        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'nullable|string',
            'description' => 'nullable|string',
            'max_file_size' => 'nullable|integer|min:100',
            'is_required' => 'nullable|boolean',
        ]);

        $requirement->update([
            'document_name' => $validated['document_name'],
            'document_type' => $validated['document_type'] ?? null,
            'description' => $validated['description'] ?? null,
            'max_file_size' => $validated['max_file_size'] ?? 5120,
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->back()->with('success', 'Requirement dokumen berhasil diperbarui');
    }

    public function destroyDocumentRequirement(Classes $class, \App\Models\DocumentRequirement $requirement)
    {
        $requirement->delete();
        return redirect()->back()->with('success', 'Requirement dokumen berhasil dihapus');
    }
}
