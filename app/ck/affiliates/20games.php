<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Special trends</title>
  <link rel="stylesheet" type="text/css" media="all" href="http://localhost:8080/includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
  <script type="text/javascript" src="http://localhost:8080/includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
      window.onload = function(){
          new JsDatePick({
              useMode:2,
              target:"from_date",
              dateFormat:"%Y-%m-%d"
          });
          new JsDatePick({
              useMode:2,
              target:"to_date",
              dateFormat:"%Y-%m-%d"
          });
      };
  </script>
<script type="text/javascript">
function redirect(){
	games = document.getElementById("games_min").value;
	perc =  document.getElementById("perc_min").value;
	league = document.getElementById("league_list").value;
	from = document.getElementById("from_date").value;
	to = document.getElementById("to_date").value;
	
	sel = 0;
	selection = document.getElementById("show_sel");
	if(selection.checked){sel = selection.value;}
	
	if(games != "" && perc != ""){
		location.href = "http://localhost:8080/ck/affiliates/20games.php?p=" + perc + "&g=" + games + "&l=" + league + "&fd=" + from + "&td=" + to + "&sel=" + sel;	
	}else{
		alert("Write the percentage and the games");
	}
}
function change_selected(ddlID, value, change){
	var ddl = document.getElementById(ddlID);
	for (var i = 0; i < ddl.options.length; i++) {
		if (ddl.options[i].value == value) {
			if (ddl.selectedIndex != i) {
				ddl.selectedIndex = i;
				if (change)
					ddl.onchange();
			}
		   break;
	   }
   }
}
</script>
</head>
<?

if(isset($_POST["ids"])){
	$t_ids = explode("-",$_POST["ids"]);
	foreach($t_ids as $chk_id){
		$juice = $_POST["juice_" . $chk_id];
		$win = $_POST["win_" . $chk_id];
		$trend = get_trends_feeds_by_id($chk_id);
		
		if($juice != "" && $juice != 0 && is_numeric($juice)){
			
			$trend->vars["selected"] = 0;
			$trend->vars["win"] = $win;
			$trend->vars["juice"] = $juice;
			$trend->update(array("selected","win","juice"));
		}else{
			$trend->vars["selected"] = $_POST["chk_" . $chk_id];
			$trend->update(array("selected"));
			
		}
   
	}
	?><script type="text/javascript">alert("Selection Saved");</script><?
}

?>

<body>
<?
$perc_get = $_GET["p"];
$games_get = $_GET["g"];
$league_get = $_GET["l"];
$from_date = $_GET["fd"];
$to_date = $_GET["td"];
$show_selected = $_GET["sel"];
if(!isset($perc_get)){$perc_get = "80";}
if(!isset($games_get)){$games_get = "20";}
if(!isset($league_get)){$league_get = "NBA";}

?>
<? if (isset($_GET['message'])) : ?>
<div id="message" class="updated fade"><p><? echo $messages[$_GET['message']]; ?></p></div>
<? endif; ?>
 <? $page_style = " width:1400px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Special Trends</span><br /><br />

<iframe src="trends_records.php" frameborder="0" width="400" height="40"></iframe>


<br />
<select id="league_list">
  <option value="all">All</option>
  <option value="NBA">NBA</option>
  <option value="NFL">NFL</option>
  <option value="NHL">NHL</option>
  <option value="MLB">MLB</option>
  <option value="NCAAB">NCAAB</option>
  <option value="NCAAF">NCAAF</option>
</select>
<script type="text/javascript">change_selected("league_list","<? echo $league_get; ?>",false)</script>
Percentage: 
<input id="perc_min" type="text" value="<? echo $perc_get; ?>" />
Games:
<input id="games_min" type="text" value="<? echo $games_get; ?>" />
From:
<input name="from_date" id="from_date" size="15" value="<? echo $from_date; ?>" />

To:
<input name="to_date" id="to_date" size="15" value="<? echo $to_date; ?>" />

Selected Ones: <input name="show_sel" type="checkbox" id="show_sel" value="1" <? if($_GET["sel"]){echo ' checked="checked" ';} ?> />&nbsp;&nbsp;&nbsp;
<a href="javascript:;" onclick="redirect();">Check</a><br /><br />

<form method="post" action="20games.php?p=<? echo $perc_get ?>&g=<? echo $games_get ?>&l=<? echo $league_get ?>&fd=<? echo $from_date ?>&td=<? echo $to_date ?>&sel=<? echo $show_selected ?>">
<div style="text-align:right">
	<input type="submit" value="Save Trends" />
</div>

