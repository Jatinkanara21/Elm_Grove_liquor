<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['user' => request()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required','string','max:100'], 'email' => ['required','email','max:255']]);
        $request->user()->update($data);
        return back()->with('success', 'Profile updated.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required','current_password'],
            'password' => ['required','confirmed','min:8'],
        ]);
        $request->user()->update(['password' => Hash::make($data['password'])]);
        return back()->with('success', 'Password updated.');
    }
}