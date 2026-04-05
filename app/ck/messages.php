<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Messages</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
Shadowbox.init();
var validations = new Array();
validations.push({id:"title",type:"null", msg:"Subject is required"});
validations.push({id:"content",type:"null", msg:"Content is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<?
if(isset($_GET["preview"]) && $current_clerk->admin()){
	$preview = true;
}else if(isset($_GET["name_sort"])){
	$name_sort = true;
}
?>
<div class="page_content" style="padding-left:50px;">

<?
$mdays = $_COOKIE["msgdays"];
$mstitle = $_COOKIE["mstitle"];
if($mdays == ""){$mdays = 0;}
if($mstitle != ""){$mdays = 36500;}
$mdate = date("Y-m-d",strtotime(date("Y-m-d")) - ($mdays * 24 * 60 * 60));
?>

<select name="" onchange="document.cookie = 'msgdays='+this.value+'; path=/'; document.cookie = 'mstitle=; path=/'; location.href = location.href;">
  <option value="0" <? if($mdays == 0){echo 'selected="selected"';} ?>>Today</option>
  <option value="7" <? if($mdays == 7){echo 'selected="selected"';} ?>>Last 7 Days</option>
  <option value="15" <? if($mdays == 15){echo 'selected="selected"';} ?>>Last 2 Weeks</option>
  <option value="30" <? if($mdays == 30){echo 'selected="selected"';} ?>>Last Month</option>
  <option value="90" <? if($mdays == 90){echo 'selected="selected"';} ?>>Last 3 Months</option>
  <option value="36500" <? if($mdays == 36500){echo 'selected="selected"';} ?>>All</option>
</select> 

&nbsp;&nbsp;/&nbsp;&nbsp;

Find: <input name="stitle" type="text" id="stitle" value="<? echo $mstitle ?>" />
<a href="javascript:;" class="normal_link" title="Clean Search" onclick="document.cookie = 'mstitle=; path=/';  location.href = location.href;">x</a>
<input name="" type="button" value="Search" onclick="document.cookie = 'mstitle='+document.getElementById('stitle').value+'; path=/'; document.cookie = 'msgdays=; path=/'; location.href = location.href;" />
<br /><br />
<span class="page_title">Messages</span>

<?
if($name_sort){
	?>&nbsp;&nbsp;&nbsp;<a href="?r" class="normal_link">Sort by Date</a>
<?	
}else{
	?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?name_sort" class="normal_link">Sort by Name</a>
<?
}
?>
<br /><br />

<div style="float:right; margin-top:-30px;">
	<?
	if($preview){
		?><a href="javascript:;" class="normal_link" onclick="window.print();">Print Page</a><?	
	}else{
		?><a href="?preview" class="normal_link">Print Preview</a><?
	}
	?>
</div>

<? include "includes/print_error.php" ?>

<a href="javascript:;" onclick="display_div('new_message_content')" class="normal_link">New Message</a>

<? $groups = get_all_user_groups(); ?>

<div class="form_box" id="new_message_content" style="display:none">
<div style="float:right; width:auto; margin-top:-25px;">
    <a onclick="display_div('new_message_content')" href="javascript:;" class="normal_link">Close</a>
</div>
<form method="post" action="process/actions/send_message_action.php" onsubmit="return prevalidate()" enctype="multipart/form-data">
<input name="admin_message" type="hidden" id="admin_message" value="1" />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>Subject:</td>
    <td><input name="title" type="text" id="title" size="50" /></td>
    <td rowspan="5">
    	<div id="receivers">
        <? foreach($groups as $group) {?>
        
			<? $clerks = get_all_clerks_by_group($group->vars["id"]) ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;" id="g_<? echo $group->vars["id"] ?>">
              <tr>
                <td class="table_header" align="center"><? echo $group->vars["name"] ?></td>
                <td class="table_header" align="center" width="100">
                	Select <input type="checkbox" id="all_sel_<? echo $group->vars["id"] ?>" onclick="mark_all('<? echo $group->vars["id"] ?>');" value="" />
                </td>
              </tr>
              <? foreach($clerks as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
              <tr>
                <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["name"]; ?></td>
                <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
                    <input name="clerk_<? echo $clerk->vars["id"]; ?>" type="checkbox" id="clerk_<? echo $clerk->vars["id"]; ?>" value="1" />
                </td>
              </tr>
              <? } ?>
              <tr>
                <td class="table_last"></td>
                <td class="table_last"></td>
              </tr>
            </table>
        
        <? } ?>
    	</div>
    </td>
  </tr>
  <tr>
    <td valign="top"><a href="javascript:;" class="normal_link" onclick="display_div('attach_new')">Attach File</a></td>
    <td valign="top"><div style="display:none;" id="attach_new"><input name="attachment" type="file" id="attachment" /></div></td>
    </tr>
  <tr>
  <tr>
    <td valign="top">Content:</td>
    <td valign="top"><textarea name="content" cols="50" rows="15" id="content"></textarea></td>
    </tr>
  <tr>
    <td valign="top"><input type="image" src="../images/temp/submit.jpg" /></td>
    <td>&nbsp;</td>
    </tr>
</table>

</form>
</div>

<br /><br />
    
<? include "includes/inbox.php" ?>
    
</div>
<? include "../includes/footer.php" ?>

<script type="text/javascript">
function mark_all(id){
	table = document.getElementById("g_"+id);
	selector = document.getElementById("all_sel_"+id);
	mark = true;
	if(selector.checked == false){mark = false;}
	items = table.getElementsByTagName("input");
	for(var i = 0; i<items.length; i++){
		if(items[i].type == "checkbox"){
			items[i].checked = mark ;
		}
	}
}
function prevalidate(){
	container = document.getElementById("receivers");
	items = container.getElementsByTagName("input");
	count = 0;
	result = true;
	for(var i = 0; i<items.length; i++){
		if(items[i].type == "checkbox"){
			if(items[i].checked){
				count++;
			}
		}
	}
	if(count < 1){
		alert("Please Select an User or a Group");
		result = false;
	}else{result = validate(validations);}		
	return result;
}
</script>