<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Makanan & Kalori
        </h2>
    </x-slot>

    <div class="py-6 bg-[#020617] min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="p-3 rounded-lg bg-emerald-600/20 text-emerald-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Summary Hari Ini --}}
            <section class="bg-slate-900 border border-slate-800 rounded-xl p-5 text-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold">Catatan Makanan</h1>
                    <p class="text-xs text-slate-400 mt-1">
                        Lacak apa yang kamu makan dan berapa banyak kalori yang masuk.
                    </p>
                    <p class="text-[11px] text-slate-500 mt-2">
                        Tanggal: {{ now()->format('d M Y') }}
                    </p>
                </div>

                <div class="text-right space-y-1">
                    <p class="text-[11px] text-slate-400">Total Kalori Hari Ini</p>
                    <p class="text-2xl font-bold">
                        {{ $todayCalories }}
                        <span class="text-sm font-normal text-slate-300">kkal</span>
                    </p>

                    @if($user->calorie_target)
                        @php
                            $diff = $todayCalories - $user->calorie_target;
                        @endphp
                        <p class="text-[11px] text-slate-400">
                            Target: {{ $user->calorie_target }} kkal
                        </p>
                        <p class="text-[11px]">
                            Selisih:
                            <span class="{{ $diff >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $diff }} kkal
                            </span>
                        </p>
                    @else
                        <p class="text-[11px] text-slate-500">
                            Set target kalori di menu "Pengaturan Target" untuk melihat selisih.
                        </p>
                    @endif
                </div>
            </section>

            {{-- Main: Form + Makanan Hari Ini --}}
            <section class="grid gap-6 md:grid-cols-2">
                {{-- Form input makanan --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                    <h3 class="font-semibold mb-1 text-sm uppercase tracking-widest text-slate-400">
                        Tambah Makanan
                    </h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Catat setiap makanan / snack untuk mendapatkan gambaran utuh kalori harianmu.
                    </p>

                    <form method="POST" action="{{ route('food_logs.store') }}" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        {{-- Tanggal --}}
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

                        {{-- Waktu makan --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-200">
                                Waktu Makan
                            </label>
                            @php $oldMeal = old('meal_type', 'breakfast'); @endphp
                            <select
                                name="meal_type"
                                class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="breakfast" {{ $oldMeal == 'breakfast' ? 'selected' : '' }}>Pagi</option>
                                <option value="lunch"     {{ $oldMeal == 'lunch' ? 'selected' : '' }}>Siang</option>
                                <option value="dinner"    {{ $oldMeal == 'dinner' ? 'selected' : '' }}>Malam</option>
                                <option value="snack"     {{ $oldMeal == 'snack' ? 'selected' : '' }}>Snack</option>
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
                                value="{{ old('name') }}"
                                placeholder="Contoh: Nasi + Ayam Bakar"
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
                                value="{{ old('portion') }}"
                                placeholder="1 porsi / 1 gelas / 2 potong"
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
                                value="{{ old('calories') }}"
                                class="mt-1 block w-full rounded-lg border border-slate-700 bg-[#020617] text-slate-100 text-sm p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('calories')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 pt-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                Simpan Makanan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Makanan Hari Ini --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-sm uppercase tracking-widest text-slate-400">
                            Makanan Hari Ini
                        </h3>
                        <p class="text-[11px] text-slate-500">
                            {{ $todayLogs->count() }} item
                        </p>
                    </div>

                    @if ($todayLogs->isEmpty())
                        <p class="text-sm text-slate-400">
                            Belum ada catatan makanan hari ini. Mulai tambahkan dari form di sebelah kiri.
                        </p>
                    @else
                        <div class="overflow-hidden rounded-lg border border-slate-800">
                            <table class="min-w-full text-xs text-slate-200">
                                <thead class="bg-slate-800">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-semibold">Waktu</th>
                                        <th class="px-3 py-2 text-left font-semibold">Nama</th>
                                        <th class="px-3 py-2 text-left font-semibold">Porsi</th>
                                        <th class="px-3 py-2 text-left font-semibold">Kalori</th>
                                        <th class="px-3 py-2 text-left font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800">
                                    @foreach ($todayLogs as $log)
                                        <tr class="hover:bg-slate-800/60">
                                            <td class="px-3 py-2 capitalize">
                                                {{ $log->meal_type }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $log->name }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $log->portion }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $log->calories }} kkal
                                            </td>
                                            <td class="px-3 py-2 space-x-2">
                                                <a href="{{ route('food_logs.edit', $log) }}"
                                                   class="inline-flex items-center px-2 py-1 text-[11px] rounded bg-yellow-500/90 text-slate-900 hover:bg-yellow-400">
                                                    Edit
                                                </a>

                                                <form action="{{ route('food_logs.destroy', $log) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Hapus catatan makanan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 text-[11px] rounded bg-red-600/90 text-white hover:bg-red-500">
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

            {{-- Riwayat beberapa hari --}}
            <section class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-sm uppercase tracking-widest text-slate-400">
                        Riwayat Kalori Per Hari
                    </h3>
                    <p class="text-[11px] text-slate-500">
                        Rekap dari beberapa hari terakhir
                    </p>
                </div>

                @if ($recentDays->isEmpty())
                    <p class="text-sm text-slate-400">
                        Belum ada riwayat makanan yang bisa ditampilkan.
                    </p>
                @else
                    <div class="space-y-3 text-xs">
                        @foreach ($recentDays as $date => $logs)
                            <div class="border border-slate-800 rounded-lg p-3 bg-slate-900/70">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-semibold text-slate-100">
                                        {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                    </span>
                                    <span class="text-slate-300">
                                        Total: {{ $logs->sum('calories') }} kkal
                                    </span>
                                </div>
                                <ul class="list-disc list-inside text-slate-300 space-y-1">
                                    @foreach ($logs as $log)
                                        <li>
                                            <span class="capitalize">{{ $log->meal_type }}</span> –
                                            {{ $log->name }} ({{ $log->portion }}, {{ $log->calories }} kkal)

                                            <span class="ml-2">
                                                <a href="{{ route('food_logs.edit', $log) }}"
                                                   class="text-[11px] text-blue-400 hover:underline">
                                                    Edit
                                                </a>
                                                |
                                                <form action="{{ route('food_logs.destroy', $log) }}"
                                                      method="POST"
                                                      class="inline"
                                                      onsubmit="return confirm('Hapus catatan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-[11px] text-red-400 hover:underline bg-transparent border-0 p-0">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-app-layout>
