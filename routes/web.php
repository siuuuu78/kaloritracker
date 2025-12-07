<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\FoodLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalsController;

Route::get("/", function () {
    // Kalau sudah login, langsung lempar ke dashboard
    if (Auth::check()) {
        return redirect()->route("dashboard");
    }

    // Kalau belum login, tampilkan landing page
    return view("landing");
})->name("landing");

Route::get("/test-storage", function () {
    Storage::disk("public")->put("test.txt", "hello world");
    return "ok";
});

Route::middleware("auth")->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name(
        "dashboard",
    );

    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );

    Route::get("/weights", [WeightLogController::class, "index"])->name(
        "weights.index",
    );
    Route::post("/weights", [WeightLogController::class, "store"])->name(
        "weights.store",
    );
    Route::get("/weights/{weightLog}/edit", [
        WeightLogController::class,
        "edit",
    ])->name("weights.edit");
    Route::put("/weights/{weightLog}", [
        WeightLogController::class,
        "update",
    ])->name("weights.update");
    Route::delete("/weights/{weightLog}", [
        WeightLogController::class,
        "destroy",
    ])->name("weights.destroy");

    Route::get("/food-logs", [FoodLogController::class, "index"])->name(
        "food_logs.index",
    );
    Route::post("/food-logs", [FoodLogController::class, "store"])->name(
        "food_logs.store",
    );
    Route::get("/food-logs/{foodLog}/edit", [
        FoodLogController::class,
        "edit",
    ])->name("food_logs.edit");
    Route::put("/food-logs/{foodLog}", [
        FoodLogController::class,
        "update",
    ])->name("food_logs.update");
    Route::delete("/food-logs/{foodLog}", [
        FoodLogController::class,
        "destroy",
    ])->name("food_logs.destroy");

    Route::get("/goals", [GoalsController::class, "edit"])->name("goals.edit");
    Route::put("/goals", [GoalsController::class, "update"])->name(
        "goals.update",
    );
});

require __DIR__ . "/auth.php";
