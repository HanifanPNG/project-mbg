<?php
require_once "config.php";
require_once "lib/db_helper.php";
require_once "lib/validation.php";

$username = v_string($_POST['username'] ?? '', 50);
$password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
$sppg_id  = (int)($_POST['sppg_id'] ?? 0);

// cek username
$cek = db_query("SELECT id FROM users WHERE username=?", "s", $username);
if($cek->num_rows > 0){
  die("Username sudah digunakan");
}

// simpan - force level = 'user'
$ok = db_exec(
  "INSERT INTO users (username, password, level, sppg_id) VALUES (?, ?, 'user', ?)",
  "ssi",
  $username, $password, $sppg_id
);

if ($ok) {
    header("location:login.php?register=success");
    exit;
}
die("Gagal mendaftar");