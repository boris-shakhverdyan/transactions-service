<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->uuid("uuid")->unique(); // for external transmission
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('type', [Transaction::DEPOSIT, Transaction::WITHDRAW, Transaction::TRANSFER]);
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');

            $table->enum('status', [Transaction::PENDING, Transaction::COMPLETED, Transaction::FAILED])
                ->default(Transaction::PENDING);

            $table->json('meta')->nullable(); // additional data

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
