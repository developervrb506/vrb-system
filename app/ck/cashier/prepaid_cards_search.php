<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_balance")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Prepaid Cards Search</title>
</head>
<body>
<?php header('Access-Control-Allow-Origin: *'); ?>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<?

 if($current_clerk->vars['id'] != 86 ){
	$subject = 'SEARCH PREPAID';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
	}

$field = $_POST["field"];
$value = $_POST["value"];
?>
<span class="page_title">Prepaid Cards Search</span>
<BR>
<BR>

<form action="" method="post">
<strong>Field: </strong>
<select name="field">
<option <? if ($field == 1){ echo '  selected="selected"'; }  ?> value="1">Card #</option>
<option <? if ($field == 2){ echo '  selected="selected"'; }  ?> value="2">Exp</option>
<option <? if ($field == 3){ echo '  selected="selected"'; }  ?> value="3">Cvv</option>
<option <? if ($field == 4){ echo '  selected="selected"'; }  ?> value="4">Account</option>
<option <? if ($field == 5){ echo '  selected="selected"'; }  ?> value="5">Id Trans</option>
</select>
&nbsp;&nbsp;&nbsp;<strong>Value: </strong>
<input type="text" name="value" value="<? echo $value ?>" size="45px" />
 &nbsp;&nbsp;<input type="submit" value="SEARCH">
</form>
</hr>

<? if(isset($_POST["value"])){ ?>
<br />


<?  echo file_get_contents("http://cashier.vrbmarketing.com/admin/prepaid_cards_search.php?field=".$field."&value=".$value."&c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>


<? } ?>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>