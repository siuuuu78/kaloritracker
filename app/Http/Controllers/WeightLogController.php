<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightLogController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $logs = WeightLog::where("user_id", $user->id)
            ->orderByDesc("date")
            ->take(30)
            ->get();

        return view("weights.index", compact("logs", "user"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "date" => ["required", "date"],
            "weight" => ["required", "numeric"],
            "note" => ["nullable", "string", "max:255"],
        ]);

        WeightLog::updateOrCreate(
            [
                "user_id" => Auth::id(),
                "date" => $request->date,
            ],
            [
                "weight" => $request->weight,
                "note" => $request->note,
            ],
        );

        return redirect()
            ->route("weights.index")
            ->with("success", "Berat harian berhasil disimpan.");
    }

    public function edit(WeightLog $weightLog)
    {
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        return view("weights.edit", [
            "log" => $weightLog,
            "user" => Auth::user(),
        ]);
    }

    public function update(Request $request, WeightLog $weightLog)
    {
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            "date" => ["required", "date"],
            "weight" => ["required", "numeric"],
            "note" => ["nullable", "string", "max:255"],
        ]);

        $weightLog->update([
            "date" => $request->date,
            "weight" => $request->weight,
            "note" => $request->note,
        ]);

        return redirect()
            ->route("weights.index")
            ->with("success", "Data berat berhasil diperbarui.");
    }

    public function destroy(WeightLog $weightLog)
    {
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        $weightLog->delete();

        return redirect()
            ->route("weights.index")
            ->with("success", "Data berat berhasil dihapus.");
    }
}
