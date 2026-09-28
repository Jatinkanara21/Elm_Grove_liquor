<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/** Development-only admin. Credentials come from .env; nothing is hard-coded. */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SEED_ADMIN_EMAIL');
        $password = env('SEED_ADMIN_PASSWORD');

        if (app()->isProduction() || ! $email || ! $password) {
            $this->command?->warn('AdminUserSeeder skipped (production, or SEED_ADMIN_* not set in .env).');
            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = env('SEED_ADMIN_NAME', 'Elm Grove Admin');
        $user->password = Hash::make($password);
        $user->is_admin = true;
        $user->email_verified_at ??= now();
        $user->save();
    }
}