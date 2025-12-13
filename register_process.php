<?php
require_once "config.php";

$username = trim($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$sppg_id  = $_POST['sppg_id'];

// cek username
$cek = $db->query("SELECT id FROM users WHERE username='$username'");
if($cek->num_rows > 0){
  die("Username sudah digunakan");
}

// simpan
$db->query("
  INSERT INTO users (username, password, level, sppg_id)
  VALUES ('$username', '$password', 'user', '$sppg_id')
");

header("location:index.php?register=success");
