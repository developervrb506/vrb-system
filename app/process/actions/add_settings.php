<?php
include(ROOT_PATH . "/ck/db/handler.php");


// Recibir JSON
$input = json_decode(file_get_contents("php://input"), true);
$ip     = trim($input['ip'] ?? '');
$secret = trim($input['secret'] ?? '');



// Validar datos recibidos
if (empty($ip) || empty($secret)) {
    http_response_code(400);
    echo "Missing data";
    exit;
}

// Frase secreta (original)
$expected_secret = hash('sha256', 'vrbip');

// Comparar el hash
if ($secret === $expected_secret) {
    $checkip = get_settings_ip($ip);

if(empty($checkip)){
  $new =  get_settings_ip(',');
  $new['ips_allowed']->vars['value'] = $new['ips_allowed']->vars['value'].",".$ip;
  $new['ips_allowed']->update(array("value"));
  echo "You're good to go!";
} else{
  echo "This IP already exist on the system, Please check Credentials or User Blocked";		
}
   
} else {
    http_response_code(403);
    echo "Access denied";
}





?>