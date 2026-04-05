<? $no_log_page = true; $no_change_pass = true; ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>


<head>
	<meta http-equiv="refresh" content="30;URL=popup_maker.php?xs<? echo mt_rand(); ?>">
</head>
<?
$alert = false;

if(_can_attend_signups($current_clerk->vars["id"])){
	if(count(new_signup_alerts_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("bitbet_deposits")){
	$pbj_wll = @file_get_contents("http://www.playblackjack.com/utilities/ui/city/bitcoin/check.php");
	$orig_wll = @file_get_contents("http://jobs.inspin.com/btc_wll.php");
	if($pbj_wll != $orig_wll){
		$alert = true;
	}	
}

if($current_clerk->im_allow("cc_denied_alerts")){
	if(count(cc_denied_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("mp_payouts_alert")){
	if(count(mp_payouts_alerts($current_clerk->vars["id"]))>0){$alert = true;}
	if(count(other_payouts_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("mp_sell_alert")){
	if(count(mp_sell_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("tweet_alert")){
	if(count(tweets_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("denied_alerts")){
	if(count(denied_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("help_calls_alerts")){
	if(count(get_pending_help_calls_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("affiliate_payout_alert")){
	if(count(affiliate_payouts_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}

if($current_clerk->im_allow("baseball_alerts")){
	if(count(get_pending_baseball_alerts($current_clerk->vars["id"]))>0){$alert = true;}
}
?>

<? if($alert){ ?>
<SCRIPT LANGUAGE="JavaScript">
	msg=window.open("http://localhost:8080/ck/process/actions/alert_window.php","msg","height=300,width=400,left=80,top=80, scrollbars=yes");
</script>
<? } ?>