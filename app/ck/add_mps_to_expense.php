<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$mpp = get_office_expense($_GET["eid"]);
if(!is_null($mpp)){
	
$zipas = get_all_zip_address("state, country_short");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">

</script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">
Available Paks
</span><br /><br />
<div class="form_box">
Select the Paks you want to add to the Expense.<br /><br />
<form method="post" action="process/actions/add_mps_to_expense.php" target="_parent">
<input name="pid" type="hidden" id="pid" value="<? echo $mpp->vars["id"] ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sortable">
  <thead>
  <tr>
    <th class="table_header" align="center" style="cursor:pointer;">Id</th>
    <th class="table_header" align="center" style="cursor:pointer;">Player</th>
    <th class="table_header" align="center" style="cursor:pointer;">mps</th>
    <th class="table_header" align="center" style="cursor:pointer;">Amount</th>
    <th class="table_header" align="center" style="cursor:pointer;">mp#</th>
    <th class="table_header" align="center" style="cursor:pointer;">Zip</th>
    <th class="table_header" align="center" style="cursor:pointer;">State</th>
    <th class="table_header" align="center" style="cursor:pointer;">Date</th>
    <th class="table_header sorttable_nosort" align="center">Status</th>
    <th class="table_header sorttable_nosort" align="center">Select</th>
  </tr>
  </thead>
  <tbody>
  
  

<? 
$i=0; 
$deposits = get_available_mps_for_payouts("NoPl@yer","m");
foreach($deposits as $dep){
    if($i % 2){$style = "1";}else{$style = "2";}
	if($dep->vars["confirmed"]){$extra_stl = "_light_";}else{$extra_stl = "";}
    $payout_total += $dep->vars["amount"];
	$mp_send = count_accepted_moneypaks_by_player($dep->vars["player"]);
?>

   <tr>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $dep->vars["id"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $dep->vars["player"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $mp_send["num"] ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $dep->vars["amount"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
    	<? 
		if($current_clerk->im_allow("view_mp_numbers")){
			echo num_two_way($dep->vars["number"], true); 
		}else{
			echo $dep->vars["number"]; 
		}		
		?>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $dep->vars["zip"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
    	<? echo $zipas[$dep->vars["zip"]]->vars["state"] ?>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $dep->vars["tdate"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $dep->color_status(); ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
    	<input name="deposits[]" type="checkbox" value="<? echo $dep->vars["id"] ?>" />
    </td>
  </tr>

<? $i++;} ?>
  </tbody>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
  
</table>

<br />
        <div align="right"><input name="Enviar" type="submit" value="Add to Expense" /></div>
</form>
</div>


</body>
</html>
<? } ?>
<? }else{echo "Access Denied";} ?>