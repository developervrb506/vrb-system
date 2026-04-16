<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("special_deposits")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){		
		$upagn = get_special_payout($_POST["update_id"]);
		
		$original_amount = $upagn->vars["amount"];
		$original_fees = $upagn->vars["fees"];
		$original_method = $upagn->vars["method"];
		
		$upagn->vars["player"] = $_POST["player"];
		$upagn->vars["amount"] = $_POST["amount"];
		$upagn->vars["fees"] = $_POST["fees"];
		$upagn->vars["method"] = $_POST["special_method"];
		$upagn->vars["comment"] = $_POST["comment"];
		$upagn->vars["feedback"] = $_POST["back"];			
		
		if($upagn->vars["inserted"]){
			
			//method changed
			if($original_method != $upagn->vars["method"]){				
				$special_method = get_special_method($upagn->vars["method"]);
				$params = "?transaction=".two_way_enc(mt_rand)."&mp=".two_way_enc($special_method->vars["dgs_id"]).
								"&cache=".two_way_enc($upagn->vars["dgs_dID"]);
				$params .= "&mxs=".two_way_enc("METHOD CHANGED");
				$upagn->vars["dgs_dID"] =  
					file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/change_amount_dgs_transaction.php$params");				
			}
			
			//Amount
			if($original_amount != $upagn->vars["amount"]){	
				$params = "?transaction=".two_way_enc(mt_rand)."&ip=".two_way_enc($upagn->vars["amount"]*-1).
					"&cache=".two_way_enc($upagn->vars["dgs_dID"]);
				$params .= "&mxs=".two_way_enc("AMOUNT CHANGED");
				$upagn->vars["dgs_dID"] = 
					file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/change_amount_dgs_transaction.php$params");
			}
			
			//fees
			if($original_fees != $upagn->vars["fees"]){
				$params = "?transaction=".two_way_enc(mt_rand)."&ip=".two_way_enc($upagn->vars["fees"]*-1).
					"&cache=".two_way_enc($upagn->vars["dgs_fID"]);
				$params .= "&mxs=".two_way_enc("AMOUNT CHANGED");
				$upagn->vars["dgs_fID"] = 
					file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/change_amount_dgs_transaction.php$params");
			}
			
		}
		
		$upagn->update();
		
	}else{
		$newagn = new _special_payout();
		$newagn->vars["player"] = $_POST["player"];
		$newagn->vars["amount"] = $_POST["amount"];
		$newagn->vars["fees"] = $_POST["fees"];
		$newagn->vars["method"] = $_POST["special_method"];
		$newagn->vars["comment"] = $_POST["comment"];
		$newagn->vars["ddate"] = date("Y-m-d H:i:s");
		$newagn->insert();
	}
}else if(isset($_GET["sd"])){
	$upagn = get_special_payout($_GET["sd"]);	
	$upagn->vars["status"] = $_GET["st"];
	$upagn->update(array("status"));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Special Payouts</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"datef",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"datet",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<? 
if(isset($_GET["detail"])){
	//details
	$payout = get_special_payout($_GET["dep"]);
	if(is_null($payout)){
		$title = "Add new Payout";
		$new = true;
	}else{
		$title = "Edit Payout";
		$read = 'readonly="readonly"';
		$new = false;
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$payout->vars["id"] .'" />';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"player",type:"null", msg:"Player is required"});
	validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
	validations.push({id:"fees",type:"numeric", msg:"Fees is required"});
	validations.push({id:"special_method",type:"null", msg:"Method is required"});
    </script>
	<div class="form_box" style="width:500px;">
        <form method="post" action="special_payout.php?e=64" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">        
          <tr>
            <td>Player</td>
            <td><input name="player" type="text" id="player" value="<? echo $payout->vars["player"] ?>" /></td>
          </tr> 
          <tr>
            <td>Amount</td>
            <td><input name="amount" type="text" id="amount" value="<? echo $payout->vars["amount"] ?>" /></td>
          </tr> 
          <tr>
            <td>Fees</td>
            <td><input name="fees" type="text" id="fees" value="<? echo $payout->vars["fees"] ?>" /></td>
          </tr>   
          <tr>
            <td>Method</td>
            <td>
            	<?
				$select_option = true;
				$current_method = $payout->vars["method"]->vars["id"];
				include "includes/special_methods_list.php" 
				?>
            </td>
          </tr>
          <? if(!$new){ ?>
          <tr>
            <td>Date</td>
            <td><input type="text" value="<? echo $payout->vars["ddate"] ?>" readonly="readonly" /></td>
          </tr> 
          <tr>
            <td>Inserted</td>
            <td><? echo $payout->str_inserted() ?></td>
          </tr> 
          <? } ?>  
          <tr>
            <td>Comment</td>
            <td><textarea name="comment" cols="35" rows="7" id="comment"><? echo $payout->vars["comment"] ?></textarea></td>
          </tr>
          <? if(!$new){ ?>
          <tr>
            <td>Admin Comment</td>
            <td><textarea name="back" cols="35" rows="7" id="back"><? echo $payout->vars["feedback"] ?></textarea></td>
          </tr>	
          <? } ?>		
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
	?>
    <span class="page_title">Special Payouts</span><br /><br />
    <a href="?detail" class="normal_link">+ Add Payout</a>
    <br /><br />
    <?
	$from = $_POST["datef"]; 
	if($_POST["datet"]==""){$to = date('Y-m-d');}else{$to = $_POST["datet"];} 
	$player = $_POST["player"];
	$method = $_POST["special_method"];
	$sstatus = $_POST["sstatus"];
	if(!isset($_POST["sstatus"])){$sstatus = "pe";}
	?>
    <form action="special_payout.php" method="post">
    From: <input name="datef" type="text" id="datef" value="<? echo $from ?>" size="15" readonly="readonly" /> 
    
    To: <input name="datet" type="text" id="datet" value="<? echo $to ?>" size="15" readonly="readonly" /> 
    
    Player: <input name="player" type="text" id="player" size="15" value="<? echo $player ?>" /> 
    
    Method: 
    
    <? 
	$all_option = true;
	$current_method = $method;
	include "includes/special_methods_list.php" 
	?>
    
    Status: 
    <select name="sstatus" id="sstatus">
      <option value="">All</option>
      <option value="ac" <? if($sstatus == "ac"){echo 'selected="selected"';} ?>>Accepted</option>
      <option value="de" <? if($sstatus == "de"){echo 'selected="selected"';} ?>>Deniedd</option>
      <option value="pe" <? if($sstatus == "pe"){echo 'selected="selected"';} ?>>Pending</option>
    </select>
    
    <input type="submit" value="Search" />
    </form>
    <br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Player</td>
        <td class="table_header" align="center">Amount</td>
        <td class="table_header" align="center">Fees</td>
        <td class="table_header" align="center">Method</td>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Comment</td>
        <td class="table_header" align="center">Inserted</td>
        <td class="table_header" align="center">Status</td>
        <? if($current_clerk->im_allow("special_deposits_process")){ ?><td class="table_header" align="center"></td><? } ?>
      </tr>
      <?
	  $i=0;
	   $methods = search_special_payout($from, $to, $player, $method, $sstatus);
	   foreach($methods as $mt){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["player"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo $mt->vars["amount"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo $mt->vars["fees"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["method"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["ddate"]; ?></td>
        <td class="table_td<? echo $style ?>" width="270">
			<div id="shortt_<? echo $mt->vars["id"]; ?>">
				<? echo cut_text($mt->vars["comment"],40); ?>
                <? if($mt->vars["comment"] != ""){ ?>
                &nbsp;<a href="javascript:;" class="normal_link" onclick="document.getElementById('shortt_<? echo $mt->vars["id"]; ?>').style.display = 'none'; document.getElementById('fullt_<? echo $mt->vars["id"]; ?>').style.display = 'block'; ">Read All</a>
                <? } ?>
            </div>
            <div style="display:none" id="fullt_<? echo $mt->vars["id"]; ?>">
                <? echo nl2br($mt->vars["comment"]); ?><br />
                <a href="javascript:;" class="normal_link" onclick="document.getElementById('fullt_<? echo $mt->vars["id"]; ?>').style.display = 'none'; document.getElementById('shortt_<? echo $mt->vars["id"]; ?>').style.display = 'block'; ">Hide</a>
            </div>
        </td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->str_inserted(); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->str_status(); ?></td>
        <? if($current_clerk->im_allow("special_deposits_process")){ ?>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="special_payout.php?detail&amp;dep=<? echo $mt->vars["id"]; ?>" class="normal_link">Edit</a>
            <? if($mt->vars["status"] == "pe"){ ?>
            &nbsp;|&nbsp;
            <a href="javascript:;" onclick="if(confirm('Are you sure you want to Accept this Payout?')){location.href = 'special_payout.php?sd=<? echo $mt->vars["id"]; ?>&st=ac';}" class="normal_link">
            	Accept
            </a>
            &nbsp;|&nbsp;
        	<a href="javascript:;" onclick="if(confirm('Are you sure you want to Deny this Payout?')){location.href = 'special_payout.php?sd=<? echo $mt->vars["id"]; ?>&st=de';}" class="normal_link">
            	Deny
            </a><? } ?>
        </td>
        <? } ?>
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
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>
      
    <?
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>