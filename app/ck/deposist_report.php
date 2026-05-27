<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<?
if(isset($_POST["save"])){
	$names = search_signups_names(clean_get("account"));
	foreach($names as $name){
		if($_POST["amount_".$name->vars["id"]] != "" && $_POST["amount_".$name->vars["id"]] != "0"){
			$name->vars["deposit_amount"] = $_POST["amount_".$name->vars["id"]];
			$name->vars["deposit_date"] = $_POST["date_".$name->vars["id"]];
			$name->vars["payment_method"] = $_POST["payment_method_list_".$name->vars["id"]];
			$name->vars["available"] = "0";
			$name->update(array("deposit_amount","payment_method","available","deposit_date"));
			
			$method = get_payment_method($name->vars["payment_method"]);
			$comision = round($name->vars["clerk"]->calculate_comision($name->vars["deposit_amount"],$method),2);
			
			$clerks = array();
			$clerks[0] = $name->vars["clerk"];
			$lead_transfer = get_lead_transfer($name->vars["id"]);
			$fronter = $lead_transfer->vars["clerk"];
			//if need to add more clerks to commision just add it to $clerks[] Array
			if(!is_null($fronter)){$clerks[] = $fronter;}
			
			$clerks_number = count($clerks);
			$splited_comision = $comision / $clerks_number;
			
			if($clerks_number>1){$comment = "Splitted in $clerks_number Clerks";}
			
			foreach($clerks as $clerk){
				$transaction = get_transaction_by_clerk_and_name($clerk->vars["id"],$name->vars["id"]);
				if(is_null($transaction)){$name->insert_transaction($splited_comision,$method,$comment,$clerk);}
				else{
					$transaction->vars["amount"] = $splited_comision;
					$transaction->vars["current_percentage"] = $method["percentage"];
					$transaction->vars["current_cap"] = $method["cap"];
					$transaction->vars["transaction_date"] = date("Y-m-d H:i:s");
					$transaction->vars["comment"] = $comment;
					$transaction->update(array("amount","transaction_date","current_percentage","current_cap"));
				}
			}
			
		}
	}
}

$dates_ids = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Deposits</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Deposits</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$account = clean_get("account");
?>

<form method="post" action="deposist_report.php">
    Account: 
    <input name="account" type="text" id="account" value="<? echo $account ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />

<form method="post" action="deposist_report.php?e=28">
<input name="save" type="hidden" id="save" value="1" />
<input name="account" type="hidden" id="account" value="<? echo $account ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Account</td>
    <td class="table_header">Affiliate</td>
    <td class="table_header">Name</td>
    <td class="table_header">Clerk</td>
    <td class="table_header">Calls</td>
    <td class="table_header">View</td>
    <td class="table_header">Amount</td>
    <td class="table_header">Date</td>
    <td class="table_header">Method</td>
  </tr>

<?
if($account == ""){$account = "n/a";}
$names = search_signups_names($account);
$i=0;
foreach($names as $name){
	  if($i % 2){$style = "1";}else{$style = "2";}
	  $i++;
	  ?>
	  <tr>
		  <td class="table_td<? echo $style ?>"><? echo $name->vars["acc_number"]; ?></td>
		  <td class="table_td<? echo $style ?>"><? echo $name->vars["aff_id"]; ?></td>
		  <td class="table_td<? echo $style ?>"><? echo $name->full_name(); ?></td>
		  <td class="table_td<? echo $style ?>"><? echo $name->vars["clerk"]->vars["name"]; ?></td>
          <td class="table_td<? echo $style ?>">
          	<a href="call_history.php?nid=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $name->full_name() ?> Call History" class="normal_link">
            Calls
            </a>
          </td>
          <td class="table_td<? echo $style ?>">
       	  	<a href="edit_name.php?nid=<? echo $name->vars["id"] ?>" target="_blank" class="normal_link">View</a>
          </td>
		  <td class="table_td<? echo $style ?>">
			  $<input name="amount_<? echo $name->vars["id"]; ?>" type="text" id="amount_<? echo $name->vars["id"]; ?>" size="5" value="<? echo $name->vars["deposit_amount"]; ?>" />
		  </td>
		  <td class="table_td<? echo $style ?>">
			  <? $dates_ids[] = "date_".$name->vars["id"]; ?>
			  <input name="date_<? echo $name->vars["id"]; ?>" type="text" id="date_<? echo $name->vars["id"]; ?>" size="7" value="<? echo null_date($name->vars["deposit_date"]); ?>" />
		  </td>
		  <td class="table_td<? echo $style ?>">
		  		<?
				 $s_method = $name->vars["payment_method"];
				 $extra_id_mth = "_".$name->vars["id"];
				 include "includes/payment_method_list.php" 
				 ?>
          </td>
		  
	  </tr>	
	  <?
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>
<div align="right"><input name="" type="submit" value="Submit" /></div>
</form>
<script type="text/javascript">
	window.onload = function(){
		<? foreach($dates_ids as $did){ ?>
		new JsDatePick({
			useMode:2,
			target:"<? echo $did ?>",
			dateFormat:"%Y-%m-%d"
		});
		<? } ?>
	};
</script>
</div>
<? include "../includes/footer.php" ?>