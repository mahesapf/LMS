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
            // Check if account is approved (status = active)
            // inactive = pending, suspended = rejected
            if ($user->status !== 'active') {
                auth()->logout();

                $message = match($user->status) {
                    'inactive' => 'Akun sekolah Anda masih menunggu persetujuan dari administrator.',
                    'suspended' => 'Akun sekolah Anda ditolak oleh administrator. Silakan hubungi administrator untuk informasi lebih lanjut.',
                    default => 'Akun sekolah Anda tidak aktif. Silakan hubungi administrator.',
                };

                return redirect()->route('login')->with('error', $message);
            }
        }

        return $next($request);
    }
}
