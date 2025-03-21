<?php

namespace App\Contracts\Services;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Interface for handling transaction-related business logic.
 */
interface TransactionServiceInterface
{
    /**
     * Create a new transaction after applying business rules.
     *
     * @param array{
     *     user_id: int,
     *     type: string,
     *     amount: float,
     *     currency?: string,
     *     meta?: array
     * } $data
     *
     * @return Transaction The newly created transaction model
     *
     * @throws Throwable If database transaction fails or input is invalid
     */
    public function create(array $data): Transaction;

    /**
     * Update an existing transaction with new data.
     *
     * @param Transaction $transaction The transaction model to update
     * @param array $data New values to apply
     * @return bool True if update was successful
     *
     * @throws Throwable
     */
    public function update(Transaction $transaction, array $data): bool;

    /**
     * Delete a transaction from the system.
     *
     * @param Transaction $transaction The transaction model to delete
     * @return bool True if deletion succeeded
     *
     * @throws Throwable
     */
    public function delete(Transaction $transaction): bool;

    /**
     * Find a transaction by its UUID (external identifier).
     *
     * @param string $uuid
     * @return Transaction|null
     */
    public function findByUuid(string $uuid): ?Transaction;

    /**
     * Get all transactions for a specific user.
     *
     * @param int $userId
     * @return Collection<Transaction>
     */
    public function getForUser(int $userId): Collection;
}

