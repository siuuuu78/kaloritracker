<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use App\Models\FoodLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Berat terakhir
        $latestWeight = WeightLog::where("user_id", $user->id)
            ->orderByDesc("date")
            ->first();

        // Log berat untuk grafik (30 hari terakhir)
        $weightLogs = WeightLog::where("user_id", $user->id)
            ->where("date", ">=", Carbon::now()->subDays(30)->toDateString())
            ->orderBy("date")
            ->get();

        $weightChartLabels = $weightLogs
            ->pluck("date")
            ->map(fn($d) => $d->format("d M"));
        $weightChartData = $weightLogs->pluck("weight");

        // Kalori hari ini
        $today = now()->toDateString();

        $todayFoodLogs = FoodLog::where("user_id", $user->id)
            ->where("date", $today)
            ->get();

        $todayCalories = $todayFoodLogs->sum("calories");

        // Kalori per hari (14 hari terakhir)
        $caloriePerDay = FoodLog::selectRaw("date, SUM(calories) as total")
            ->where("user_id", $user->id)
            ->where("date", ">=", Carbon::now()->subDays(14)->toDateString())
            ->groupBy("date")
            ->orderBy("date")
            ->get();

        $calorieChartLabels = $caloriePerDay
            ->pluck("date")
            ->map(fn($d) => Carbon::parse($d)->format("d M"));
        $calorieChartData = $caloriePerDay->pluck("total");

        // Rata-rata kalori 7 hari terakhir
        $avgCalories7 = FoodLog::where("user_id", $user->id)
            ->where("date", ">=", Carbon::now()->subDays(7)->toDateString())
            ->selectRaw("AVG(calories) as avg_cal")
            ->value("avg_cal");

        if ($avgCalories7 !== null) {
            $avgCalories7 = round($avgCalories7);
        }

        return view("dashboard", [
            "user" => $user,
            "latestWeight" => $latestWeight,
            "todayCalories" => $todayCalories,
            "weightChartLabels" => $weightChartLabels,
            "weightChartData" => $weightChartData,
            "calorieChartLabels" => $calorieChartLabels,
            "calorieChartData" => $calorieChartData,
            "avgCalories7" => $avgCalories7,
        ]);
    }
}
