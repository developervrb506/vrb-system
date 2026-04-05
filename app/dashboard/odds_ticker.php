<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$book = get_sportsbook($_GET["book"]);

if($book->id == 1){$promoid = "1562";}
else if($book->id == 3){$promoid = "1563";}
else if($book->id == 7){$promoid = "1972";}

if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Live Odds Widget</title>
<script type="text/javascript" src="http://jobs.inspin.com/includes/js/encrypt.js"></script>
</head>
<script type="text/javascript">
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
function get_leagues(){
	
}
function is_number(input){return (input - 0) == input && input.length > 0;}
function generate_code(){
	var wiframe = document.getElementById("ipreview");
	
	
	var wurl = "http://localhost:8080/widgets/odds_widget.php?ticker";	
	wurl += "&ls=" + get_tabs_widget();
	wurl += "&b=<? echo $book->id ?>";
	
	wiframe.src = wurl;
	
	code = '<iframe id="ipreview" frameborder="0" width="672" height="136"';
	code += 'src="'+wurl+'&af=<? echo $current_affiliate->id ?>&pid=<? echo $promoid ?>" scrolling="no">';
	code += '</iframe>';
	code += '';
	
	document.getElementById("code_field").value = "<!--VRB Widget-->\n"+code+"\n<!--VRB Widget-->";
}
function copy_code(field){
	field.focus();
	field.select();
}
function get_tabs_widget(){
	var tabs = "";
	var felements = document.getElementById("flags").elements;
	for (i=0;i<felements.length;i++){
		if(felements[i].type == "select-one"){
			if(document.getElementById("select_nfl").selectedIndex == i){
				tabs = tabs + "-NFL";
			}else if(document.getElementById("select_nba").selectedIndex == i){
				tabs = tabs + "-NBA";
			}else if(document.getElementById("select_nhl").selectedIndex == i){
				tabs = tabs + "-NHL";
			}else if(document.getElementById("select_mlb").selectedIndex == i){
				tabs = tabs + "-MLB";
			}else if(document.getElementById("select_ncaaf").selectedIndex == i){
				tabs = tabs + "-NCAAF";
			}else if(document.getElementById("select_ncaab").selectedIndex == i){
				tabs = tabs + "-NCAAB";
			}else if(document.getElementById("select_boxing").selectedIndex == i){
				tabs = tabs + "-BOXING";
			}else if(document.getElementById("select_mma").selectedIndex == i){
				tabs = tabs + "-MMA";
			}
		}
	}
	return tabs.substring(1);
}
</script>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>

<div class="page_content">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title">Live Odds Ticker</span><br /><br />

<? if($promoid != ""){ ?>

<div style="float:none;" class="gray_box">
<form id="flags">
<table width="90%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="9"><strong>Select Tabs Order (#1 is shown by default) - PID = <? echo $promoid ?></strong></td>
  </tr>
  <tr>
    <td width="50"><select name="nfl" id="select_nfl" onclick="changing_list = this.selectedIndex;" onchange="change_order(this);">
      <option value="1" selected="selected">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
    </select></td>
    <td width="80"><img src="http://jobs.inspin.com/images/leagues_logos/nfl.jpg" width="64" height="40" /></td>
    <td>NFL</td>
    <td width="50"><select name="ncaaf" id="select_ncaaf" onclick="changing_list = this.selectedIndex;" onchange="change_order(this);">
      <option value="1">1</option>
      <option value="2" selected="selected">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
    </select></td>
    <td width="80"><img src="http://jobs.inspin.com/images/leagues_logos/ncaaf.jpg" width="64" height="40" /></td>
    <td>NCAAF</td>
    <td width="50"><select name="nhl" id="select_nhl" onclick="changing_list = this.selectedIndex;" onchange="change_order(this);">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3" selected="selected">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
    </select></td>
    <td width="80"><img src="http://jobs.inspin.com/images/leagues_logos/nhl.jpg" width="64" height="40" /></td>
    <td>NHL</td>
  </tr>
  <tr>
    <td><select name="mlb" id="select_mlb" onclick="changing_list = this.selectedIndex;"  onchange="change_order(this);">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4" selected="selected">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
    </select></td>
    <td><img src="http://jobs.inspin.com/images/leagues_logos/mlb.jpg" width="64" height="40" /></td>
    <td>MLB</td>
    <td><select name="nba" id="select_nba" onclick="changing_list = this.selectedIndex;" onchange="change_order(this);">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5" selected>5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
    </select></td>
    <td><img src="http://jobs.inspin.com/images/leagues_logos/nba.jpg" width="64" height="40" /></td>
    <td>NBA</td>
    <td><select name="ncaab" id="select_ncaab" onclick="changing_list = this.selectedIndex;" onchange="change_order(this);">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6" selected>6</option>
      <option value="7">7</option>
      <option value="8">8</option>
    </select></td>
    <td><img src="http://jobs.inspin.com/images/leagues_logos/ncaab.jpg" width="64" height="40" /></td>
    <td>NCAAB</td>
  </tr>
  <tr>
    <td><select name="boxing" id="select_boxing" onclick="changing_list = this.selectedIndex;"  onchange="change_order(this);">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7" selected="selected">7</option>
      <option value="8">8</option>
    </select></td>
    <td>Boxing</td>
    <td>&nbsp;</td>
    <td><select name="mma" id="select_mma" onclick="changing_list = this.selectedIndex;" onchange="change_order(this);">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8" selected="selected">8</option>
    </select></td>
    <td>MMA</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>


<div style="float:none;" class="gray_box">
	<strong>Preview</strong><br />
    <iframe id="ipreview" frameborder="0" width="672" height="136" src="http://localhost:8080/widgets/odds_widget.php?ticker&b=<? echo $book->id ?>&ls=NFL-NCAAF-NHL-MLB-NBA-NCAAB-BOXING-MMA" scrolling="no"></iframe>
    
    <br /><br />
    <strong>Code</strong><br />
    <textarea name="code_field" cols="40" rows="10" readonly="readonly" id="code_field" onclick="copy_code(this)"></textarea><br />
    <input type="button" value="Generate Code" onclick="generate_code()" />
                
</div>
<? }else{echo "No ". $book->name . " Ticker Available";} ?>
</div>
<? include "../includes/footer.php" ?>