<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::query()->orderBy('key')->pluck('value', 'key');
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'website_name' => ['nullable','string','max:150'],
            'website_description' => ['nullable','string','max:500'],
            'contact_email' => ['nullable','email','max:255'],
            'contact_phone' => ['nullable','string','max:40'],
            'google_maps_url' => ['nullable','url','max:1000'],
            'order_access_enabled' => ['sometimes','boolean'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings updated.');
    }
}