<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_transaction(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $payload = [
            'type' => Transaction::DEPOSIT,
            'amount' => 100.50,
            'currency' => 'USD',
            'meta' => ['source' => 'test-case'],
        ];

        $response = $this
            ->actingAs($user)
            ->postJson('/api/transactions', $payload);

        $response->assertCreated()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'transaction' => [
                        'uuid',
                        'user_id',
                        'type',
                        'amount',
                        'currency',
                        'status',
                        'meta',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'type' => $payload['type'],
            'currency' => $payload['currency'],
        ]);
    }
}

