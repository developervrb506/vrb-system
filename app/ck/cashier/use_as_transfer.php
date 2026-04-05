<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<p><strong>Use deposit as Transfer</strong></p>
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript" src="http://localhost:8080/ck/balances/api/functions.js"></script>

<?
$amount = $_GET["amount"];
$tid = ($_GET["home"] - 987566335);
?>

<form method="post" action="../process/actions/insert_intersystem_action.php" target="_parent" id="frm_<? echo $tid ?>" >
    <input name="autoinsert" type="hidden" id="autoinsert" value="1" />
    <input name="system_list_from" type="hidden" id="system_list_from" value="4" />
    <input name="from_account" type="hidden" id="from_account" value="130" />
    <input name="amount" type="hidden" id="amount" value="<? echo $amount; ?>" />
  	<input name="cash_arch" type="hidden" id="cash_arch" value="<? echo $tid ?>" />
    <input name="burl" type="hidden" id="burl" value="" />
  	<script type="text/javascript">
	document.getElementById("burl").value = parent.location.href;
	</script>
    To:<br />
    <?
    $select_option = true;
    $extra_name = "_to";
    $system_change = "load_system_accounts('to_div_".$tid."', this.value, 'to_account', 0);";
    $system_change .= "if(this.value != ''){document.getElementById('btn_".$tid."').style.display = 'block';}else{document.getElementById('btn_".$tid."').style.display = 'none';}";
    include("../includes/systems_list.php");
    ?>
    <br /><div id="to_div_<? echo $tid ?>"><input type="hidden" value="" name="to_account" id="to_account" /></div>
    <br />
    Note:<br />
    <textarea name="note" cols="" rows="" id="note"></textarea>
    <input name="hidden_note" type="hidden" id="hidden_note" value="Moneypak Id:<? echo $tid ?>" />
    <input name="Enviar" type="submit" id="btn_<? echo $tid ?>" style="display:none;" value="Submit"  />
</form>

<? }else{echo "Access Denied";} ?>