<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'KaloriTracker') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#020617] text-slate-100 antialiased">

<div class="min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <header class="border-b border-slate-800 bg-[#020617]/95 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo1.png') }}" alt="KaloriTracker" class="h-12 w-auto">
                <span class="font-semibold text-lg">
                    KaloriTracker
                </span>
            </div>

            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('login') }}" class="text-slate-300 hover:text-white">Masuk</a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2 rounded-lg bg-blue-600 font-semibold text-white hover:bg-blue-700 transition">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-1">

        {{-- HERO --}}
        <section class="max-w-7xl mx-auto px-6 py-20 grid gap-16 lg:grid-cols-2 items-center">
            {{-- LEFT: copy / text --}}
            <div class="space-y-6">
                <p class="text-xs tracking-[0.3em] text-blue-400 uppercase">
                    Bulking & Tracking Sehat
                </p>

                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight">
                    Pantau berat badan dan kalori harianmu
                    <span class="block text-blue-400 mt-2">
                        dengan tampilan yang simpel dan fokus ke kesehatan.
                    </span>
                </h1>

                <p class="text-slate-400 max-w-xl leading-relaxed">
                    Aplikasi ini membantu kamu mencatat berat badan, makanan, dan asupan kalori setiap hari.
                    Fokus pada surplus yang masuk akal (±300 kkal), agar kenaikan berat lebih stabil dan sehat.
                </p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 rounded-xl bg-blue-600 font-semibold text-white hover:bg-blue-700 transition">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 rounded-xl border border-slate-600 font-semibold text-slate-200 hover:bg-slate-900 transition">
                        Saya Sudah Punya Akun
                    </a>
                </div>

                {{-- Mini health bullets --}}
                <div class="grid sm:grid-cols-3 gap-4 pt-8 text-xs text-slate-400">
                    <div class="space-y-1">
                        <p class="text-emerald-400 font-semibold">Surplus Seimbang</p>
                        <p>+200–300 kkal lebih aman untuk bulking jangka panjang.</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-blue-400 font-semibold">Pantau Konsistensi</p>
                        <p>Berat ideal naik 0,25–0,5 kg per minggu.</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-fuchsia-400 font-semibold">Data Itu Penting</p>
                        <p>Catatan rapi bantu kamu evaluasi progres secara objektif.</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT: hero image slot --}}
            <div class="flex justify-center">
                    <img src="{{ asset('images/preview.png') }}" alt="KaloriTracker" class="h-auto w-auto">

            </div>
        </section>

        {{-- SPACER ANTAR SECTION --}}
        <div class="h-20 md:h-28"></div>

        {{-- SECTION: FITUR (HORIZONTAL CARDS) --}}
        <section class="border-t border-slate-800 pt-16 pb-24">
            <div class="max-w-7xl mx-auto px-6 space-y-10">

                <div class="text-center space-y-2">
                    <h2 class="text-3xl font-bold">
                        Fitur Utama KaloriTracker
                    </h2>
                    <p class="text-sm text-slate-400 max-w-2xl mx-auto">
                        Dibuat simpel supaya kamu fokus ke kebiasaan, bukan pusing sama aplikasi.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row gap-8">
                    {{-- CARD 1 --}}
                    <div class="flex-1 bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 hover:border-blue-500/40 transition">
                        <img src="{{ asset('images/preview1.png') }}" alt="KaloriTracker" class="h-auto w-auto rounded-xl border border-slate-800">

                        <div class="space-y-2">
                            <h3 class="font-semibold text-lg">Catat Berat Harian</h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Simpan berat badan setiap hari dan lihat trennya dalam grafik mingguan dan bulanan.
                            </p>
                        </div>
                    </div>

                    {{-- CARD 2 --}}
                    <div class="flex-1 bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 hover:border-emerald-500/40 transition">

                            <img src="{{ asset('images/preview1.png') }}" alt="KaloriTracker" class="h-auto w-auto rounded-xl border border-slate-800">


                        <div class="space-y-2">
                            <h3 class="font-semibold text-lg">Tracking Kalori</h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Catat makanan, snack, dan minuman untuk mengetahui total kalori harianmu dengan cepat.
                            </p>
                        </div>
                    </div>

                    {{-- CARD 3 --}}
                    <div class="flex-1 bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 hover:border-fuchsia-500/40 transition">
                        <img src="{{ asset('images/preview1.png') }}" alt="KaloriTracker" class="h-auto w-auto rounded-xl border border-slate-800">

                        <div class="space-y-2">
                            <h3 class="font-semibold text-lg">Grafik & Target</h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Atur target berat dan kalori, lalu pantau progres lewat grafik dan progress bar otomatis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SPACER ANTAR SECTION --}}
        <div class="h-20 md:h-28"></div>

        {{-- SECTION: EDUKASI KESEHATAN (HORIZONTAL CARDS) --}}
        <section class="bg-[#020617] border-t border-slate-800 pt-16 pb-24">
            <div class="max-w-7xl mx-auto px-6 space-y-12">

                <div class="text-center space-y-3">
                    <h2 class="text-3xl font-bold">
                        Kenapa Tracking Itu Penting?
                    </h2>
                    <p class="text-sm text-slate-400 max-w-2xl mx-auto">
                        Tracking bukan soal obsesif ke angka, tapi memahami pola tubuh dan kebiasaan makanmu dengan lebih objektif.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row gap-8">

                    {{-- CARD 1 --}}
                    <div class="flex-1 bg-slate-900 border border-slate-800 rounded-2xl p-7 space-y-4 hover:border-blue-500/40 transition">
                        <div class="h-10 w-10 rounded-xl bg-blue-600/20 flex items-center justify-center text-blue-400 text-sm font-bold">
                            01
                        </div>
                        <h4 class="text-lg font-semibold">
                            Bukan Sekadar Berat
                        </h4>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Berat harian bisa naik-turun karena air dan isi perut.
                            Yang penting adalah tren mingguan—apakah naik, turun, atau stagnan.
                        </p>
                    </div>

                    {{-- CARD 2 --}}
                    <div class="flex-1 bg-slate-900 border border-slate-800 rounded-2xl p-7 space-y-4 hover:border-emerald-500/40 transition">
                        <div class="h-10 w-10 rounded-xl bg-emerald-600/20 flex items-center justify-center text-emerald-400 text-sm font-bold">
                            02
                        </div>
                        <h4 class="text-lg font-semibold">
                            Bulking Lebih Aman
                        </h4>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Surplus kecil dan terukur membantu kamu naik berat tanpa terlalu banyak lemak berlebih,
                            sehingga lebih nyaman dan sustainable.
                        </p>
                    </div>

                    {{-- CARD 3 --}}
                    <div class="flex-1 bg-slate-900 border border-slate-800 rounded-2xl p-7 space-y-4 hover:border-fuchsia-500/40 transition">
                        <div class="h-10 w-10 rounded-xl bg-fuchsia-600/20 flex items-center justify-center text-fuchsia-400 text-sm font-bold">
                            03
                        </div>
                        <h4 class="text-lg font-semibold">
                            Data = Evaluasi
                        </h4>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Dengan data yang rapi, kamu bisa melihat pola, menyesuaikan kalori,
                            dan lebih siap kalau suatu saat konsultasi ke dokter atau ahli gizi.
                        </p>
                    </div>

                </div>
            </div>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-slate-800 py-6 text-center text-xs text-slate-500">
        © {{ date('Y') }} KaloriTracker — Fokus ke progres, bukan sekadar angka.
    </footer>

</div>

</body>
</html>
