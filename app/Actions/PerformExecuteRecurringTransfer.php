<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\InsufficientBalance;
use App\Models\RecurringTransfer;
use App\Models\WalletTransfer;
use Illuminate\Support\Facades\DB;

readonly class PerformExecuteRecurringTransfer
{
    public function __construct(protected PerformWalletTransfer $performWalletTransfer) {}

    /**
     * @throws InsufficientBalance
     */
    public function execute(RecurringTransfer $recurringTransfer): WalletTransfer
    {
        return DB::transaction(function () use ($recurringTransfer) {
            // Perform a wallet transfer as set in the recurring transfer.
            $transfer = $this->performWalletTransfer->execute(
                sender: $recurringTransfer->source->user,
                recipient: $recurringTransfer->target->user,
                amount: $recurringTransfer->amount,
                reason: $recurringTransfer->reason,
            );
            //TODO send an email when InsufficientBalance is thrown.

            // Save the transfer in the transfers of the saved recurring transfer.
            $recurringTransfer->transfers()->save($transfer);

            return $transfer;
        });
    }
}
