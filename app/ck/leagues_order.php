<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("leagues_order")){ ?>
<?
$date = $_POST["date"];
if($date == ""){$date = $_POST["ndate"];}
if($date == ""){$date = date("Y-m-d");}
$corder = get_leagues_order_by_day($date);
if($_POST["complete"]){
	$inactives = $_POST["inactives"];
	$list = array();
	if($_POST["nfl"] != "ia"){$list[$_POST["nfl"]-1] = "NFL";}
	if($_POST["nba"] != "ia"){$list[$_POST["nba"]-1] = "NBA";}
	if($_POST["nhl"] != "ia"){$list[$_POST["nhl"]-1] = "NHL";}
	if($_POST["mlb"] != "ia"){$list[$_POST["mlb"]-1] = "MLB";}
	if($_POST["ncaaf"] != "ia"){$list[$_POST["ncaaf"]-1] = "NCAAF";}
	if($_POST["ncaab"] != "ia"){$list[$_POST["ncaab"]-1] = "NCAAB";}
	ksort($list);
	$list = implode("-",$list);
	if(is_null($corder)){
		$corder = new _league_order();
		$corder->vars["sdate"] = $_POST["ndate"];
		$corder->vars["list"] = $list;
		$corder->insert();
	}else{
		$corder->vars["sdate"] = $_POST["ndate"];
		$corder->vars["list"] = $list;
		$corder->update();
	}
}
$list = explode("-",$corder->vars["list"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});

	};

	var changing_list;
	function change_order(list){
	  var value_list = list.value;
	  var felements = document.getElementById("flags").elements;
	  for (i=0;i<felements.length;i++){
		  if(felements[i].value == value_list && felements[i].id != list.id){
			  felements[i].selectedIndex = changing_list;
		  }
	  }
	}
</script>
<title>Leagues Order</title>


</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Leagues Order</span><br /><br />

<form id="frm_dates" method="post">
Date: 
<input name="date" type="text" id="date" value="<? echo $date ?>" readonly="readonly" /> &nbsp;&nbsp;<input type="submit" value="Go" /> 

</select>

</form>

<br /><br />
<form method="post" id="flags">
<input name="complete" type="hidden" id="complete" value="1" />
<input name="ndate" type="hidden" id="ndate" value="<? echo $date ?>" />
<div class="form_box">
	<table width="90%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td colspan="9">
        	<strong>Tabs Order for <? echo $date ?></strong>
        </td>
      </tr>
      <tr>
        <td width="50"><select name="nfl" id="nfl" onclick="changing_list = this.selectedIndex;" onchange="if(this.value != 'ia'){change_order(this);}">
          <option value="ia">Inactive</option>
          <option value="1" <? if(is_null($corder)){ ?>selected="selected"<? } ?>>1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          
        </select></td>
        <td width="80"><img src="http://jobs.inspin.com/images/leagues_logos/nfl.jpg" width="64" height="40" /></td>
        <td><label for="checkbox"></label>
          NFL</td>
        <td width="50"><select name="ncaaf" id="ncaaf" onclick="changing_list = this.selectedIndex;" onchange="if(this.value != 'ia'){change_order(this);}">
          <option value="ia">Inactive</option>
          <option value="1">1</option>
          <option value="2" <? if(is_null($corder)){ ?>selected="selected"<? } ?>>2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          
        </select></td>
        <td width="80"><img src="http://jobs.inspin.com/images/leagues_logos/ncaaf.jpg" width="64" height="40" /></td>
        <td>          NCAAF</td>
        <td width="50"><select name="nhl" id="nhl" onclick="changing_list = this.selectedIndex;" onchange="if(this.value != 'ia'){change_order(this);}">
          <option value="ia">Inactive</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3" <? if(is_null($corder)){ ?>selected="selected"<? } ?>>3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          
        </select></td>
        <td width="80"><img src="http://jobs.inspin.com/images/leagues_logos/nhl.jpg" width="64" height="40" /></td>
        <td>          NHL</td>
      </tr>
      <tr>
        <td><select name="mlb" id="mlb" onclick="changing_list = this.selectedIndex;"  onchange="if(this.value != 'ia'){change_order(this);}">
          <option value="ia">Inactive</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4" <? if(is_null($corder)){ ?>selected="selected"<? } ?>>4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          
        </select></td>
        <td><img src="http://jobs.inspin.com/images/leagues_logos/mlb.jpg" width="64" height="40" /></td>
        <td>          MLB</td>
        <td><select name="nba" id="nba" onclick="changing_list = this.selectedIndex;" onchange="if(this.value != 'ia'){change_order(this);}">
          <option value="ia">Inactive</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5" <? if(is_null($corder)){ ?>selected="selected"<? } ?>>5</option>
          <option value="6">6</option>
          
        </select></td>
        <td><img src="http://jobs.inspin.com/images/leagues_logos/nba.jpg" width="64" height="40" /></td>
        <td>          NBA</td>
        <td><select name="ncaab" id="ncaab" onclick="changing_list = this.selectedIndex;" onchange="if(this.value != 'ia'){change_order(this);}">
          <option value="ia">Inactive</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6" <? if(is_null($corder)){ ?>selected="selected"<? } ?>>6</option>
          
        </select></td>
        <td><img src="http://jobs.inspin.com/images/leagues_logos/ncaab.jpg" width="64" height="40" /></td>
        <td>          NCAAB</td>
      </tr>
    </table>
    <br /><br />
	<input name="" type="submit" value="Submit" />
	    
</div>


</form>
</div>
<? if(!is_null($corder)){ ?>
<script type="text/javascript">
<? $position = array_search("NFL",$list); if(!in_array("NFL",$list)){$position = -1;} ?>
load_dropdown('nfl','<? echo $position+1; ?>');
<? $position = array_search("NBA",$list); if(!in_array("NBA",$list)){$position = -1;} ?>
load_dropdown('nba','<? echo $position+1; ?>');
<? $position = array_search("NHL",$list); if(!in_array("NHL",$list)){$position = -1;} ?>
load_dropdown('nhl','<? echo $position+1; ?>');
<? $position = array_search("MLB",$list); if(!in_array("MLB",$list)){$position = -1;} ?>
load_dropdown('mlb','<? echo $position+1; ?>');
<? $position = array_search("NCAAF",$list); if(!in_array("NCAAF",$list)){$position = -1;} ?>
load_dropdown('ncaaf','<? echo $position+1; ?>');
<? $position = array_search("NCAAB",$list); if(!in_array("NCAAB",$list)){$position = -1;} ?>
load_dropdown('ncaab','<? echo $position+1; ?>');
</script>
<? } ?>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>