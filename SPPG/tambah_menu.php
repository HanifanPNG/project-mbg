<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Menu - MBG Sistem</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">

  <main class="max-w-5xl mx-auto px-6 py-12">

    <!-- Header -->
    <div class="mb-10">
      <span class="inline-block mb-3 rounded-full bg-green-100 px-4 py-1 text-sm font-semibold text-green-700">
        Manajemen Menu SPPG
      </span>
      <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
        Tambah Menu Makanan
      </h1>
    </div>

    <!-- Card -->
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-slate-200 p-8">

      <?php
      $sppg_id = $_GET['id'] ?? '';
      date_default_timezone_set('Asia/Jakarta');
      if (isset($_POST['simpanMenu'])) {
          $hari = $_POST['hari'];
          $nama_menu = $_POST['nama_menu'];
          $deskripsi = $_POST['deskripsi_menu'];
          $image = $_FILES['image']['name'];
          $tmp = $_FILES['image']['tmp_name'];

          move_uploaded_file($tmp, "../uploads/" . $image);

          require_once "../config.php";
          $waktu = date("Y-m-d H:i:s");
          $sql = "INSERT INTO menu_sppg 
                  (sppg_id, hari, nama_menu, deskripsi_menu, image, waktu)
                  VALUES ('$sppg_id','$hari','$nama_menu','$deskripsi','$image', '$waktu')";
          $db->query($sql);

          echo "
          <div class='mb-6 flex items-center gap-3 rounded-xl bg-green-50 px-5 py-4 text-green-700 border border-green-200'>
            <span class='text-xl'>✅</span>
            <span class='font-medium'>Menu berhasil ditambahkan</span>
          </div>";
      }
      ?>

      <form method="post" enctype="multipart/form-data" class="space-y-8">

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Nama Menu -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Nama Menu
            </label>
            <input type="text" name="nama_menu" required
              placeholder="Contoh: Nasi Ayam Sehat"
              value="<?= $nama_menu ?? '' ?>"
              class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-700
                     focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition">
          </div>

          <!-- Hari -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Hari
            </label>
            <select name="hari" required
              class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white text-slate-700
                     focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition">
              <option value="">Pilih Hari</option>
              <option value="1" <?= ($hari ?? '') == "1" ? 'selected' : '' ?>>Senin</option>
              <option value="2" <?= ($hari ?? '') == "2" ? 'selected' : '' ?>>Selasa</option>
              <option value="3" <?= ($hari ?? '') == "3" ? 'selected' : '' ?>>Rabu</option>
              <option value="4" <?= ($hari ?? '') == "4" ? 'selected' : '' ?>>Kamis</option>
              <option value="5" <?= ($hari ?? '') == "5" ? 'selected' : '' ?>>Jumat</option>
            </select>
          </div>

        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            Deskripsi Menu
          </label>
          <textarea name="deskripsi_menu" rows="4" required
            placeholder="Deskripsi singkat kandungan gizi menu"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-700
                   focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition"><?= $deskripsi ?? '' ?></textarea>
        </div>

        <!-- Upload -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            Foto Menu
          </label>

          <div class="flex items-center justify-between rounded-xl border border-dashed border-slate-300 px-5 py-4">
            <input type="file" name="image" required accept="image/*"
              class="block w-full text-sm text-slate-600
                     file:mr-4 file:rounded-lg
                     file:border-0 file:bg-green-600
                     file:px-4 file:py-2
                     file:text-white hover:file:bg-green-700 transition">
          </div>
        </div>

        <!-- Action -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-slate-200">

          <a href="./?p=detail_sppg&id=<?= $sppg_id ?>"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-300
                   px-6 py-3 text-slate-700 hover:bg-slate-100 transition">
            ← Kembali
          </a>

          <button type="submit" name="simpanMenu"
            class="inline-flex items-center gap-2 rounded-xl bg-green-600
                   px-7 py-3 text-white font-semibold
                   hover:bg-green-700 hover:shadow-lg transition">
            Simpan Menu
          </button>

        </div>

      </form>
    </div>
  </main>

</body>
</html>
