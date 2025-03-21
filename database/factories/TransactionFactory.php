<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement([Transaction::DEPOSIT, Transaction::WITHDRAW, Transaction::TRANSFER]),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'currency' => $this->faker->randomElement(['USD', 'EUR']),
            'status' => Transaction::COMPLETED,
            'meta' => ['source' => $this->faker->word()],
        ];
    }
}
