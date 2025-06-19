<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[0-9])(?=.*[\W_]).+$/'
            ],
        ], [
            'password.regex' => 'Pastikan kata sandi mengandung angka (0–9) dan simbol seperti ! @ # $ %.'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'Pengguna',
            'is_active' => true,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}
