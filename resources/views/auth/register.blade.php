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
                <div class="  flex items-center justify-center ">
                 <img src="{{ asset('images/logo1.png') }}" alt="KaloriTracker" class="h-16 w-auto">
                </div>
                <div>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-50">
                        Buat akun KaloriTracker
                    </h2>
                    <p class="mt-1 text-sm text-slate-400">
                        Mulai catat berat badan & kalori harianmu dari sekarang.
                    </p>
                </div>
            </div>

            {{-- Card form --}}
            <div class="bg-slate-900/95 border border-slate-800/90 rounded-2xl px-6 py-6 shadow-xl shadow-slate-950/60 card-animate backdrop-blur-sm">
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <x-input-label for="name" :value="__('Nama')" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="name"
                            class="block mt-1 w-full rounded-lg border-slate-700 bg-[#020617] text-slate-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="email"
                            class="block mt-1 w-full rounded-lg border-slate-700 bg-[#020617] text-slate-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="password"
                            class="block mt-1 w-full rounded-lg border-slate-700 bg-[#020617] text-slate-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                    </div>

                    {{-- Konfirmasi password --}}
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="password_confirmation"
                            class="block mt-1 w-full rounded-lg border-slate-700 bg-[#020617] text-slate-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                    </div>

                    {{-- Button --}}
                    <div class="pt-2">
                        <x-primary-button
                            class="w-full justify-center bg-blue-600 hover:bg-blue-700 border-0 py-2.5 text-sm tracking-wide">
                            {{ __('Daftar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Link ke login --}}
            <p class="text-center text-xs text-slate-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold">
                    Masuk sekarang
                </a>
            </p>

            {{-- Disclaimer kesehatan --}}
            <p class="text-[11px] text-slate-500 text-center max-w-sm mx-auto leading-relaxed">
                Pastikan kamu tetap memperhatikan kebutuhan kesehatanmu secara menyeluruh:
                tidur cukup, bergerak aktif, dan konsultasi ke tenaga kesehatan bila diperlukan.
                Aplikasi ini hanya alat bantu, bukan pengganti profesional medis.
            </p>
        </div>
    </div>
</x-guest-layout>
