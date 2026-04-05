<? include(ROOT_PATH . "/ck/process/security.php"); 
   if($current_clerk->im_allow("baseball_file")){ ?>
  
   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<title>Roof Fix</title>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />

<script>

function change_roof_fix(id,opened){
  
 // document.getElementById("changer").src = "process/actions/change_roof_fix.php?gid="+id+"&status="+opened;
  //var result = confirm("Want to Change it?");
//if (result) {
	document.getElementById("changer").src = "process/actions/change_roof_fix.php?gid="+id+"&status="+opened;

	// document.location = "process/actions/change_roof_fix.php?gid="+id+"&status="+opened;
	      document.getElementById("game_"+id).style.display = "none";
//}
   
//   document.getElementById("game_"+id).style.display = "none";

}

function change_link(date){
 document.getElementById("sche_frm").src = "https://www.mlb.com/scores/"+date;
}

</script>


<? 

//patch
// replace strstr for myStrstrTrue

function get_baseball_games_fix_roof(){
	baseball_db();
	$sql = "SELECT g.*,t.team_name as away,td.team_name as home FROM game g
			inner join  stadium t on g.team_away = t.team_id 
			inner join stadium td on g.team_home = td.team_id 
			WHERE DATE(startdate) >= '2018-01-01' 
      And postponed = 0 and real_roof_open = -1
      and team_home IN (select team_id from stadium where has_roof = 1 )
     ORDER BY startdate ASC";
	return get($sql, "_baseball_game");
}

$games = get_baseball_games_fix_roof();


 if($current_clerk->vars['id'] != 86 ){
	$subject = 'ROOF FIX ACCESS';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
	}
   
?>

</head>
<body>
<? // $page_style = " width:14200px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>


<div class="page_content" style="padding-left:10px; height: 1500px;">
<span class="page_title"Fix Roof Game
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><BR>
<BR>

<br /><br />

<iframe id="changer" width="1" height="1" scrolling="no" frameborder="0"></iframe>

<div  style="float:left">
TOTAL: <? echo count($games)." Games to be fixed<BR><BR>"; ?>
<p style="font-size:12px"> Click on Link and search the game, Search the Box option, </p> 
<p style="font-size:12px">Scroll for the Weather Info, if there said Roof CLose,  </p>
<p style="font-size:12px">Please chose closed in the List Button else choose Open  </p>
<table  id="baseball" name="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
 <thead>
  <tr >
    <th  class="table_header" >Date</th>
    <th  name ="game_info_" width="120" class="table_header">Away
    <th class="table_header">Home</th>
    <th name="stadium_stadistics" width="" class="table_header">Roof</th>
    <th  class="table_header" align="center"></th>
  </tr>
 </thead> 
 <tbody>
<?

 foreach($games as $game){
   
  if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
	$day= date('M-d',strtotime($game->vars["startdate"]));
	$hour= date('H:i',strtotime($game->vars["startdate"]));
	$Hh =  date('H',strtotime($game->vars["startdate"]));
	$date = date('Y-m-d',strtotime($game->vars["startdate"]));
	if($i==1){$date1 = $date;}
	//Weather formulas

	$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	  
	  if ($stadium->vars["has_roof"] == 2 || !$game->vars["roof_open"]) {$weather_style = "_gray";} 
?>	  
     <tr <? if($game->vars["bet"] != "-1") { echo 'class="rowhighlight" '; }?>  id="game_<? echo $game->vars["id"] ?>">
  
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."   ".$hour ?></td> 
          
      <td  name ="game_info_" id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["away_rotation"].") ".$game->vars["away"] ?><BR><BR>
   
      </td>
      
      <td id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<a href="http://localhost:8080/ck/baseball_file/stadium_phones.php?sid=<? echo $stadium->vars["id"]?>" class="normal_link" rel="shadowbox;height=700;width=630"><? echo "(".$game->vars["home_rotation"].") ".$game->vars["home"]?></a>
        <BR><BR>
      </td>

      <? // To control the PK avg excluding games with roof closed
       $roof = true;
	    if ($stadium->vars["has_roof"] == 1) { 
	       if (!$game->vars["roof_open"]){ $roof = false;} 
	    }
	   if ($stadium->vars["has_roof"] == 2) { $roof = false; }
	  ?>
       <td name="stadium_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;" align="table_td<? echo $style.$orweather_style ?>" id="r<? echo $game->vars["id"]?>" >
		   <? if ($stadium->vars["has_roof"] ==1) { ?>
                   <select name="roof" id="<? echo $game->vars["id"]?>" onChange="change_roof_fix(<? echo $game->vars["id"]?>,this.value)" >
				   <option value="">Roof</option>                   
                   <option value="1">Open</option>
                   <option value="0" <? if(!$game->vars["roof_open"]){ ?>selected="selected"<? } ?>>Close</option>
                   </select>
               <? } ?>
      </td>
  <?    
   ?>
   <td   class="table_td<? echo $style ?>" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>">
   <a href="javascript:void(0);" onclick="change_link('<? echo $date ?>');"  class="normal_link">Link</a>
</td>   
     
</tr>  

<? } ?>
   
 <tr>
  <td class="table_last"></td>
  </tr>
  </tbody>
</table>

</div>

<div id="" style="float:right"  >
<iframe id="sche_frm" height="900" src="https://www.mlb.com/scores/<? echo $date1 ?>"></iframe>

</div>
</div>
        
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>
