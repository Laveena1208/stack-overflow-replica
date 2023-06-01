<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $user->questions()->saveMany(
                Question::factory(random_int(5, 15))->make()
            )->each(function ($question) {
                $question->answers()->saveMany(
                    Answer::factory(random_int(2, 10))->make()
                );
            });
        });

        \App\Models\User::factory()->create([
            'name' => 'Laveena Kithani',
            'email' => 'laveena@example.com',
            'password' => Hash::make('abcd1234')
        ]);
    }
}
