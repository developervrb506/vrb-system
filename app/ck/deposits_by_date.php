<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Deposits Report</title>
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
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Deposits Report</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
?>

<form method="post" action="deposits_by_date.php">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />

<?
$total = 0;
$methods = get_payment_methods();
foreach($methods as $met){
	$i=0;
	echo "<strong>".$met["name"]."</strong><br />";
	$names = search_deposits_names($from, $to, $met["id"]);
	$subtotal = 0;
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header">Account</td>
        <td class="table_header">Affiliate</td>
        <td class="table_header">Name</td>
        <td class="table_header">Clerk</td>
        <td class="table_header">Amount</td>
        <td class="table_header">Date</td>
      </tr>
      <?
		foreach($names as $name){
			  if($i % 2){$style = "1";}else{$style = "2";}$i++;
			  $subtotal += $name->vars["deposit_amount"];
			  ?>
			  <tr>
				  <td class="table_td<? echo $style ?>"><? echo $name->vars["acc_number"]; ?></td>
				  <td class="table_td<? echo $style ?>"><? echo $name->vars["aff_id"]; ?></td>
				  <td class="table_td<? echo $style ?>"><? echo $name->full_name(); ?></td>
				  <td class="table_td<? echo $style ?>"><? echo $name->vars["clerk"]->vars["name"]; ?></td>
				  <td class="table_td<? echo $style ?>">$<? echo $name->vars["deposit_amount"]; ?></td>
				  <td class="table_td<? echo $style ?>"><? echo date("M jS, Y",strtotime($name->vars["deposit_date"])); ?></td>	  
			  </tr>	
			  <?
		}
		if($i % 2){$style = "1";}else{$style = "2";}
		?>
        	<tr>
                <td class="table_td<? echo $style ?>"><strong><? echo $met["name"] ?> Total</strong></td>
                <td class="table_td<? echo $style ?>"></td>
                <td class="table_td<? echo $style ?>"></td>
                <td class="table_td<? echo $style ?>"></td>
                <td class="table_td<? echo $style ?>"><strong>$<? echo $subtotal; ?></strong></td>
                <td class="table_td<? echo $style ?>"></td>	  
            </tr>	
			<tr>
			  <td class="table_last"></td>
			  <td class="table_last"></td>
			  <td class="table_last"></td>
			  <td class="table_last"></td>
			  <td class="table_last"></td>
			  <td class="table_last"></td>
			</tr>
		
		</table>
        <br /><br />
    <?
	$total += $subtotal;
}
?>
<table width="200" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="table_header">Total:</td>
      <td class="table_header">$<? echo $total ?></td>
    </tr>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>
</table>

</div>
<? include "../includes/footer.php" ?>