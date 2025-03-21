<?php

namespace App\Services;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Contracts\Services\TransactionServiceInterface;
use App\Enums\Currency;
use App\Events\TransactionCreated;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\TransactionCreatedNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        protected TransactionRepositoryInterface $repository
    ) {}

    /**
     * @throws Throwable
     */
    public function create(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            // Add uuid if it wasn't passed
            $data['uuid'] ??= Str::uuid()->toString();

            // Currency check
            if (!in_array($data['currency'] ?? 'USD', Currency::values())) {
                throw new InvalidArgumentException("Unsupported currency");
            }

            // Type check
            if (!in_array($data['type'], [Transaction::DEPOSIT, Transaction::WITHDRAW, Transaction::TRANSFER])) {
                throw new InvalidArgumentException("Invalid transaction type");
            }

            // Amount check
            if (($data['amount'] ?? 0) <= 0) {
                throw new InvalidArgumentException("Transaction amount must be positive");
            }

            // Format the amount
            $data['amount'] = number_format((float) $data['amount'], 2, '.', '');

            // Create transaction
            $transaction = $this->repository->create($data);

            // Dispatch event
            TransactionCreated::dispatch($transaction);

            // Send notification
            /** @var User $user */
            $user = optional($transaction->user);

            $user->notify(new TransactionCreatedNotification($transaction));

            return $transaction;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(Transaction $transaction, array $data): bool
    {
        return DB::transaction(function () use ($transaction, $data) {
            return $this->repository->update($transaction, $data);
        });
    }

    /**
     * @throws Throwable
     */
    public function delete(Transaction $transaction): bool
    {
        return DB::transaction(function () use ($transaction) {
            return $this->repository->delete($transaction);
        });
    }

    public function findByUuid(string $uuid): ?Transaction
    {
        return $this->repository->findByUuid($uuid);
    }

    public function getForUser(int $userId): Collection
    {
        return $this->repository->getForUser($userId);
    }
}
