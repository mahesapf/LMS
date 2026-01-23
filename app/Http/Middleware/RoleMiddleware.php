<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Debug log
        \Log::info('RoleMiddleware Check', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'required_roles' => $roles,
            'url' => $request->url(),
        ]);

        if (!in_array($user->role, $roles)) {
            \Log::warning('Role Mismatch', [
                'user_role' => $user->role,
                'required_roles' => $roles,
            ]);
            abort(403, 'Unauthorized action.');
        }

        // Cek status user
        if ($user->status === 'suspended') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda telah disuspend. Silakan hubungi administrator.');
        }

        if ($user->status === 'inactive') {
            // Khusus role sekolah, cek approval_status
            if ($user->role === 'sekolah') {
                if (isset($user->approval_status)) {
                    if ($user->approval_status === 'pending') {
                        auth()->logout();
                        return redirect()->route('login')->with('error', 'Akun Anda sedang menunggu persetujuan dari administrator. Anda akan dihubungi melalui email setelah akun disetujui.');
                    } elseif ($user->approval_status === 'rejected') {
                        auth()->logout();
                        return redirect()->route('login')->with('error', 'Pendaftaran Anda ditolak. Silakan hubungi administrator untuk informasi lebih lanjut.');
                    }
                }
            }
            
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        return $next($request);
    }
}
