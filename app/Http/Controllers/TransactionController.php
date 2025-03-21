<?php

namespace App\Http\Controllers;

use App\Contracts\Services\TransactionServiceInterface;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Throwable;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface $service
    ) {}

    /**
     * Get all transactions for the authenticated user.
     */
    public function index(): JsonResponse
    {
        $transactions = $this->service->getForUser(auth()->id());

        return ApiResponse::success([
            'transactions' => TransactionResource::collection($transactions)
        ]);
    }

    /**
     * Store a newly created transaction.
     * @throws Throwable
     */
    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = $this->service->create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return ApiResponse::success([
            'transaction' => TransactionResource::make($transaction)
        ], 'Transaction created', 201);
    }

    /**
     * Show a single transaction by UUID.
     */
    public function show(string $uuid): JsonResponse
    {
        $transaction = $this->service->findByUuid($uuid);

        if (!$transaction) {
            return ApiResponse::error('Transaction not found', 404);
        }

        return ApiResponse::success([
            'transaction' => TransactionResource::make($transaction)
        ]);
    }
}
