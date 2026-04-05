<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>List Calls</title>
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
<span class="page_title">List Calls</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$from = $_POST["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_POST["to"];
if($to == ""){$to = date("Y-m-d");}
$lists = count_calls_by_list($from, $to);
?>

<form action="list_calls.php" method="post">
From:
<input name="from" type="text" id="from" value="<? echo $from ?>" />
&nbsp;&nbsp;&nbsp;
to:
<input name="to" type="text" id="to" value="<? echo $to ?>" />
&nbsp;&nbsp;&nbsp;

<input name="" type="submit" value="Search" />
</form>
<br />
List name in red when list is disable.
<br /><br />
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header">List</td>
    <td class="table_header" align="center"># of Calls</td>
  </tr>
  
  <? foreach($lists as $list){if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;	  
  ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" <? if(!$list["available"]){ ?>style="color:#F00;"<? } ?>>
		<? echo $list["name"]; ?>
    </td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $list["calls_num"]; ?></td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>
<br /><br />

</div>

<? include "../includes/footer.php" ;

?>