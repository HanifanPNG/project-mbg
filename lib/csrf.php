<?php
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}
function csrf_verify(): bool {
    if (!isset($_POST['csrf_token'])) return false;
    $stored = $_SESSION['csrf_token'] ?? '';
    return hash_equals($stored, $_POST['csrf_token']);
}
function csrf_regenerate(): void {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
