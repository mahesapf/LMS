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
    public function index(Request $request)
    {
        $status = $request->get('status', 'validated'); // Default to validated
        
        $registrations = Registration::with(['activity.program', 'user', 'class', 'teacherParticipants', 'payment'])
            ->when($status !== 'all', function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $classes = Classes::with('activity.program')->get();
        
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'super-admin';

        return view('admin.registrations.index', compact('registrations', 'classes', 'routePrefix', 'status'));
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
        $existingMapping = ParticipantMapping::where('participant_id', $registration->user_id)
            ->where('class_id', $validated['class_id'])
            ->first();

        if (!$existingMapping) {
            ParticipantMapping::create([
                'participant_id' => $registration->user_id,
                'class_id' => $validated['class_id'],
                'enrolled_date' => now(),
                'assigned_by' => auth()->id(),
            ]);
        }

        return redirect()->route('super-admin.registrations.index')
            ->with('success', 'Peserta berhasil ditambahkan ke kelas.');
    }

    /**
     * Remove participant from class.
     */
    public function removeFromClass(Registration $registration)
    {
        if ($registration->class_id) {
            // Remove participant mapping
            ParticipantMapping::where('participant_id', $registration->user_id)
                ->where('class_id', $registration->class_id)
                ->delete();

            $registration->update([
                'class_id' => null
            ]);
        }

        return redirect()->route('super-admin.registrations.index')
            ->with('success', 'Peserta berhasil dihapus dari kelas.');
    }
}
