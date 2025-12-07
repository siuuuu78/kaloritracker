<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
// gunakan Storage tapi kita pakai di destroy saja (juga super aman)
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil.
     */
    public function edit(Request $request): View
    {
        return view("profile.edit", [
            "user" => $request->user(),
        ]);
    }

    /**
     * Update informasi profil user (nama, email, avatar).
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->hasFile("avatar")) {
            $f = $request->file("avatar");
            if (!$f->isValid()) {
                return back()
                    ->withErrors([
                        "avatar" =>
                            "Upload error code: " .
                            $f->getError() .
                            " (" .
                            $f->getErrorMessage() .
                            ")",
                    ])
                    ->withInput();
            }
        }
        /** @var \App\Models\User $user */
        $user = $request->user();

        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255"],
            "avatar" => ["nullable", "image", "max:2048"], // 2 MB
        ]);

        // ===== HANDLE AVATAR (mirip contoh "photo" di website) =====
        if ($request->hasFile("avatar")) {
            $file = $request->file("avatar");

            if ($file->isValid()) {
                // nama file unik: timestamp + nama asli
                $fileName = time() . "_" . $file->getClientOriginalName();

                // simpan ke storage/app/public/avatars/xxxxx
                $path = $file->storeAs("avatars", $fileName, "public");

                // simpan PATH RELATIF ke DB (tanpa /storage di depan)
                $user->avatar = $path;
            }
        }

        // ===== HANDLE NAMA & EMAIL =====
        $user->name = $validated["name"];

        if (
            $validated["email"] !== $user->email &&
            $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
        ) {
            $user->email = $validated["email"];
            $user->email_verified_at = null;
        } else {
            $user->email = $validated["email"];
        }

        $user->save();

        return Redirect::route("profile.edit")->with(
            "status",
            "profile-updated",
        );
    }

    /**
     * Hapus akun user + logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            "password" => ["required", "current_password"],
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Simpan avatar path sebelum user dihapus
        $avatarPath = $user->avatar;

        // Logout dulu
        Auth::logout();

        // Hapus user dari database
        $user->delete();

        // Hapus avatar file kalau ada (super aman)
        if (!empty($avatarPath)) {
            try {
                Storage::disk("public")->delete($avatarPath);
            } catch (\Throwable $e) {
                // kalau ada error saat delete file, kita diamkan saja
            }
        }

        // Reset session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to("/");
    }
}
