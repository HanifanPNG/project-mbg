<?php
session_start();

require_once "../config.php";

$idx = $_GET['id'];
$sql = "select * from sppg where id='$idx'";
$data = $db->query($sql);

$sppg_id = $_GET['id'];
if (isset($_POST["submit"])) {
    $nama = $_POST["nama"];
    $komentar = $_POST["komentar"];
    $rating = $_POST["rating"];

    $sql = "insert into sppg_rating set sppg_id='$sppg_id', nama='$nama', komentar='$komentar', rating='$rating'";
    $hasil = $db->query($sql);

    $_SESSION['success'] = "Komentar berhasil ditambahkan!";
    header("Location: detail_sppg.php?id=$sppg_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail SPPG - MBG Sistem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        :root {
            --green: #10b981;
            --green-dark: #059669;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--green), #34d399);
        }

        .text-green-main {
            color: var(--green);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <header class="bg-white shadow-lg py-4 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Detail SPPG</h1>
            <a href="index.php" class="text-sm px-4 py-2 bg-gray-100 rounded-lg text-gray-600 hover:bg-gray-200 transition duration-150 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8" data-aos="fade-right" data-aos-duration="1000">

        <?php
        foreach ($data as $d) {
            echo "
  <div class='bg-white p-8 rounded-xl shadow-xl border border-gray-200' >
    <h2 class='text-3xl font-extrabold text-gray-800 mb-6 border-b-2 border-green-main pb-2 flex items-center gap-2'>
      <svg xmlns='http://www.w3.org/2000/svg' class='w-7 h-7 text-green-main' viewBox='0 0 20 20' fill='currentColor'>
        <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0z'/>
      </svg>
      Informasi SPPG
    </h2>

    <!-- GRID INFO + MAP -->
    <div class='grid grid-cols-1 md:grid-cols-2 gap-8'>

      <!-- KIRI : INFORMASI -->
      <div class='space-y-4 text-gray-700'>
        <div>
          <p class='font-medium text-sm text-gray-500'>Nama SPPG</p>
          <p class='text-lg font-semibold border-b pb-2'>{$d['nama_sppg']}</p>
        </div>

        <div>
          <p class='font-medium text-sm text-gray-500'>Kota</p>
          <p class='text-lg font-semibold border-b pb-2'>{$d['kota']}</p>
        </div>

        <div>
          <p class='font-medium text-sm text-gray-500'>Jam Operasional</p>
          <p class='text-lg font-semibold'>
            {$d['jam_buka']} - {$d['jam_tutup']}
          </p>
        </div>

        <div>
          <p class='font-medium text-sm text-gray-500'>Alamat Lengkap</p>
          <p class='text-lg font-semibold'>{$d['alamat']}</p>
        </div>
      </div>

      <div class='w-full h-[320px] rounded-xl overflow-hidden border shadow'>
        <iframe
          class='w-full h-full'
          frameborder='0'
          referrerpolicy='no-referrer-when-downgrade'
          src='https://www.google.com/maps?q=" . urlencode($d['alamat']) . "&output=embed'
          allowfullscreen>
        </iframe>
      </div>

    </div>
  </div>";
        }
        ?>


        <!-- menu harian -->
        <div class="bg-white p-8 rounded-xl shadow-xl border border-gray-200"  data-aos="fade-right" data-aos-duration="1000">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-green-main pb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-main" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 001.414 1.414L12 15.414l-3.293-3.293a1 1 0 00-1.414 1.414L8.586 17H5a3 3 0 01-3-3V5a1 1 0 001-1z" clip-rule="evenodd" />
                </svg>
                Menu Harian
            </h2>

            <?php
            $sqlMenu = "select * from menu_sppg WHERE sppg_id='$sppg_id' ORDER BY hari ASC";
            $dataMenu = $db->query($sqlMenu);
            ?>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-100/70">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-20">Hari</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Menu</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Deskripsi Menu</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">Gambar</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        <?php
                        if ($dataMenu->num_rows > 0) {
                            foreach ($dataMenu as $m) {
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
                                <tr class='even:bg-gray-50 hover:bg-green-50 transition duration-100'>
                                    <td class='py-4 px-6 font-medium'>{$hari}</td>
                                    <td class='py-4 px-6'>{$m['nama_menu']}</td>
                                    <td class='py-4 px-6'>{$m['deskripsi_menu']}</td>
                                    <td class='py-4 px-6'>
                                        <img src='../uploads/{$m['image']}' alt='Menu' class='h-16 w-16 object-cover rounded-md shadow-sm border border-gray-200' />
                                    </td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='py-5 text-center text-gray-500 bg-gray-50'>Belum ada menu yang terdaftar untuk SPPG ini.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- sekolah -->
        <div class="bg-white p-8 rounded-xl shadow-xl border border-gray-200"  data-aos="fade-right" data-aos-duration="1000">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-green-main pb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-main" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Daftar Sekolah Penerima MBG
            </h2>

            <?php
            $sqlSek = "select * from sekolah WHERE sppg_id='$sppg_id'";
            $dataSek = $db->query($sqlSek);
            ?>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-100/70">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-10">No</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Sekolah</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenjang Pendidikan</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        <?php
                        $no = 0;
                        if ($dataSek->num_rows > 0) {
                            foreach ($dataSek as $ds) {
                                $no++;
                                echo "
                                <tr class='even:bg-gray-50 hover:bg-green-50 transition duration-100'>
                                    <td class='py-4 px-6'>$no</td>
                                    <td class='py-4 px-6 font-medium'>{$ds['nama_sekolah']}</td>
                                    <td class='py-4 px-6'>{$ds['jenjang']}</td>
                                    <td class='py-4 px-6 max-w-xs'>{$ds['alamat']}</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='py-5 text-center text-gray-500 bg-gray-50'>Belum ada sekolah penerima yang terdaftar.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- kelomppok 3b -->
        <div class="bg-white p-8 rounded-xl shadow-xl border border-gray-200"  data-aos="fade-right" data-aos-duration="1000">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-green-main pb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-main" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Daftar kelompok 3B Penerima MBG
            </h2>

            <?php
            $sql3b = "select * from ibu_hamil WHERE sppg_id='$sppg_id'";
            $data3b = $db->query($sql3b);
            ?>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-100/70">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-10">No</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Penerima</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Klaster</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        <?php
                        $no = 0;
                        if ($data3b->num_rows > 0) {
                            foreach ($data3b as $c) {
                                $no++;
                                if ($c['klaster'] == 1) {
                                    $c['klaster'] = "Ibu Hamil";
                                } elseif ($c['klaster'] == 2) {
                                    $c['klaster'] = "Ibu Menyusui";
                                } elseif ($c['klaster'] == 3) {
                                    $c['klaster'] = "Balita Non PAUD";
                                }
                                echo "
                                <tr class='even:bg-gray-50 hover:bg-green-50 transition duration-100'>
                                    <td class='py-4 px-6'>$no</td>
                                    <td class='py-4 px-6 font-medium'>{$c['nama_ibu']}</td>
                                    <td class='py-4 px-6'>{$c['klaster']}</td>
                                    <td class='py-4 px-6 max-w-xs'>{$c['alamat']}</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='py-5 text-center text-gray-500 bg-gray-50'>Belum ada kelompok 3B penerima yang terdaftar.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- komentar -->
        <div class="bg-white p-8 rounded-xl shadow-xl border border-gray-200"  data-aos="fade-right" data-aos-duration="1000">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-green-main pb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-main" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 000 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Ulasan & Komentar
            </h2>

            <?php
            $sqlRat = "
SELECT 
  sr.komentar,
  sr.rating,
  sr.tanggal,
  u.username AS nama
FROM sppg_rating sr
JOIN users u ON sr.user_id = u.id
WHERE sr.sppg_id = '$sppg_id'
ORDER BY sr.tanggal DESC
";
            $dataRat = $db->query($sqlRat);
            ?>
            <div class="overflow-x-auto rounded-lg border border-gray-200 mb-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-100/70">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-40">Nama</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Komentar</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">Rating</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        <?php
                        if ($dataRat->num_rows > 0) {
                            foreach ($dataRat as $dr) {
                                if ($dr['rating'] == 5) {
                                    $rating_stars = "⭐⭐⭐⭐⭐";
                                } elseif ($dr['rating'] == 4) {
                                    $rating_stars = "⭐⭐⭐⭐";
                                } elseif ($dr['rating'] == 3) {
                                    $rating_stars = "⭐⭐⭐";
                                } elseif ($dr['rating'] == 2) {
                                    $rating_stars = "⭐⭐";
                                } elseif ($dr['rating'] == 1) {
                                    $rating_stars = "⭐";
                                } else {
                                    $rating_stars = "";
                                }
                                echo "
                                <tr class='even:bg-gray-50 hover:bg-green-50 transition duration-100'>
                                    <td class='py-4 px-6 font-medium'>$dr[nama]</td>
                                    <td     class='py-4 px-6 max-w-md'>$dr[komentar]</td>
                                    <td class='py-4 px-6 text-lg'>$rating_stars</td>
                                    <td class='py-4 px-6 text-gray-500'>$dr[tanggal]</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='py-5 text-center text-gray-500 bg-gray-50'>Belum ada ulasan untuk SPPG ini. Jadilah yang pertama!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-4 pt-4 border-t">Beri Ulasan Anda</h3>

            <?php if (
                isset($_SESSION['level']) &&
                $_SESSION['level'] === 'user' &&
                $_SESSION['sppg_id'] != $sppg_id
            ): ?>
                <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded-lg">
                    Anda hanya dapat memberi ulasan pada SPPG yang anda terima.
                </div>
            <?php else: ?>
                <form action="../actions/simpan_komentar.php" method="post" class="space-y-4"  data-aos="zoom-in" data-aos-duration="500">
                    <input type="hidden" name="sppg_id" value="<?= $sppg_id ?>">
                    <textarea
                        name="komentar"
                        required
                        placeholder="Tulis ulasan Anda mengenai kualitas layanan atau menu..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg h-28 resize-none shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none transition"></textarea>

                    <div>
                        <label for="rating" class="block mb-1 font-medium text-gray-700">Pilih Rating</label>
                        <select
                            name="rating"
                            id="rating"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none transition appearance-none">
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                            <option value="3">⭐⭐⭐ (Cukup)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Buruk)</option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        name="submit"
                        class="w-full gradient-bg hover:opacity-90 text-white py-3 rounded-lg font-semibold shadow-md transition duration-300 ease-in-out">
                        Kirim Ulasan
                    </button>
                </form>
            <?php endif; ?>
        </div>


    </main>
    <footer class="bg-gray-900 text-gray-300 mt-16">
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
                    <li><a href="index.php#beranda" class="hover:text-green-400 transition duration-150 ease-in-out">Beranda</a></li>
                    <li><a href="index.php#daftar_sppg" class="hover:text-green-400 transition duration-150 ease-in-out">Daftar SPPG</a></li>
                </ul>
            </div>

            <div class="md:col-span-1">
                <h3 class="text-lg font-semibold text-white mb-4">Informasi</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-green-400 transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-green-400 transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-green-400 transition">Syarat & Ketentuan</a></li>
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
                    <a href="#" class="text-gray-500 hover:text-green-400 transition duration-150 ease-in-out" aria-label="Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987H7.898v-2.89h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.629.771-1.629 1.562v1.875h2.773l-.443 2.89h-2.33v6.987C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>

                    <a href="#" class="text-gray-500 hover:text-green-400 transition duration-150 ease-in-out" aria-label="Twitter">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 7.48v.45A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                        </svg>
                    </a>

                    <a href="#" class="text-gray-500 hover:text-green-400 transition duration-150 ease-in-out" aria-label="Instagram">
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
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>