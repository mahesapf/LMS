<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\FasilitatorMapping;
use App\Models\ParticipantMapping;
use App\Models\Grade;
use App\Models\Document;
use App\Models\DocumentRequirement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitatorController extends Controller
{
    public function dashboard()
    {
        $fasilitatorId = auth()->id();

        $classIds = FasilitatorMapping::where('fasilitator_id', $fasilitatorId)
            ->where('status', 'in')
            ->pluck('class_id');

        $stats = [
            'total_classes' => $classIds->count(),
            'total_participants' => ParticipantMapping::whereIn('class_id', $classIds)
                ->where('status', 'in')
                ->count(),
            'total_grades' => Grade::where('fasilitator_id', $fasilitatorId)->count(),
            'total_documents' => Document::where('user_id', $fasilitatorId)->count(),
        ];

        return view('fasilitator.dashboard', compact('stats'));
    }

    // Profile Management
    public function profile()
    {
        $user = auth()->user();
        return view('fasilitator.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'nip' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:16',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'rank' => 'nullable|string|max:100',
            'group' => 'nullable|string|max:50',
            'last_education' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'email_belajar' => 'nullable|email',
            'photo' => 'nullable|image|max:2048',
            'digital_signature' => 'nullable|image|max:1024',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('fasilitators/photos', 'public');
        }

        // Handle digital signature upload
        if ($request->hasFile('digital_signature')) {
            // Delete old signature if exists
            if ($user->digital_signature) {
                Storage::disk('public')->delete($user->digital_signature);
            }
            $validated['digital_signature'] = $request->file('digital_signature')->store('fasilitators/signatures', 'public');
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }

    // My Classes
    public function myClasses()
    {
        $fasilitatorId = auth()->id();

        $mappings = FasilitatorMapping::with(['class.activity', 'assignedBy'])
            ->where('fasilitator_id', $fasilitatorId)
            ->where('status', 'in')
            ->latest()
            ->paginate(20);

        return view('fasilitator.classes.index', compact('mappings'));
    }

    public function classDetail(Classes $class)
    {
        // Check if fasilitator is assigned to this class
        $mapping = FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        $participants = ParticipantMapping::with('participant')
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->get();

        return view('fasilitator.classes.detail', compact('class', 'participants'));
    }

    // Grading
    public function grades(Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        // Get participants who have submitted documents
        $participants = ParticipantMapping::with(['participant', 'participant.grades' => function($q) use ($class) {
            $q->where('class_id', $class->id);
        }])
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->whereHas('participant.documents', function($q) use ($class) {
                $q->where('class_id', $class->id);
            })
            ->get();

        return view('fasilitator.grades.index', compact('class', 'participants'));
    }

    public function storeGrade(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:users,id',
            'final_score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'graded_date' => 'nullable|date',
        ]);

        // Check if grade already exists
        $existingGrade = Grade::where('participant_id', $validated['participant_id'])
            ->where('class_id', $class->id)
            ->first();

        // Calculate grade letter and status
        $score = $validated['final_score'];
        $gradeLetter = 'E';
        if ($score >= 85) $gradeLetter = 'A';
        elseif ($score >= 80) $gradeLetter = 'A-';
        elseif ($score >= 75) $gradeLetter = 'B+';
        elseif ($score >= 70) $gradeLetter = 'B';
        elseif ($score >= 65) $gradeLetter = 'B-';
        elseif ($score >= 60) $gradeLetter = 'C+';
        elseif ($score >= 55) $gradeLetter = 'C';
        elseif ($score >= 50) $gradeLetter = 'C-';
        elseif ($score >= 45) $gradeLetter = 'D';

        $status = $score >= 60 ? 'lulus' : 'tidak_lulus';

        if ($existingGrade) {
            $existingGrade->update([
                'final_score' => $validated['final_score'],
                'grade_letter' => $gradeLetter,
                'status' => $status,
                'notes' => $validated['notes'] ?? null,
                'graded_date' => $validated['graded_date'] ?? now(),
            ]);
        } else {
            Grade::create([
                'participant_id' => $validated['participant_id'],
                'class_id' => $class->id,
                'fasilitator_id' => auth()->id(),
                'final_score' => $validated['final_score'],
                'grade_letter' => $gradeLetter,
                'status' => $status,
                'notes' => $validated['notes'] ?? null,
                'graded_date' => $validated['graded_date'] ?? now(),
            ]);
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan');
    }

    // Documents
    public function documents()
    {
        $documents = Document::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('fasilitator.documents.index', compact('documents'));
    }

    public function uploadDocument()
    {
        return view('fasilitator.documents.upload');
    }

    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:surat_tugas,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/fasilitator', $filename, 'public');

        Document::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'file_name' => $filename,
            'uploaded_date' => now(),
        ]);

        return redirect()->route('fasilitator.documents')->with('success', 'Dokumen berhasil diupload');
    }

    public function deleteDocument(Document $document)
    {
        // Check ownership
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($document->file_path);
        $document->forceDelete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus permanent dari database');
    }

    // Participant Mapping
    public function participantMappingsIndex()
    {
        $fasilitatorId = auth()->id();

        // Get classes that this fasilitator is assigned to
        $classIds = FasilitatorMapping::where('fasilitator_id', $fasilitatorId)
            ->where('status', 'in')
            ->pluck('class_id');

        $classesWithMappings = Classes::with(['activity', 'participantMappings.participant'])
            ->whereIn('id', $classIds)
            ->get();

        $stats = [
            'in' => ParticipantMapping::whereIn('class_id', $classIds)->where('status', 'in')->count(),
            'move' => ParticipantMapping::whereIn('class_id', $classIds)->where('status', 'move')->count(),
            'out' => ParticipantMapping::whereIn('class_id', $classIds)->where('status', 'out')->count(),
        ];

        return view('fasilitator.mappings.index', compact('classesWithMappings', 'stats'));
    }

    public function participantMappings(Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        $mappings = ParticipantMapping::with(['participant', 'assignedBy'])
            ->where('class_id', $class->id)
            ->latest()
            ->get();

        $availableParticipants = User::where('role', 'peserta')
            ->where('status', 'active')
            ->whereNotIn('id', $mappings->where('status', 'in')->pluck('participant_id'))
            ->get();

        $availableClasses = Classes::whereHas('fasilitatorMappings', function($query) {
                $query->where('fasilitator_id', auth()->id())
                    ->where('status', 'in');
            })
            ->where('id', '!=', $class->id)
            ->get();

        return view('fasilitator.mappings.participants', compact('class', 'mappings', 'availableParticipants', 'availableClasses'));
    }

    public function assignParticipant(Request $request, Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

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
        // Check if fasilitator is assigned to the current class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $mapping->class_id)
            ->where('status', 'in')
            ->firstOrFail();

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
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $mapping->class_id)
            ->where('status', 'in')
            ->firstOrFail();

        $mapping->update([
            'status' => 'out',
            'removed_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Peserta berhasil dihapus dari kelas');
    }

    // Document Submissions
    public function viewDocumentRequirements(Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        // Get all document requirements for this class with submission counts
        $requirements = DocumentRequirement::where('class_id', $class->id)
            ->with(['stage', 'documents.user'])
            ->withCount('documents')
            ->orderBy('created_at')
            ->get();

        // Get total participants
        $totalParticipants = ParticipantMapping::where('class_id', $class->id)
            ->where('status', 'in')
            ->count();

        // Get stages for dropdown
        $stages = \App\Models\Stage::orderBy('name')->get();

        return view('fasilitator.documents.requirements', compact('class', 'requirements', 'totalParticipants', 'stages'));
    }

    public function createDocumentRequirement(Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        $stages = \App\Models\Stage::orderBy('name')->get();

        return view('fasilitator.documents.create-requirement', compact('class', 'stages'));
    }

    public function storeDocumentRequirement(Request $request, Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        $validated = $request->validate([
            'stage_id' => 'nullable|exists:stages,id',
            'documents' => 'required|array|min:1',
            'documents.*.document_name' => 'required|string|max:255',
            'documents.*.document_type' => 'required|string|in:pdf,doc,docx,ppt,pptx,image,video,other',
            'documents.*.description' => 'nullable|string',
            'documents.*.is_required' => 'required|boolean',
            'documents.*.max_file_size' => 'nullable|numeric|min:1|max:50',
        ]);

        $createdCount = 0;
        foreach ($validated['documents'] as $docData) {
            DocumentRequirement::create([
                'class_id' => $class->id,
                'stage_id' => $validated['stage_id'],
                'document_name' => $docData['document_name'],
                'document_type' => $docData['document_type'],
                'description' => $docData['description'] ?? null,
                'is_required' => $docData['is_required'],
                'max_file_size' => $docData['max_file_size'] ?? 10,
            ]);
            $createdCount++;
        }

        return redirect()->route('fasilitator.classes.document-requirements', $class)
            ->with('success', $createdCount . ' tugas berhasil dibuat');
    }

    public function deleteDocumentRequirement(Classes $class, DocumentRequirement $requirement)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        // Check if requirement belongs to this class
        if ($requirement->class_id !== $class->id) {
            abort(403, 'Requirement tidak termasuk dalam kelas ini');
        }

        // Delete all associated documents
        foreach ($requirement->documents as $document) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();
        }

        $requirement->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus');
    }

    public function viewSubmissions(Classes $class, DocumentRequirement $requirement)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        // Check if requirement belongs to this class
        if ($requirement->class_id !== $class->id) {
            abort(403, 'Requirement tidak termasuk dalam kelas ini');
        }

        // Get all participants in this class
        $participants = ParticipantMapping::with(['participant'])
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->get();

        // Get submissions for this requirement
        $submissions = Document::where('document_requirement_id', $requirement->id)
            ->with('user')
            ->get()
            ->keyBy('user_id');

        // Build data with submission status
        $participantSubmissions = $participants->map(function($mapping) use ($submissions, $requirement) {
            $submission = $submissions->get($mapping->participant_id);

            return [
                'participant' => $mapping->participant,
                'mapping' => $mapping,
                'submission' => $submission,
                'has_submitted' => $submission !== null,
                'submitted_at' => $submission ? $submission->uploaded_date : null,
                'file_path' => $submission ? $submission->file_path : null,
                'file_name' => $submission ? $submission->file_name : null,
            ];
        });

        // Count statistics
        $stats = [
            'total_participants' => $participants->count(),
            'submitted' => $submissions->count(),
            'not_submitted' => $participants->count() - $submissions->count(),
            'completion_rate' => $participants->count() > 0
                ? round(($submissions->count() / $participants->count()) * 100, 1)
                : 0,
        ];

        return view('fasilitator.documents.submissions', compact(
            'class',
            'requirement',
            'participantSubmissions',
            'stats'
        ));
    }
}
