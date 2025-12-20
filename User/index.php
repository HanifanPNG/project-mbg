<?php
error_reporting(0);
session_start();
$username = $_SESSION['user'] ?? 'Pengunjung';

if ($_SESSION['isLogin'] == false or $_SESSION['level'] != "user") {
    header("location:../logout.php");
}

require_once "../config.php";
$keyword = $_POST['keyword'] ?? '';
$sql = "select * from sppg";
$pesan = "";

if ($_POST["cari"]) {
    $sql = "select * from sppg where nama_sppg like'%$keyword%'";
}
$data = $db->query($sql);
$jumlah_data = $data->num_rows;

if (($_POST["cari"])  && !empty($keyword)) {
    if ($jumlah_data > 0) {
        $pesan = "<p style='color:green;margin-top:8px;'> SPPG dengan kata kunci <b>$keyword</b> ";
    }
}
?>
<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>MBG - Sistem Pelayanan Makanan Bergizi Gratis</title>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --green: #10b981;
            --green-weak: #dff7ef;
            --green-dark: #059669;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--green), #34d399);
        }

        .gradient-detail-btn {
            background: linear-gradient(90deg, #10b981, #34d399);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">
    <header class="shadow-md sticky top-0 bg-white z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="#" class="flex items-center gap-3 transition duration-150 ease-in-out hover:opacity-90">
                    <img src="../assets/img/mbg-ku.png" alt="" class="w-20 absolute left-0 top-1">
                    <div class="pl-10">
                        <h1 class="text-xl font-bold">MBG-KU</h1>
                        <p class="text-xs text-gray-500 -mt-0.5 tracking-wider">Pelayanan Makanan Bergizi Gratis</p>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="#beranda" class="text-gray-700 font-medium hover:text-[var(--green)] transition duration-150 ease-in-out">Beranda</a>
                    <a href="#daftar_sppg" class="text-gray-700 font-medium hover:text-[var(--green)] transition duration-150 ease-in-out">Daftar SPPG</a>
                    <button id="logoutBtn" class="px-4 py-2 rounded-lg text-sm font-semibold border border-gray-300 hover:bg-red-500 hover:text-white hover:border-red-500 transition duration-150 ease-in-out shadow-sm">Logout</button>
                </nav>

                <div class="md:hidden">
                    <button id="mobileBtn" aria-label="Open menu" class="p-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobileMenu" class="md:hidden px-4 pb-4 hidden bg-white shadow-inner">
            <a href="#beranda" class="block py-2 text-gray-700 hover:text-[var(--green)] border-b border-gray-100">Beranda</a>
            <a href="#daftar_sppg" class="block py-2 text-gray-700 hover:text-[var(--green)] border-b border-gray-100">Daftar SPPG</a>
            <button id="logoutBtn2" class="block w-full text-left py-2 text-red-500 font-medium hover:text-red-700 transition">Logout</button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <section id="beranda" class="pt-16 pb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-4xl sm:text-5xl font-extrabold leading-snug">
                        Selamat Datang <?= $username ?><br>
                        <span class="text-[var(--green)] tracking-wide">Sistem Pelayanan Program MBG</span>
                    </h2>
                    <p class="text-lg text-gray-600 max-w-xl">
                        Platform digital untuk mengawasi jalannya Program Makan Bergizi Gratis
                    </p>
                    <a href="#daftar_sppg" class="inline-block px-8 py-3 text-white font-semibold rounded-full shadow-lg gradient-bg hover:shadow-xl hover:opacity-90 transition duration-300 ease-in-out" data-aos="zoom-in" data-aos-duration="1000">
                        Lihat Daftar SPPG
                    </a>
                </div>

                <div>
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-100 transform hover:scale-[1.01] transition duration-500 ease-in-out">
                        <img src="../assets/img/gpt.png" alt="Makanan bergizi" class="w-full h-80 object-cover object-center hidden lg:flex">
                    </div>
                </div>
            </div>
        </section>

        <section id="daftar_sppg" class="py-12">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 border-b-2 border-[var(--green)] pb-2 inline-block"  data-aos="fade-up" data-aos-duration="500">Daftar SPPG</h2>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-6"  data-aos="flip-up" data-aos-duration="500">
                <form action="" method="post" class="flex flex-col sm:flex-row gap-4 items-center">
                    <div class="relative flex-grow w-full">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Cari berdasarkan Nama SPPG..." name="keyword" value="<?= $keyword ?>" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--green)] focus:border-[var(--green)] transition-all duration-200">
                    </div>
                    <input type="submit" name="cari" value="cari" class="w-full sm:w-auto px-6 py-2 rounded-lg text-white font-semibold shadow-md gradient-bg hover:opacity-90 transition duration-200" data-aos="fade-right" data-aos-duration="1000">
                </form>
                <?= $pesan ?>
            </div>
            <div class="overflow-x-auto rounded-xl shadow-xl border border-gray-200" data-aos="fade-up"
     data-aos-anchor-placement="center-bottom" data-aos-duration="500">
                <table class="min-w-full bg-white divide-y divide-gray-200">
                    <thead class="bg-[var(--green)] text-white">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider">Nama SPPG</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100">
                        <?php
                        $no = 1;
                        if ($data->num_rows > 0):
                            foreach ($data as $d):
                        ?>
                                <tr class="hover:bg-gray-50 transition duration-100">
                                    <td class="py-4 px-6 whitespace-nowrap"><?= $no ?></td>
                                    <td class="py-4 px-6 whitespace-nowrap font-medium text-gray-700"><?= $d['nama_sppg'] ?></td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <a href="detail_sppg.php?id=<?= $d['id'] ?>" class="px-4 py-1.5 text-white rounded-full text-xs font-medium shadow-md gradient-detail-btn hover:opacity-90 transition duration-200">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            endforeach;
                        else:
                            ?>
                            <tr>
                                <td colspan="3" class="py-6 text-center text-gray-500 font-medium bg-gray-50">
                                    <p class="mb-1">Tidak ada data SPPG yang ditemukan.</p>
                                    <p class="text-xs">Coba ubah kata kunci pencarian Anda.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>


    </main>
    <footer class="bg-gray-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">

            <div class="md:col-span-1">
                <h2 class="text-2xl font-bold text-white mb-3">MBG Sistem</h2>
                <p class="mt-2 text-sm text-gray-400 leading-relaxed">
                    Sistem Pelayanan Makanan Bergizi Gratis — Platform untuk transparansi dan akuntabilitas distribusi.
                </p>
            </div>

            <div class="md:col-span-1">
                <h3 class="text-lg font-semibold text-white mb-4">Navigasi Utama</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#beranda" class="hover:text-[var(--green)] transition duration-150 ease-in-out">Beranda</a></li>
                    <li><a href="#daftar_sppg" class="hover:text-[var(--green)] transition duration-150 ease-in-out">Daftar SPPG</a></li>
                </ul>
            </div>

            <div class="md:col-span-1">
                <h3 class="text-lg font-semibold text-white mb-4">Informasi</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-[var(--green)] transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-[var(--green)] transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-[var(--green)] transition">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <div class="md:col-span-1">
                <h3 class="text-lg font-semibold text-white mb-4">Hubungi Kami</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        Email: <span class="text-gray-400">adminGanteng@gmail.com</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 3.683c.27.134.56.248.87.35l3.864-3.864a1 1 0 011.414 0l1.414 1.414a1 1 0 010 1.414L14.43 12.01c.102.31.216.6.35.87l3.683.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-5.414a2 2 0 00-1.414.586L9 19.586A2 2 0 007.586 20H4a2 2 0 01-2-2V3z" />
                        </svg>
                        Telepon: <span class="text-gray-400">0812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Alamat: <span class="text-gray-400">Purbalingga, Jawa Tengah, Indonesia</span>
                    </li>
                </ul>

                <div class="flex gap-4 mt-6">
                    <a href="#" class="text-gray-500 hover:text-[var(--green)] transition duration-150 ease-in-out" aria-label="Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987H7.898v-2.89h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.629.771-1.629 1.562v1.875h2.773l-.443 2.89h-2.33v6.987C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>

                    <a href="#" class="text-gray-500 hover:text-[var(--green)] transition duration-150 ease-in-out" aria-label="Twitter">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 7.48v.45A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                        </svg>
                    </a>

                    <a href="#" class="text-gray-500 hover:text-[var(--green)] transition duration-150 ease-in-out" aria-label="Instagram">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96s4.46 9.96 9.96 9.96 9.96-4.46 9.96-9.96S17.5 2.04 12 2.04zm0 18.1A8.14 8.14 0 013.86 12 8.14 8.14 0 0112 3.86 8.14 8.14 0 0120.14 12 8.14 8.14 0 0112 20.14zm3.74-12.78a1.38 1.38 0 11-1.37-1.38 1.38 1.38 0 011.37 1.38zM12 7.96A4.03 4.03 0 108 12a4.03 4.03 0 004-4.04z" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-800 py-4 text-center text-sm text-gray-500">
            © 2025 MBG Sistem. Hak Cipta Dilindungi.
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileBtn = document.getElementById('mobileBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth scroll for mobile menu links
        document.querySelectorAll('#mobileMenu a').forEach(item => {
            item.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // Logout confirmation (Updated to use event listeners)
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutBtn2 = document.getElementById('logoutBtn2');

        function doLogout(event) {
            event.preventDefault(); // Mencegah aksi default tombol jika ada
            if (confirm('Anda yakin ingin keluar dari sesi ini?')) {
                // Arahkan ke halaman logout.php setelah konfirmasi
                window.location.href = "../logout.php";
            }
        }

        // Attach event listeners for logout buttons
        logoutBtn.addEventListener('click', doLogout);
        logoutBtn2.addEventListener('click', doLogout);
    </script>
      <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>