<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../lib/db_helper.php';

$hash = password_hash('testpass', PASSWORD_DEFAULT);
$db->query("DELETE FROM users WHERE username='testuser'");
$db->query("INSERT INTO users (username, password, level) VALUES ('testuser', '$hash', 'user')");

$_POST['tuser'] = 'testuser';
$_POST['tpass'] = 'testpass';
$_POST['btnLogin'] = 'Login';

session_start();
include __DIR__ . '/../index.php';

// If we reach here without exit, login failed or something wrong
echo "Reached end (no exit). loginError='".$loginError."'\n";
if (isset($_SESSION['isLogin'])) {
    echo "REDIRECT OBJECT SET\n";
} else {
    echo "No session\n";
}
$db->query("DELETE FROM users WHERE username='testuser'");
