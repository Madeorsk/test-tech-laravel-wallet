<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\PerformSetRecurringTransfers;
use App\Actions\PerformWalletTransfer;
use App\Exceptions\InsufficientBalance;
use App\Http\Requests\SendMoneyRequest;
use App\Http\Requests\SetRecurringTransferRequest;
use Carbon\Carbon;

class SetRecurringTransferController
{
    public function __invoke(SetRecurringTransferRequest $request, PerformSetRecurringTransfers $setRecurringTransfers)
    {
        $recipient = $request->getRecipient();

        $setRecurringTransfers->execute(
            startDate: Carbon::createFromFormat("Y-m-d", $request->input("start_date")),
            endDate: Carbon::createFromFormat("Y-m-d", $request->input("end_date")),
            frequency: intval($request->input("frequency")),
            sender: $request->user(),
            recipient: $recipient,
            amount: $request->getAmountInCents(),
            reason: $request->input("reason"),
        );

        return redirect()->back()
            ->with('recurring-transfers-status', 'success')
            ->with('recurring-transfers-recipient-name', $recipient->name)
            ->with('recurring-transfers-amount', $request->getAmountInCents())
            ->with('recurring-transfers-frequency', $request->input("frequency"));
    }
}
