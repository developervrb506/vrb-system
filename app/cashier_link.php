<?php
declare(strict_types=1);

// Construye la URL con parámetros de forma segura
$base = 'https://cashier.vrbmarketing.com/index.php';
$params = [
    'customer'  => 2002,
    'account'   => 'AF1008',
    'password'  => '12345',
    'brand'     => 1,
    'is_affiliate' => 1,
    'is_cmmprt' => 1,
];

$url = $base . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);

// Evita cache y redirige
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Location: ' . $url, true, 302);
exit;
