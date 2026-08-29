<?php
function setup_error_handling(bool $isDev = false) {
    if ($isDev) {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', '0');
        error_reporting(E_ALL);
        ini_set('log_errors', '1');
        $logDir = dirname(__DIR__) . '/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }
        ini_set('error_log', $logDir . '/php_errors.log');
    }
    set_error_handler(function($severity, $message, $file, $line) {
        if (!(error_reporting() & $severity)) return false;
        error_log("PHP $severity: $message in $file:$line");
        return true;
    });
    set_exception_handler(function($e) {
        error_log("Uncaught exception: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
        if (ini_get('display_errors')) {
            echo "<pre>Uncaught exception: " . e($e->getMessage()) . "</pre>";
        } else {
            echo "Terjadi kesalahan server. Silakan coba lagi nanti.";
        }
    });
}
