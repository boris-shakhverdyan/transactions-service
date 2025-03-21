<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'email' => 'demo@example.com',
            'name' => 'Demo User',
        ]);

        $token = $user->createToken("API Token")->plainTextToken;
        $this->command->info("User token: " . $token);

        Transaction::factory()->count(5)->create(['user_id' => $user->id]);
    }
}
