<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("denied_resolutions")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?></title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Denied Transactions Resolutions</span><br /><br />

<?
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
$names = get_denied_resolutions($from,$to);
$i=0;
?>

<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>
<br /><br />

<? include "includes/print_error.php" ?>
	
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header">Player</td>
        <td class="table_header">Transaction</td>
        <td class="table_header">Date</td>
        <td class="table_header">Resolution</td>
      </tr>
      <? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
      <tr>
        <td class="table_td<? echo $style ?>"><? echo $name->vars["acc_number"]; ?></td>  
        <td class="table_td<? echo $style ?>"><? echo $name->vars["message_to_clerk"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $name->vars["added_date"]; ?></td>  
        <td class="table_td<? echo $style ?>"><? echo nl2br($name->vars["note"]); ?></td>      
      </tr>
      <? } ?>
      <tr>
        <td class="table_last" colspan="1000"></td>
      </tr>
    </table>


</div>
<? include "../includes/footer.php" ?>
<? } ?>