<?php
require_once "config.php";
require_once "lib/db_helper.php";
require_once "lib/validation.php";

$username = v_string($_POST['username'] ?? '', 50);
$password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
$sppg_id  = v_int($_POST['sppg_id'] ?? '', 1);

$exists = db_query("SELECT id FROM users WHERE username=?", "s", $username);
if ($exists && $exists->num_rows > 0) {
    die("Username sudah digunakan");
}

$ok = db_exec(
    "INSERT INTO users (username, password, level, sppg_id) VALUES (?, ?, ?, ?)",
    "sssi",
    $username, $password, 'user', $sppg_id
);
if ($ok) {
    header("location:index.php?register=success");
    exit;
}
die("Gagal mendaftar");