<?php
require_once __DIR__ . '/../lib/db_helper.php';
require_once __DIR__ . '/../config.php';

function test_db_query_returns_result() {
    $res = db_query("SELECT 1 AS test", "");
    assert($res instanceof mysqli_result, "Should return mysqli_result");
    $row = $res->fetch_assoc();
    assert($row['test'] === 1, "Should return correct value");
    echo "PASS: db_query works\n";
}

function test_db_exec_returns_affected_rows() {
    global $db;
    $db->query("CREATE TEMPORARY TABLE tmp_test (id INT)");
    $affected = db_exec("INSERT INTO tmp_test (id) VALUES (?)", "i", 42);
    assert($affected === 1, "Should return 1 affected row");
    $db->query("DROP TEMPORARY TABLE tmp_test");
    echo "PASS: db_exec works\n";
}

test_db_query_returns_result();
test_db_exec_returns_affected_rows();
