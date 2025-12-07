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
                 <img src="{{ asset('images/logo1.png') }}" alt="KaloriTracker" class="h-20 w-auto">
                </div>
                <div>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-50">
                        Masuk ke KaloriTracker
                    </h2>
                    <p class="mt-1 text-sm text-slate-400">
                        Lanjutkan tracking berat dan kalori harianmu.
                    </p>
                </div>
            </div>

            {{-- Status / Error --}}
            <x-auth-session-status class="mb-2 text-emerald-400 text-sm text-center" :status="session('status')" />

            {{-- Card form --}}
            <div class="bg-slate-900/95 border border-slate-800/90 rounded-2xl px-6 py-6 shadow-xl shadow-slate-950/60 card-animate backdrop-blur-sm">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

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
                            autofocus
                            autocomplete="username"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Password')" class="text-slate-200 text-sm" />
                            @if (Route::has('password.request'))
                                <a class="text-xs text-blue-400 hover:text-blue-300"
                                   href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>

                        <x-text-input
                            id="password"
                            class="block mt-1 w-full rounded-lg border-slate-700 bg-[#020617] text-slate-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center justify-between text-xs text-slate-400">
                        <label for="remember_me" class="inline-flex items-center gap-2">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="rounded border-slate-700 bg-slate-900 text-blue-600 shadow-sm focus:ring-blue-500"
                                name="remember">
                            <span>{{ __('Ingat saya') }}</span>
                        </label>
                    </div>

                    {{-- Button --}}
                    <div class="pt-2">
                        <x-primary-button
                            class="w-full justify-center bg-blue-600 hover:bg-blue-700 border-0 py-2.5 text-sm tracking-wide">
                            {{ __('Masuk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Link ke register --}}
            <p class="text-center text-xs text-slate-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold">
                    Daftar sekarang
                </a>
            </p>

            {{-- Disclaimer kesehatan --}}
            <p class="text-[11px] text-slate-500 text-center max-w-sm mx-auto leading-relaxed">
                KaloriTracker membantu kamu memantau pola makan & berat badan,
                namun tidak menggantikan saran dari dokter atau ahli gizi terutama bila kamu punya kondisi kesehatan tertentu.
            </p>
        </div>
    </div>
</x-guest-layout>
