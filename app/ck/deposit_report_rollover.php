<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("last_deposit_report")){ ?>

	<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_rollover.php?".$_SERVER['QUERY_STRING']); ?>

<? }else{echo "Access Denied";} ?>