<?php
function rate_limit(string $key, int $maxAttempts = 5, int $windowSec = 300): bool {
    $file = sys_get_temp_dir() . "/ratelimit_" . md5($key) . ".json";
    $now = time();
    $data = [];
    if (file_exists($file)) {
        $raw = json_decode(file_get_contents($file), true);
        if (is_array($raw)) {
            $data = array_filter($raw, fn($t) => ($now - $t) < $windowSec);
        }
    }
    if (count($data) >= $maxAttempts) return false;
    $data[] = $now;
    file_put_contents($file, json_encode(array_values($data)));
    return true;
}