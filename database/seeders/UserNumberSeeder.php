<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function GenerateNumber()
    {
        do {
            $number = rand(100000, 999999);
        } while (User::where('user_number', $number)->exists());

        return $number;
    }
    public function run(): void
    {


        User::all()->each(function ($user) {
            $user->update([
                'user_number' => $this->GenerateNumber(),
            ]);
        });
    }
}
