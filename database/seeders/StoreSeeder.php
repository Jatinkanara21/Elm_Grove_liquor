<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

/**
 * Real locations are not invented. One inactive placeholder is created so the
 * admin can edit it with true details and switch it to Active.
 */
class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::firstOrCreate(
            ['slug' => 'elm-grove-liquor-main'],
            [
                'name' => 'Elm Grove Liquor',
                'address' => 'Address to be added in Admin',
                'is_active' => false,
            ]
        );
    }
}