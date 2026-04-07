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

if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
	$_SERVER['HTTPS'] = 'on';
}

// Base URL dinámica
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST']);