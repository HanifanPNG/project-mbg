<?php
/**
 * Execute a prepared SELECT query and return mysqli_result.
 */
function db_query(string $sql, string $types, ...$params): mysqli_result|false {
    global $db;
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        error_log("db_query prepare failed: " . $db->error);
        return false;
    }
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    if (!$stmt->execute()) {
        error_log("db_query execute failed: " . $stmt->error);
        return false;
    }
    return $stmt->get_result();
}

/**
 * Execute a prepared INSERT/UPDATE/DELETE query and return affected rows.
 */
function db_exec(string $sql, string $types, ...$params): int|false {
    global $db;
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        error_log("db_exec prepare failed: " . $db->error);
        return false;
    }
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    if (!$stmt->execute()) {
        error_log("db_exec execute failed: " . $stmt->error);
        return false;
    }
    return $stmt->affected_rows;
}
