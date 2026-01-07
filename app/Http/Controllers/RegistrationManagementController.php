<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Classes;
use App\Models\ParticipantMapping;
use Illuminate\Http\Request;

class RegistrationManagementController extends Controller
{
    /**
     * Display validated registrations.
     */
    public function index()
    {
        $registrations = Registration::with(['activity.program', 'user', 'class'])
            ->where('status', 'validated')
            ->orderBy('created_at', 'desc')
            ->get();

        $classes = Classes::with('activity.program')->get();

        return view('admin.registrations.index', compact('registrations', 'classes'));
    }

    /**
     * Assign participant to class.
     */
    public function assignToClass(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        // Update registration
        $registration->update([
            'class_id' => $validated['class_id']
        ]);

        // Create participant mapping if not exists
        $existingMapping = ParticipantMapping::where('user_id', $registration->user_id)
            ->where('class_id', $validated['class_id'])
            ->first();

        if (!$existingMapping) {
            ParticipantMapping::create([
                'user_id' => $registration->user_id,
                'class_id' => $validated['class_id'],
            ]);
        }

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Peserta berhasil ditambahkan ke kelas.');
    }

    /**
     * Remove participant from class.
     */
    public function removeFromClass(Registration $registration)
    {
        if ($registration->class_id) {
            // Remove participant mapping
            ParticipantMapping::where('user_id', $registration->user_id)
                ->where('class_id', $registration->class_id)
                ->delete();

            $registration->update([
                'class_id' => null
            ]);
        }

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Peserta berhasil dihapus dari kelas.');
    }
}
