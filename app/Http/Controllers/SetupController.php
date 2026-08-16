<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SetupController
{
    private function ensureSetupOpen(): void
    {
        if (User::query()->where('role', 'super_admin')->where('is_active', true)->exists()) {
            abort(404);
        }
    }

    public function show(): View
    {
        $this->ensureSetupOpen();

        return view('setup.admin');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureSetupOpen();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        User::query()->updateOrCreate(
            ['email' => strtolower($data['email'])],
            [
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'role' => 'super_admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );

        return redirect('/admin/login')->with('status', 'Super admin berhasil dibuat. Silakan login.');
    }
}
