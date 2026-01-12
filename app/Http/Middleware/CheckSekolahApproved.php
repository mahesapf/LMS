<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSekolahApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Only check for sekolah role
        if ($user && $user->role === 'sekolah') {
            // Check if account is approved
            if ($user->approval_status !== 'approved') {
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Akun sekolah Anda belum disetujui atau ditolak oleh administrator.');
            }

            // Check if account is active
            if ($user->status !== 'active') {
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Akun sekolah Anda tidak aktif. Silakan hubungi administrator.');
            }
        }

        return $next($request);
    }
}
