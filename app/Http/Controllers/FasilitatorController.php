<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\FasilitatorMapping;
use App\Models\ParticipantMapping;
use App\Models\Grade;
use App\Models\Document;
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
            'degree' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'institution' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

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
            
        $participants = ParticipantMapping::with(['participant', 'participant.grades' => function($q) use ($class) {
            $q->where('class_id', $class->id);
        }])
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->get();
            
        return view('fasilitator.grades.index', compact('class', 'participants'));
    }

    public function storeGrade(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:users,id',
            'assessment_type' => 'required|string|max:255',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'graded_date' => 'nullable|date',
        ]);

        // Check if grade already exists
        $existingGrade = Grade::where('participant_id', $validated['participant_id'])
            ->where('class_id', $class->id)
            ->where('assessment_type', $validated['assessment_type'])
            ->first();

        if ($existingGrade) {
            $existingGrade->update([
                'score' => $validated['score'],
                'notes' => $validated['notes'] ?? null,
                'graded_date' => $validated['graded_date'] ?? now(),
            ]);
        } else {
            Grade::create([
                'participant_id' => $validated['participant_id'],
                'class_id' => $class->id,
                'fasilitator_id' => auth()->id(),
                'assessment_type' => $validated['assessment_type'],
                'score' => $validated['score'],
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
        $document->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
    }

    // Participant Mapping
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
            
        return view('fasilitator.mappings.participants', compact('class', 'mappings'));
    }
}
