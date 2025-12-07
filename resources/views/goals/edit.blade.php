<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Pengaturan Target & Profil
        </h2>
    </x-slot>

    <div class="py-6 bg-[#020617] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 rounded-lg bg-emerald-600/20 text-emerald-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#111827] p-6 shadow-lg rounded-xl text-gray-200">
                <h3 class="font-semibold text-white text-lg mb-4">Data Tubuh & Target</h3>

                <form method="POST" action="{{ route('goals.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Tinggi badan --}}
                    <div>
                        <label class="block text-sm font-medium text-white">
                            Tinggi Badan (cm)
                        </label>
                        <input
                            type="number"
                            name="height"
                            value="{{ old('height', $user->height) }}"
                            class="mt-1 block w-full rounded-lg border border-gray-600 bg-[#020617] text-gray-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Misal: 170"
                        >
                        @error('height')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Berat awal --}}
                    <div>
                        <label class="block text-sm font-medium text-white">
                            Berat Awal (kg)
                        </label>
                        <input
                            type="number"
                            step="0.1"
                            name="start_weight"
                            value="{{ old('start_weight', $user->start_weight) }}"
                            class="mt-1 block w-full rounded-lg border border-gray-600 bg-[#020617] text-gray-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Misal: 51.5"
                        >
                        @error('start_weight')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Target berat --}}
                    <div>
                        <label class="block text-sm font-medium text-white">
                            Target Berat (kg)
                        </label>
                        <input
                            type="number"
                            step="0.1"
                            name="target_weight"
                            value="{{ old('target_weight', $user->target_weight) }}"
                            class="mt-1 block w-full rounded-lg border border-gray-600 bg-[#020617] text-gray-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Misal: 60"
                        >
                        @error('target_weight')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Target kalori --}}
                    <div>
                        <label class="block text-sm font-medium text-white">
                            Target Kalori Harian (kkal)
                        </label>
                        <input
                            type="number"
                            name="calorie_target"
                            value="{{ old('calorie_target', $user->calorie_target) }}"
                            class="mt-1 block w-full rounded-lg border border-gray-600 bg-[#020617] text-gray-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Misal: 2500"
                        >
                        @error('calorie_target')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            Misal: kebutuhan kalori harian + 300 untuk bulking pelan-pelan.
                        </p>
                    </div>

                    {{-- Mode --}}
                    <div>
                        <label class="block text-sm font-medium text-white">
                            Mode
                        </label>
                        <select
                            name="mode"
                            class="mt-1 block w-full rounded-lg border border-gray-600 bg-[#020617] text-gray-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            @php
                                $mode = old('mode', $user->mode ?? 'bulking');
                            @endphp
                            <option value="bulking" {{ $mode === 'bulking' ? 'selected' : '' }}>Bulking (naik berat)</option>
                            <option value="cutting" {{ $mode === 'cutting' ? 'selected' : '' }}>Cutting (turun lemak)</option>
                            <option value="maintenance" {{ $mode === 'maintenance' ? 'selected' : '' }}>Maintenance (jaga stabil)</option>
                        </select>
                        @error('mode')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
