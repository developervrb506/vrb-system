<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>

<?
$id = param("id");

if( isset($id) && !empty($id) ){
	$update = true;
	$member = get_twitter_member($id);
    $title = "Edit " . $member->vars["name"];
}else{
	$update = false;
	$title = "Create New Member";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/twitter/js/scripts.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"id",type:"null", msg:"The twitter id is required"});
validations.push({id:"name",type:"null", msg:"The twitter name is required"});
validations.push({id:"account",type:"null", msg:"The twitter account is required"});
validations.push({id:"leagues_dd",type:"null", msg:"The sport is required"});
validations.push({id:"teams_dd",type:"null", msg:"The team is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<a href="<?= BASE_URL ?>/ck/twitter_members.php"><< Back</a><br><br />

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/create_twitter_member_action.php" onsubmit="return validate(validations);">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $member->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td <? if($update) { ?> style="display:none;" <? } ?>>Twitter ID</td>
        <td><input name="id" type="number" id="id" min="1" oninput="validity.valid||(value='');" value="<? echo $member->vars["id"]; ?>" tabindex="1" <? if($update) { ?> style="display:none;" <? } ?> /></td>
      </tr>
      <tr>
        <td>Twitter name</td>
        <td><input name="name" type="text" id="name" value="<? echo $member->vars["name"] ?>" tabindex="2" /></td>
      </tr>
      <tr>
        <td>Twitter account</td>
        <td><input name="account" type="text" id="account" value="<? echo $member->vars["account"] ?>" tabindex="3" /></td>
      </tr>      
      <tr>
        <td>Twitter number of followers</td>
        <td><input name="followers" type="number" id="followers" min="1" oninput="validity.valid||(value='');" value="<? echo $member->vars["followers"] ?>" tabindex="4" /></td>
      </tr>
      <tr>
        <td>Sport</td>
        <td>
		<? $sports_list = array("NFL", "NBA", "NHL", "MLB", "MMA-BOXING"); ?>
   
        <select name="sport" id="leagues_dd"> 
           <option value="">Choose sport</option>     
           <?	    		
           foreach($sports_list as $sp){
           ?>
           <option <? if($sp == $member->vars["sport"]){echo 'selected="selected"';}?> value="<? echo $sp ?>"><? echo $sp ?></option>
          <? } ?>              
        </select>        
      </td>
      </tr>
      <tr>
        <td>Team</td>
        <td>		
        <select name="teamid" id="teams_dd">                      
        </select>
        <input type="hidden" id="choosen_team" name="choosen_team" value="<? echo $member->vars["teamid"] ?>">        
      </td>
      </tr>            
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>      
    </table>
	</form>
</div>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>