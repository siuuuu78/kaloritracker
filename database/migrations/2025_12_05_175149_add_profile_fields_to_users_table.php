<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float('height')->nullable()->after('email'); // tinggi badan (cm)
            $table->float('start_weight')->nullable()->after('height'); // berat awal
            $table->float('target_weight')->nullable()->after('start_weight');
            $table->integer('calorie_target')->nullable()->after('target_weight'); // target kalori / hari
            $table->enum('mode', ['bulking', 'cutting', 'maintenance'])
                  ->default('bulking')
                  ->after('calorie_target');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'height',
                'start_weight',
                'target_weight',
                'calorie_target',
                'mode',
            ]);
        });
    }
};
