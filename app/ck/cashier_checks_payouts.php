<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Cashier Checks Payouts</title>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
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

<span class="page_title">Cashier Checks Payouts</span>
<br /><br />
<? 
$trans = array_reverse(get_waiting_mp_checks_payouts()); 
$player_list = array();

$str_ids = "";
foreach($trans as $tr){
	$player_list[] = $tr->vars["player"];
	$str_ids .= ",'MP".$tr->vars["id"]."'";
}
$str_ids = substr($str_ids, 1);
$dgs_insertions = get_dgs_insertions_by_list($str_ids);
$inserted_ids = array();
foreach($dgs_insertions as $dgsi){
	$inserted_ids[] = str_replace("MP","",$dgsi["ezpay_id"]);
}

$nets = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_net_winloss.php?accs=".implode(",",$player_list)));

?>
<br />
<? include "includes/print_error.php" ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <?
   
   $total = 0;
   $total_fees = 0;
   foreach($trans as $ctran){
	   $tran = get_related_mp_for_check($ctran->vars["id"]);
	   if(!is_null($tran)){
	   if(!in_array($tran->vars["id"],$inserted_ids)){$inserted = false;}else{$inserted = true;}
       $i++;
	   $reserved_player = get_mp_reserved_player($tran->vars["id"]);
	   if(is_null($reserved_player)){$total += $tran->vars["amount"]; $total_fees += $tran->vars["fees"]; }
	   $prev_sum = get_total_mp_amounts($tran->vars["player"], date("Y-m-d",strtotime(date("Y-m-d")." - 7 days")), date("Y-m-d"));
	   if($prev_sum["total"] >= 1000){$extra_stl = "_red";}else{$extra_stl = "";}
  ?>  
  <? if($inserted){ ?>
  <tr>
    <td class="table_header error" colspan="100"><strong>This transaction was already inserted in DGS but is not marked. Please Contact Rob to fix it.</strong></td>
  </tr>
  <? } ?>
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Player</td>
    <td class="table_header" align="center">Requested Amount</td>
    <td class="table_header" align="center">Fees</td>
    <td class="table_header" align="center">Requested Date</td>
    <td class="table_header">Info</td>
    <td class="table_header" align="center" title="Comments">Com.</td>
    <td class="table_header" align="center" title="Comments"></td>
  </tr>
  <tr>
    <td class="table_td2<? echo $extra_stl; ?>" align="center">
    	<? if($tran->vars["confirmed"]){ ?>
			<?
            $data["tid"] = "MP" . $tran->vars["id"];
            $data["account"] = $tran->vars["player"];
            $data["method"] = "mp";
            $data["amount"] = $tran->vars["amount"];
            $data["fees"] = $tran->vars["fees"];
            $key = two_way_enc(implode("_*_",$data));
			if(contains_ck(strtoupper($tran->vars["player"]),"AF")){
				$url = "dgs_payout_affiliate.php";
			}else{
				$url = "dgs_payout.php";
			}
            ?>
            <a href="<?= BASE_URL ?>/ck/<? echo $url ?>?mts=<? echo $key ?>&free=<? if(contains_ck($tran->vars["aps_comment"],"(--FREE--)")){echo "1";}else{echo "0";}  ?>" class="normal_link" rel="shadowbox;height=370;width=600">
            <img id="umki_<? echo "MP" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/important_vrb.png" width="20" height="20" alt="/" title="Insert Payout">
            </a>
            <img id="mki_<? echo "MP" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/complete_vrb.png" width="20" height="20" alt="/" title="Paid" style="display:none;">
        <? } ?>
    </td>
    <td class="table_td2<? echo $extra_stl; ?>" align="center"><? echo $ctran->vars["id"]; ?></td>
    <td class="table_td2<? echo $extra_stl; ?>" align="center"><? echo $ctran->vars["player"]; ?></td>
    <td class="table_td2<? echo $extra_stl; ?>" align="center"><? echo $ctran->vars["amount"]; ?></td>
    <td class="table_td2<? echo $extra_stl; ?>" align="center"><? echo $ctran->vars["fees"]; ?></td>
    <td class="table_td2<? echo $extra_stl; ?>" align="center"><? echo $ctran->vars["tdate"]; ?></td>
    <td class="table_td2<? echo $extra_stl; ?>">
    	<strong>First Name:</strong> <? echo $ctran->vars["name"] ?><br />        
        <strong>Street:</strong> <? echo $ctran->vars["street"] ?><br />
        <strong>City:</strong> <? echo $ctran->vars["city"] ?><br />
        <strong>State:</strong> <? echo $ctran->vars["state"] ?><br />
        <strong>Zip:</strong> <? echo $ctran->vars["zip"] ?>
    </td>
    <td class="table_td2<? echo $extra_stl; ?>" align="center"><? echo nl2br($ctran->vars["comments"]); ?></td>
    <td class="table_td2<? echo $extra_stl; ?>" align="center">
    	<? if(!$inserted){ ?>
    	 <form method="post" action="process/actions/deny_cashier_checks.php" onsubmit="return confirm('Are you sure you want to Deny this Payout?')">
        <input name="id" type="hidden" value="<? echo $ctran->vars["id"]; ?>" />
        <textarea name="bmsg" cols="10"></textarea><br />
        <input name="Enviar" type="submit" value="Deny"  />
        </form>
        <? } ?>
    </td>
  </tr>
  <tr>
    <td class="table_td_message" align="center" colspan="100">
    
    	<br /><strong>Deposits reserved for this payout:</strong>
        
        &nbsp;&nbsp;&nbsp;
        <? if(!$inserted){ ?>
        <a href="add_mps_to_payouts.php?mpid=<? echo $tran->vars["id"]; ?>" class="normal_link" rel="shadowbox;height=600;width=850">+ Add Deposits</a>
        <? } ?>
        
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="table_header" align="center">Id</td>
            <td class="table_header" align="center">Player</td>
            <td class="table_header" align="center">Amount</td>
            <td class="table_header" align="center">mp#</td>
            <td class="table_header" align="center">Zip</td>
            <td class="table_header" align="center">Date</td>
            <td class="table_header" align="center">Status</td>
            <td class="table_header" align="center"></td>
          </tr>
          
          
        
		<? 
		$i=0; 
        $dep_ids = explode(",",$tran->vars["deposit"]);
        $ids = "";
		$payout_total = 0;
        foreach($dep_ids as $did){
            $ids .= ",'".trim($did)."'";
        }
        $deposits = get_moneypaks_by_group_ids(substr($ids,1));
        foreach($deposits as $dep){
			if($i % 2){$style = "1";}else{$style = "2";}
			$payout_total += $dep->vars["amount"];
        ?>
        
           <tr>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["id"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["player"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["amount"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center">
            	<? 
				if($current_clerk->im_allow("view_mp_numbers")){
					echo num_two_way($dep->vars["number"], true); 
				}else{
					echo $dep->vars["number"]; 
				}		
				?>
            </td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["zip"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["tdate"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->color_status(); ?></td>
            <td class="table_td<? echo $style ?>" align="center">
            	<? if(!$inserted){ ?>
                <form method="post" action="process/actions/release_mps_from_payout.php" id="release_<? echo $dep->vars["id"]; ?>">
                	<input name="pid" type="hidden" id="pid" value="<? echo $tran->vars["id"] ?>" />
                    <input name="did" type="hidden" id="did" value="<? echo $dep->vars["id"] ?>" />
                	<a href="javascript:;" onclick="document.getElementById('release_<? echo $dep->vars["id"]; ?>').submit()" class="normal_link">Release</a>
                </form>
                <? } ?>
            </td>
          </tr>
        
        <? $i++;} ?>
        
          <tr>
          	<td class="table_header" colspan="2" align="right"><strong>Current Amount:&nbsp;&nbsp;</strong></td>
            <td class="table_header" align="center"><strong><? echo $payout_total ?></strong></td>
            <td class="table_header"></td>
            <td class="table_header"></td>
            <td class="table_header"></td>
            <td class="table_header"></td>
          </tr>
        
        </table>
        <br />
        
        <div align="right">
        	
				<? if(count($deposits)>0 && !$inserted){ ?>
                <form method="post" action="process/actions/complete_mp_payout.php" onsubmit="return confirm('Are you sure you want to complete this payout?');">
                <input name="pid" type="hidden" id="pid" value="<? echo $tran->vars["id"] ?>" />
                <input name="Enviar" type="submit" value="Complete" />
                </form>
                &nbsp;&nbsp;&nbsp;
                <? } ?>            
            
        </div>
        
    
    </td>
  </tr>
  <tr>
    <td height="50" align="center" colspan="100"></td>
  </tr>
  	<? }//if ?>
  <? }//for ?>
   <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">TOTAL:</td>
    <td class="table_header" align="center"><? echo $total ?></td>
    <td class="table_header" align="center"><? echo $total_fees ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>