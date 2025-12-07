<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Berat Badan
        </h2>
    </x-slot>

    <div class="py-6 bg-[#020617] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="p-3 rounded-lg bg-emerald-600/20 text-emerald-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header kecil + info berat terakhir --}}
            <section class="bg-slate-900 border border-slate-800 rounded-xl p-5 text-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-lg font-semibold">Catatan Berat Badan</h1>
                    <p class="text-xs text-slate-400 mt-1">
                        Pantau perkembangan berat badanmu dari hari ke hari.
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[11px] text-slate-400">Berat Terakhir</p>
                    @php
                        $latest = $logs->sortByDesc('date')->first();
                    @endphp
                    <p class="text-2xl font-bold">
                        @if($latest)
                            {{ number_format($latest->weight, 1) }} <span class="text-sm font-normal">kg</span>
                        @else
                            -
                        @endif
                    </p>
                    @if($latest)
                        <p class="text-[11px] text-slate-500">
                            {{ $latest->date->format('d M Y') }}
                        </p>
                    @endif
                </div>
            </section>

            {{-- Main content: form + riwayat --}}
            <section class="grid gap-6 md:grid-cols-2">
                {{-- Form input berat --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                    <h3 class="font-semibold mb-1 text-sm uppercase tracking-widest text-slate-400">
                        Input Berat
                    </h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Biasakan catat berat di waktu yang sama tiap hari (misal pagi setelah bangun).
                    </p>

                    <form method="POST" action="{{ route('weights.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-slate-200">
                                Tanggal
                            </label>
                            <input
                                type="date"
                                name="date"
                                value="{{ old('date', now()->toDateString()) }}"
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
                                value="{{ old('weight') }}"
                                placeholder="Misal: 51.5"
                                class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('weight')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-200">
                                Catatan (opsional)
                            </label>
                            <input
                                type="text"
                                name="note"
                                value="{{ old('note') }}"
                                placeholder="Misal: habis olahraga, kurang tidur, dll"
                                class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('note')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Tabel log berat --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-sm uppercase tracking-widest text-slate-400">
                            Riwayat Terakhir
                        </h3>
                        <p class="text-[11px] text-slate-500">
                            Maks. 30 catatan terbaru
                        </p>
                    </div>

                    @if ($logs->isEmpty())
                        <p class="text-sm text-slate-400">
                            Belum ada data berat. Mulai catat hari ini untuk lihat progresmu nanti.
                        </p>
                    @else
                        <div class="overflow-hidden rounded-lg border border-slate-800">
                            <table class="min-w-full text-xs text-slate-200">
                                <thead class="bg-slate-800">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-semibold">Tanggal</th>
                                        <th class="px-3 py-2 text-left font-semibold">Berat</th>
                                        <th class="px-3 py-2 text-left font-semibold">Catatan</th>
                                        <th class="px-3 py-2 text-left font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800">
                                    @foreach ($logs as $log)
                                        <tr class="hover:bg-slate-800/60">
                                            <td class="px-3 py-2">
                                                {{ $log->date->format('d M Y') }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ number_format($log->weight, 1) }} kg
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $log->note ?? '-' }}
                                            </td>
                                            <td class="px-3 py-2 space-x-2">
                                                <a href="{{ route('weights.edit', $log) }}"
                                                   class="inline-flex items-center px-2 py-1 text-[11px] rounded bg-yellow-500 text-slate-900 hover:bg-yellow-400">
                                                    Edit
                                                </a>

                                                <form action="{{ route('weights.destroy', $log) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Hapus data berat ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 text-[11px] rounded bg-red-600 text-white hover:bg-red-500">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
