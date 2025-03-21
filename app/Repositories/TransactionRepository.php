<?php

namespace App\Repositories;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;
use Illuminate\Support\Collection;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function all(): Collection
    {
        return Transaction::latest()->get();
    }

    public function findById(int $id): ?Transaction
    {
        return Transaction::find($id);
    }

    public function findByUuid(string $uuid): ?Transaction
    {
        return Transaction::where('uuid', $uuid)->first();
    }

    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function update(Transaction $transaction, array $data): bool
    {
        return $transaction->update($data);
    }

    public function delete(Transaction $transaction): bool
    {
        return $transaction->delete();
    }

    public function getForUser(int $userId): Collection
    {
        return Transaction::where('user_id', $userId)->get();
    }
}
