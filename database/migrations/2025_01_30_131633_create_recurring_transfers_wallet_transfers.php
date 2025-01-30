<?php

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
        Schema::create('recurring_transfers_wallet_transfers', function (Blueprint $table) {
            $table->foreignId("recurring_transfer_id");
            $table->foreignId("wallet_transfer_id");

            $table->primary(["recurring_transfer_id", "wallet_transfer_id"]);

            $table->foreign("recurring_transfer_id")
                ->references("id")->on("recurring_transfers")
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign("wallet_transfer_id")
                ->references("id")->on("wallets_transfers")
                ->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_transfers_wallet_transfers');
    }
};
