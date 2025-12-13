<?php
require_once "config.php";
$sppg = $db->query("SELECT id, nama_sppg FROM sppg");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register Akun | MBG</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9, #ffffff);
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
    
    <!-- Judul -->
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">
      Registrasi Akun
    </h2>


    <!-- Form -->
    <form action="register_process.php" method="post" class="space-y-4">

      <!-- Username -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Username
        </label>
        <input
          type="text"
          name="username"
          required
          placeholder="Masukkan username"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
        >
      </div>

      <!-- Password -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Password
        </label>
        <input
          type="password"
          name="password"
          required
          placeholder="Masukkan password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
        >
      </div>

      <!-- Pilih SPPG -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          SPPG
        </label>
        <select
          name="sppg_id"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
        >
          <option value="">-- Pilih SPPG --</option>
          <?php while ($s = $sppg->fetch_assoc()): ?>
            <option value="<?= $s['id'] ?>">
              <?= htmlspecialchars($s['nama_sppg']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <!-- Tombol -->
      <button
        type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition duration-200"
      >
        Daftar Akun
      </button>

    </form>

    <!-- Footer -->
    <p class="text-xs text-gray-500 text-center mt-6">
      © <?= date('Y') ?> MBG-KU
    </p>

  </div>

</body>
</html>
