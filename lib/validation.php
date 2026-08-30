<?php
function v_string(string $val, int $max = 255): string {
    $val = trim($val);
    return mb_substr($val, 0, $max);
}
function v_int(string $val, int $min = 0, int $max = PHP_INT_MAX): int {
    $n = (int)$val;
    return max($min, min($max, $n));
}
function v_rating(string $val): int { return v_int($val, 0, 5); }
function v_time(string $val): string {
    return preg_match('/^\d{2}:\d{2}$/', $val) ? $val : '00:00';
}
function v_enum(string $val, array $allowed): string {
    return in_array($val, $allowed, true) ? $val : $allowed[0];
}
function e(mixed $val): string {
    return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate username from SPPG name (huruf besar semua, spasi tetap)
 * Contoh: "SPPG Purbalingga Wetan 01" → "SPPG PURBALINGGA WETAN 01"
 */
function sppg_username_from_name(string $nama_sppg): string {
    $username = mb_strtoupper(trim($nama_sppg));
    return mb_substr($username, 0, 50);
}

/**
 * Generate unique SPPG username (append number if exists)
 */
function sppg_generate_unique_username(string $base_username): string {
    global $db;
    $username = $base_username;
    $counter = 1;
    $res = db_query("SELECT id FROM users WHERE username=?", "s", $username);
    while ($res && $res->num_rows > 0) {
        $username = $base_username . " " . $counter;
        $counter++;
        $res = db_query("SELECT id FROM users WHERE username=?", "s", $username);
    }
    return $username;
}
