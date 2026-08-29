<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../lib/db_helper.php';
require_once __DIR__ . '/../lib/validation.php';

// Clean up
$db->query("DELETE FROM users WHERE username='regtest'");

$_POST['username'] = 'regtest';
$_POST['password'] = 'pass123';
$_POST['sppg_id'] = '4';

try {
    ob_start();
    include __DIR__ . '/../register_process.php';
    $output = ob_get_clean();
} catch (\Throwable $e) {
    $output = ob_get_clean();
    echo "THREW: " . $e->getMessage() . "\n";
}

// Verify the write happened regardless of exit
$res = db_query("SELECT password FROM users WHERE username=?", "s", 'regtest');
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if (password_verify('pass123', $row['password'])) {
        echo "PASS: register works\n";
    } else {
        echo "FAIL: password mismatch\n";
    }
} else {
    echo "FAIL: user not created\n";
}

$db->query("DELETE FROM users WHERE username='regtest'");
