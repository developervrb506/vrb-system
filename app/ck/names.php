<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
  if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin") && !$current_clerk->im_allow("john_list_control") && !  $current_clerk->im_allow("phone_names") && !$current_clerk->im_allow("users")){
  include(ROOT_PATH . "/ck/process/admin_security.php");
  }
  
$jlists = explode(",",str_replace(" ","",$gsettings["johns_lists_ids"]->vars["value"]));
if(!$current_clerk->im_allow("john_list_control") || in_array($_GET["lid"],$jlists)){

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
$all_option = true;
$names = array();

$display_clerks = true;
$display_lists = true;
$title = "Search";
$search_action = "?all";

if(isset($_GET["lid"])){
	$display_clerks = true;
	$display_lists = false;
	$list = get_names_list($_GET["lid"]);
	$names = get_all_cknames($list->vars["id"],$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$page_index*$names_per_page,$s_acc,$s_lastname);
	$excel = $list->vars["id"].",$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$s_acc,$s_lastname";
	$count_names = count_all_cknames($list->vars["id"],$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$s_acc,$s_lastname);
	$title = $list->vars["name"];
	$search_action = "?lid=".$list->vars["id"];
}else if(isset($_GET["cid"])){
	$display_clerks = false;
	$display_lists = true;
	$clerk = get_clerk($_GET["cid"]);
	$names = get_all_cknames($s_list,$s_available,$s_status,$clerk->vars["id"],$s_name,$s_email,$s_phone,$page_index*$names_per_page,$s_acc,$s_lastname);
	$excel = "$s_list,$s_available,$s_status,".$clerk->vars["id"].",$s_name,$s_email,$s_phone,$s_acc,$s_lastname";
	$count_names = count_all_cknames($s_list,$s_available,$s_status,$clerk->vars["id"],$s_name,$s_email,$s_phone,$s_acc,$s_lastname);
	$title = $clerk->vars["name"];
	$search_action = "?cid=".$clerk->vars["id"];
}else if(isset($_POST["search"])){	
	$names = get_all_cknames($s_list,$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$page_index*$names_per_page,$s_acc,$s_lastname);
	$excel = "$s_list,$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$s_acc,$s_lastname";
	$count_names = count_all_cknames($s_list,$s_available,$s_status,$s_clerk,$s_name,$s_email,$s_phone,$s_acc,$s_lastname);	
}

$phone = array();
foreach ($names as $name){
$phone[] = $name->vars["phone"];	
}
 //Lines commented by Andy Hines on 07/18/2024 because it points to mysql phone db (pbx) that doesn't exist anymore and it the system was showing a database connection error.
 
 //$clerk_call_src = get_call_name_by_src_phone($phone);
 //$clerk_call_dst = get_call_name_by_dst_phone($phone);



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

<form action="names.php<? echo $search_action ?>" method="post" id="form_search">
<input name="page_index" type="hidden" id="page_index" value="<? echo $page_index ?>" />
<input name="search" type="hidden" id="search" value="1" />
<input name="ed" type="hidden" id="ed" value="" />
<? if($display_lists){ ?>
List:
<? include "includes/lists_list.php" ?>
&nbsp;&nbsp;&nbsp;
<? } ?>

Available:
<? include "includes/available_list.php" ?>
&nbsp;&nbsp;&nbsp;

Status:
<? include "includes/status_list.php" ?>
&nbsp;&nbsp;&nbsp;

<? if($display_clerks){ ?>
Clerk:
<? $clerks_admin = "2,4,5"; $free_option = true; include "includes/clerks_list.php" ?>
&nbsp;&nbsp;&nbsp;
<? } ?>
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
<div align="right"><a href="export.php?v=<? echo $excel ?>" target="_blank" class="normal_link">Export Names</a></div>
<? } ?>
<? echo $count_names["num"]." Names Found" ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<? if($display_lists){ ?><td class="table_header" align="center">List</td><? } ?>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Last Name</td>
    <? if($current_clerk->vars["level"]->vars["is_admin"]){ ?>
    <td class="table_header" align="center">Email</td>
    <td class="table_header" align="center">Phone</td>
    <? } ?>
    <td class="table_header" align="center">Enable</td>
    <? if($display_clerks){ ?><td class="table_header" align="center">Clerk</td><? } ?>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Calls</td>
    <td class="table_header" align="center">View</td>
  </tr>
  <? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";} $i++;?>
  
  <tr>
  	<? if($display_lists){ ?>
  	<td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo "<strong>".$name->vars["list"]->vars["name"]."</strong>"; ?>
    </td>
    <? } ?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["last_name"]; ?></td>
    <? if($current_clerk->vars["level"]->vars["is_admin"]){ ?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? 
		echo $name->vars["phone"];
		if($name->vars["phone2"] != ""){
			echo "<br />".$name->vars["phone2"];
		}
		?>
    </td>
    <? } ?>
    
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if(!$name->vars["available"]){echo "<strong>";} ?>
		<a href="javascript:;" onclick="ed('<? echo $name->vars["id"]; ?>');" class="normal_link"><? echo $name->print_status(); ?></a>
        <? if(!$name->vars["available"]){echo "</strong>";} ?>
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
     <? if ((isset($clerk_call_dst["1".clean_phone($name->vars["phone"])]))|| (isset($clerk_call_src[clean_phone($name->vars["phone"])]))) { echo "<strong>* "; } ?>   
        <a href="calls.php?nid=<? echo $name->vars["id"] ?>" target="_blank" class="normal_link">Calls</a>
      <? if ((isset($clerk_call_dst["1".clean_phone($name->vars["phone"])]))|| (isset($clerk_call_src[clean_phone($name->vars["phone"])]))) { echo "</strong>"; } ?>  
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

<? }else{echo "Access Denied";} ?>