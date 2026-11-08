<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('profile.show', ['user' => $request->user()->load('profile')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'umur' => ['required', 'integer', 'min:1', 'max:120'],
            'bio' => ['required', 'string', 'max:1000'],
            'alamat' => ['required', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($user, $validated): void {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
            $user->profile->update([
                'umur' => $validated['umur'],
                'bio' => $validated['bio'],
                'alamat' => $validated['alamat'],
            ]);
        });

        return redirect()->route('profile.show')->with('status', 'Profil berhasil diperbarui.');
    }
}
