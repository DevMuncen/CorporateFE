<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('api_token')) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            // Target the BackendCorporateLogistic API with portal_type: corporate
            $response = Http::post(config('services.backend.url').'/api/auth/login', [
                'username' => $request->email,
                'password' => $request->password,
                'portal_type' => 'corporate',
            ]);

            if ($response->successful()) {
                $payload = $response->json('data') ?? $response->json();
                $user = $payload['user'] ?? [];

                $role = $user['role'] ?? '';
                if (! in_array($role, ['corporate_admin', 'corporate_inventory', 'corporate_operations', 'corporate_finance', 'corporate_user', 'super_admin', 'admin'])) {
                    return back()->with('error', 'Akses ditolak. Akun Anda bukan akun Corporate.');
                }

                $token = $payload['access_token'] ?? $payload['token'] ?? null;
                $corporateId = $user['corporate_id'] ?? $user['tenant_id'] ?? $payload['corporate_id'] ?? 1;

                // Store token and tenant_corporate_id in session
                session([
                    'api_token' => $token,
                    'tenant_corporate_id' => $corporateId,
                    'user_id' => $user['id'] ?? null,
                    'user_name' => $user['name'] ?? 'User',
                    'user_email' => $user['email'] ?? '',
                    'user_role' => $user['role'] ?? 'corporate_user',
                    'corporate_id' => $corporateId,
                    'corporate_name' => $user['corporate_name'] ?? null,
                    'corporate_code' => $user['corporate_code'] ?? null,
                    'user_data' => $user,
                ]);

                return redirect('/dashboard');
            }

            return back()->with('error', $response->json('message') ?? 'Invalid credentials.');
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to connect to authentication server: '.$e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = session('api_token');

        if ($token) {
            try {
                Http::withToken($token)->post(config('services.backend.url').'/api/auth/logout');
            } catch (\Exception $e) {
                // Ignore failure on logout, just clear local session
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
