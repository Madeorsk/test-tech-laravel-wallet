<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\PerformSetRecurringTransfers;
use App\Http\Requests\Api\V1\SetRecurringTransferRequest;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SetRecurringTransferController
{
    public function __invoke(SetRecurringTransferRequest $request, PerformSetRecurringTransfers $setRecurringTransfers): Response
    {
        $recipient = $request->getRecipient();

        $setRecurringTransfers->execute(
            startDate: Carbon::createFromFormat("Y-m-d", $request->input("start_date")),
            endDate: Carbon::createFromFormat("Y-m-d", $request->input("end_date")),
            frequency: intval($request->input("frequency")),
            sender: $request->user(),
            recipient: $recipient,
            amount: $request->input("amount"),
            reason: $request->input("reason"),
        );

        return response()->noContent(201);
    }
}
