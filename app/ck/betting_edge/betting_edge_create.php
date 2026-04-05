<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("betting_edge_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="http://localhost:8080/includes/calendar/jsDatePick_ltr.min.css" />
<title>The Betting Edge</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.3.min.js"> </script>
<script type="text/javascript" src="http://localhost:8080/includes/calendar/jsDatePick.min.1.3.js"></script>
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
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<?
$hours = get_all_hours();
$minutes = get_all_minutes();

$update = false;
if (isset($_GET["id"])){
	$update = true;
	$bet = get_external_bet($_GET["id"]);
}
?>
<span class="page_title"><? if($update) { echo "Edit ";} else { echo "Add New ";}?>Betting Edge</span><br /><br />
<?
 include "../includes/print_error.php";
?>


<form action="../process/actions/insert_betting_edge_action.php" method="post">
	<? if ($update){ ?>
    	<input id="update" type="hidden" name="update" value="<? echo $bet->vars["id"] ?>">
    <? } ?>
   
    <? 
     $time_open = date("g:i:A", strtotime($bet->vars["game_date"]));
     $oparts = explode(":",$time_open); 
     
     if (!$update){
      $date_start = date("Y-m-d");
	 
     }
     else{
      $date_start = date("Y-m-d", strtotime($bet->vars["game_date"]));
     
     }	 
    ?>
    <div class="form_box" style="width:50%" align="center">
    <strong>Start Time:</strong>&nbsp;&nbsp; 
    <input id="from" type="text" name="from" value="<? echo $date_start ?>" readonly="readonly">
    <select name="start_hour">
    <? foreach ($hours as $hour){ ?>
    <option <? if ($hour== $oparts[0]){ echo "selected"; } ?>  value="<? echo $hour?>" ><? echo $hour ?> </option>
    <? } ?>
    </select> : 
    <select  name="start_minute">
    <? foreach ($minutes as $minute){ ?>
    <option <? if ($minute== $oparts[1]){ echo "selected"; } ?> value="<? echo $minute?>" ><? echo $minute ?> </option>
    <? }  ?>
    </select>
    <select  name="start_data" >
    <option <? if ($oparts[2] == "AM"){ echo "selected"; } ?> value="AM" >AM</option>
    <option <? if ($oparts[2] == "PM" ){ echo "selected"; } ?> value="PM" >PM</option> 
    </select>
     <BR><BR>
     <strong>Home Team</strong>&nbsp;&nbsp; 
     <input required="required" id="home" name="home"  type="text" value="<? echo $bet->vars["home"]?>">
     <BR><BR>
      <strong>Away Team</strong>&nbsp;&nbsp; 
     <input required="required" id="away" name="away"  type="text" value="<? echo $bet->vars["away"]?>">
     <BR><BR>
     <strong>League:</strong>&nbsp;&nbsp; 
     <input  required="required" id="league" name="league" type="text" value="<? echo $bet->vars["league"]?>">
     <BR><BR>
     <strong>Period:</strong>&nbsp;&nbsp; 
     <input required="required" id="period" name="period" type="text" value="<? echo $bet->vars["period"]?>">
     <BR><BR>
     <strong>Bet Type:</strong>&nbsp;&nbsp; 
     <input required="required" id="type" name="type" type="text" value="<? echo $bet->vars["bet_type"]?>">
     <BR><BR>
     <strong>Line:</strong>&nbsp;&nbsp; 
     <input required="required" id="line" name="line" type="text" value="<? echo $bet->vars["line"]?>">
     <BR><BR>
     <strong>Risk:</strong>&nbsp;&nbsp; 
     <input required="required" id="risk" name="risk" type="text" value="<? echo $bet->vars["risk"]?>">
      <BR><BR>
      <strong>Win:</strong>&nbsp;&nbsp; 
     <input  required="required" id="win" name="win" type="text" value="<? echo $bet->vars["win"]?>">
      <BR><BR>       
   
    <input required="required" id="btn" style="width: 120px;" type="submit" value="Save" />

   </form>
   </div>



</div>
<? include "../../includes/footer.php" ?>

<? } else { echo "ACCESS DENIED"; } ?>