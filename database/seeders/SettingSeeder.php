<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Contact details are intentionally blank: fill them in from Admin > Settings.
        $defaults = [
            'website_name' => 'Elm Grove Liquor',
            'tagline' => 'Premium Selection. Elegant Experience. Local Convenience.',
            'logo' => null,
            'phone' => null,
            'email' => null,
            'address' => null,
            'opening_hours' => null,
            'google_maps_url' => null,
            'instagram_url' => null,
            'facebook_url' => null,
            'accepting_online_orders' => '1', // display toggle only; no e-commerce exists
            'maintenance_mode' => '0',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}