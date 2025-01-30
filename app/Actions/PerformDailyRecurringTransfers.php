<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\RecurringTransfer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

readonly class PerformDailyRecurringTransfers
{
    public function __construct(protected PerformExecuteRecurringTransfer $performExecuteRecurringTransfer) {}

    public function execute(): void
    {
        DB::transaction(function () {
            // Get all active recurring transfers.
            $recurringTransfers = RecurringTransfer::query()->with(["transfers" => function (BelongsToMany $query) {
               return $query->limit(1)->orderByDesc("created_at");
            }])->whereDate("start_date", ">", Carbon::today())
                ->whereDate("end_date", "<", Carbon::today())
                ->get();

            foreach ($recurringTransfers as $recurringTransfer)
            { // For each active recurring transfer, execute the transfer if enough days have passed.
                $latestTransfer = $recurringTransfer->transfers->first();

                if (empty($latestTransfer) || $latestTransfer->created_at->before(Carbon::today()->subDays($recurringTransfer->frequency)))
                {
                    $this->performExecuteRecurringTransfer->execute($recurringTransfer);
                }
            }
        });
    }
}
