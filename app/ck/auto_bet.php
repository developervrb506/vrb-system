<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/js/bets.js"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"sport",type:"null", msg:"Sport is required"});
validations.push({id:"rotation",type:"numeric", msg:"Rotation is required"});
validations.push({id:"line",type:"null", msg:"Line is required"});
validations.push({id:"juice",type:"numeric", msg:"Juice is required"});
validations.push({id:"type",type:"null", msg:"Type is required"});
</script>
</head>
<body>
<div class="page_content" style="padding-left:20px; font-size:12px;">
  <span class="page_title">New Auto Bet</span><br /><br />
  <? include "includes/print_error.php" ?>
  <?
  $reloader = mt_rand(100,1000000);
  $_SESSION["reloader"] = $reloader;
  ?>
    <form method="post" action="autobet/place_auto_bet.php" onsubmit="return validate(validations)" target="_blank">
    <input type="hidden" name="noreload" id="noreload" value="<? echo $reloader ?>" />
    <div class="form_box">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="33%">
            Sport:<br />
            <select name="sport" id="sport" onchange="change_period_drop()">
            	<option value="">-Select-</option>
            	<? foreach(get_betting_sports() as $sp){ ?>
                <option value="<? echo $sp["name"] ?>"><? echo $sp["name"] ?></option>
                <? } ?>
            </select>
        </td>
        <td width="33%">Period:<br />
          <!--NFL, NCAAF, NBA-->
          <div id="periods_box">
          Select the Sport
          </div>
        </td>
        <td width="33%">Rotation:<br />
          <input name="rotation" type="text" id="rotation" size="7" /></td>
      </tr>
      <tr>
        <td width="33%">
            Line:<br />
            <input name="line" type="text" id="line" size="7" />
        </td>
        <td width="33%">
            Juice:<br />
            <input name="juice" type="text" id="juice" value="-110" size="7" />
        </td>
        <td width="33%">
            Type:<br />
            <select name="type" id="type">
            	<option value="">-Select-</option>
                <option value="m">Money</option>
                <option value="s">Spread</option>
                <option value="o">Over</option>
                <option value="u">Under</option>
            </select>
        </td>
      </tr>
      <tr>
        <td width="33%">Amount:<br />
          <input name="amount" type="text" id="amount" size="7" /></td>
        <td width="33%">Group:<br />
          <? $none_option = true; include "includes/betting_groups_list.php"; ?></td>
        <td width="33%"><?php /*?>Action:<br />
          <select name="action" id="action">
            <option value="manual">Manual Bet</option>
            <option value="auto">Auto Bet</option>
          </select><?php */?></td>
      </tr>
    </table>
    </div><br /><br />
    <input type="image" src="../images/temp/submit.jpg" />
    </form>
</div>
<? }else{echo "Access Denied";} ?>