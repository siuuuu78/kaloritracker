<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Edit Berat Badan
        </h2>
    </x-slot>

    <div class="py-6 bg-[#020617] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="p-3 mb-4 rounded-lg bg-emerald-600/20 text-emerald-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                <h3 class="font-semibold mb-1 text-sm uppercase tracking-widest text-slate-400">
                    Edit Catatan Berat
                </h3>
                <p class="text-xs text-slate-500 mb-4">
                    Ubah data berat untuk tanggal
                    <span class="font-semibold text-slate-200">
                        {{ $log->date->format('d M Y') }}
                    </span>
                </p>

                <form method="POST" action="{{ route('weights.update', $log) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

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

                    <div>
                        <label class="block text-sm font-medium text-slate-200">
                            Berat (kg)
                        </label>
                        <input
                            type="number"
                            step="0.1"
                            name="weight"
                            value="{{ old('weight', $log->weight) }}"
                            class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('weight')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-200">
                            Catatan
                        </label>
                        <input
                            type="text"
                            name="note"
                            value="{{ old('note', $log->note) }}"
                            class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('note')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('weights.index') }}"
                           class="text-sm text-slate-400 hover:text-slate-200 hover:underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
