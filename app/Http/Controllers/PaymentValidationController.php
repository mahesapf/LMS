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
        $payments = Payment::with(['registration.program', 'registration.user'])
            ->whereIn('status', ['pending'])
            ->orderBy('created_at', 'desc')
            ->get();

        $validatedPayments = Payment::with(['registration.program', 'registration.user', 'validator'])
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
        $payment->load(['registration.program', 'registration.user']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Validate the payment.
     */
    public function validate(Payment $payment)
    {
        $payment->update([
            'status' => 'validated',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        $payment->registration->update([
            'status' => 'validated'
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil divalidasi.');
    }

    /**
     * Reject the payment.
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

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran ditolak.');
    }
}
