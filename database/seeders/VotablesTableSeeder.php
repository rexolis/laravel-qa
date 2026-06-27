<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('votables')->delete();

        Question::query()->each(function (Question $question) {
            User::query()
                ->inRandomOrder()
                ->limit(fake()->numberBetween(1, User::count()))
                ->get()
                ->each(fn (User $user) => $user->voteQuestion(
                    $question,
                    fake()->randomElement([-1, 1])
                ));
        });

        Answer::query()->each(function (Answer $answer) {
            User::query()
                ->inRandomOrder()
                ->limit(fake()->numberBetween(1, User::count()))
                ->get()
                ->each(fn (User $user) => $user->voteAnswer(
                    $answer,
                    fake()->randomElement([-1, 1])
                ));
        });
    }
}
