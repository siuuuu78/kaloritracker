<?php

namespace App\Http\Controllers;

use App\Models\FoodLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodLogController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $today = now()->toDateString();

        $todayLogs = FoodLog::where("user_id", $user->id)
            ->where("date", $today)
            ->orderBy("meal_type")
            ->get();

        $todayCalories = $todayLogs->sum("calories");

        $recentDays = FoodLog::where("user_id", $user->id)
            ->orderByDesc("date")
            ->get()
            ->groupBy("date");

        return view(
            "food_logs.index",
            compact("user", "todayLogs", "todayCalories", "recentDays"),
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            "date" => ["required", "date"],
            "meal_type" => ["required", "in:breakfast,lunch,dinner,snack"],
            "name" => ["required", "string", "max:255"],
            "portion" => ["required", "string", "max:100"],
            "calories" => ["required", "numeric", "min:0"],
        ]);

        FoodLog::create([
            "user_id" => Auth::id(),
            "food_id" => null,
            "date" => $request->date,
            "meal_type" => $request->meal_type,
            "name" => $request->name,
            "portion" => $request->portion,
            "calories" => $request->calories,
        ]);

        return redirect()
            ->route("food_logs.index")
            ->with("success", "Catatan makanan berhasil ditambahkan.");
    }

    public function edit(FoodLog $foodLog)
    {
        if ($foodLog->user_id !== Auth::id()) {
            abort(403);
        }

        return view("food_logs.edit", [
            "log" => $foodLog,
            "user" => Auth::user(),
        ]);
    }

    public function update(Request $request, FoodLog $foodLog)
    {
        if ($foodLog->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            "date" => ["required", "date"],
            "meal_type" => ["required", "in:breakfast,lunch,dinner,snack"],
            "name" => ["required", "string", "max:255"],
            "portion" => ["required", "string", "max:100"],
            "calories" => ["required", "numeric", "min:0"],
        ]);

        $foodLog->update([
            "date" => $request->date,
            "meal_type" => $request->meal_type,
            "name" => $request->name,
            "portion" => $request->portion,
            "calories" => $request->calories,
        ]);

        return redirect()
            ->route("food_logs.index")
            ->with("success", "Catatan makanan berhasil diperbarui.");
    }

    public function destroy(FoodLog $foodLog)
    {
        if ($foodLog->user_id !== Auth::id()) {
            abort(403);
        }

        $foodLog->delete();

        return redirect()
            ->route("food_logs.index")
            ->with("success", "Catatan makanan berhasil dihapus.");
    }
}
