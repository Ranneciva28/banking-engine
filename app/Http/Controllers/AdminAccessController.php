<?php

namespace App\Http\Controllers;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAccessController
{
    public function show(): View
    {
        return view('auth.admin-access');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->whereRaw('lower(email) = ?', [strtolower($data['email'])])->first();

        if (! $user) {
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Akun dengan email ini tidak ditemukan.']);
        }

        if (! Hash::check($data['password'], $user->password)) {
            return back()->withInput($request->only('email'))->withErrors(['password' => 'Password tidak cocok dengan hash yang tersimpan.']);
        }

        if (! $user->is_active) {
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Akun ditemukan, tetapi statusnya tidak aktif.']);
        }

        $panel = Filament::getPanel('admin');
        if (! $user->canAccessPanel($panel)) {
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Akun valid, tetapi role tidak memiliki akses ke panel admin.']);
        }

        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        if (! Auth::guard('web')->check()) {
            return back()->withErrors(['email' => 'Credential valid, tetapi session login gagal dibuat.']);
        }

        return redirect('/admin');
    }
}
