<?php

ob_start();

define('ROOT_PATH', __DIR__);

/*
PHP → BASE_URL .
HTML → <?= BASE_URL ?>
CSS → /
*/

// Detecta protocolo (http / https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Base URL dinámica
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST']);