<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_lists")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../process/js/functions.js"></script>
<title>House Deposit Target</title>
</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	House Deposit Target
</span>
<br /><br />





	<script type="text/javascript">
	var validations = new Array();
	validations.push({id:"name",type:"null", msg:"Please insert a name"});
	validations.push({id:"method",type:"null", msg:"Please select a deposit method"});
	validations.push({id:"details",type:"null", msg:"Please insert the payment details"});
	validations.push({id:"mind_deps",type:"numeric", msg:"Please insert the minimum amount of deposits needed"});
	validations.push({id:"priority",type:"numeric", msg:"Please insert priority"});
	</script>


	<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/new_house_deposit.php?c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>


</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>