<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Academic War</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <style>
        body {
            background: radial-gradient(circle at top, #1a1a1a, #0d0d0d);
            color: white;
        }

        .grid-pattern {
            background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>

<body class="grid-pattern min-h-screen flex flex-col">

    <!-- HERO SECTION -->
    <section class="flex flex-col items-center justify-center text-center py-32 px-6 relative">
        <div class="absolute inset-0 bg-red-600 opacity-10 blur-3xl"></div>

        <h1 class="text-5xl md:text-7xl font-bold tracking-tight" data-aos="fade-up">
            <span class="text-red-500">Academic</span> War
        </h1>
        <p class="mt-6 max-w-2xl text-lg text-gray-300" data-aos="fade-up" data-aos-delay="200">
            Sistem Akademik Kampus dengan teknik gamifikasi.
            Berjuang dalam arena akademik dan raih kemenangan ilmu.
        </p>
        <div class="mt-8" data-aos="fade-up" data-aos-delay="400">
            <a href="/login" class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg text-lg font-semibold shadow-lg">
                Masuk Sistem
            </a>
            <a href="/admin/login"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg text-lg font-semibold shadow-lg">
                Login Admin
            </a>
        </div>
    </section>

    <!-- GAMIFICATION PREVIEW -->
    <section class="py-24 px-6" id="gamification">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-14" data-aos="fade-down">
            Gamifikasi Akademik
        </h2>

        <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">
            <!-- XP CARD -->
            <div class="bg-black/40 border border-red-700/40 p-8 rounded-2xl shadow-xl" data-aos="zoom-in">
                <h3 class="text-xl font-bold mb-3 text-red-400">XP & Level</h3>
                <p class="text-gray-300 mb-4">Kumpulkan XP dari aktivitas belajar dan naikkan level akademikmu.</p>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    <div class="bg-red-500 h-3 rounded-full w-3/4"></div>
                </div>
                <p class="mt-2 text-sm text-gray-400">Level 12 · 750 / 1000 XP</p>
            </div>

            <!-- BADGE CARD -->
            <div class="bg-black/40 border border-red-700/40 p-8 rounded-2xl shadow-xl" data-aos="zoom-in"
                data-aos-delay="200">
                <h3 class="text-xl font-bold mb-3 text-red-400">Badge</h3>
                <p class="text-gray-300 mb-4">Dapatkan badge prestasi untuk setiap pencapaian akademik.</p>
                <div class="flex space-x-3">
                    <div class="w-12 h-12 bg-red-500/20 border border-red-500 rounded-xl"></div>
                    <div class="w-12 h-12 bg-yellow-500/20 border border-yellow-500 rounded-xl"></div>
                    <div class="w-12 h-12 bg-blue-500/20 border border-blue-500 rounded-xl"></div>
                </div>
            </div>

            <!-- LEADERBOARD CARD -->
            <div class="bg-black/40 border border-red-700/40 p-8 rounded-2xl shadow-xl" data-aos="zoom-in"
                data-aos-delay="400">
                <h3 class="text-xl font-bold mb-3 text-red-400">Leaderboard</h3>
                <p class="text-gray-300 mb-4">Bersaing secara sehat dengan mahasiswa lain di kampus.</p>
                <ul class="text-gray-300 space-y-1 text-sm">
                    <li>1. <span class="text-red-400 font-bold">Aulia</span> — 12.300 XP</li>
                    <li>2. Reza — 11.950 XP</li>
                    <li>3. Nanda — 11.100 XP</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- FITUR AKADEMIK -->
    <section class="py-24 px-6 bg-black/30">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-14" data-aos="fade-down">
            Fitur Akademik
        </h2>

        <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">
            <div class="p-8 rounded-2xl bg-gray-900/50 border border-gray-700" data-aos="fade-right">
                <h3 class="text-xl font-semibold mb-2">Manajemen Dosen</h3>
                <p class="text-gray-300">Kelola profil dosen, NIDN, jabatan fungsional, dan akun user.</p>
            </div>

            <div class="p-8 rounded-2xl bg-gray-900/50 border border-gray-700" data-aos="fade-up">
                <h3 class="text-xl font-semibold mb-2">Prodi & Fakultas</h3>
                <p class="text-gray-300">Struktur akademik lengkap dengan jenjang dan jumlah semester.</p>
            </div>

            <div class="p-8 rounded-2xl bg-gray-900/50 border border-gray-700" data-aos="fade-left">
                <h3 class="text-xl font-semibold mb-2">Dashboard Pintar</h3>
                <p class="text-gray-300">Menampilkan data realtime: presensi, meeting, tugas, dan lainnya.</p>
            </div>
        </div>
    </section>

    <!-- CTA FOOTER -->
    <footer class="py-16 text-center text-gray-400 text-sm">
        <p>Academic War © 2025 — Dibuat untuk kebaikan.</p>
        <p class="mt-1">https://kangsolihin.web.id</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>