<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        \App\Models\User::factory(10)->create()->each(function($user){
            for($i=0;$i<random_int(5,10);$i++){
                $user->question()->create(
                    Question::factory()
                    ->make()
                    ->toArray()
                );
            }
        });

        \App\Models\User::factory()->create([
            'name' => 'Laveena Kithani',
            'email' => 'laveena@example.com',
            'password' => Hash::make('abcd1234')
        ]);



    }
}
