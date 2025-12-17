<?php
session_start();
require_once "../config.php";

$username = $_SESSION['user'] ?? 'SPPG';

if (!isset($_SESSION['isLogin']) || $_SESSION['level'] !== 'sppg') {
    die("Akses ditolak");
}
$sppg_id = $_SESSION['sppg_id'];

// minggu aktif (contoh: 202502)
$minggu = isset($_GET['minggu'])
    ? (int) $_GET['minggu']
    : (int) date('oW');

$sqlMenu = "
SELECT *
FROM menu_sppg
WHERE sppg_id = '$sppg_id'
AND YEARWEEK(tanggal, 1) = $minggu
ORDER BY tanggal ASC
";

$dataMenu = $db->query($sqlMenu);

if (!$dataMenu) {
    die("SQL Error: " . $db->error);
}


?>

<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <title>Dashboard SPPG | MBG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        :root {
            --green: #16a34a;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .gradient-detail-btn {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- HEADER -->

    <header class="shadow-md sticky top-0 bg-white z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="#" class="flex items-center gap-3">
                    <div>
                        <img src="../assets/img/mbg-ku.png" alt="" class="w-20 absolute left-0 top-1">
                        <h1 class="pl-8 text-xl font-bold">MBG-KU</h1>
                        <p class="pl-8 text-xs text-gray-500">Pelayanan Makanan Bergizi Gratis</p>
                    </div>
                </a>


                <nav class="hidden md:flex items-center gap-8">
                    <a href="#beranda" class="font-medium hover:text-[var(--green)]">Beranda</a>
                    <a href="#daftar_sppg" class="font-medium hover:text-[var(--green)]">Lihat Menu</a>
                    <a href="../index.php">
                        <button class="px-4 py-2 border rounded-lg hover:bg-red-500 hover:text-white">Logout</button>
                    </a>
                </nav>

                <div class="md:hidden">
                    <button id="mobileBtn" class="p-2 border rounded-lg">☰</button>
                </div>
            </div>


        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-white px-4 pb-4">
            <a href="#beranda" class="block py-2">Beranda</a>
            <a href="#daftar_sppg" class="block py-2">Daftar SPPG</a>
            <button class="py-2 text-red-500">Logout</button>
        </div>
    </header>

    <!-- MAIN -->

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- HERO -->

        <section id="beranda" class="pt-16 pb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-4xl sm:text-5xl font-extrabold leading-snug mb-4">
                        Selamat Datang<br>
                        <span class="text-[var(--green)]"><?= $username ?></span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        Panel pengelolaan dan monitoring Program Makan Bergizi Gratis
                    </p>
                    <a href="#daftar_sppg" class="inline-block px-8 py-3 text-white font-semibold rounded-full gradient-bg shadow-lg hover:opacity-90 transition" data-aos="flip-up" data-aos-duration="1000">
                        Lihat Data Menu
                    </a>
                </div>

            </div>
        </section>
        <?php
        $qMinggu = $db->query("
            SELECT 
                YEARWEEK(tanggal,1) AS minggu,
                MIN(tanggal) AS dari,
                MAX(tanggal) AS sampai
            FROM menu_sppg
            WHERE sppg_id = '$sppg_id'
            GROUP BY YEARWEEK(tanggal,1)
            ORDER BY minggu DESC
        ");
        ?>
        <select
            onchange="location.href='?minggu='+this.value"
            class="border rounded-lg px-4 py-2 mb-4">

            <?php while ($m = $qMinggu->fetch_assoc()): ?>
                <option value="<?= $m['minggu'] ?>"
                    <?= ($minggu == $m['minggu']) ? 'selected' : '' ?>>

                    <?php if (!empty($m['dari']) && !empty($m['sampai'])): ?>
                        <?= date('d M', strtotime($m['dari'])) ?>
                        -
                        <?= date('d M Y', strtotime($m['sampai'])) ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>

                </option>
            <?php endwhile ?>
        </select>

        <!-- TABLE -->
        <section id="daftar_sppg" class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 sm:mb-0 border-b-4 border-green-500 pb-1" data-aos="fade-right" data-aos-duration="500">
                        Daftar Menu
                    </h2>
                    <a href="tambah_menu.php?id=<?= $sppg_id ?>">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600
                    px-6 py-3 text-lg text-white font-semibold shadow-md
                    hover:bg-green-700 hover:shadow-xl transition duration-300 transform hover:scale-105" data-aos="flip-up" data-aos-duration="700">
                            <i class="bi bi-plus-lg"></i>
                            Tambah Menu
                        </button>
                    </a>
                </div>

                <div class="shadow-lg rounded-xl overflow-hidden border border-gray-200 bg-white" data-aos="fade-right" data-aos-duration="500">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-20">Hari</th>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Menu</th>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Deskripsi Menu</th>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Gambar</th>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Waktu</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-40">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                <?php
                                if ($dataMenu->num_rows > 0) {
                                    foreach ($dataMenu as $m) {

                                        $waktu = !empty($m['waktu'])
                                            ? date('d M Y H:i', strtotime($m['waktu']))
                                            : '-';
                                        $update = !empty($m['updated_at'])
                                            ? date('d M Y H:i', strtotime($m['updated_at']))
                                            : '-';

                                        // Logika PHP untuk menentukan hari (Backend tidak diubah)
                                        if ($m['hari'] == 1) {
                                            $hari = "Senin";
                                        } elseif ($m['hari'] == 2) {
                                            $hari = "Selasa";
                                        } elseif ($m['hari'] == 3) {
                                            $hari = "Rabu";
                                        } elseif ($m['hari'] == 4) {
                                            $hari = "Kamis";
                                        } elseif ($m['hari'] == 5) {
                                            $hari = "Jum'at";
                                        } else {
                                            $hari = "Lainnya";
                                        }
                                        echo "
                                <tr class='bg-white even:bg-gray-50 hover:bg-green-50 transition duration-150'>
                                    <td class='py-4 px-6 font-semibold text-gray-800'>{$hari}</td>
                                    <td class='py-4 px-6 font-medium'>{$m['nama_menu']}</td>
                                    <td class='py-4 px-6'>{$m['deskripsi_menu']}</td>
                                    <td class='py-4 px-6'>
                                        <img src='../uploads/{$m['image']}' alt='Menu' class='h-16 w-16 object-cover rounded-lg shadow-sm border border-gray-200' />
                                    </td>
                                        <td class='text-xs text-gray-600'>
                                        Created: {$waktu}<br>
                                        Update: {$update}
                                    </td>
                                    <td class='py-4 px-6 text-center whitespace-nowrap'>
                                        <div class='flex items-center justify-center space-x-2'>
                                            <a href='edit_menu.php?id={$m['id']}&sppg_id=$sppg_id' class='p-2 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition duration-150' title='Edit Menu'>
                                                <i class='bi bi-pencil-fill text-lg'></i>
                                            </a>
                                            <a href='hapus_menu.php?id={$m['id']}&sppg_id=$sppg_id' class='p-2 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition duration-150' title='Hapus Menu'>
                                                <i class='bi bi-trash3-fill text-lg'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                ";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='py-10 text-center text-gray-500 bg-white font-medium'>Belum ada menu yang terdaftar untuk SPPG ini.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->

    <footer class="bg-gray-900 text-gray-300 mt-20">
        <div class="text-center py-6 text-sm">© 2025 MBG Sistem</div>
    </footer>

    <script>
        const mobileBtn = document.getElementById('mobileBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        mobileBtn.onclick = () => mobileMenu.classList.toggle('hidden');
    </script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>

</body>

</html>