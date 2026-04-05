<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_cashback")){ ?>
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_cashback_detail.php?cb=".$_GET["cb"]."&type=".$_GET["type"]); ?>
<? }else{echo "Access Denied";} ?>