<?
$ids = "";
$display_block = "
<table class=\"sortable\" id=\"sort_table\" style=\"cursor:pointer;\">
	<thead>
	<tr>		
		<th class=\"table_header\" scope=\"col\" style=\"text-align: center\">ID</th>".	
		"<th class=\"table_header\" scope=\"col\" >Date</th>".
		"<th class=\"table_header\" scope=\"col\" >Away</th>".
		"<th class=\"table_header\" scope=\"col\" >Home</th>".	
		"<th class=\"table_header\" scope=\"col\" >Trend</th>".
		"<th class=\"table_header\" scope=\"col\" style=\"text-align: center\">Win %</th>".
		"<th class=\"table_header\" scope=\"col\" style=\"text-align: center\">Games</th>".
		"<th class=\"table_header\" scope=\"col\" style=\"text-align: center\" class=\"sorttable_nosort\">Selected</th>".
		"<th class=\"table_header\" scope=\"col\" style=\"text-align: center\" class=\"sorttable_nosort\">Grade</th>
	</tr>
	</thead>
  <tbody id=\"the-list\">";
  
  $Limit = 30; //Number of results per page 
  
  $pagenum =  $_GET["pagenum"]; 
  
  if($pagenum == "") $pagenum=1; //If no page number is set, the default page is 1  					 
  //create the display string
  $trends_feed_res = get_all_trends_feeds($perc_get,$games_get,$from_date,$to_date,$league_get,$show_selected);
  
   $NumberOfResults = count($trends_feed_res);
  //Get the number of pages
  $NumberOfPages=ceil($NumberOfResults/$Limit);
  
  if ($NumberOfResults > 0) { 
     
	
	$trends_feed_data = get_all_trends_feeds($perc_get,$games_get,$from_date,$to_date,$league_get,$show_selected, true,$pagenum,$Limit);
	 $count = 0;
					
     foreach ($trends_feed_data as $trends_feed_info) {
       ++ $count;
	   if ( $count % 2 )
			$style = 'alternate';
	   else
			$style = '';	   		
           
	   $id           = $trends_feed_info->vars['id'];
	   $description  = $trends_feed_info->vars['description'];	
	   $perc      = $trends_feed_info->vars['win_percentage'];
	   $games = $trends_feed_info->vars['total'];
	   $team_away = $trends_feed_info->vars['team_away'];
	   $team_home = $trends_feed_info->vars['team_home'];
	   $trend_date = $trends_feed_info->vars['game_date'];
	   $selected = $trends_feed_info->vars['selected'];
	   $juice = $trends_feed_info->vars['juice'];
	   if($juice == "0"){$juice = "";}
	   $win = $trends_feed_info->vars['win'];
	   if($selected){$sel_flag = ' checked="checked" ';}else{$sel_flag = "";}
	   $ids .= "-".$id;
	   $win_list = array("Win","Loss","Push");
	   
	   $display_block .= "	   
	   <tr class='$style'>         
		 <td class=\"table_td1\" valign=\"top\">".$id."</td>
		 <td class=\"table_td1\" valign=\"top\">".$trend_date."</td>
		 <td class=\"table_td1\" valign=\"top\">".$team_away."</td>
		 <td class=\"table_td1\" valign=\"top\">".$team_home."</td>   	     
		 <td class=\"table_td1\" valign=\"top\">".$description."</td>
		 <td class=\"table_td1\" valign=\"top\" align=\"center\">".$perc."</td>
		 <td class=\"table_td1\" valign=\"top\" align=\"center\">".$games."</td>
		 <td class=\"table_td1\" valign=\"top\" align=\"center\"><input name='chk_".$id."' id='chk_".$id."' type='checkbox' value='1' ". $sel_flag ." /></td>
		 <td class=\"table_td1\" valign=\"top\" align=\"center\">
		 	<input name='juice_".$id."' type='text' id='juice_".$id."' size='5' value='".$juice."' /><br />
			<select name='win_".$id."' id='win_".$id."'>";
			  
			  foreach($win_list as $wl){
				$first = substr($wl,0,1);
				if($first == $win){$sel_win = ' selected="selected" ';}else{$sel_win = "";}
			  	$display_block .= "<option ".$sel_win." value='" .$first. "'>".$wl."</option>";
			  }
			  
$display_block .= "
		    </select>
		 </td>
	   </tr>";
   
       		  
     }	

     $display_block .= "</tbody></table>";	
	 echo $display_block;
	 
	 ?>
   <div style="text-align:right">
     	<input type="submit" value="Save Trends" />
       <input name="ids" type="hidden" id="ids" value="<? echo substr($ids,1) ?>" />
     </div>
     </form>
  <?
		 
     $Nav = "";
  		
     If($pagenum > 1) {
        $Nav .= "&nbsp;&nbsp;<A HREF=\"?p=". $perc_get ."&g=". $games_get ."&l=". $league_get ."&fd=$from_date&td=$to_date&sel=$show_selected&pagenum=".($pagenum-1)."\">&lt;&lt;Prev</A>&nbsp;&nbsp;";
     }
	
     For($i = 1 ; $i <= $NumberOfPages ; $i++) {
	
       If($i == $pagenum) {
          $Nav .= "<B>$i</B>";
       }	   
	   Else {
          $Nav .= "&nbsp;&nbsp;<A HREF=\"?p=". $perc_get ."&g=". $games_get ."&l=". $league_get ."&fd=$from_date&td=$to_date&sel=$show_selected&pagenum=".$i."\">$i</A>&nbsp;&nbsp;";
       }
     }
	
     If($pagenum < $NumberOfPages) {
        $Nav .= "&nbsp;&nbsp;<A HREF=\"?p=". $perc_get ."&g=". $games_get ."&l=". $league_get ."&fd=$from_date&td=$to_date&sel=$show_selected&pagenum=".($pagenum+1)."\">&nbsp;Next&gt;&gt;</A>&nbsp;&nbsp;";
     }
	 
     echo "<BR>";
	 ?><div style="text-align:center; word-wrap:break-word;"><? echo $Nav; ?></div><?   
  }else{echo "No Trends Found";}
?>




</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>