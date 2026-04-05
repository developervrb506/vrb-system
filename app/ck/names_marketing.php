<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
if($_POST["ed"] != ""){
	$name = get_ckname($_POST["ed"]);
	if($name->vars["available"]){$name->vars["available"] = 0;}
	else{$name->vars["available"] = 1;}
	
	$name->update(array("available"));
}
$names_per_page = 100;
$s_available = $_POST["available_list"];
$s_status = $_POST["status_list"];
$s_clerk =  $_POST["clerk_list"];
$s_list =  $_POST["list_list"];
$s_name =  $_POST["name_search"];
$s_lastname =  $_POST["lastname_search"];
$s_email =  $_POST["email_search"];
$s_phone =  $_POST["phone_search"];
$s_acc =  $_POST["acc_search"];
$page_index =  $_POST["page_index"];

//$from = "2012-08-01";

$all_option = true;
$names = array();

$display_clerks = true;
$display_lists = true;
$title = "Search";
$search_action = "?all";

if(isset($_POST["search"])){	
	$names = get_all_cknames($s_list,$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$page_index*$names_per_page,$s_acc,$s_lastname,$from,"added_date DESC");
	$excel = "$s_list,$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$s_acc,$s_lastname";
	$count_names = count_all_cknames($s_list,$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$s_acc,$s_lastname,$from);	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?> Names</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title"><? echo $title ?> Names</span><br /><br />

<? include "includes/print_error.php" ?>

<form action="names_marketing.php<? echo $search_action ?>" method="post" id="form_search">
<input name="page_index" type="hidden" id="page_index" value="<? echo $page_index ?>" />
<input name="search" type="hidden" id="search" value="1" />
<input name="ed" type="hidden" id="ed" value="" />
<input name="list_list" type="hidden" id="list_list" value="" />


<br /><br />
Name:
<input name="name_search" type="text" id="name_search" value="<? echo $s_name ?>" />
&nbsp;&nbsp;&nbsp;
Last Name:
<input name="lastname_search" type="text" id="lastname_search" value="<? echo $s_lastname ?>" />
&nbsp;&nbsp;&nbsp;
Email:
<input name="email_search" type="text" id="email_search" value="<? echo $s_email ?>" />
&nbsp;&nbsp;&nbsp;
<br /><br />
Phone:
<input name="phone_search" type="text" id="phone_search" value="<? echo $s_phone ?>" />
&nbsp;&nbsp;&nbsp;
Account #:
<input name="acc_search" type="text" id="acc_search" value="<? echo $s_acc ?>" />
&nbsp;&nbsp;&nbsp;

<input name="" type="submit" value="Filter" onclick="document.getElementById('page_index').value = '0';" />
</form>
<br /><br />
<? if($current_clerk->vars["level"]->vars["is_admin"]){ ?>
<!--<div align="right"><a href="export.php?v=<? echo $excel ?>" target="_blank" class="normal_link">Export Names</a></div>-->
<? } ?>
<? echo $count_names["num"]." Names Found" ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<? if($display_lists){ ?><td class="table_header" align="center">Affiliate</td><? } ?>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Last Name</td>
    <td class="table_header" align="center">Email</td>
    <td class="table_header" align="center">Phone</td>
    <td class="table_header" align="center">Enable</td>
    <? if($display_clerks){ ?><td class="table_header" align="center">Clerk</td><? } ?>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Added</td>
    <td class="table_header" align="center">Calls</td>
    <td class="table_header" align="center">View</td>
  </tr>
  <? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";} $i++;?>
  
  <tr>
  	<? if($display_lists){ ?>
  	<td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo "<strong>".$name->vars["aff_id"]."</strong>"; ?>
    </td>
    <? } ?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["last_name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? 
		echo $name->vars["phone"];
		if($name->vars["phone2"] != ""){
			echo "<br />".$name->vars["phone2"];
		}
		?>
    </td>
    
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? //if(!$name->vars["available"]){echo "<strong>";} ?>
		<a href="javascript:;" onclick="ed('<? echo $name->vars["id"]; ?>');" class="normal_link"><? echo $name->print_status(); ?></a>
        <? //if(!$name->vars["available"]){echo "</strong>";} ?>
    </td>
    <? if($display_clerks){ ?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? 
		if(is_null($name->vars["clerk"])){
			echo "Free";
		}else{
			echo "<strong>".$name->vars["clerk"]->vars["name"]."</strong>";
		}
		?>
    </td>
    <? } ?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo $name->vars["status"]->vars["name"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo date("Y-m-d",strtotime($name->vars["added_date"])); ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a href="calls.php?nid=<? echo $name->vars["id"] ?>" target="_blank" class="normal_link">Calls</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a href="edit_name.php?nid=<? echo $name->vars["id"] ?>" target="_blank" class="normal_link">View</a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>
<br /><br />
<?
$num_pages = ceil($count_names["num"] / $names_per_page);
for($i=0;$i<$num_pages;$i++){
	if($i == $page_index){echo $i + 1 ."&nbsp;&nbsp;-&nbsp;&nbsp;";}
	else{
		?>
		<a onclick="change_index('<? echo $i ?>')" href="javascript:;" class="normal_link"><? echo $i + 1 ?></a>&nbsp;&nbsp;-&nbsp;&nbsp;
		<?
	}
}
?>
<script type="text/javascript">
function change_index(index){
	document.getElementById("page_index").value = index;
	document.getElementById("form_search").submit();
}
function ed(id){
	document.getElementById("ed").value = id;
	document.getElementById("form_search").submit();
	//alert(document.getElementById("ed").value);
}
</script>
</div>
<? include "../includes/footer.php" ?>