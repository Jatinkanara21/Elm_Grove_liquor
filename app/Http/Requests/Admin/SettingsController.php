<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'website_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\-\s.]*$/'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string', 'max:255'],
            'opening_hours' => ['nullable', 'string', 'max:1000'],
            'google_maps_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'facebook_url' => ['nullable', 'url'],
            'accepting_online_orders' => ['boolean'],
            'maintenance_mode' => ['boolean'],
            'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $old = Setting::where('key', 'logo')->value('value');
            $this->images->delete($old);
            $data['logo'] = $this->images->store($request->file('logo'), 'settings', 500);
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}