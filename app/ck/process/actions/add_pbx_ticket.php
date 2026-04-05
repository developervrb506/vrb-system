<?
require_once(ROOT_PATH . "/ck/db/handler.php");

$data = $_POST["stdin"];

$parts = explode("X-Asterisk-CallerID: ",$data);
$parts2 = explode("X-Asterisk-CallerIDName",$parts[1]);
$parts2 = explode("MIME-Version",$parts2[0]);
$phone = $parts2[0];

$parts = explode("From:",$data);
$date = str_replace("Date: ","",$parts[0]);

$message = "You have received a new voicemail from $phone on $date.<br />To check the voicemail dial *99#2297#1234# on your phone and follow the instructions.";


$ticket = new _ticket();	
$ticket->vars["name"]     = "Phone Call";
$ticket->vars["email"]    = "none@none.com";
$ticket->vars["player_account"] = "N/A";
$ticket->vars["website"]  = "VRB";
$ticket->vars["subject"]  = "New Voicemail";
$ticket->vars["message"]  = $message;
$ticket->vars["category"] = "agents";
$ticket->vars["tdate"]    = date("Y-m-d H:i:s");
$ticket->vars["dep_id_live_chat"] = 12;
$ticket->vars["trans_id"] = "";
$ticket->insert();


?>