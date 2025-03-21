<?php


namespace Tests\Feature\Transaction;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTransactionValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_fails_with_negative_amount(): void
    {
        $user = User::factory()->create();

        $payload = [
            'type' => 'deposit',
            'amount' => -10,
            'currency' => 'USD',
        ];

        $response = $this
            ->actingAs($user)
            ->postJson('/api/transactions', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['amount']);
    }

    public function test_transaction_fails_with_invalid_currency(): void
    {
        $user = User::factory()->create();

        $payload = [
            'type' => 'deposit',
            'amount' => 100,
            'currency' => 'BTC', // not supported
        ];

        $response = $this
            ->actingAs($user)
            ->postJson('/api/transactions', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['currency']);
    }
}
