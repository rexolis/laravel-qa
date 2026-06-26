<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)
            ->create()
            ->each(function (User $user) {
                Question::factory()
                    ->count(rand(1, 5))
                    ->for($user)
                    ->create()
                    ->each(function (Question $question) {
                        Answer::factory()
                            ->count(rand(1, 5))
                            ->for($question)
                            ->create();
                    });
            });
    }
}
