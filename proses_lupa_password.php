<?php
require "config.php";

$username = $_POST['username'];
$password_baru = $_POST['password_baru'];

$q = $db->query("SELECT * FROM users WHERE username='$username'");
$user = $q->fetch_assoc();

if (!$user) {
    echo "<script>alert('Username tidak ditemukan');history.back();</script>";
    exit;
}

$hash = password_hash($password_baru, PASSWORD_DEFAULT);

$db->query("UPDATE users SET password='$hash' WHERE username='$username'");

echo "<script>
    alert('Password berhasil direset, silakan login');
    location='index.php';
</script>";
