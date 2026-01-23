<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ParticipantMapping;
use App\Models\Grade;
use App\Models\Document;
use App\Models\User;
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
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:16|regex:/^[0-9]{10,16}$/',
            'email_belajar' => 'nullable|email|max:50',
            'npsn' => 'nullable|string|size:8|regex:/^[0-9]{8}$/',
            'nip' => 'nullable|string|size:18|regex:/^[0-9]{18}$/',
            'nik' => 'nullable|string|size:16|regex:/^[0-9]{16}$/',
            'birth_place' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'pns_status' => 'nullable|in:PNS,Non PNS',
            'rank' => 'nullable|string|max:50',
            'group' => 'nullable|string|max:10',
            'position_type' => 'nullable|in:Guru,Kepala Sekolah,Lainnya',
            'position' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:50',
            'last_education' => 'nullable|in:SMA/SMK,D3,S1,S2,S3',
            'major' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'district' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
            'digital_signature' => 'nullable|image|max:1024',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('participants/photos', 'public');
        }

        // Handle digital signature upload
        if ($request->hasFile('digital_signature')) {
            // Delete old signature if exists
            if ($user->digital_signature) {
                Storage::disk('public')->delete($user->digital_signature);
            }
            $validated['digital_signature'] = $request->file('digital_signature')->store('participants/signatures', 'public');
        }

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

        // Get grades for all classes
        $grades = Grade::where('participant_id', $participantId)
            ->get()
            ->groupBy('class_id');

        return view('peserta.classes.index', compact('mappings', 'grades'));
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

        // Get admins for this activity
        $admins = User::whereHas('adminMappings', function($query) use ($class) {
            $query->where('activity_id', $class->activity_id)
                  ->where('status', 'in');
        })->get();

        return view('peserta.classes.detail', compact('class', 'mapping', 'fasilitators', 'myGrades', 'admins'));
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
    public function documentClasses()
    {
        $myClasses = ParticipantMapping::with(['class.activity'])
            ->where('participant_id', auth()->id())
            ->where('status', 'in')
            ->latest()
            ->get();

        return view('peserta.documents.classes', compact('myClasses'));
    }

    public function documents(Classes $class)
    {
        // Verify that the participant is enrolled in this class
        $mapping = ParticipantMapping::where('participant_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        $myClasses = ParticipantMapping::with([
                'class.stages.documentRequirements' => function ($query) {
                    $query->forPeserta();
                },
                'class.stages.documentRequirements.documents' => function($query) {
                    $query->where('uploaded_by', auth()->id());
                },
                'class.activity',
                'class.stages'
            ])
            ->where('participant_id', auth()->id())
            ->where('class_id', $class->id)
            ->where('status', 'in')
            ->firstOrFail();

        return view('peserta.documents.index', compact('myClasses'));
    }

    public function uploadDocument(Request $request)
    {
        $validated = $request->validate([
            'document_requirement_id' => 'required|exists:document_requirements,id',
            'class_id' => 'required|exists:classes,id',
            'file' => 'required|file',
            'notes' => 'nullable|string',
        ]);

        // Get requirement
        $requirement = \App\Models\DocumentRequirement::findOrFail($validated['document_requirement_id']);

        // Check if participant is enrolled
        $mapping = ParticipantMapping::where('participant_id', auth()->id())
            ->where('class_id', $validated['class_id'])
            ->where('status', 'in')
            ->firstOrFail();

        // Validate file type
        $file = $request->file('file');
        if ($requirement->document_type) {
            $allowedTypes = explode(',', $requirement->document_type);
            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, $allowedTypes)) {
                return redirect()->back()->with('error', 'Tipe file tidak sesuai. Hanya diperbolehkan: ' . $requirement->document_type);
            }
        }

        // Validate file size (max_file_size is in MB, convert to bytes)
        $maxSizeInBytes = $requirement->max_file_size * 1024 * 1024;
        if ($file->getSize() > $maxSizeInBytes) {
            return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal: ' . number_format($requirement->max_file_size, 1) . ' MB');
        }

        // Delete old document if exists
        $oldDocument = Document::where('document_requirement_id', $requirement->id)
            ->where('uploaded_by', auth()->id())
            ->first();
        if ($oldDocument) {
            \Storage::delete($oldDocument->file_path);
            $oldDocument->forceDelete();
        }

        // Store file
        $path = $file->store('documents', 'public');

        // Create document record
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

    public function destroyDocument(Document $document)
    {
        // Check ownership
        if ($document->uploaded_by != auth()->id()) {
            abort(403);
        }

        \Storage::delete($document->file_path);
        $document->forceDelete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus permanent dari database');
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
        $document->forceDelete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus permanent dari database');
    }

    public function downloadDocument(Document $document)
    {
        // Check if user can access this document
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    // Biodata Management
    public function biodata()
    {
        $user = auth()->user();
        return view('peserta.biodata', compact('user'));
    }

    public function updateBiodata(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nik' => 'nullable|string|size:16',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'email_belajar_id' => 'nullable|email',
            'gelar' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'nip_nipy' => 'nullable|string|max:50',
            'npsn' => 'nullable|string|max:50',
            'instansi' => 'nullable|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'kabupaten_kota' => 'nullable|string|max:255',
            'provinsi_peserta' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'kcd' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jurusan' => 'nullable|string|max:100',
            'foto_3x4' => 'nullable|image|max:2048',
            'surat_tugas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanda_tangan' => 'nullable|image|max:1024',
        ]);

        // Map form fields to database columns for location
        if (isset($validated['provinsi_peserta'])) {
            $validated['province'] = $validated['provinsi_peserta'];
            unset($validated['provinsi_peserta']);
        }
        if (isset($validated['kabupaten_kota'])) {
            $validated['city'] = $validated['kabupaten_kota'];
            unset($validated['kabupaten_kota']);
        }
        if (isset($validated['kecamatan'])) {
            $validated['district'] = $validated['kecamatan'];
            unset($validated['kecamatan']);
        }

        // Handle foto 3x4 upload
        if ($request->hasFile('foto_3x4')) {
            if ($user->foto_3x4) {
                Storage::disk('public')->delete($user->foto_3x4);
            }
            $validated['foto_3x4'] = $request->file('foto_3x4')->store('peserta/foto', 'public');
        }

        // Handle surat tugas upload
        if ($request->hasFile('surat_tugas')) {
            if ($user->surat_tugas) {
                Storage::disk('public')->delete($user->surat_tugas);
            }
            $validated['surat_tugas'] = $request->file('surat_tugas')->store('peserta/surat-tugas', 'public');
        }

        // Handle tanda tangan upload
        if ($request->hasFile('tanda_tangan')) {
            if ($user->tanda_tangan) {
                Storage::disk('public')->delete($user->tanda_tangan);
            }
            $validated['tanda_tangan'] = $request->file('tanda_tangan')->store('peserta/tanda-tangan', 'public');
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Biodata berhasil diperbarui');
    }
}
