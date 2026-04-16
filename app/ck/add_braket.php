<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("march_madness")){ ?>
<?
if(isset($_POST["player"])){
	$player = strtoupper(clean_str_ck($_POST["player"]));
	$entry = get_braket_player($player);
	  if(!is_null($entry)){
		  $entry->vars["amount"] += 1;
		  $entry->update(array("amount"));
	  }else{
		  $entry = new _braket_player();
		  $entry->vars["player"] = $player;
		  $entry->vars["amount"] = 1;
		  $entry->vars["bgroup"] = 1;
		  $entry->insert();
	  }
}else if(isset($_POST["dentry"])){
	$player = strtoupper(clean_str_ck($_POST["dentry"]));
	$entry = get_braket_player($player);
	$amount = clean_str_ck($_POST["damount"]);
	if($entry->vars["amount"] <= $amount){
		$entry->delete();
	}else{
		$entry->vars["amount"] -= $amount;
		$entry->update(array("amount"));
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Add Braket Entry</title>

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
<span class="page_title">Add Braket Entry</span><br /><br />

<div class="form_box" style="padding:20px;">
	<form method="post" onsubmit="return validate(validations)">
    
    Player: &nbsp;&nbsp;<input name="player" type="text" id="player" /><br /><br /><input type="image" src="../images/temp/submit.jpg" />
    
	</form>
</div>
<br /><br />
<? $players = get_all_brakets_players() ?>
Player List
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>    
    <td class="table_header" align="center">Player</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0; 
   foreach($players as $item){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr title="<? echo $tran->vars["note"]; ?>">    
    <td class="table_td<? echo $style ?>" align="center"><? echo $item->vars["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $item->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<form method="post" onsubmit="return confirm('Are you sure you want to delete this brakets?')">
        <input type="hidden" name="dentry" value="<? echo $item->vars["player"]; ?>" />
    	Delete <input type="text" value="1" size="5" name="damount" /> entry 
        <input name="Enviar" type="submit" value="Delete" />
        </form>
    </td>
  </td>
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>