{{-- resources/views/auth/forgot-password.blade.php --}}
<x-guest-layout>
    <style>
        @keyframes fadeInUpSoft {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .card-animate {
            animation: fadeInUpSoft 0.55s ease-out;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 flex items-center justify-center px-4">
        <div class="w-full max-w-md space-y-8">

            {{-- Logo / Brand --}}
            <div class="text-center space-y-3">
                <div class="mx-auto h-12 w-12 rounded-2xl bg-blue-600 flex items-center justify-center font-bold text-lg">
                    KT
                </div>
                <div>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-50">
                        Lupa Password?
                    </h2>
                    <p class="mt-1 text-sm text-slate-400">
                        Masukkan email yang terdaftar, kami akan kirim link untuk reset password.
                    </p>
                </div>
            </div>

            {{-- Status --}}
            <x-auth-session-status class="mb-2 text-emerald-400 text-sm text-center" :status="session('status')" />

            {{-- Card form --}}
            <div class="bg-slate-900/95 border border-slate-800/90 rounded-2xl px-6 py-6 shadow-xl shadow-slate-950/60 card-animate backdrop-blur-sm">
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-1">
                        <x-input-label for="email" :value="__('Email')" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="email"
                            class="block mt-1 w-full rounded-lg border-slate-700 bg-[#020617] text-slate-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="email"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Setelah menekan tombol di bawah, cek email-mu (termasuk folder spam/promo).
                        Link reset biasanya hanya berlaku dalam waktu tertentu.
                    </p>

                    <div class="pt-2">
                        <x-primary-button
                            class="w-full justify-center bg-blue-600 hover:bg-blue-700 border-0 py-2.5 text-sm tracking-wide">
                            {{ __('Kirim Link Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Link balik ke login --}}
            <p class="text-center text-xs text-slate-400">
                Ingat passwordnya?
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold">
                    Kembali ke halaman masuk
                </a>
            </p>

            {{-- Disclaimer kecil --}}
            <p class="text-[11px] text-slate-500 text-center max-w-sm mx-auto leading-relaxed">
                Jaga keamanan akunmu: jangan bagikan link reset password ke orang lain,
                dan gunakan password yang kuat serta tidak digunakan ulang di layanan lain.
            </p>
        </div>
    </div>
</x-guest-layout>
