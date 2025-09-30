<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::info('Login attempt started', [
            'input' => $request->only('gsis_id')
        ]);

        $credentials = $request->validate([
            'gsis_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('Login successful', [
                'user_id' => $user->id,
                'gsis_id' => $user->gsis_id,
            ]);

            $deptCode = $user->employee->department->department_code;
            $route = $this->getDepartmentRoute($deptCode);
            return Inertia::location($route);
        }

        Log::warning('Login failed', [
            'gsis_id' => $request->gsis_id,
        ]);

        return back()->withErrors([
            'gsis_id' => 'The provided GSIS ID or password is incorrect.',
        ])->onlyInput('gsis_id');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(route('login'));
    }

    private function getDepartmentRoute($code)
    {
        $mapping = [
            'LM001' => '/hr-dashboard',       // Inertia HR dashboard
            'LM005' => '/build/dashboard',    // Sneat Budget
            'LM006' => '/build/dashboard',    // Sneat Accounting
            'LM007' => '/build/dashboard',    // Sneat Treasury
        ];

        return $mapping[$code] ?? '/';
    }

    public function createToken(Request $request)
    {
        $credentials = $request->validate([
            'gsis_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
