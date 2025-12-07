<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("foods", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("name"); // nama makanan: "Nasi + Telur 2"
            $table
                ->integer("default_calories") // kalori default per porsi
                ->nullable();
            $table->string("default_portion")->nullable(); // misal: "1 porsi", "1 gelas"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("foods");
    }
};
