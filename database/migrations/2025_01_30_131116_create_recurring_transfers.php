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
        Schema::create("recurring_transfers", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTimeTz("start_date");
            $table->dateTimeTz("end_date");
            $table->integer("frequency");
            $table->foreignId("source_id")->index();
            $table->foreignId("target_id")->index();
            $table->bigInteger("amount")->unsigned();
            $table->text("reason");

            $table->foreign("source_id")
                ->references("id")->on("wallets")
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign("target_id")
                ->references("id")->on("wallets")
                ->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("recurring_transfers");
    }
};
