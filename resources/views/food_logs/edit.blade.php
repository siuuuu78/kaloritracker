<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Edit Makanan
        </h2>
    </x-slot>

    <div class="py-6 bg-[#020617] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="p-3 mb-4 rounded-lg bg-emerald-600/20 text-emerald-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                <h3 class="font-semibold mb-1 text-sm uppercase tracking-widest text-slate-400">
                    Edit Catatan Makanan
                </h3>
                <p class="text-xs text-slate-500 mb-4">
                    Ubah detail makanan yang kamu konsumsi pada
                    <span class="font-semibold text-slate-200">
                        {{ $log->date->format('d M Y') }}
                    </span>
                </p>

                <form method="POST" action="{{ route('food_logs.update', $log) }}" class="grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200">
                            Tanggal
                        </label>
                        <input
                            type="date"
                            name="date"
                            value="{{ old('date', $log->date->toDateString()) }}"
                            class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('date')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Waktu makan --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200">
                            Waktu Makan
                        </label>
                        @php $meal = old('meal_type', $log->meal_type); @endphp
                        <select
                            name="meal_type"
                            class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="breakfast" {{ $meal == 'breakfast' ? 'selected' : '' }}>Pagi</option>
                            <option value="lunch"     {{ $meal == 'lunch' ? 'selected' : '' }}>Siang</option>
                            <option value="dinner"    {{ $meal == 'dinner' ? 'selected' : '' }}>Malam</option>
                            <option value="snack"     {{ $meal == 'snack' ? 'selected' : '' }}>Snack</option>
                        </select>
                        @error('meal_type')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama makanan --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-200">
                            Nama Makanan
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $log->name) }}"
                            class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('name')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Porsi --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200">
                            Porsi
                        </label>
                        <input
                            type="text"
                            name="portion"
                            value="{{ old('portion', $log->portion) }}"
                            class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('portion')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kalori --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200">
                            Kalori (kkal)
                        </label>
                        <input
                            type="number"
                            name="calories"
                            value="{{ old('calories', $log->calories) }}"
                            class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('calories')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('food_logs.index') }}"
                           class="text-sm text-slate-400 hover:text-slate-200 hover:underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
