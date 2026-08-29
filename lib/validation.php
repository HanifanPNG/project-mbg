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
