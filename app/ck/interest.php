<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("player_interest")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upagn = get_player_interest($_POST["update_id"]);
		$upagn->vars["player"] = $_POST["player"];
		$upagn->vars["percentage"] = $_POST["percentage"];
		$upagn->update();
	}else{
		$newagn = new _interest();
		$newagn->vars["player"] = $_POST["player"];
		$newagn->vars["percentage"] = $_POST["percentage"];
		$newagn->insert();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Player Interest</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<? 
if(isset($_GET["detail"])){
	//details
	$player = get_player_interest($_GET["acc"]);
	if(is_null($player)){
		$title = "Add new Player";
	}else{
		$title = "Edit Player";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$player->vars["id"] .'" />';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"player",type:"null", msg:"Player is required"});
	validations.push({id:"percentage",type:"null", msg:"Percentage is required"});
    </script>
	<div class="form_box" style="width:400px;">
        <form method="post" action="interest.php?e=39" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Player</td>
            <td><input name="player" type="text" id="player" value="<? echo $player->vars["player"] ?>" /></td>
          </tr> 
          <tr>
            <td>Percentage</td>
            <td><input name="percentage" type="text" id="percentage" value="<? echo $player->vars["percentage"] ?>" size="5" /></td>
          </tr>
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
    <span class="page_title">Players Interest</span><br /><br />
    <a href="?detail" class="normal_link">Add Player</a>
    
    
    <br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Player</td>
        <td class="table_header" align="center">Percentage</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $players = get_all_players_interests();
	   foreach($players as $acc){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["player"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["percentage"]; ?>%</td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&acc=<? echo $acc->vars["id"]; ?>" class="normal_link">Edit</a>
        </td>
      </td>
      <? } ?>
      <tr>
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