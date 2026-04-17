<?php
// Prevent config.php's HTML injection and HTTPS redirect from interfering
// with this pure-JSON API endpoint.
ob_end_clean();

header('Content-Type: application/json');

// ── helpers ────────────────────────────────────────────────────────────────

function json_out(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function validate_api_key(): void
{
    //$expected = getenv('CREDENTIALS_API_KEY');
    $expected = 'bitbet2026';
    if (empty($expected)) {
        // Fallback: read from a local config file outside the web root is ideal,
        // but since this legacy stack has no shared secrets directory we use a
        // compile-time default that MUST be overridden via the environment variable
        // before deploying to production.
        $expected = 'change-me-in-docker-compose';
    }

    $provided = $_SERVER['HTTP_X_API_KEY'] ?? '';
    if (!hash_equals($expected, $provided)) {
        json_out(['success' => false, 'reason' => 'unauthorized'], 401);
    }
}

function call_bitbet(string $username, string $password): array
{
    $url    = 'https://wager.bitbet.com/cloud/api/System/authenticateCustomer';
    $domain = 'wager.bitbet.com';

    // The JS client uppercases both fields before sending
    $payload = http_build_query([
        'customerID'    => strtoupper($username),
        'password'      => strtoupper($password),
        'state'         => 'true',
        'multiaccount'  => '1',
        'response_type' => 'code',
        'client_id'     => strtoupper($username),
        'domain'        => $domain,
        'redirect_uri'  => $domain,
        'operation'     => 'authenticateCustomer',
        'token'         => '',
    ]);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; VRB-Validator/1.0)',
        CURLOPT_HTTPHEADER     => [
            'Accept: application/json',
            'Authorization: Bearer ',
        ],
    ]);

    $body     = curl_exec($ch);
    $errno    = curl_errno($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($errno || $body === false) {
        return ['ok' => false, 'reason' => 'connection_error'];
    }

    if ($httpCode !== 200) {
        return ['ok' => false, 'reason' => 'connection_error'];
    }

    return ['ok' => true, 'body' => $body];
}

function parse_login_result(string $body): bool
{
    $json = json_decode($body, true);

    if (!is_array($json)) {
        return false;
    }

    // API returns accountInfo on success
    return !empty($json['accountInfo']);
}

// ── request guards ─────────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_out(['success' => false, 'reason' => 'method_not_allowed'], 405);
}

validate_api_key();

// ── parse body ─────────────────────────────────────────────────────────────

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data) || empty($data['username']) || empty($data['password'])) {
    json_out(['success' => false, 'reason' => 'missing_credentials'], 400);
}

$username = trim((string) $data['username']);
$password = (string) $data['password'];

if ($username === '' || $password === '') {
    json_out(['success' => false, 'reason' => 'missing_credentials'], 400);
}

// ── validate ───────────────────────────────────────────────────────────────

$result = call_bitbet($username, $password);

if (!$result['ok']) {
    json_out(['success' => false, 'reason' => $result['reason']]);
}

$success = parse_login_result($result['body']);

if ($success) {
    json_out(['success' => true]);
} else {
    json_out(['success' => false, 'reason' => 'invalid_credentials']);
}
