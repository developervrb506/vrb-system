<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? //if(!$current_clerk->vars["level"]->vars["schedules_access"]){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
	<?
	$bet = get_bet($_GET["bid"]);
	$accounts = get_all_betting_accounts();
	$identifiers = get_all_betting_identifiers();
	?>
	<script type="text/javascript" src="../process/js/functions.js"></script>
    <script type="text/javascript" src="includes/js/bets.js"></script>
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
    <span class="page_title">Edit Bet</span><br /><br />
	<div class="form_box">
        <form method="post" onsubmit="return prevalidate(validations)" action="process/actions/edit_bet_action.php">
        <input name="bid" type="hidden" id="bid" value="<? echo $bet->vars["id"] ?>" />
        <input name="turl" type="hidden" id="turl" value="<? echo $_GET["turl"] ?>" />
        <table width="100%" border="0" cellspacing="0" cellpadding="10">          
          <tr>
            <td>Account Number:</td>
            <td>
				<input name="account" type="text" id="account" value="<? echo $bet->vars["account"]->vars["name"] ?>" />
            </td>
          </tr>
          <tr>
            <td>Team:</td>
            <td><strong><? echo $bet->vars["team"] . " " . ucwords($bet->vars["type"]) ?></strong></td>
          </tr>
          <tr>
            <td>Exact Line (<? echo $bet->vars["period"] ?>):</td>
            <td>
            	<?
				$lines = split_line($bet->vars["line"]);
				?>
                <? if(isset($lines[1])){ ?>
                <script type="text/javascript">
				validations.push({id:"preline",type:"null", msg:"Please insert an Exact Line"});
				</script>
                <input name="preline" type="text" id="preline" value="<? echo $lines[0] ?>" size="5"/>&nbsp;&nbsp;
                <input name="line" type="text" id="line" value="<? echo $lines[1] ?>" size="5" onblur="focus_amount()" />
                <? }else{ ?>
                <input name="line" type="text" id="line" value="<? echo $lines[0] ?>" onblur="focus_amount()" />
                <? } ?>
                
            </td>
          </tr> 
          <tr>
            <td>Risk Amount</td>
            <td><input name="risk" type="text" id="risk" onblur="calc_amount('win')" value="<? echo $bet->vars["risk"] ?>" /></td>
          </tr> 
          <tr>
            <td>Win Amount</td>
            <td><input name="win" type="text" id="win" onblur="calc_amount('risk')" value="<? echo $bet->vars["win"] ?>" /></td>
          </tr> 
          <tr>
            <td>Identifier</td>
            <td>
				<input name="identifier" type="text" id="identifier"  value="<? echo $bet->vars["identifier"]->vars["name"] ?>" />
            </td>
          </tr> 
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
</body>
</html>