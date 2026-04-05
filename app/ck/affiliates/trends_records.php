<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size:13px;
	color: #333;
	background:#CCC;
}
</style>
<?
$league = $_GET["le"];

$trends = get_trends_league($league);
					   
$wins = 0;
$loss = 0;
$push = 0;
$units = 0;
				  
foreach ($trends as $trends_feed_info)  {
	$win  = $trends_feed_info['win'];
	$juice = $trends_feed_info['juice'];
	if($juice == ""){$juice = 0;}
	if($win == "W"){
		$wins ++;
		$units += ($juice / 100);
	}else if($win == "L"){
		$loss ++;
		$units -= ($juice / 100);
	}else if($win == "P"){
		$push ++;
	}
}
if($wins + $loss > 0){
	$percentage =   ($wins * 100) / ($loss + $wins);
	$percentage = round($percentage,2);
	$record = "SU: $wins-$loss-$push ($percentage%) Units: $units";
}else{
	$record = "SU: 0-0-$push (0%) Units: 0";
}

$league_array = array("-1","NFL","NBA","NHL","MLB","NCAAB","NCAAF");

?>

<select name="" onchange="location.href = '?le=' + this.value;">
	<? foreach($league_array as $le){ ?>
    	<option <? if($le == $league){echo ' selected="selected" ';} ?> value="<? echo $le ?>"><? if($le == "-1"){echo "Global";}else{echo $le;} ?> Records</option>
    <? } ?>
</select>:&nbsp;&nbsp;&nbsp;

<? echo $record ?>
<? } else { echo "ACCESS DENIED"; }?>