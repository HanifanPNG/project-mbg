<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../lib/db_helper.php';

// Insert test user (ensure clean state)
$hash = password_hash('testpass', PASSWORD_DEFAULT);
$db->query("DELETE FROM users WHERE username='testuser'");
$db->query("INSERT INTO users (username, password, level) VALUES ('testuser', '$hash', 'user')");

// Simulate POST login
$_POST['tuser'] = 'testuser';
$_POST['tpass'] = 'testpass';
$_POST['btnLogin'] = 'Login';

ob_start();
include __DIR__ . '/../index.php';
$output = ob_get_clean();

assert(strpos($output, 'Location: User/') !== false, 'Should redirect to User/');

echo "PASS: login works with prepared statement\n";

// Cleanup
$db->query("DELETE FROM users WHERE username='testuser'");
