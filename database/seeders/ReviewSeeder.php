<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

/** Sample review data for development and moderation testing only. */
class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        if (Review::exists()) {
            return;
        }

        $rows = [
            ['Sample Customer A', 5, 'Great selection and helpful staff.', Review::APPROVED],
            ['Sample Customer B', 4, 'Easy to find what I was looking for.', Review::APPROVED],
            ['Sample Customer C', 5, 'Clean, welcoming store.', Review::APPROVED],
            ['Sample Customer D', 3, 'Pending moderation example.', Review::PENDING],
            ['Sample Customer E', 1, 'Rejected example for moderation testing.', Review::REJECTED],
        ];

        foreach ($rows as [$name, $rating, $body, $status]) {
            Review::create([
                'name' => $name,
                'email' => 'sample@example.test',
                'rating' => $rating,
                'body' => $body,
                'status' => $status,
            ]);
        }
    }
}