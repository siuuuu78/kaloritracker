<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6 bg-[#020617] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- TOP: Greeting + tombol cepat --}}
            <section class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm text-slate-400">Selamat datang kembali,</p>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-50">
                        {{ $user->name }} 👋
                    </h1>
                    <p class="text-sm text-slate-400 mt-1">
                        Mode:
                        <span class="font-semibold capitalize text-blue-300">
                            {{ $user->mode ?? 'bulking' }}
                        </span>
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('weights.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg text-xs font-semibold text-white uppercase tracking-widest hover:bg-blue-700 transition">
                        + Catat Berat
                    </a>
                    <a href="{{ route('food_logs.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-lg text-xs font-semibold text-white uppercase tracking-widest hover:bg-emerald-700 transition">
                        + Catat Makanan
                    </a>
                </div>
            </section>

            {{-- ROW: Summary cards --}}
            <section class="grid gap-4 md:grid-cols-4">

                {{-- Berat terakhir --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 text-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Berat Terakhir</p>
                    <p class="text-2xl font-bold">
                        @if ($latestWeight)
                            {{ number_format($latestWeight->weight, 1) }} <span class="text-sm font-normal">kg</span>
                        @else
                            -
                        @endif
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        @if ($latestWeight)
                            {{ $latestWeight->date->format('d M Y') }}
                        @else
                            Belum ada data.
                        @endif
                    </p>
                </div>

                {{-- Kalori hari ini --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 text-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Kalori Hari Ini</p>
                    <p class="text-2xl font-bold">
                        {{ $todayCalories }}
                        <span class="text-sm font-normal text-slate-300">kkal</span>
                    </p>

                    @if($user->calorie_target)
                        @php $diff = $todayCalories - $user->calorie_target; @endphp
                        <p class="text-[11px] mt-1 text-slate-400">
                            Target: {{ $user->calorie_target }} kkal<br>
                            Selisih:
                            <span class="{{ $diff >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $diff }} kkal
                            </span>
                        </p>
                    @else
                        <p class="text-[11px] text-slate-500 mt-1">
                            Set target kalori di menu "Pengaturan Target".
                        </p>
                    @endif
                </div>

                {{-- Progress ke target berat --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 text-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Progres Berat</p>

                    @if($user->start_weight && $user->target_weight && $latestWeight)
                        @php
                            $progress   = $latestWeight->weight - $user->start_weight;
                            $targetGain = $user->target_weight - $user->start_weight;
                            $percent    = $targetGain > 0 ? max(0, min(100, ($progress / $targetGain) * 100)) : 0;
                        @endphp

                        <p class="text-sm">
                            {{ number_format($progress, 1) }} kg dari {{ number_format($targetGain, 1) }} kg
                        </p>

                        <div class="mt-2 h-2 w-full bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500" style="width: {{ $percent }}%"></div>
                        </div>

                        <p class="text-[11px] text-slate-500 mt-1">
                            ~{{ number_format($percent, 0) }}% menuju target
                        </p>
                    @else
                        <p class="text-xs text-slate-500">
                            Lengkapi berat awal & target di "Pengaturan Target".
                        </p>
                    @endif
                </div>

                {{-- Rata-rata kalori 7 hari --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 text-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Rata-rata Kalori 7 Hari</p>
                    <p class="text-2xl font-bold">
                        @if ($avgCalories7)
                            {{ $avgCalories7 }}
                            <span class="text-sm font-normal text-slate-300">kkal</span>
                        @else
                            -
                        @endif
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Membantu lihat konsistensi makanmu.
                    </p>
                </div>

            </section>

            {{-- MAIN CONTENT: 2 kolom grafik --}}
            <section class="grid gap-6 lg:grid-cols-2">
                {{-- Grafik Berat --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold">Grafik Berat Badan</h3>
                        <p class="text-[11px] text-slate-500">30 hari terakhir</p>
                    </div>

                    @if (count($weightChartLabels))
                        <canvas id="weightChart" height="90"></canvas>
                    @else
                        <p class="text-sm text-slate-400">
                            Belum ada data berat. Catat di menu "Berat Badan".
                        </p>
                    @endif
                </div>

                {{-- Grafik Kalori --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 text-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold">Grafik Kalori Per Hari</h3>
                        <p class="text-[11px] text-slate-500">14 hari terakhir</p>
                    </div>

                    @if (count($calorieChartLabels))
                        <canvas id="calorieChart" height="90"></canvas>
                    @else
                        <p class="text-sm text-slate-400">
                            Belum ada data makanan. Catat di menu "Makanan & Kalori".
                        </p>
                    @endif
                </div>
            </section>

            {{-- (Opsional) Section lain seperti list makanan hari ini bisa ditambah di bawah sini --}}
        </div>
    </div>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const weightLabels  = @json($weightChartLabels);
        const weightData    = @json($weightChartData);
        const calorieLabels = @json($calorieChartLabels);
        const calorieData   = @json($calorieChartData);
        const calorieTarget = @json($user->calorie_target);

        // Grafik Berat
        if (weightLabels.length > 0) {
            const ctxWeight = document.getElementById('weightChart').getContext('2d');
            new Chart(ctxWeight, {
                type: 'line',
                data: {
                    labels: weightLabels,
                    datasets: [{
                        label: 'Berat (kg)',
                        data: weightData,
                        borderWidth: 2,
                        tension: 0.3,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            ticks: { color: '#9ca3af' },
                            grid: { color: '#1f2937' }
                        },
                        y: {
                            beginAtZero: false,
                            ticks: { color: '#9ca3af' },
                            grid: { color: '#1f2937' }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: { color: '#e5e7eb' }
                        }
                    }
                }
            });
        }

        // Grafik Kalori
        if (calorieLabels.length > 0) {
            const ctxCalorie = document.getElementById('calorieChart').getContext('2d');

            const datasets = [{
                type: 'bar',
                label: 'Total Kalori (kkal)',
                data: calorieData,
                borderWidth: 1,
            }];

            if (calorieTarget) {
                const targetArray = calorieLabels.map(() => calorieTarget);
                datasets.push({
                    type: 'line',
                    label: 'Target Kalori',
                    data: targetArray,
                    borderWidth: 1,
                    borderDash: [4, 4],
                    pointRadius: 0,
                });
            }

            new Chart(ctxCalorie, {
                data: {
                    labels: calorieLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            ticks: { color: '#9ca3af' },
                            grid: { color: '#1f2937' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#9ca3af' },
                            grid: { color: '#1f2937' }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: { color: '#e5e7eb' }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
