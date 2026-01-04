<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ParticipantMapping;
use App\Models\Grade;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesertaController extends Controller
{
    public function dashboard()
    {
        $participantId = auth()->id();
        
        $stats = [
            'total_classes' => ParticipantMapping::where('participant_id', $participantId)
                ->where('status', 'in')
                ->count(),
            'total_grades' => Grade::where('participant_id', $participantId)->count(),
            'total_documents' => Document::where('user_id', $participantId)->count(),
        ];
        
        return view('peserta.dashboard', compact('stats'));
    }

    // Profile Management
    public function profile()
    {
        $user = auth()->user();
        return view('peserta.profile', compact('user'));
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
        $participantId = auth()->id();
        
        $mappings = ParticipantMapping::with(['class.activity', 'assignedBy'])
            ->where('participant_id', $participantId)
            ->where('status', 'in')
            ->latest()
            ->paginate(20);
            
        return view('peserta.classes.index', compact('mappings'));
    }

    public function classDetail(Classes $class)
    {
        // Check if participant is enrolled in this class
        $mapping = ParticipantMapping::where('participant_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();
            
        $fasilitators = $class->fasilitators;
        $myGrades = Grade::where('participant_id', auth()->id())
            ->where('class_id', $class->id)
            ->get();
            
        return view('peserta.classes.detail', compact('class', 'mapping', 'fasilitators', 'myGrades'));
    }

    // My Grades
    public function myGrades()
    {
        $grades = Grade::with(['class.activity', 'fasilitator'])
            ->where('participant_id', auth()->id())
            ->latest('graded_date')
            ->paginate(20);
            
        return view('peserta.grades.index', compact('grades'));
    }

    // Documents
    public function documents()
    {
        $documents = Document::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);
            
        return view('peserta.documents.index', compact('documents'));
    }

    public function uploadDocument()
    {
        $myClasses = ParticipantMapping::with('class')
            ->where('participant_id', auth()->id())
            ->where('status', 'in')
            ->get();
            
        return view('peserta.documents.upload', compact('myClasses'));
    }

    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'nullable|exists:classes,id',
            'type' => 'required|in:surat_tugas,tugas_kegiatan,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Verify class enrollment if class_id is provided
        if ($request->filled('class_id')) {
            ParticipantMapping::where('participant_id', auth()->id())
                ->where('class_id', $validated['class_id'])
                ->where('status', 'in')
                ->firstOrFail();
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/peserta', $filename, 'public');

        Document::create([
            'user_id' => auth()->id(),
            'class_id' => $validated['class_id'] ?? null,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'file_name' => $filename,
            'uploaded_date' => now(),
        ]);

        return redirect()->route('peserta.documents')->with('success', 'Dokumen berhasil diupload');
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

    public function downloadDocument(Document $document)
    {
        // Check if user can access this document
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}
