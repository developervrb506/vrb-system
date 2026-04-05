<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_insert_dgs")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<strong>DGS Deposit</strong>
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"methods_list",type:"null", msg:"Please Select the Payment Method"});
validations.push({id:"fees",type:"numeric", msg:"Please insert the Fees"});
function mark_free(def){
	box = document.getElementById("fees");
	cb = document.getElementById("free");
	if(!cb.checked){
		box.disabled = false;
		box.value = def;
	}else{
		box.disabled = true;
		box.value = "0";
	}
}
</script>

<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/DGS_payout.php?c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>


<? }else{echo "Access Denied";} ?>