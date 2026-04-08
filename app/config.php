<?php

ob_start();

define('ROOT_PATH', __DIR__);

/*
REGLAS:
PHP → BASE_URL .
HTML → <?= BASE_URL ?>
CSS → /
*/

// ===============================
// DETECTAR HTTPS CORRECTAMENTE
// ===============================
$is_https = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
);

// ===============================
// FORZAR HTTPS (SOLO PRODUCCIÓN)
// ===============================
if (
    !$is_https &&
    isset($_SERVER['HTTP_HOST']) &&
    $_SERVER['HTTP_HOST'] !== 'localhost:8080'
) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

// ===============================
// BASE URL DINÁMICA
// ===============================
$protocol = $is_https ? "https://" : "http://";

define('BASE_URL', $protocol . $_SERVER['HTTP_HOST']);

// ===============================
// DEBUG (opcional)
// ===============================
// ini_set('display_errors', 1);
// error_reporting(E_ALL);