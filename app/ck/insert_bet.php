<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
<script type="text/javascript" src="includes/js/bets.js"></script>
<? if(isset($_GET["gdel"])){ ?>
<script type="text/javascript">
alert("Bet has been Deleted");
</script>
<? } ?>

<? if(!isset($_GET["good"])){ ?>
	<?
	$parts = explode("/",biencript($_GET["game"],true));
	$rotation = $parts[0];
	$team = $parts[1];
	$period = $parts[2];
	$date = $parts[3];
	$type = $parts[4];
	$league = $parts[5];
	echo $league." ".$rotation." ".$period." ".$type."<BR>";
	$accounts = get_all_betting_accounts();
	$identifiers = get_all_betting_identifiers();
	$bets = search_bet($_GET["gid"],$period, $team, $type);
	if(false/*count($bets)>0 && !isset($_GET["new"])*/){ // Uncomment to show bets list on this pop up
		?>
         <span class="page_title"><? echo $team. " " . ucwords($type) ?> Bets</span><br /><br />
         <a href="<? echo ck_curl() ?>&new" class="normal_link">+ Add new bet</a>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
         	<tr>
              <td class="table_header">Bet</td>
              <td class="table_header">Date</td>
              <td class="table_header">Acc.</td>
              <td class="table_header"></td>
              <td class="table_header"></td>
            </tr>
            <? $i = 0 ?>
         	<? foreach($bets as $bet){ ?>
            <? if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>
            <tr>
              <td class="table_td<? echo $style ?>"><? echo $bet->vars["team"] . " " . $bet->vars["line"] ?></td>
              <td class="table_td<? echo $style ?>"><? echo date("y/m/d H:i A",strtotime($bet->vars["bdate"])) ?></td>
              <td class="table_td<? echo $style ?>"><? echo $bet->vars["account"]->vars["name"] ?></td>
              <td class="table_td<? echo $style ?>" align="center">
              	<a href="edit_bet.php?bid=<? echo $bet->vars["id"] ?>" class="normal_link">View</a>
              </td>
              <td class="table_td<? echo $style ?>" align="center">
              	<form action="process/actions/delete_bet_action.php" method="post" id="del_frm_<? echo $bet->vars["id"] ?>">
                	<input name="delid" type="hidden" id="delid" value="<? echo $bet->vars["id"] ?>" />
                    <input name="curl" type="hidden" id="curl" value="<? echo ck_curl() ?>" />
                </form>
              	<a href="javascript:;" onclick="delete_bet('<? echo $bet->vars["id"] ?>');" class="normal_link">Delete</a>
              </td>
            </tr>
            <? } ?>
            <tr>
              <td class="table_last"></td>
              <td class="table_last"></td>
              <td class="table_last"></td>
              <td class="table_last"></td>
              <td class="table_last"></td>   
            </tr>
          </table>
        <?
	}else{
	?>
	<script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"account",type:"null", msg:"Please Select an Account Number"});
	validations.push({id:"line",type:"null", msg:"Please insert an Exact Line"});
	validations.push({id:"risk",type:"numeric", msg:"Please insert a Risk Amount"});
	validations.push({id:"win",type:"numeric", msg:"Please insert a Win Amount"});
	validations.push({id:"identifier",type:"null", msg:"Please Select an Identifier"});
	
	var accounts = new Array();
	<? foreach($accounts as $acc){ ?>
	accounts.push('<? echo $acc->vars["name"] ?>');
	<? } ?>
	var identifiers = new Array();
	<? foreach($identifiers as $idf){ ?>
	identifiers.push('<? echo $idf->vars["name"] ?>');
	<? } ?>
    </script>
    <span class="page_title">Add New Bet</span><br /><br />
	<div class="form_box">
        <form method="post" onsubmit="return prevalidate(validations)" action="process/actions/add_bet_action.php">
        <input name="gameid" type="hidden" id="gameid" value="<? echo $_GET["gid"] ?>" />
        <input name="period" type="hidden" id="period" value="<? echo $period ?>" />
        <input name="team" type="hidden" id="team" value="<? echo $team ?>" />
        <input name="type" type="hidden" id="type" value="<? echo $type ?>" />
        <input name="date" type="hidden" id="date" value="<? echo $date ?>" />
        <input name="league" type="hidden" id="league" value="<? echo $league ?>" />
        <input name="rotation" type="hidden" id="rotation" value="<? echo $rotation ?>" />        
        <table width="100%" border="0" cellspacing="0" cellpadding="10">          
          <tr>
            <td>Account Number:</td>
            <td>
				<input name="account" type="text" id="account" onkeyup="make_upper(this);" value="<? echo $_COOKIE["current_account"] ?>" />
				<? //$select_option = true; include "includes/betting_accounts_list.php" ?>
            </td>
          </tr>
          <tr>
            <td>Team:</td>
            <td><strong><? echo $team . " " . ucwords(str_replace("_"," ",$type)) ?></strong></td>
          </tr>
          <tr>
            <td>Exact Line (<? echo $period ?>):</td>
            <td>
            	<?
				$lines = split_line(biencript($_GET["line"],true));
				?>
                <? //if(isset($lines[1])){ ?>
                <? if($type == "total" || $type == "spread" || contains_ck($type,"team_totals")){ ?>
                <script type="text/javascript">
				validations.push({id:"preline",type:"null", msg:"Please insert an Exact Line"});
				</script>
                <input name="preline" type="text" id="preline" value="<? echo $lines[0] ?>" size="5"/>&nbsp;&nbsp;
                <input name="line" type="text" id="line" value="<? echo $lines[1] ?>" size="5" onblur="focus_amount();" />
                <? }else{ ?>
                <input name="line" type="text" id="line" value="<? echo $lines[0] ?>" onblur="focus_amount();" />
                <? } ?>
                
            </td>
          </tr> 
          <tr>
            <td>Risk Amount</td>
            <td><input name="risk" type="text" id="risk" onblur="calc_amount('win')" /></td>
          </tr> 
          <tr>
            <td>Win Amount</td>
            <td><input name="win" type="text" id="win" onblur="calc_amount('risk')" /></td>
          </tr> 
          <tr>
            <td>Identifier</td>
            <td>
				<input name="identifier" type="text" id="identifier" />
				<? //include "includes/betting_identifiers_list.php" ?>
            </td>
          </tr> 
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <script type="text/javascript">setTimeout(function(){document.getElementById("account").focus();document.getElementById('account').select();},50);</script>
    <? } ?>
<? }else{ ?>
	<script type="text/javascript">parent.Shadowbox.close();</script>
<? } ?>
</body>
</html>
<? }else{echo "Access Denied";} ?>