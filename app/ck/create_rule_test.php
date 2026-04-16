<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
if(isset($_GET["rid"])){
	$update = true;
	$rule = get_rule($_GET["rid"]);
	$title = "Edit " . $rule->vars["title"];
}else{
	$update = false;
	$title = "Create New Rule";
}
$groups = get_all_user_groups();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?></title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"title",type:"null", msg:"Title is required"});
validations.push({id:"content",type:"null", msg:"Content is required"});
</script>
<script type="text/javascript">
function check_all(group,cant){
 var checks = document.getElementsByClassName("box_"+group);
 for (x=0;x<cant;x++){
   if (checks[x].checked == true){     
	checks[x].checked = false;
   }
   else{
	checks[x].checked = true;   
   }
 }
}

function colapse(id){

var href = document.getElementById(id);
 
  if (href.innerHTML == "+" ){
	  href.innerHTML = "-"
  }
  else{
	  href.innerHTML = "+"
  }
}
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:750px;">
	<form method="post" action="process/actions/create_rule_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $rule->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Title</td>
        <td><input name="title" type="text" id="title" value="<? echo $rule->vars["title"] ?>" /></td>
      </tr>
      <tr>
        <td>Content</td>
        <td><textarea name="content" cols="60" rows="10" id="content"><? echo $rule->vars["content"] ?></textarea></td>
      </tr>      
      <tr>
       <td> Groups</td>
       <td>  
          <? $i =0; 
		  foreach ($groups as $group) { ?>
           <BR />
            <? $clerks = get_all_clerks_by_group($group->vars["id"]); ?>
           <input  type="checkbox"  checked="checked" onclick="javascript:check_all('<? echo $group->vars["id"] ?>','<? echo count($clerks)?>')" /> <? echo $group->vars["name"]?>&nbsp;&nbsp;<a id="extend_<? echo $group->vars["id"] ?>" href="javascript:display_div('div_'+<? echo $group->vars["id"]?>)" onclick="colapse('extend_'+<? echo $group->vars["id"] ?>);" class="normal_link" title="See all clerks for this group" >+</a>
          
            <div id="div_<? echo $group->vars["id"]?>" style="display:none" >  
             <? foreach ($clerks as $_clerk){ $i++; ?>
              &nbsp;&nbsp;<input class="box_<? echo $group->vars["id"] ?>" name="clerk_<? echo $i ?>" value="<? echo $_clerk->vars["id"] ?>" id="clerk_<? echo $group->vars["id"] ?>" checked="checked" type="checkbox"  /> <? echo $_clerk->vars["name"] ?><BR>
            <? } ?>
            </div>
          <? } ?>
          <input type="hidden" name="total_clerks" value="<? echo $i ?>" />
       </td>
    
      </tr>
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>