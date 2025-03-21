<?php

namespace App\Contracts\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function all(): Collection;

    public function findById(int $id): ?Transaction;

    public function findByUuid(string $uuid): ?Transaction;

    public function create(array $data): Transaction;

    public function update(Transaction $transaction, array $data): bool;

    public function delete(Transaction $transaction): bool;

    public function getForUser(int $userId): Collection;
}
