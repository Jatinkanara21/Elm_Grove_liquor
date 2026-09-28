<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Whiskey', 'Bourbon, Scotch, Irish, rye and more.'],
            ['Vodka', 'Clean, crisp and versatile spirits.'],
            ['Rum', 'From light and bright to rich and aged.'],
            ['Gin', 'Botanical spirits for classic and modern cocktails.'],
            ['Tequila', 'Blanco, reposado and añejo expressions.'],
            ['Wine', 'Reds, whites, rosés and sparkling selections.'],
            ['Beer', 'Lagers, ales, stouts and craft favorites.'],
            ['Champagne', 'Celebration-ready sparkling wines.'],
            ['Other Spirits', 'Liqueurs, brandy, cognac and specialty bottles.'],
        ];

        foreach ($items as $i => [$name, $desc]) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $desc, 'is_active' => true, 'sort_order' => $i]
            );
        }
    }
}