<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Livebetting Count</title>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
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
<?
$from = $_POST["from"];
$to = $_POST["to"];
$type = $_POST["type"];
$sender = $_POST["sender"];
if($from == ""){$from = date("Y-m-d");}
if($to == ""){$to = date("Y-m-d");}
?>
<div class="page_content" style="padding-left:10px;">
    <span class="page_title">Player Count</span><br /><br />
    <form method="post">
    From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;
    To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;
    Type:
    
    <select name="type" id="type">
    	<option value="liveplus">Live+</option>
        <option value="propsplus" <? if($type == "propsplus"){ ?>selected="selected" <? } ?>>Props+</option> 
    </select>
    
    <input type="hidden" name="sender" value="1" />
    
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
    </form>
    <br /><br />
    
    <?

     if($sender){ echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/agent_livebetting.php?from=$from&to=$to&type=$type"); } ?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>