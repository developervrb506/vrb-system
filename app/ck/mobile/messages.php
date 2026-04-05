<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1;

             maximum-scale=1;

             minimum-scale=1; 

             user-scalable=no;" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Messages</title>
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"title",type:"null", msg:"Subject is required"});
validations.push({id:"content",type:"null", msg:"Content is required"});
</script>
</head>
<body>

<div class="page_content" style="padding:3px;">

<a href="index.php" class="normal_link">&lt;&lt; Back to Main Menu</a><br /><br />



<? include "../includes/print_error.php" ?>

<? $groups = get_all_user_groups(); ?>

<div class="form_box" id="new_message_content">

<span class="page_title">Add New Message</span><br /><br />


<form method="post" action="../process/actions/send_message_action.php" onsubmit="return prevalidate()" enctype="multipart/form-data">
<input name="admin_message" type="hidden" id="admin_message" value="1" />
<input name="mobile" type="hidden" id="mobile" value="1" />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  
  <tr>
    <td>Subject:</td>
    <td><input name="title" type="text" id="title" /></td>
  </tr>
  <tr>
    <td valign="top">Content:</td>
    <td valign="top"><textarea name="content" id="content"></textarea></td>
    </tr>
    
    <tr>
    <td colspan="2">
    
    
    <div id="receivers">
        <? foreach($groups as $group) {?>
        
			<? $clerks = get_all_clerks_by_group($group->vars["id"]) ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;" id="g_<? echo $group->vars["id"] ?>">
              <tr>
                <td class="table_header" align="center"><? echo $group->vars["name"] ?></td>
                <td class="table_header" align="center" width="20">
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
    <td valign="top" colspan="2"><input type="image" src="../../images/temp/submit.jpg" /></td>
    </tr>
    
</table>

</form>
</div>

    
</div>
<br /><br />
<a href="index.php" class="normal_link">&lt;&lt; Back to Main Menu</a>

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