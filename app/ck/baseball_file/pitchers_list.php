<? require_once(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../process/js/functions.js"></script>
<style>
.avatar {
  vertical-align: middle;
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
</style>

</head>
<body style="background:#fff; padding:20px;">

<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  

//
$from = param('date');
$games = get_baseball_games_by_date($from);


?>

<div class="form_box">
  
    <table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td  name ="game_info_"    class="table_header"></td>
        <td  name ="game_info_"   class="table_header"></td>
        <td  align="center" name ="game_info_"   class="table_header"></td>
        <td  align="center" name ="game_info_"  class="table_header"> </td>
        <td   align="center"name ="game_info_"   class="table_header"></td>
      </tr>
      
    <? foreach ( $games as $game){
       
	   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
	   $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
	   $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);	
	 //  print_r($game);
   	 //  print_r($player_a);
   	 //  print_r($player_h);
	   if($player_a->vars["image"] == "no_image" ){ $player_a->vars["image"] = BASE_URL . "/ck/baseball_file/images/no_image.png";}
   	   if($player_h->vars["image"] == "no_image" ){ $player_h->vars["image"] = BASE_URL . "/ck/baseball_file/images/no_image.png";}
           
		    $image_a = $player_a->vars["image"];
			$image_h = $player_h->vars["image"];   
			
			if($image_a == ""){ $image_a = $image_h = BASE_URL . "/ck/baseball_file/images/no_image.png"; }
	   	   
		   
?>
       
       <tr>

        <td class="table_td<? echo $style ?>" style="font-size:12px;"><img src="<? echo $image_a ?>" alt="Avatar" class="avatar"> <? echo $player_a->vars["player"] ?></td> 
        <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><img src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/<? echo date("Ymd",strtotime($from))?>/<? echo $game->vars['away_rotation'] ?>.jpg" alt="Avatar" class="avatar"></td> 
        <td  align="center" class="table_td<? echo $style ?>" style="font-size:12px;"> <strong>VS</strong></td> 
  <td  align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><img src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/<? echo date("Ymd",strtotime($from))?>/<? echo $game->vars['home_rotation'] ?>.jpg" alt="Avatar" class="avatar"></td> 
        <td class="table_td<? echo $style ?>" style="font-size:12px;"><img src="<? echo $image_h ?>" alt="Avatar" class="avatar"><? echo $player_h->vars["player"] ?></td> 

       
  
      </tr>
       <?
		
      		
	}?>
      
    </table>
  
</div>

</body>
</html>

