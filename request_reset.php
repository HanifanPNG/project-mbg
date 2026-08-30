<?php
session_start();
require_once "lib/error_handler.php"; setup_error_handling(true);
require_once "config.php";
require_once "lib/db_helper.php";
require_once "lib/validation.php";
require_once "lib/csrf.php";
csrf_token();

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        $message = "Invalid CSRF token";
    } else {
        $username = v_string($_POST['username'] ?? '', 50);
    $res = db_query("SELECT id FROM users WHERE username=?", "s", $username);
    if ($res && $res->num_rows > 0) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 900); // 15 minutes
        db_exec("INSERT INTO password_resets (username, token, expires) VALUES (?, ?, ?)",
            "sss", $username, $token, $expires);
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $resetLink = "$scheme://{$_SERVER['HTTP_HOST']}/reset_password.php?token=$token";
        // Note: In production, send actual email. Here we just show the link for testing.
        $message = "Link reset password: $resetLink<br>(Dalam produksi, link ini akan dikirim ke email. Untuk testing, link di atas bisa diklik.)";
    } else {
        $message = "Username tidak ditemukan";
    }
}
}
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><title>Request Reset</title>
<script src="https://cdn.tailwindcss.com"></script></head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Lupa Password</h2>
    <?php if ($message): ?><div class="mb-4 rounded-lg bg-blue-100 border border-blue-300 text-blue-700 px-4 py-3 text-sm"><?= $message ?></div><?php endif; ?>
    <form method="post" class="space-y-4">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
      </div>
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg">Kirim Link Reset</button>
    </form>
    <p class="text-sm text-center mt-4"><a href="login.php" class="text-green-600">Kembali ke login</a></p>
  </div>
</body></html>
