<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){
 require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/ajax.js"></script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
function hide_link(id,id2){

  if(document.getElementById(id).style.display == "none"){
	 document.getElementById(id).style.display = "block";
	 document.getElementById(id2).style.display = "none";
	 document.getElementById(id+'_div').style.display = "none";
	 document.getElementById(id2+'_div').style.display = "block";
	 document.getElementById('hide').value = "team";
  } else if(document.getElementById(id).style.display == "block"){
	 document.getElementById(id).style.display = "none";
	 document.getElementById(id2).style.display = "block";
	 document.getElementById(id+'_div').style.display = "block";
	 document.getElementById(id2+'_div').style.display = "none";
	 document.getElementById('hide').value = "date";
  }

}
</script>

<script type="text/javascript">
Shadowbox.init();
</script>

<script type="text/javascript">
var validations = new Array();
validations.push({id:"pitches",type:"numeric", msg:"Please use only Numbers"});
//validations.push({id:"games",type:"numeric", msg:"Please use only Numbers"});
</script>

</head>
<body>
 <? //$page_style = " width:1680px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<? 
echo "<pre>";
//print_r($_POST);
echo "</pre>";



$games = get_baseball_games_by_date(date("Y-m-d"));


$stadiums = get_all_baseball_stadiums();
//$teams = get_all_baseball_team();

?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Pitchers Report 
</span><br /><br />


<form method="post" onsubmit="return validate(validations)">
 <input name="hide" type="hidden" id="hide" value="x" /> 

&nbsp;&nbsp;
  	
    
        <a  id="by_date" href="javascript:hide_link('by_date','by_team')" class="normal_link" title="Click to change the Date Search" style="display:none" >Today Pitchers</a> 	
    <a  id="by_team" href="javascript:hide_link('by_date','by_team')" class="normal_link" title="Click to change the Date Search" style="display:block"  >Pitchers by Team </a> 	
    
   <BR> <BR> 
    <div id="by_date_div"   >
    <?
    $pitchers = array();
	$j=0;
    foreach ($games as $_game){
      $pitchers[$j]["pitcher"] = $_game->vars["pitcher_away"];
	  $player = get_baseball_player_by_id('fangraphs_player',$_game->vars["pitcher_away"]);
	  $pitchers[$j]["name"] = $player->vars["player"];
	  $j++;
	  $pitchers[$j]["pitcher"] = $_game->vars["pitcher_home"];
	  $player = get_baseball_player_by_id('fangraphs_player',$_game->vars["pitcher_home"]);
	  $pitchers[$j]["name"] = $player->vars["player"];
	  $j++;    
   }
	
	?>
   
    Pitcher: 
    <select name="pitcher_today">
    <option>Please Select a Pitcher</option>
	<? foreach($pitchers as $pitcher) { ?>
     <option <? if($_POST["pitcher_today"] == $pitcher["pitcher"]){ echo ' selected '; }?> value="<? echo $pitcher["pitcher"] ?>"><? echo $pitcher["name"] ?></option>
    <? } ?>
    </select>
     
     </div>  
    
 
 
  <div id="by_team_div" style="display:none"  >
   <?
  	$on_change = "from_ajax(this.value,'team_pitcher','process/actions/pitcher_team.php')";
   ?>
    Team:
     <? 
       create_objects_list("team_id", "team_id", $stadiums, "fangraphs_team", "team_name", "Select Team",$_POST["team_id"],$on_change,"_baseball_stadium");  ?>
   
   
   <div name="team_pitcher" id="team_pitcher">
        Pitcher: 
        <select onchange="" name="pitcher" id="pitcher"  class="">
 
        <option value="" id="select"  selected="selected">Select Team First</option>
    
        </select>
    </div>
   
   </div>
   <?
   if ($_POST["hide"]=="team"){
	?>
	<script>	
      hide_link('by_date','by_team');
    </script>
   <? }?>
	
    <? if ($_POST["hide"]=="team") {
	 $pit = $_POST["pitcher"];
	 } else { $pit  = $_POST["pitcher_today"];} 
	
  ?>
	
   
    <?  if ($_POST["team_id"] != ""){ ?>
     <script>
	  from_ajax('<? echo $_POST["team_id"]."_".$_POST["pitcher"] ?>','team_pitcher','process/actions/pitcher_team.php');
	 
	 </script>
   <? } ?> 
    
   <BR><BR>
    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
   <Br/ >
 </form>
<BR />



<? if ($pit != ""){
 $pit_data = get_baseball_player_max_data($pit);	
	
 ?>
   
 	<table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Pitcher</td>
			<td  name ="game_info_" width="120"  class="table_header">Max Last Game</td>
			<td  name ="game_info_" width="120"  class="table_header">Max Last 2 Games</td>
            <td  name ="game_info_" width="120"  class="table_header">Max Last 3 Games</td>
            <td  name ="game_info_" width="120"  class="table_header">Max Last 4 Games</td>
            <td  name ="game_info_" width="120"  class="table_header">Max Last 5 Games</td>
           </tr> 
            <tr>
			<td class="table_td1" style="font-size:12px;"><? echo $pit_data["player"] ?></td>
            <td class="table_td1" style="font-size:12px;"><? echo $pit_data["last_one"] ?></td>
            <td class="table_td1" style="font-size:12px;"><? echo $pit_data["last_two"] ?></td> 
            <td class="table_td1" style="font-size:12px;"><? echo $pit_data["last_three"] ?></td>            <td class="table_td1" style="font-size:12px;"><? echo $pit_data["last_four"] ?></td>            <td class="table_td1" style="font-size:12px;"><? echo $pit_data["last_five"] ?></td>           
            
           </tr>   
   </table>	
	

   
 <? } ?>
  
</div>



</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

