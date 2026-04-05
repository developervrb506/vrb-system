<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("manage_bonus")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Player Bonus</title>
</head>
<body>
<?
$types = get_all_bonus_programs();
?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Manage Player Bonus</span><br /><br />

<? include "includes/print_error.php" ?> 

<div class="form_box">
	<table>
     <tr>
    <td width="500px">
    <form method="get">
    Player: <input name="player" type="text" id="player" value="<? echo $_GET["player"] ?>" />
    <input name="" type="submit" value="Search" />
    </form>
    </td>
   	<td width="500px">
    <form method="get">
    Bonus:
    <select name="bonus">
      <? foreach ($types as $type) {?>
         <option  <? if ($_GET["bonus"]==$type["id"]){ echo 'selected="selected"'; } ?> value="<? echo $type["id"] ?>"><? echo $type["name"] ?></option>
      <? } ?> 
         <option  <? if ($_GET["bonus"]=="n"){ echo 'selected="selected"'; } ?> value="n" >None</option>
    </select>    
    <input name="" type="submit" value="Search" />
    </form>
    </td>
    </tr>
   </table>
</div>
<table border="0">
 <tr>
   <td width="500px">
<?  if (isset($_GET["player"])) {
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_manage_bonus_players.php?ps=VRB@conection&player=".$_GET["player"]); ?>
    <? } ?>
   </td>
   <td width="500px">
<? if (isset($_GET["bonus"])) {
	
  ?>
 <div align="center">
	<a href="javascript:;" onclick="document.getElementById('xml_form').submit();" class="normal_link">
	Export
	</a>
  </div>
  <? 
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_players_by_bonus.php?ps=VRB@conection&bonus=".$_GET["bonus"]); ?>  
 <?  } ?> 

   </td>
 <tr>
</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>