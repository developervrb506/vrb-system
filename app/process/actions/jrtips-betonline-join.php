<? include(ROOT_PATH . "/process/functions.php"); ?>
<?
$content = "A customer has clicked thru the join button on your custom BetOnline mailer.";
send_email_partners("betonlineagent@gmail.com", "Potential new customer sign up for bet online", $content, true);
send_email_partners("alex@vrbmarketing.com", "Potential new customer sign up for bet online", $content, true);
header("Location: http://partners.commission.bz/processing/clickthrgh.asp?btag=a_2651b_868");
?>

