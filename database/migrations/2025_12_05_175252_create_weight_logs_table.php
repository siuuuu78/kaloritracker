<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("weight_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->date("date"); // tanggal penimbangan
            $table->float("weight"); // berat (kg)
            $table->string("note")->nullable(); // catatan opsional
            $table->timestamps();

            $table->unique(["user_id", "date"]); // 1 data per hari per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("weight_logs");
    }
};
