<?
include(ROOT_PATH . "/ck/process/functions.php");

$ip_chat_agents = ".127..86..130..70..60..162..130..70.";
$account = asp_encryption($ip_chat_agents);
//$account = two_way_enc($account);

echo $account;

?>