<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Sample catalog entries. Only widely documented facts are filled in; unknown
 * fields stay null for the admin to complete. No prices or stock, by design.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['whiskey', "Maker's Mark", 'Kentucky Straight Bourbon', 'Bourbon', 'United States', 'Kentucky', 45.0, '750 ml', true,
                'A wheated Kentucky straight bourbon known for a soft, approachable profile.'],
            ['whiskey', 'Jameson', 'Irish Whiskey', 'Irish Whiskey', 'Ireland', null, 40.0, '750 ml', true,
                'A triple-distilled Irish whiskey with a smooth character.'],
            ['vodka', "Tito's", 'Handmade Vodka', 'Vodka', 'United States', 'Texas', 40.0, '750 ml', true,
                'A corn-based vodka distilled in Austin, Texas.'],
            ['rum', 'Bacardí', 'Superior White Rum', 'White Rum', 'Puerto Rico', null, 40.0, '750 ml', false,
                'A light white rum widely used in classic cocktails.'],
            ['gin', 'Tanqueray', 'London Dry Gin', 'London Dry Gin', 'United Kingdom', null, null, '750 ml', false,
                'A classic London dry gin with a juniper-forward profile.'],
            ['tequila', 'Casamigos', 'Blanco Tequila', 'Blanco Tequila', 'Mexico', 'Jalisco', 40.0, '750 ml', true,
                'A blanco tequila made from 100% blue Weber agave.'],
            ['beer', 'Guinness', 'Draught Stout', 'Stout', 'Ireland', null, null, null, false,
                'An Irish dry stout with a creamy texture.'],
            ['champagne', 'Moët & Chandon', 'Impérial Brut', 'Brut Champagne', 'France', 'Champagne', null, '750 ml', true,
                'A non-vintage brut Champagne from the Champagne region of France.'],
        ];

        foreach ($rows as [$cat, $brand, $name, $type, $country, $region, $abv, $size, $featured, $short]) {
            $category = Category::where('slug', $cat)->first();
            if (! $category) {
                continue;
            }

            Product::updateOrCreate(
                ['slug' => Str::slug("$brand $name")],
                [
                    'category_id' => $category->id,
                    'name' => $name,
                    'brand' => $brand,
                    'short_description' => $short,
                    'description' => $short,
                    'type' => $type,
                    'country' => $country,
                    'region' => $region,
                    'alcohol_percentage' => $abv,
                    'bottle_size' => $size,
                    'is_featured' => $featured,
                    'is_active' => true,
                ]
            );
        }
    }
}