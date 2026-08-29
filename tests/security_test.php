<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../lib/db_helper.php';
require_once __DIR__ . '/../lib/validation.php';
require_once __DIR__ . '/../lib/csrf.php';
require_once __DIR__ . '/../lib/rate_limit.php';

echo "=== Security Test Suite ===\n\n";

function test_sqli_param() {
    $res = db_query("SELECT * FROM users WHERE username=?", "s", "' OR '1'='1");
    assert($res !== false, "Query runs");
    assert($res->num_rows === 0, "SQLi payload should not match");
    echo "PASS: SQLi blocked (literal param)\n";
}

function test_insert_sqli() {
    $payload = "'; DROP TABLE users;--";
    $ok = db_exec("INSERT INTO users (username,password,level) VALUES (?,?,?)", "sss", $payload, 'x', 'user');
    assert($ok !== false, "Prepared statement should insert literal payload");
    db_exec("DELETE FROM users WHERE username=?", "s", $payload);
    echo "PASS: SQLi blocked (literal insert)\n";
}

function test_xss_escape() {
    $x = e("<script>alert(1)</script>");
    assert($x === htmlspecialchars("<script>alert(1)</script>", ENT_QUOTES, 'UTF-8'), "XSS escaped");
    echo "PASS: XSS escaping works\n";
}

function test_csrf() {
    $_SESSION['csrf_token'] = 'known';
    unset($_POST['csrf_token']);
    assert(csrf_verify() === false, "No token rejected");
    $_POST['csrf_token'] = 'wrong';
    assert(csrf_verify() === false, "Wrong token rejected");
    $_POST['csrf_token'] = 'known';
    assert(csrf_verify() === true, "Correct token accepted");
    echo "PASS: CSRF validation works\n";
}

function test_validation() {
    assert(v_int("5", 0, 10) === 5);
    assert(v_int("abc", 0, 10) === 0);
    assert(v_rating("99") === 5);
    assert(v_time("13:45") === "13:45");
    assert(v_time("bad") === "00:00");
    assert(v_enum("SD", ["SD","SMP","SMA"]) === "SD");
    assert(v_enum("XX", ["SD","SMP","SMA"]) === "SD");
    echo "PASS: Validation helpers work\n";
}

function test_rate_limit() {
    $key = "test_ratelimit_" . uniqid();
    // first 5 should pass
    for ($i=0;$i<5;$i++) {
        assert(rate_limit($key, 5, 60), "Attempt $i should pass");
    }
    // 6th should fail
    assert(rate_limit($key, 5, 60) === false, "6th attempt should fail");
    echo "PASS: Rate limiting works\n";
}

function test_password_reset_flow() {
    // Can't fully test without email, but can verify token table exists
    $res = db_query("SELECT 1 FROM password_resets LIMIT 1", "");
    assert($res !== false, "password_resets table exists");
    echo "PASS: password_resets table exists\n";
}

try {
    test_sqli_param();
    test_insert_sqli();
    test_xss_escape();
    test_csrf();
    test_validation();
    test_rate_limit();
    test_password_reset_flow();
    echo "\n=== ALL SECURITY TESTS PASSED ===\n";
} catch (AssertionError $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
    exit(1);
}