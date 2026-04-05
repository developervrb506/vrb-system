<?php
ob_start();
// ROOT real del proyecto dentro del contenedor
define('ROOT_PATH', __DIR__);

// Debug (opcional)
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);