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

        // Get participants from registrations (same as super admin)
        $kecamatanStatuses = ['validated', 'payment_uploaded', 'payment_validated', 'approved', 'accepted', 'belum ditentukan', 'belum_ditentukan'];

        $assignedRegistrations = \App\Models\Registration::with(['user', 'teacherParticipants.user'])
            ->where('activity_id', $class->activity_id)
            ->where('class_id', $class->id)
            ->whereIn('status', $kecamatanStatuses)
            ->get();

        // Collect all participants (kepala sekolah + guru) from registrations
        $participants = collect();
        foreach ($assignedRegistrations as $reg) {
            // Add kepala sekolah if exists
            if ($reg->jumlah_kepala_sekolah > 0 && $reg->nama_kepala_sekolah) {
                // Get kepala sekolah email from User if exists
                $kepalaSekolahEmail = '-';
                $kepalaSekolahPhone = '-';
                $kepalaSekolahUserId = $reg->kepala_sekolah_user_id ?? null;
                if ($reg->kepala_sekolah_user_id) {
                    $kepalaUser = \App\Models\User::find($reg->kepala_sekolah_user_id);
                    if ($kepalaUser) {
                        $kepalaSekolahEmail = $kepalaUser->email;
                        $kepalaSekolahPhone = $kepalaUser->phone ?? '-';
                    }
                }

                $participants->push([
                    'type' => 'kepala_sekolah',
                    'registration_id' => $reg->id,
                    'user_id' => $kepalaSekolahUserId,
                    'name' => $reg->nama_kepala_sekolah,
                    'email' => $kepalaSekolahEmail,
                    'institution' => $reg->nama_sekolah,
                    'position' => 'Kepala Sekolah',
                    'phone' => $kepalaSekolahPhone,
                    'nik' => $reg->nik_kepala_sekolah ?? null,
                ]);
            }

            // Add guru dari teacher participants
            foreach ($reg->teacherParticipants as $teacher) {
                // Get position from related user if available
                $position = 'Guru'; // default
                if ($teacher->user_id && $teacher->user) {
                    $position = $teacher->user->position_type
                        ?? $teacher->user->jabatan
                        ?? ($teacher->user->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Guru');
                }

                $participants->push([
                    'type' => 'guru',
                    'registration_id' => $reg->id,
                    'teacher_participant_id' => $teacher->id,
                    'user_id' => $teacher->user_id ?? null,
                    'name' => $teacher->nama_lengkap,
                    'email' => $teacher->email ?? '-',
                    'institution' => $reg->nama_sekolah,
                    'position' => $position,
                    'phone' => $teacher->phone ?? $reg->user->phone ?? '-',
                    'nik' => $teacher->nik ?? null,
                ]);
            }
        }

        // Get stages with document requirements (tasks for peserta only)
        $stages = \App\Models\Stage::with(['documentRequirements' => function ($query) {
                $query->forPeserta();
            }])
            ->where('class_id', $class->id)
            ->orderBy('order')
            ->get();

        // Get facilitator required documents (created by super admin)
        $fasilitatorRequirementsByStage = DocumentRequirement::forFasilitator()
            ->where('class_id', $class->id)
            ->with(['stage', 'documents' => function ($query) {
                $query->where('uploaded_by', auth()->id());
            }])
            ->orderBy('created_at')
            ->get()
            ->groupBy('stage_id');

        $fasilitatorGeneralRequirements = $fasilitatorRequirementsByStage->get(null, collect());

        return view('fasilitator.classes.detail', compact('class', 'participants', 'stages', 'fasilitatorRequirementsByStage', 'fasilitatorGeneralRequirements'));
    }

    // Grading
    public function grades(Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        // Get all active participants in this class (only users with role 'peserta')
        $participants = ParticipantMapping::with(['participant', 'participant.grades' => function($q) use ($class) {
            $q->where('class_id', $class->id);
        }])
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->whereHas('participant', function($q) {
                $q->where('role', 'peserta');
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

        // Pastikan fasilitator mengampu kelas ini
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        // Pastikan peserta memang terdaftar di kelas ini
        $participantMapping = ParticipantMapping::where('class_id', $class->id)
            ->where('participant_id', $validated['participant_id'])
            ->where('status', 'in')
            ->first();

        if (!$participantMapping) {
            return redirect()->back()->with('error', 'Peserta tidak terdaftar di kelas ini.');
        }

        $participant_id = $validated['participant_id'];

        // Check if grade already exists
        $existingGrade = Grade::where('participant_id', $participant_id)
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
                'participant_id' => $participant_id,
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

    public function storeTask(Request $request, Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        $validated = $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'is_required' => 'nullable|boolean',
            'max_file_size' => 'nullable|integer|min:1',
        ]);

        // Verify stage belongs to this class
        $stage = \App\Models\Stage::where('id', $validated['stage_id'])
            ->where('class_id', $class->id)
            ->firstOrFail();

        DocumentRequirement::create([
            'class_id' => $class->id,
            'stage_id' => $validated['stage_id'],
            'document_name' => $validated['document_name'],
            'document_type' => $validated['document_type'],
            'description' => $validated['description'],
            'is_required' => $validated['is_required'] ?? true,
            'max_file_size' => $validated['max_file_size'] ?? 5120, // Default 5MB
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan');
    }

    public function deleteTask(DocumentRequirement $task, Classes $class)
    {
        // Check if fasilitator is assigned to this class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        // Verify task belongs to this class
        if ($task->class_id !== $class->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus');
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
                'target_role' => DocumentRequirement::TARGET_PESERTA,
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

    public function uploadRequiredDocument(Request $request)
    {
        $validated = $request->validate([
            'document_requirement_id' => 'required|exists:document_requirements,id',
            'class_id' => 'required|exists:classes,id',
            'file' => 'required|file',
            'notes' => 'nullable|string',
        ]);

        // Ensure fasilitator is assigned to class
        FasilitatorMapping::where('fasilitator_id', auth()->id())
            ->where('class_id', $validated['class_id'])
            ->where('status', 'in')
            ->firstOrFail();

        $requirement = DocumentRequirement::where('id', $validated['document_requirement_id'])
            ->where('class_id', $validated['class_id'])
            ->firstOrFail();

        if ($requirement->target_role !== DocumentRequirement::TARGET_FASILITATOR) {
            abort(403);
        }

        $file = $request->file('file');

        if ($requirement->document_type) {
            $allowedTypes = array_map('trim', explode(',', $requirement->document_type));
            $fileExtension = strtolower($file->getClientOriginalExtension());
            if (!in_array($fileExtension, $allowedTypes)) {
                return redirect()->back()->with('error', 'Tipe file tidak sesuai. Hanya diperbolehkan: ' . $requirement->document_type);
            }
        }

        // Validate file size (keep consistent with existing peserta upload logic)
        $maxSizeInBytes = $requirement->max_file_size * 1024 * 1024;
        if ($file->getSize() > $maxSizeInBytes) {
            return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal: ' . number_format($requirement->max_file_size, 1) . ' MB');
        }

        $oldDocument = Document::where('document_requirement_id', $requirement->id)
            ->where('uploaded_by', auth()->id())
            ->first();
        if ($oldDocument) {
            Storage::disk('public')->delete($oldDocument->file_path);
            $oldDocument->forceDelete();
        }

        $path = $file->store('documents/fasilitator-required', 'public');

        Document::create([
            'class_id' => $validated['class_id'],
            'document_requirement_id' => $requirement->id,
            'user_id' => auth()->id(),
            'uploaded_by' => auth()->id(),
            'title' => $requirement->document_name,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'description' => $validated['notes'] ?? null,
            'uploaded_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload');
    }

    public function taskSubmissions(Classes $class)
    {
        // Check if fasilitator has access to this class
        $fasilitatorMapping = FasilitatorMapping::where('class_id', $class->id)
            ->where('fasilitator_id', auth()->id())
            ->where('status', 'in')
            ->first();

        if (!$fasilitatorMapping) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini');
        }

        // Get all stages for this class with document requirements (only for peserta)
        $stages = $class->stages()
            ->with(['documentRequirements' => function($query) {
                $query->forPeserta()->orderBy('created_at', 'desc');
            }])
            ->orderBy('order')
            ->get();

        // Get all participants in this class
        $participants = $this->getClassParticipants($class);
        $participantIds = collect($participants)->pluck('user_id')->filter()->toArray();

        // Get all document submissions for this class
        $allSubmissions = Document::where('class_id', $class->id)
            ->whereIn('user_id', $participantIds)
            ->with('user')
            ->get();

        // Group submissions by stage and requirement
        $submissionsByStage = [];
        foreach ($stages as $stage) {
            $stageData = [
                'stage' => $stage,
                'requirements' => []
            ];

            foreach ($stage->documentRequirements as $requirement) {
                $submissions = $allSubmissions->where('document_requirement_id', $requirement->id);

                $requirementData = [
                    'requirement' => $requirement,
                    'total_submitted' => $submissions->count(),
                    'total_participants' => count($participants),
                    'percentage' => count($participants) > 0
                        ? round(($submissions->count() / count($participants)) * 100, 1)
                        : 0,
                    'submissions' => $submissions->map(function($doc) {
                        return [
                            'id' => $doc->id,
                            'participant_name' => $doc->user->name ?? 'Unknown',
                            'participant_email' => $doc->user->email ?? '-',
                            'file_name' => $doc->file_name,
                            'file_path' => $doc->file_path,
                            'uploaded_at' => $doc->created_at,
                            'description' => $doc->description,
                        ];
                    })
                ];

                $stageData['requirements'][] = $requirementData;
            }

            $submissionsByStage[] = $stageData;
        }

        // Calculate overall stats
        $totalTasks = $stages->sum(fn($stage) => $stage->documentRequirements->count());
        $totalSubmissions = $allSubmissions->count();
        $expectedSubmissions = count($participants) * $totalTasks;
        $overallPercentage = $expectedSubmissions > 0
            ? round(($totalSubmissions / $expectedSubmissions) * 100, 1)
            : 0;

        $stats = [
            'total_participants' => count($participants),
            'total_tasks' => $totalTasks,
            'total_submissions' => $totalSubmissions,
            'expected_submissions' => $expectedSubmissions,
            'overall_percentage' => $overallPercentage,
        ];

        return view('fasilitator.tasks.submissions', compact('class', 'submissionsByStage', 'stats', 'participants'));
    }

    /**
     * Get all participants (kepala sekolah + guru) for a class
     */
    private function getClassParticipants(Classes $class)
    {
        $kecamatanStatuses = ['validated', 'payment_uploaded', 'payment_validated', 'approved', 'accepted', 'belum ditentukan', 'belum_ditentukan'];

        $assignedRegistrations = \App\Models\Registration::with(['user', 'teacherParticipants.user'])
            ->where('activity_id', $class->activity_id)
            ->where('class_id', $class->id)
            ->whereIn('status', $kecamatanStatuses)
            ->get();

        // Collect all participants (kepala sekolah + guru) from registrations
        $participants = collect();
        foreach ($assignedRegistrations as $reg) {
            // Add kepala sekolah if exists
            if ($reg->jumlah_kepala_sekolah > 0 && $reg->nama_kepala_sekolah) {
                $userId = $reg->kepala_sekolah_user_id ?? $reg->user_id;

                // Get kepala sekolah email from User if exists
                $kepalaSekolahEmail = '-';
                $kepalaSekolahPhone = '-';
                if ($reg->kepala_sekolah_user_id) {
                    $kepalaUser = \App\Models\User::find($reg->kepala_sekolah_user_id);
                    if ($kepalaUser) {
                        $kepalaSekolahEmail = $kepalaUser->email;
                        $kepalaSekolahPhone = $kepalaUser->phone ?? '-';
                    }
                }

                $participants->push([
                    'type' => 'kepala_sekolah',
                    'registration_id' => $reg->id,
                    'user_id' => $userId,
                    'name' => $reg->nama_kepala_sekolah,
                    'email' => $kepalaSekolahEmail,
                    'institution' => $reg->nama_sekolah,
                    'position' => 'Kepala Sekolah',
                    'phone' => $kepalaSekolahPhone,
                    'nik' => $reg->nik_kepala_sekolah ?? null,
                ]);
            }

            // Add guru dari teacher participants
            foreach ($reg->teacherParticipants as $teacher) {
                // Get position with priority: teacher_participants.jabatan > user.position_type > user.jabatan > default
                $position = 'Guru'; // default

                // First check if jabatan is set directly in teacher_participants table
                if (!empty($teacher->jabatan)) {
                    $position = $teacher->jabatan;
                }
                // Otherwise, try to get from related user if available
                elseif ($teacher->user_id && $teacher->user) {
                    $position = $teacher->user->position_type
                        ?? $teacher->user->jabatan
                        ?? ($teacher->user->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Guru');
                }

                $participants->push([
                    'type' => 'guru',
                    'registration_id' => $reg->id,
                    'teacher_participant_id' => $teacher->id,
                    'user_id' => $teacher->user_id ?? null,
                    'name' => $teacher->nama_lengkap,
                    'email' => $teacher->email ?? '-',
                    'institution' => $reg->nama_sekolah,
                    'position' => $position,
                    'phone' => $teacher->phone ?? $reg->user->phone ?? '-',
                    'nik' => $teacher->nik ?? null,
                ]);
            }
        }

        return $participants;
    }
}
