<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('favorites')->delete();

        $userIds = User::pluck('id');

        Question::query()->each(function (Question $question) use ($userIds) {
            $favoriteCount = fake()->numberBetween(0, $userIds->count());

            if ($favoriteCount === 0) {
                return;
            }

            $question->favorites()->attach(
                $userIds->random($favoriteCount)
            );
        });
    }
}
