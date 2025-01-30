<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\InsufficientBalance;
use App\Models\RecurringTransfer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

readonly class PerformSetRecurringTransfers
{
    public function __construct(protected PerformExecuteRecurringTransfer $performExecuteRecurringTransfer) {}

    public function execute(Carbon $startDate, Carbon $endDate, int $frequency, User $sender, User $recipient, int $amount, string $reason): RecurringTransfer
    {
        $recurringTransfer = DB::transaction(function () use ($startDate, $endDate, $frequency, $sender, $recipient, $amount, $reason) {
            $recurringTransfer = RecurringTransfer::create([
                "start_date" => $startDate,
                "end_date" => $endDate,
                "frequency" => $frequency,
                "amount" => $amount,
                "source_id" => $sender->wallet->id,
                "target_id" => $recipient->wallet->id,
                "reason" => $reason,
            ]);

            return $recurringTransfer;
        });

        // Once the recurring transfer is set, try to execute it.
        try
        {
            $this->performExecuteRecurringTransfer->execute($recurringTransfer);
        }
        catch (InsufficientBalance $exception)
        {} //TODO find a way to return that the immediate transfer couldn't be executed.

        return $recurringTransfer;
    }
}
