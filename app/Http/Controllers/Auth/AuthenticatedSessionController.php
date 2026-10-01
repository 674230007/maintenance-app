<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // ล็อกอินด้วยฟิลด์ name และ password โดยไม่ใช้อีเมล
        if (! Auth::attempt($request->only('name', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'name' => __('ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/repairs');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}