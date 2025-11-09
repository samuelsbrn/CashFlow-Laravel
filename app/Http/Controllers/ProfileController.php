<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        $user->update($data);

        return back()->with('status', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'min:6', 'confirmed'],
        ]);

        // cek password lama
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password sekarang tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password berhasil diganti.');
    }
}
