<?php
session_start();
require_once "lib/error_handler.php"; setup_error_handling(true);
require_once "config.php";
require_once "lib/db_helper.php";
require_once "lib/validation.php";
require_once "lib/csrf.php";
csrf_token();

$token = $_GET['token'] ?? '';
$res = db_query("SELECT username FROM password_resets WHERE token=? AND expires>NOW() AND used=0", "s", $token);
if (!$res || $res->num_rows === 0) {
    die("Token tidak valid atau sudah kadaluarsa");
}
$row = $res->fetch_assoc();
$username = $row['username'];

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) die("Invalid CSRF");
    $newPass = $_POST['password_baru'] ?? '';
    if (strlen($newPass) < 8) {
        $error = "Password minimal 8 karakter";
    } else {
        $hash = password_hash($newPass, PASSWORD_DEFAULT);
        db_exec("UPDATE users SET password=? WHERE username=?", "ss", $hash, $username);
        db_exec("UPDATE password_resets SET used=1 WHERE token=?", "s", $token);
        header("Location: index.php?reset=success");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><title>Reset Password</title>
<script src="https://cdn.tailwindcss.com"></script></head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Reset Password untuk <?= e($username) ?></h2>
    <?php if ($error): ?><div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3 text-sm"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="space-y-4">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
        <input type="password" name="password_baru" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
      </div>
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg">Ubah Password</button>
    </form>
  </div>
</body></html>
