<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('inicio');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:6|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($usuario);

        return redirect()->route('login')->with('success', '¡Registro exitoso! Inicia sesión.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}