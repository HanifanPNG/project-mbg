<?php
$title = "MBG-KU";
session_start();
error_reporting(0);

$loginError = "";

if (isset($_POST['btnLogin'])) {
  $tuser = $_POST['tuser'];
  $tpass = $_POST['tpass'];
  require_once "config.php";

  $sql = "SELECT * FROM users WHERE username='$tuser'";
  $hasil = $db->query($sql);

  if ($hasil->num_rows > 0) {
    $data = $hasil->fetch_assoc();

    if (password_verify($tpass, $data['password'])) {

      if ($data['level'] != 'admin' && $data['level'] != 'user' && $data['level'] != 'sppg') {
        $loginError = "Akun tidak diizinkan login";
      } else if ($data['level'] == 'user' && empty($data['sppg_id'])) {
        $loginError = "Akun belum terdaftar ke SPPG";
      } else {
        $_SESSION['isLogin'] = true;
        $_SESSION['level']   = $data['level'];
        $_SESSION['user']    = $data['username'];
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['sppg_id'] = $data['sppg_id'];

        if ($data['level'] == 'admin') {
          header("Location: Admin/");
        } elseif ($data['level'] == 'user') {
          header("Location: User/");
        } elseif ($data['level'] == 'sppg') {
          header("Location: SPPG/");
        }
        exit;
      }
    } else {
      $loginError = "Username atau Password salah";
    }
  } else {
    $loginError = "Username atau Password salah";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?> | Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#22c55e',
            secondary: '#3b82f6'
          }
        }
      }
    }
  </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-blue-50">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

    <!-- Logo / Title -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-extrabold text-gray-800"><?= $title ?></h1>
      <p class="text-sm text-gray-500 mt-1">Sistem Pelayanan Makanan Bergizi</p>
    </div>

    <!-- Error -->
    <?php if (!empty($loginError)): ?>
      <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3 text-sm">
        <?= $loginError ?>
      </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="post" class="space-y-6">

      <!-- Username -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input type="text" name="tuser" required
          class="w-full rounded-xl border border-gray-300 px-4 py-3
          focus:ring-2 focus:ring-primary focus:border-primary transition">
      </div>

      <!-- Password -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <input type="password" name="tpass" id="password" required
            class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-12
            focus:ring-2 focus:ring-primary focus:border-primary transition">
          <button type="button" onclick="togglePassword()"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
            👁
          </button>
        </div>
      </div>

      <!-- Login Button -->
      <button type="submit" name="btnLogin"
        class="w-full py-3 rounded-xl text-white font-semibold
        bg-gradient-to-r from-green-500 to-blue-500
        hover:opacity-90 hover:shadow-lg transition">
        Login
      </button>

    </form>

    <!-- Links -->
    <div class="mt-6 text-center space-y-2 text-sm">
      <p class="text-gray-600">
        Belum punya akun?
        <a href="register.php" class="text-primary font-semibold hover:underline">Daftar di sini</a>
      </p>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-xs text-gray-400">
      © <?= date('Y') ?> MBG-KU • Copyright by Gweh
    </div>

  </div>

  <script>
    function togglePassword() {
      const pass = document.getElementById('password');
      pass.type = pass.type === 'password' ? 'text' : 'password';
    }
  </script>

</body>
</html>
