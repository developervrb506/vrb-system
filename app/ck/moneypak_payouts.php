<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$from = post_get("from",date("Y-m-d"));
$to = post_get("to",date("Y-m-d"));
$status = post_get("status_list","all");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Paks Payouts</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
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
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Paks Payouts</span>
<br /><br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
Status: <? $current_status = $status; $all_option = true; include("includes/pt_transaction_status_list.php") ?>
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>

<? $trans = search_my_moneypak_payouts($from, $to, $status); ?>
<br />
<? include "includes/print_error.php" ?>


<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="changer"></iframe>
<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="updater"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <?
   
   $total = 0;
   $total_fees = 0;
   foreach($trans as $tran){
       $i++;
	   $reserved_player = get_mp_reserved_player($tran->vars["id"]);
	   if(is_null($reserved_player)){$total += $tran->vars["amount"]; $total_fees += $tran->vars["fees"]; }
  ?>  
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Method</td>
    <td class="table_header" align="center">Player</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Fees</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Destination</td>
    <td class="table_header" align="center" title="Comments">Com.</td>
  </tr>
  <tr>
    <td class="table_td2" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td2" align="center"><? echo $tran->str_method(); ?></td>
    <td class="table_td2" align="center"><? echo $tran->vars["player"]; ?></td>
    <td class="table_td2" align="center"><? echo $tran->vars["amount"]; ?></td>
    <td class="table_td2" align="center"><? echo $tran->vars["fees"]; ?></td>
    <td class="table_td2" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td2" align="center"><? echo $tran->color_status(); ?></td>
    <td class="table_td2" align="center"><? echo $tran->get_destination(); ?></td>
        <td class="table_td2" align="center"><? echo nl2br($tran->vars["comments"]); ?></td>
  </tr>
  <tr>
    <td class="table_td_message" align="center" colspan="100">
    
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="table_header" align="center">Id</td>
            <td class="table_header" align="center">Player</td>
            <td class="table_header" align="center">Amount</td>
            <td class="table_header" align="center">Fees</td>
            <td class="table_header" align="center">mp#</td>
            <td class="table_header" align="center">Date</td>
            <td class="table_header" align="center">Status</td>
            <td class="table_header" align="center" title="Comments">Com.</td>
          </tr>
          
          
        
		<? 
		$i=0; 
        $dep_ids = explode(",",$tran->vars["deposit"]);
        $ids = "";
        foreach($dep_ids as $did){
            $ids .= ",'".trim($did)."'";
        }
        $deposits = get_moneypaks_by_group_ids(substr($ids,1));
        foreach($deposits as $dep){
			if($i % 2){$style = "1";}else{$style = "2";}
        ?>
        
           <tr>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["id"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["player"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["amount"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["fees"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center">
            	<? 
				if($current_clerk->im_allow("view_mp_numbers")){
					echo num_two_way($dep->vars["number"], true); 
				}else{
					echo $dep->vars["number"]; 
				}		
				?>
            </td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["tdate"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->color_status(); ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($dep->vars["comments"]); ?></td>
          </tr>
        
        <? $i++;} ?>
        
          <tr><td class="table_last" colspan="100"></td></tr>
        
        </table>
    
    </td>
  </tr>
  <tr>
    <td height="50" align="center" colspan="100"></td>
  </tr>
  
  <? } ?>
   <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">TOTAL:</td>
    <td class="table_header" align="center"><? echo $total ?></td>
    <td class="table_header" align="center"><? echo $total_fees ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td align="center" class="table_header"></td>
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>