<?php

namespace App\Models;

use App\Traits\HasResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $type
 * @property string $amount
 * @property string $currency
 * @property string $status
 * @property string $meta
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $user
 */
class Transaction extends Model
{
    use HasResource, HasFactory;

    public const WITHDRAW = 'withdraw';
    public const TRANSFER = 'transfer';
    public const DEPOSIT = 'deposit';

    public const PENDING = 'pending';
    public const COMPLETED = 'completed';
    public const FAILED = 'failed';

    protected $fillable = ["uuid", "user_id", "type", "amount", "currency", "status", "meta"];

    protected $casts = ["meta" => "array", "amount" => "decimal:2"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
