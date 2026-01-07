<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentValidationController extends Controller
{
    /**
     * Display a listing of payments to validate.
     */
    public function index()
    {
        $payments = Payment::with(['registration.activity.program', 'registration.user'])
            ->whereIn('status', ['pending'])
            ->orderBy('created_at', 'desc')
            ->get();

        $validatedPayments = Payment::with(['registration.activity.program', 'registration.user', 'validator'])
            ->whereIn('status', ['validated', 'rejected'])
            ->orderBy('validated_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments', 'validatedPayments'));
    }

    /**
     * Show the payment details.
     */
    public function show(Payment $payment)
    {
        $payment->load(['registration.activity.program', 'registration.user']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Approve the payment (Super Admin only).
     */
    public function approve(Payment $payment)
    {
        $payment->update([
            'status' => 'validated',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        $payment->registration->update([
            'status' => 'validated'
        ]);

        // Update user role to peserta
        $user = $payment->registration->user;
        if ($user->role !== 'peserta') {
            $user->update(['role' => 'peserta']);
        }

        return redirect()->route('super-admin.payments.index')
            ->with('success', 'Pembayaran berhasil divalidasi dan user sekarang menjadi peserta.');
    }

    /**
     * Reject the payment (Super Admin only).
     */
    public function reject(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $payment->update([
            'status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        $payment->registration->update([
            'status' => 'rejected'
        ]);

        return redirect()->route('super-admin.payments.index')
            ->with('success', 'Pembayaran ditolak.');
    }
}
