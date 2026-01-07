<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user to Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google authentication callback.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists with this google_id
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if ($user) {
                // Update user's avatar if changed
                $user->update([
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Check if user exists with this email
                $user = User::where('email', $googleUser->getEmail())->first();
                
                if ($user) {
                    // Link Google account to existing user
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'password' => Hash::make(uniqid()), // Random password
                        'role' => 'peserta', // Default role
                        'status' => 'active',
                    ]);
                }
            }
            
            // Log the user in
            Auth::login($user);
            
            // Redirect based on user role
            return $this->redirectBasedOnRole($user);
            
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }
    
    /**
     * Redirect user based on their role.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('super-admin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'fasilitator':
                return redirect()->route('fasilitator.dashboard');
            case 'peserta':
            default:
                return redirect()->route('home');
        }
    }
}
