<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? require_once(ROOT_PATH . '/includes/html_dom_parser.php');  ?>
<? require_once(ROOT_PATH . '/ck/nhl_file/process/functions.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>NHL SYSTEM</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();

function send_form(){
	
document.getElementById('frm_dist').submit();
}

</script>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<img src="images/NHL.png" style="width:60px; margin-bottom:-20px"><span class="page_title">TEAMS DISTANCE</span><br /><br /><br />
<?	
$parsing = false; // PARSING ONLY IS TRUE the first time. or in a maitanance.

$team = param("team");
$teams = get_nhl_teams("team");
$i=0;

if($team != ""){
  $dist_team = get_nhl_teams_distance($team);	
 
}

if(isset($_POST["dist"])){
 
  for($k=1;$k<=32;$k++){
	if($k!= $team){
	 
	  if(!isset($dist_team[$team."_".$k])){
   
	   $distance = new _nhl_teams_distance();
	   $distance->vars["team_home"] = $team;
  	   $distance->vars["team_away"] = $k;
       $distance->vars["distance"] = $_POST["t_".$k];	  
	   $distance->insert();	
	   }else{
		 	 $dist_team[$team."_".$k]->vars["distance"] = $_POST["t_".$k];
		   $dist_team[$team."_".$k]->update(array("distance"));
       }
	
	}
	  
  }
	
}


?>
<form id="frm_dist" method="post">
 Team:&nbsp;
 <select name="team" onchange="send_form();">
  <option value="" >Choose a Team</option>
  <? foreach($teams as $t){ ?>
  <option <? if ($t->vars["id"]== $team){ echo ' selected="selected" ';}?>  value="<? echo $t->vars["id"]?>"><? echo $t->vars["team"]?></option>
  <? } ?>
 </select>
 
</form>
<BR><BR>

<? if($team != "") { ?>
<?
if($parsing){
 $t = get_nhl_team($team);
 $distance = get_nhl_team_distance($t->vars["map_link"],$teams);
}
?>

<form method="post">
<input type="hidden" name="team" value="<? echo $team ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">Team</td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">Arena</td>    
    <td class="table_header" align="center">Miles</td> 
<? if($parsing){ ?> <td class="table_header" align="center">Miles </td><? } ?>
       
    
  </tr>
 <? foreach ($teams as $ts){  if($i % 2){
	  $style = "1";}else{$style = "2";}?>
 <?  if($ts->vars["id"] != $team){  $i++; ?>
   <tr>
     <td class="table_td<? echo $style ?>" align="center"><? echo $ts->vars["team"]?></td>
     <td class="table_td<? echo $style ?>" align="center"><img style="width:60px" src="<?= BASE_URL ?>/ck/nhl_file/images/<? echo $ts->vars["logo"]?>.png"></td>     
     <td class="table_td<? echo $style ?>" align="center"><? echo $ts->vars["arena"]?></td>     
     <td class="table_td<? echo $style ?>" align="center"><input <? if(!$parsing){ ?> disabled="disabled" <? } ?> readonly="readonly" style="width:50px" type="text" name="dt_<? echo $ts->vars["id"] ?>" value="<? echo  $dist_team[$team."_".$ts->vars["id"]]->vars["distance"]?>"></td> 
    <? if($parsing){ ?>       <td class="table_td<? echo $style ?>" align="center"><input style="width:50px" type="text" name="t_<? echo $ts->vars["id"] ?>" value="<? echo  $distance[$ts->vars["id"]]["distance"]?>"></td>  <? } ?>
     					   
   </tr> 
   
   <?  } ?> 
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
  <tr>
   <td colspan="4" align="center"><input type="submit" <? if(!$parsing){ ?> disabled="disabled" <? } ?>name="dist" value="Save" style="width:120px; height:30px; margin-top:5px" ></td>
  </tr>
 </table>
</form>

<? } ?>

</div>
<? include "../../includes/footer.php" ?>