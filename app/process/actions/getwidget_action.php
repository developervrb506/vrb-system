<?php 
include(ROOT_PATH . "/db/handler.php");

$name   = clean_str($_POST["name"]);
$email    = clean_str($_POST["email"]);
$phone     = clean_str($_POST["phone"]);

$content = "Someone requested a Widget:\n\n";
$content .= "Name: $name\n";
$content .= "Email: $email\n";
$content .= "Phone: $phone\n";

send_email_partners("support@inspin.com", 'Widget Requested', $content);

header("Location: ../../dashboard/get_widget.php?e=6");
?>