<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("player_ip")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PLAYER IPs</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"player",type:"null", msg:"Player is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">PLAYER IPs</span><br /><br />

<? include "includes/print_error.php" ?>

<?

if (isset($_GET["player_id"])){
$_POST["player_update"] = $_GET["player_id"];	
$ips = new _player_ip();  
$ips->vars["allowed_ip"] = "";
$ips->vars["player"] = $_POST["player_update"];
$ips->insert();
unset($_GET["player_id"]);
}

if (isset($_POST["player_update"])){
	
    $player = $_POST["player_update"];
	$ips = get_player_ips($player);  
	$ips->vars["allowed_ip"] = $_POST["ips"];
	$ips->update(array("allowed_ip")); 
		
}
else{
  $player = $_POST["player"];
  
  if($player != ""){ 

  $ips = get_player_ips($player);  
 
 }
  
  
}
?>
<form method="post" action="player_ip.php"  onsubmit="return validate(validations)">
Player: <input name="player" type="text" id="player" value="<? echo $player ?>" />
<input type="submit" name ="search" value="Search" />
</form>
<br /><br />



<?
 if (is_null($ips) && isset($_POST["search"])){
	 
   echo "Player not Found&nbsp;&nbsp; "; ?>
   	<a href="?player_id=<? echo $player?>" class="normal_link" onclick="">Add This Player </a>
   
   <? }
 
 
 if (!is_null($ips) ){
 
 
 ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="" onsubmit="return validate(validations)">
	<input name="player_update" type="hidden" id="player_update" value="<? echo $player ?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="10">
       <tr>
        <td><strong>Player:</strong> <? echo $ips->vars["player"]?> <BR><BR>IPs Allowed (separated by comma)</td>
        <td><textarea name="ips" cols="50" rows="10" id="ips"><? 
			echo $ips->vars["allowed_ip"]; 
		?></textarea></td>
      </tr> 
     
      <tr>
       <td>&nbsp;</td>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        
      </tr>
    </table>
	</form>
</div>


<? } ?>


</div>
<? } else { echo "Access Denied";} ?>

<? include "../includes/footer.php" ?>