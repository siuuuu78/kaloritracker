<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view("goals.edit", compact("user"));
    }

    public function update(Request $request)
    {
        $request->validate([
            "height" => ["nullable", "numeric", "min:100", "max:250"],
            "start_weight" => ["nullable", "numeric", "min:20", "max:300"],
            "target_weight" => ["nullable", "numeric", "min:20", "max:300"],
            "calorie_target" => ["nullable", "integer", "min:800", "max:6000"],
            "mode" => ["required", "in:bulking,cutting,maintenance"],
        ]);

        $user = Auth::user();

        $user->update([
            "height" => $request->height,
            "start_weight" => $request->start_weight,
            "target_weight" => $request->target_weight,
            "calorie_target" => $request->calorie_target,
            "mode" => $request->mode,
        ]);

        return redirect()
            ->route("goals.edit")
            ->with("success", "Target & profil berhasil diperbarui.");
    }
}
