<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript" >

function fix_data(player,pre,id){
   
 
	if(confirm("Are you sure you want to UPDATE this player?")){
		document.getElementById("idel").src = BASE_URL . "/ck/baseball_file/process/actions/fix_player_data.php?player="+player+"&pre="+pre;
     	//document.location = BASE_URL . "/ck/baseball_file/process/actions/fix_player_data.php?player="+player+"&pre="+pre;
		document.getElementById("table_"+id).style.display = "none";
	}

  
  
}
</script>



</head>
<body style="background:#fff; padding:20px;">
<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
<span class="page_title">Duplicate Players</span><br />
<br />

<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>



<?
/*
Note:

  At the beggining when a new player is added in http://www.fangraphs.com  database they use ids as "sa326530" and later they changed
  to another numbers. you can see this in the following link : http://www.fangraphs.com/statss.aspx?playerid=sa326530&position=P
  if you see the id # changed for : 8185.  for that reason is that this job is done, to check this cases and delete the older ids. updating fist all the old entrys with the new id#. 

*/

if(isset($_GET["de"])){
	$player = get_baseball_player_by_id("id",$_GET["de"]);
	$player->delete();
	
	
	header("Location: duplicate_players_fix.php?e=3");
}




 $duplicate_players = get_baseball_all_duplicated_players();

 //echo "<pre>";
 // print_r($duplicate_players);

?>
<div class="form_box">
      
    

<?
 $j=0;
 foreach ($duplicate_players as $duplicate){
	
	$j++; 
	$_player = get_baseball_player_by_name($duplicate["player"]);  
	 
	// print_r($_player);
	 
	  if ( ($_player[0]->vars["type"] == $_player[1]->vars["type"] ) && (   (contains_ck($_player[0]->vars["fangraphs_player"],'sa'))
	    || (contains_ck($_player[1]->vars["fangraphs_player"],'sa')) ) ) {
	 
	 ?>
	 
 
	  <table width="50%" border="0" cellspacing="0" cellpadding="10" id="table_<? echo $j;?>">
      <tr>
        <td  name ="game_info_" width="120"  class="table_header">Player</td>
        <td  name ="game_info_" width="120"  class="table_header">ID</td>
        <td  name ="game_info_" width="120"  class="table_header">Position</td>
        <td  name ="game_info_" width="120"  class="table_header">team</td>
        <td  name ="game_info_" width="120"  class="table_header"></td>
        <td  name ="game_info_" width="120"  class="table_header"></td>        
      </tr>
       <?  foreach ($_player as $player){ ?>
       
        <? if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>
      
        <tr>
		<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $player->vars["player"] ?></td> 
        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $player->vars["fangraphs_player"] ?></td>
        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $player->vars["position"] ?>    </td> 
         <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $player->vars["fangraphs_team"] ?>     
         </td> 
         <td class="table_td<? echo $style ?>" style="font-size:12px;">
         <? /* if ($id_fan == $player->vars["fangraphs_player"]) { ?>     
             <a href="?de=<? echo $player->vars["id"]; ?>" class="normal_link">Delete</a>
         <? }*/ ?>
         <? echo $player->vars["type"] ?>
         </td> 
         <td class="table_td<? echo $style ?>" style="font-size:12px;" align="center"><? if (!contains_ck($player->vars["fangraphs_player"],'sa')) {?> 
          <? if( strtoupper($pre_name) == strtoupper($player->vars["player"])) { ?>
         <input type="button" value="FIX DATA" onclick="fix_data('<? echo $player->vars["fangraphs_player"] ?>','<? echo  $id_fan ?>','<? echo $j ?>');">
          <? } ?>
		  
		  <? } ?>  </td>
          
      </tr>
        <?
          $pre_name = $player->vars["player"];
		  $id_fan = $player->vars["fangraphs_player"];
		?>
      
        <? } ?>
      
       </table>
        <BR><BR />
        <? } ?>
        
      <? } ?> 
      
   

 


</body>
</html>

