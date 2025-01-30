<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecurringTransfer extends Model
{
    protected $guarded = ["id"];

    /**
     * @return BelongsTo<Wallet>
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, "source_id");
    }
    /**
     * @return BelongsTo<Wallet>
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, "target_id");
    }

    /**
     * @return BelongsToMany<WalletTransfer>
     */
    public function transfers(): BelongsToMany
    {
        return $this->belongsToMany(WalletTransfer::class, "recurring_transfers_wallet_transfers", "recurring_transfer_id", "wallet_transfer_id");
    }
}
