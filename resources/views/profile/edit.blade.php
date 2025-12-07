<x-app-layout>
    <div class="py-12 bg-[#020617] min-h-screen">
        <div class="max-w-4xl mx-auto px-6 space-y-12">

            {{-- HEADER --}}
            <div class="space-y-2">
                <h1 class="text-3xl font-bold text-slate-100">
                    Pengaturan Profil
                </h1>
                <p class="text-sm text-slate-400">
                    Kelola informasi akun, keamanan, dan preferensi pribadimu.
                </p>
            </div>

            {{-- ================= INFORMASI AKUN ================= --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow">
                <h2 class="text-lg font-semibold text-slate-100 mb-1">
                    Informasi Akun
                </h2>
                <p class="text-xs text-slate-400 mb-6">
                    Perbarui nama, email, dan foto profil yang digunakan di KaloriTracker.
                </p>

                {{-- AVATAR DISPLAY --}}
                <div class="flex items-center gap-6 mb-8">
                    <div class="relative">
                        @if ($user->avatar)
                            <img
                                src="{{ asset('storage/' . $user->avatar) }}"
                                class="h-20 w-20 rounded-full object-cover border border-slate-700"
                                alt="Avatar"
                            >
                        @else
                            <div class="h-20 w-20 rounded-full bg-blue-600 flex items-center justify-center text-2xl font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <p class="text-lg font-semibold text-slate-100">
                            {{ $user->name }}
                        </p>
                        <p class="text-xs text-slate-400">
                            {{ $user->email }}
                        </p>
                    </div>
                </div>

                <form
                    method="post"
                    action="{{ route('profile.update') }}"
                    class="space-y-5"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('patch')

                    {{-- UPLOAD AVATAR --}}
                    <div>
                        <x-input-label for="avatar" value="Foto Profil" class="text-slate-200 text-sm" />
                        <input
                            type="file"
                            name="avatar"
                            id="avatar"
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-slate-400
                                   file:bg-slate-800 file:border file:border-slate-700
                                   file:px-4 file:py-2 file:rounded-lg file:text-slate-200
                                   hover:file:bg-slate-700"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Format JPG atau PNG, maks. 2MB.
                        </p>
                        <x-input-error class="mt-1 text-xs" :messages="$errors->get('avatar')" />
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <x-input-label for="name" value="Nama" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            class="mt-1 block w-full rounded-lg bg-[#020617] border-slate-700 text-slate-100 text-sm"
                            :value="old('name', $user->name)"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <x-input-error class="mt-1 text-xs" :messages="$errors->get('name')" />
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <x-input-label for="email" value="Email" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            class="mt-1 block w-full rounded-lg bg-[#020617] border-slate-700 text-slate-100 text-sm"
                            :value="old('email', $user->email)"
                            required
                            autocomplete="username"
                        />
                        <x-input-error class="mt-1 text-xs" :messages="$errors->get('email')" />
                    </div>

                    {{-- VERIFIKASI EMAIL --}}
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="text-xs text-yellow-400">
                            Email kamu belum terverifikasi.
                            <button form="send-verification" class="underline text-blue-400 hover:text-blue-300">
                                Klik untuk kirim ulang email verifikasi.
                            </button>
                        </div>
                    @endif

                    <div class="pt-2">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            Simpan Perubahan
                        </x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-xs text-emerald-400 mt-2">
                                Profil berhasil diperbarui.
                            </p>
                        @endif
                    </div>
                </form>

                {{-- FORM VERIFIKASI EMAIL (HIDDEN) --}}
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
            </div>

            {{-- ================= KEAMANAN AKUN ================= --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow">
                <h2 class="text-lg font-semibold text-slate-100 mb-1">
                    Keamanan Akun
                </h2>
                <p class="text-xs text-slate-400 mb-6">
                    Gunakan password yang kuat dan jangan dibagikan ke siapa pun.
                </p>

                <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    @method('put')

                    {{-- PASSWORD LAMA --}}
                    <div>
                        <x-input-label for="current_password" value="Password Saat Ini" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="current_password"
                            name="current_password"
                            type="password"
                            class="mt-1 block w-full rounded-lg bg-[#020617] border-slate-700 text-slate-100 text-sm"
                            autocomplete="current-password"
                        />
                        <x-input-error class="mt-1 text-xs" :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    {{-- PASSWORD BARU --}}
                    <div>
                        <x-input-label for="password" value="Password Baru" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-full rounded-lg bg-[#020617] border-slate-700 text-slate-100 text-sm"
                            autocomplete="new-password"
                        />
                        <x-input-error class="mt-1 text-xs" :messages="$errors->updatePassword->get('password')" />
                    </div>

                    {{-- KONFIRMASI --}}
                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="mt-1 block w-full rounded-lg bg-[#020617] border-slate-700 text-slate-100 text-sm"
                            autocomplete="new-password"
                        />
                    </div>

                    <div class="pt-2">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            Perbarui Password
                        </x-primary-button>

                        @if (session('status') === 'password-updated')
                            <p class="text-xs text-emerald-400 mt-2">
                                Password berhasil diperbarui.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ================= HAPUS AKUN ================= --}}
            <div class="bg-slate-900 border border-red-900/40 rounded-2xl p-6 shadow">
                <h2 class="text-lg font-semibold text-red-400 mb-1">
                    Hapus Akun
                </h2>
                <p class="text-xs text-slate-400 mb-6">
                    Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
                </p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="space-y-3">
                        <x-input-label for="password" value="Konfirmasi dengan Password" class="text-slate-200 text-sm" />
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-full rounded-lg bg-[#020617] border-slate-700 text-slate-100 text-sm"
                            placeholder="Masukkan password untuk konfirmasi"
                        />
                        <x-input-error class="mt-1 text-xs" :messages="$errors->userDeletion->get('password')" />
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                            Hapus Akun Permanen
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
