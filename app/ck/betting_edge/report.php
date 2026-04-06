<? 
$no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>AGENT Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>

<? 

$from = clean_get("from");
$to =  clean_get("to");
$league =  clean_get("league");

if($from == ""){
  $from = "2024-01-01"; $to = "2024-12-01";
}


?>

<div class="page_content" style="padding-left:10px;">
<span class="page_title">AGENT REPORT
</span><br /><br />

<table >
<tr>
 <td >
<form method="post">
    <BR/> 
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
    &nbsp;&nbsp;&nbsp;&nbsp;
    League:
    <select name="league" >
      <option <? if($league == 'MLB'){ echo ' selected="selected" ';}?> value="MLB">MLB</option>
      <option <? if($league == 'NBA'){ echo ' selected="selected" ';}?>value="NBA">NBA</option>
      <option <? if($league == 'NHL'){ echo ' selected="selected" ';}?>value="NHL">NHL</option>
      <option <? if($league == 'NFL'){ echo ' selected="selected" ';}?>value="NFL">NFL</option>                  
      <option <? if($league == 'NCAAF'){ echo ' selected="selected" ';}?>value="NCAAF">NCAAF</option>                  
      <option <? if($league == 'NCAAB'){ echo ' selected="selected" ';}?>value="NCAAB">NCAAB</option>                              
    </select>
    
    &nbsp;&nbsp;&nbsp;&nbsp; 
   <input type="submit" value="Search" />
 </td>
 </tr>
 </table>
 <? if (isset($_POST["league"])) { 
   
   $league = $_POST["league"];
   $win = get_special_query_data($league,$from,$to,"w");

   $l = get_special_query_data($league,$from,$to,"l");   

 ?><br /><br />
   <table width="40%" border="0" cellspacing="0" cellpadding="0" class="sortable">
     <thead>
   <tr>
			 <th class="table_header" align="center" style="cursor:pointer;">AGENT</th>
			 <th class="table_header" align="center" style="cursor:pointer;">WIN</th>
			 <th class="table_header" align="center" style="cursor:pointer;">LOST</th>             
			 <th class="table_header" align="center" style="cursor:pointer;">TOTAL</th>
			 <th class="table_header" align="center" style="cursor:pointer;">LAST BET</th>
  </tr>
    </thead>
  <tbody>
   <? $i=0;
    foreach( $win as $w){
      if($i % 2){$style = "1";}else{$style = "2";} $i++;
			 
			   $t_win = number_format($w["value"],2);
			   $t_lost =  number_format($l[$w["name"]]["value"],2);
			   $t_total = number_format($w["value"] - $l[$w["name"]]["value"],2);
			   if($t_total > 0){ $color = "green"; }else{$color = "red";}
			 
			  ?>
			  <tr>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;" align="center"><strong><? echo $w["name"] ?></strong></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px; color:green;">$<? echo $t_win ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px; color:red;">-$<? echo $t_lost ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px; background-color: <? echo $color?>;">$<? echo $t_total ?></td>                             
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"  align="center"><? echo $w["lastbet"] ?></td>                                           
 
     </tr>
 
   <? } ?>
   </tbody>
 </table>
 <? } ?>
 
 
 </body>
 
 <?
 function get_special_query_data($league,$from,$to,$action){

	sbo_sports_db();
	$sql = "select id from sports.games g where g.league = '".strtolower($league)."' and startdate >= '".$from."' and startdate <= '".$to."' ";
    $games = get_str($sql);
	$str_games = "";
	if(count($games)>0){ 
	  foreach($games as $g){
		    $str_games .= $g["id"].",";
		  
		  }
	    $str_games .= substr($str_games,0,-1);
	 
	}
	  

    betting_db();	
	if($action == 'w'){
	$sql = "select b.account , acc.name,  SUM(win) as 'value' , max(bdate) as 'lastbet'
from bet b , account acc 
WHERE  b.account = acc.id AND
b.gameid IN ($str_games)  and b.status = 'w' 
GROUP BY b.account order by SUM(win) DESC";
	}
	if($action == 'l'){
    	$sql = "select b.account , acc.name,  SUM(risk) as 'value' , max(bdate) as 'lastbet'
from bet b , account acc 
WHERE  b.account = acc.id AND
b.gameid IN ($str_games)  and b.status = 'l' 
GROUP BY b.account order by SUM(risk) DESC";
	}
	//$sql = "select * from bet limit 5";

	
	return get_str($sql,false,'name');
}


 
 
 ?>
 