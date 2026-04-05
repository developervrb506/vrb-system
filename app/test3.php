<?php
/**
 * test.php — External Gateway quick tester (Alexis preset)
 * Uso (CLI):
 *   php test.php action=playerinfo
 *   php test.php action=playerinfo player="PLAYER 1"
 *   php test.php action=transinfo last=1
 *   php test.php action=wagerinfo last=1
 *
 * Uso (web):
 *   ?action=playerinfo
 *   ?action=playerinfo&player=PLAYER%201
 *   ?action=transinfo&last=1
 *   ?action=wagerinfo&last=1
 */

// ====== Config (preset) ======
$TOKEN = getenv('EXTGW_TOKEN') ?: 'xbEzOK-bphicheg';   // <— tu token
$DEFAULT_MASTER = 'CASABLANCA';                        // <— tu masterAgent

// Nota: según colección, playerinfo usa HTTPS; transinfo y wagerinfo HTTP.
// Ajusta a HTTPS si tu entorno ya está con TLS en todos.
$URLS = [
    'playerinfo' => 'https://external-gateway.gamemecanica.net/api/v1/ExternalGateway/playerinfo',
    'transinfo'  => 'http://external-gateway.gamemecanica.net/api/v1/ExternalGateway/transinfo',
    'wagerinfo'  => 'http://external-gateway.gamemecanica.net/api/v1/ExternalGateway/wagerinfo',
];

// ====== Helpers ======
function input_args(): array {
    $args = [];
    if (PHP_SAPI === 'cli' && isset($GLOBALS['argv'])) {
        foreach (array_slice($GLOBALS['argv'], 1) as $kv) {
            if (strpos($kv, '=') !== false) {
                [$k,$v] = explode('=', $kv, 2);
                $args[$k] = $v;
            }
        }
    }
    return array_merge($_GET, $args);
}

function pretty($data) {
    echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . PHP_EOL;
}

function api_post(string $url, string $token, array $payload, int $attempts = 3): array {
    $ch = curl_init($url);
    $body = json_encode($payload, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
    ];

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,          // para leer headers de rate limit
        CURLOPT_TIMEOUT => 60,
        // Para entornos de prueba con certificados/self-signed. Desactiva en producción.
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        $err = curl_error($ch);
        curl_close($ch);
        return ['ok' => false, 'status' => 0, 'error' => "cURL error: $err"];
    }

    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $rawHeaders = substr($response, 0, $headerSize);
    $rawBody    = substr($response, $headerSize);
    curl_close($ch);

    // Parse headers
    $hdrs = [];
    foreach (explode("\r\n", $rawHeaders) as $line) {
        if (strpos($line, ':') !== false) {
            [$k,$v] = explode(':', $line, 2);
            $hdrs[strtolower(trim($k))] = trim($v);
        }
    }

    // Rate limit handling: 429 => esperar y reintentar (1 req/2s recomendado)
    if ($status == 429 && $attempts > 1) {
        $reset = (int)($hdrs['x-ratelimit-reset'] ?? 2);
        $wait  = max($reset, 2);
        sleep($wait);
        return api_post($url, $token, $payload, $attempts - 1);
    }

    $decoded = json_decode($rawBody, true);
    if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
        return [
            'ok' => false,
            'status' => $status,
            'headers' => $hdrs,
            'raw' => $rawBody,
            'error' => 'JSON decode error: ' . json_last_error_msg(),
        ];
    }

    return [
        'ok' => $status >= 200 && $status < 300,
        'status' => $status,
        'headers' => $hdrs,
        'json' => $decoded,
    ];
}

function rate_pause(int $seconds = 2): void { sleep($seconds); }

// ====== Main ======
$args = input_args();
$action = strtolower($args['action'] ?? '');
$master = $args['masteragent'] ?? $DEFAULT_MASTER;
$player = $args['player'] ?? null;               // solo playerinfo (opcional)
$last   = isset($args['last']) ? (int)$args['last'] : 1; // trans/wager inicio

if (!$action || !isset($URLS[$action])) {
    echo "Acciones válidas: playerinfo | transinfo | wagerinfo\n";
    echo "Ejemplos CLI:\n";
    echo "  php test.php action=playerinfo\n";
    echo "  php test.php action=playerinfo player=\"PLAYER 1\"\n";
    echo "  php test.php action=transinfo  last=1\n";
    echo "  php test.php action=wagerinfo  last=1\n";
    exit(1);
}

switch ($action) {
    case 'playerinfo':
        $payload = ['masteragent' => $master];
        if (!empty($player)) $payload['player'] = $player;

        $res = api_post($URLS['playerinfo'], $TOKEN, $payload);
        pretty($res);
        break;

    case 'transinfo':
        $all = [];
        $currentLast = max(1, $last);
        while (true) {
            $payload = [
                'masteragent' => $master,
                'LastIdPlayerAccounting' => $currentLast,
            ];
            $res = api_post($URLS['transinfo'], $TOKEN, $payload);
            fwrite(STDERR, sprintf(
                "HTTP %d | Limit:%s Remaining:%s Reset:%s\n",
                $res['status'] ?? 0,
                $res['headers']['ratelimit-limit'] ?? '-',
                $res['headers']['x-ratelimit-remaining'] ?? '-',
                $res['headers']['x-ratelimit-reset'] ?? '-'
            ));
            if (!($res['ok'] ?? false)) { pretty($res); break; }

            $chunk = $res['json'] ?? [];
            if (!is_array($chunk) || count($chunk) === 0) break;

            $all = array_merge($all, $chunk);

            $maxId = $currentLast;
            foreach ($chunk as $row) {
                if (isset($row['idPlayerAccounting'])) {
                    $maxId = max($maxId, (int)$row['idPlayerAccounting']);
                }
            }
            if ($maxId <= $currentLast || count($chunk) < 1000) break;

            $currentLast = $maxId;
            rate_pause(2);
        }
        pretty(['ok' => true, 'count' => count($all), 'data' => $all]);
        break;

    case 'wagerinfo':
        $all = [];
        $currentLast = max(1, $last);
        while (true) {
            $payload = [
                'masteragent' => $master,
                'LastTicketNumber' => $currentLast,
            ];
            $res = api_post($URLS['wagerinfo'], $TOKEN, $payload);
            fwrite(STDERR, sprintf(
                "HTTP %d | Limit:%s Remaining:%s Reset:%s\n",
                $res['status'] ?? 0,
                $res['headers']['ratelimit-limit'] ?? '-',
                $res['headers']['x-ratelimit-remaining'] ?? '-',
                $res['headers']['x-ratelimit-reset'] ?? '-'
            ));
            if (!($res['ok'] ?? false)) { pretty($res); break; }

            $chunk = $res['json'] ?? [];
            if (!is_array($chunk) || count($chunk) === 0) break;

            $all = array_merge($all, $chunk);

            $maxTicket = $currentLast;
            foreach ($chunk as $row) {
                if (isset($row['ticketNumber'])) {
                    $maxTicket = max($maxTicket, (int)$row['ticketNumber']);
                }
            }
            if ($maxTicket <= $currentLast || count($chunk) < 1000) break;

            $currentLast = $maxTicket;
            rate_pause(2);
        }
        pretty(['ok' => true, 'count' => count($all), 'data' => $all]);
        break;
}
?>