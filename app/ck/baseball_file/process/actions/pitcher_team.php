<? 
require_once(ROOT_PATH . "/ck/process/security.php");


 if (contains_ck($_GET["id"],"_")){
 $get = explode("_",$_GET["id"]);
 $team = $get[0];
 $pit = $get[1];
}  else {$team = $_GET["id"];}


$pitchers = get_baseball_pitcher_team($team);    
?>
Pitcher :
  <select onchange="" name="pitcher" id="pitcher"  class="">
    <option  value="">Select a Pitcher</option>
    
  <? foreach ($pitchers as $pitcher) { ?>
      <option  <? if ($pitcher["fangraphs_player"] == $pit) { echo ' selected ';} ?> value="<? echo $pitcher["fangraphs_player"] ?>" ><? echo $pitcher["player"]?></option>
  <? } ?>    
 </select>