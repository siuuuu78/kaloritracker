<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("food_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");

            $table
                ->foreignId("food_id")
                ->nullable()
                ->references("id")
                ->on("foods")
                ->onDelete("set null"); // kalau template dihapus, log tetap ada

            $table->date("date"); // hari makan
            $table
                ->enum("meal_type", ["breakfast", "lunch", "dinner", "snack"])
                ->default("breakfast");

            $table->string("name"); // nama makanan (boleh override dari template)
            $table->string("portion"); // contoh: "1 porsi", "2 sendok", dll
            $table->integer("calories"); // kalori final setelah hitung porsi

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("food_logs");
    }
};
