<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$name = $_GET["fn"] . " " . $_GET["ln"];
$email = $_GET["em"];
$phone = $_GET["ph"];

$content = "Name: $name<br /><br />Email: $email<br /><br />Phone: $phone";

insert_book_signup($name, $email, $phone, 3);

send_email_partners("support@inspin.com", "New Horizon Sign Up", $content, true);
send_email_partners("support@vrbmarketing.com", "New Horizon Sign Up", $content, true);
//send_email_partners("rarce@inspin.com", "New Horizon Sign Up", $content, true);

?>