<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?  if($current_clerk->im_allow("manual_sites_payments")) {

$date = $_POST["date"];
if($date == ""){
  $date = get_monday(date("Y-m-d"));	
} else {
  $date = get_monday($date);	
}
$site_id = 5; // 5 is the ID for the SGI site, from the BOOKS/Sites table.
$players = get_pre_player_by_brand('SGI');
$players_payments = get_manual_sites_payments($date,$site_id); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<title>SGI Manual Payments</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">SGI Manual Payments</span><br /><br />
<? include "includes/print_error.php" ?>

  <form method="post" id="frm_search">
	Date: <input name="date" type="text" id="date" value="<? echo $date ?>" readonly="readonly" size="10" /> &nbsp;&nbsp;
        <input name="" type="submit" value="Search" />
    </form>



<script>
document.getElementById("error_box").style.display = "none";
</script>
<BR><BR>
<div align="center" class="form_box" >
  <form method="post" action="./process/actions/add_manual_site_payment.php">
  
  <input  style="width:250px" type="submit" value="Submit"><BR><BR>
  <input type="hidden" name="total_players" value="<? echo count($players)?>">
  <input type="hidden" name="date" value="<? echo $date ?>">
  <input type="hidden" name="site" value="<? echo $site_id ?>">  
  <input type="hidden" name="type" value="SGI">    
  
<table width="600px" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center"><strong>ACCOUNT</strong></td>
    <td class="table_header" align="center"><strong>NAME</strong></td>
    <td class="table_header" align="center"><strong>PAYMENT</strong></td>
    
  </tr>

  <? foreach($players as $player){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $player["account"]; ?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $player["name"]." ".$player["last"]?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
   <? if(isset($players_payments[$site_id."_".$player["account"]."_".$date])){ ?><strong>PAID</strong> <?
   } else { ?>
   <input style="width:25px; height:25px" type="checkbox" value="<? echo $player["account"]; ?>" name="payment_<? echo $i ?>">
   <? } ?>
   </td>
    
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>
  <BR>
   <input style="width: 250px;" type="submit" value="Submit">

  </form>
</div>  

</div>
<? include "../includes/footer.php" ?>

<? }else{echo "access Denied";} ?>
