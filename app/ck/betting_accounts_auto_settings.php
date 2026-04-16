<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>

<?
$account = get_betting_account($_GET["aid"]);
$settings = get_betting_auto_settings($account->vars["id"]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/js/bets.js"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"url",type:"null", msg:"URL is required"});
validations.push({id:"betting_software_list",type:"null", msg:"Software is required"});
validations.push({id:"username",type:"null", msg:"Username is required"});
validations.push({id:"password",type:"null", msg:"Password is required"});
</script>
</head>
<body>
<div class="page_content" style="padding-left:20px; font-size:12px;">
  <span class="page_title"><? echo $account->vars["name"] ?></span><br /><br />
  <? include "includes/print_error.php" ?>
    <form method="post" action="process/actions/save_auto_settings.php" onsubmit="return validate(validations)">
    <input name="aid" type="hidden" id="aid" value="<? echo $account->vars["id"]?> " />
    <strong>WEBSITE</strong>
    <div class="form_box">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="33%">
            URL:<br />
            <input name="url" type="text" id="url" value="<? echo $settings->vars["url"] ?>" />
        </td>
        <td width="33%">
            Site Name:<br />
            <input name="sname" type="text" id="sname" value="<? echo $settings->vars["site_name"] ?>" />
        </td>
        <td width="33%">
            Site Domain:<br />
            <input name="sdomain" type="text" id="sdomain" value="<? echo $settings->vars["site_domain"] ?>" />
        </td>
      </tr>
      <tr>
        <td width="33%">
            Username:<br />
            <input name="username" type="text" id="username" value="<? echo $settings->vars["username"] ?>" />
        </td>
        <td width="33%">
        	Password:<br />
            <input name="password" type="text" id="password" value="<? echo $settings->vars["password"] ?>" />
        </td>
        <td width="33%">
            Software:<br />
            <? $select_option = true; $current_software = $settings->vars["software"]; include "includes/betting_software_list.php"; ?>
        </td>
      </tr>
    </table>
    </div>
    
    <strong>Connection</strong>
    <div class="form_box">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
            <td width="33%">
                Proxy:<br />
                <? $proxys = get_all_betting_proxys(); ?>
                <? create_objects_list("proxy", "proxy", $proxys, "id", "name", "None", $settings ->vars["proxy"]); ?>
            </td>
            <td width="33%">
                
            </td>
            <td width="33%">
                
            </td>
          </tr>
        </table>
    </div>
    
    
    <strong>AMOUNTS</strong>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:;" class="normal_link" onclick="switch_max_amounts();" id="max_btn">+ Detailed</a>
    <input name="detailed_max" type="hidden" id="detailed_max" value="0" />
    <div class="form_box">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" id="basic_max">
      <tr>
        <td width="33%">
            Max Amount:<br />
            <input name="max" type="text" id="max" value="<? echo $settings->vars["NFL_m"] ?>" />
        </td>
        <td width="33%"></td>
        <td width="33%"></td>
      </tr>
     </table>
     <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;" id="detail_max">
     <?
	 $sports = get_betting_sports();
	 $types = get_betting_line_types();
	 foreach($sports as $sp){
	 ?>
      <tr>
      	<? foreach($types as $tp){ ?>
        <td width="33%">
            <? echo $sp["name"] . " " . $tp["name"] ?>:<br />
            <input name="<? echo $sp["name"] . "_" . $tp["short"] ?>" type="text" id="<? echo $sp["name"] . "_" . $tp["short"] ?>" value="<? echo $settings->vars[$sp["name"] . "_" . $tp["short"]] ?>" />
        </td>
        <? } ?> 
      </tr>
      <? } ?>  
    </table>
  </div>
  <? if($settings->vars["detailed_max"]){?><script type="text/javascript">switch_max_amounts();</script><? } ?>
    
    <strong>GROUPS</strong>
    <div class="form_box">
    <?
    $groups = get_all_betting_groups();
    foreach($groups as $grp){
		if(!is_null($settings->groups[$grp->vars["id"]])){$cstatus = 'checked="checked"';}else{$cstatus = '';}
        ?><label>
            <input type="checkbox" name="groups[]" value="<? echo $grp->vars["id"] ?>" id="CheckboxGroup1_0" <? echo $cstatus ?>  />
            <? echo $grp->vars["name"] ?>
        </label>&nbsp;&nbsp;&nbsp;&nbsp;<?
    }
    ?>
    
    </div>
    <br /><br />
    <input type="image" src="../images/temp/submit.jpg" />
    </form>
</div>
<? }else{echo "Access Denied";} ?>