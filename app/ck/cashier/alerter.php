<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<?

$types = "";
if($current_clerk->im_allow("process_deposit_alert")){
	$types .= "unprocessed_deposit";
}
if($current_clerk->im_allow("approved_deposit_alert")){
	$types .= ",approved_deposit";
}
if($current_clerk->im_allow("denied_deposit_alert")){
	$types .= ",denied_deposit";
}

?>


<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/vrb_alerts.php?c=2002&p=PRXniq92iewoie2112ias&dog=".$types); ?>