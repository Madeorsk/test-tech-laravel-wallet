<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

\Illuminate\Support\Facades\Schedule::call([\App\Actions\PerformDailyRecurringTransfers::class, "execute"])->dailyAt("02:00");
