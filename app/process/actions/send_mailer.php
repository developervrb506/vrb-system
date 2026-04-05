<?php 
include(ROOT_PATH . "/db/handler.php");

$email   = clean_str($_POST["email"]);
$camp_id    = clean_str($_POST["campaigne_id"]);
$camp_name     = clean_str($_POST["campaigne_name"]);
$mail_id     = clean_str($_POST["mail_id"]);
$code     = $_POST["code_".$mail_id];
$code = str_replace('\"','"',$code);
send_email_partners($email, ucwords($camp_name).' Mailer', $code, true);
header("Location: ../../dashboard/mailer.php?cid=$camp_id&e=7");
?>