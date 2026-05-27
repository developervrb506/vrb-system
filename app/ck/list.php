<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>

<?
$pointer = get_list_pointer();

if(isset($_GET["reslist"])){
	set_all_names_available($_GET["reslist"]);
	header("Location: list.php");
}
if(isset($_GET["ed"])){
	$list = get_names_list($_GET["ed"]);
	if($list->vars["available"]){$list->vars["available"] = 0;}
	else{$list->vars["available"] = 1;}
	
	$list->update(array("available"));
	header("Location: list.php?e=3");
}
if(isset($_GET["dwn"])){
	$mlist = get_names_list($_GET["dwn"]);
	$slist = get_names_list_by_position($mlist->vars["position"]+1);
	$mlist->vars["position"]++;
	$mlist->update(array("position"));
	$slist->vars["position"]--;
	$slist->update(array("position"));
	header("Location: list.php");
}else if(isset($_GET["up"])){
	$mlist = get_names_list($_GET["up"]);
	$slist = get_names_list_by_position($mlist->vars["position"]-1);
	$mlist->vars["position"]--;	
	$mlist->update(array("position"));
	$slist->vars["position"]++;
	$slist->update(array("position"));
	header("Location: list.php");
}
if(isset($_POST["reset"])){
	$res_list = get_names_list($_POST["list_list"]);
	$pointer->vars["list"] = $res_list;
	$pointer->vars["remaining"] = $res_list->vars["allow"];
	$pointer->update();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Names Lists</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content">
<span class="page_title">Names Lists</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="create_list.php" class="normal_link">Create New List</a><br /><br />


<span style="font-size:12px; font-weight:bold; display:none">
<?
echo $pointer->vars["remaining"] . " names left to display from ". $pointer->vars["list"]->vars["name"] . " list. ";
?>
&nbsp;&nbsp;&nbsp;&nbsp;
<form method="post" action="list.php">
<input name="reset" type="hidden" id="reset" value="1" />
Reset to list: <?
$lists_available = 1;
include "includes/lists_list.php";
?>
&nbsp;&nbsp;
<input name="" type="submit" value="Reset" />
</form>
<br />
</span>



<? 
$lists = get_all_names_list(1);
$max_index = count($lists);
?>
<form method="post" action="process/actions/allow_action.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <!--<td class="table_header" align="center">Pos.</td>
    <td class="table_header" align="center">Allow</td>-->
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Av.</td>
    <td class="table_header" align="center">Total</td>
    <td class="table_header" align="center">Agent</td> 
    <? if ($current_clerk->im_allow("reset_list"))  { ?>     
    <td class="table_header" align="center"></td>
    <? } ?>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <? foreach($lists as $list){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
		<? echo $list->vars["id"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal; font-size:11px;"><? echo $list->vars["name"]; ?></td>
        <?php /*?><td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo $list->vars["position"]; ?>&nbsp;&nbsp;&nbsp;
        <? if($i > 1){ ?><strong style="font-size:15px;"><a class="normal_link" href="?up=<? echo $list->vars["id"] ?>">˄</a></strong> <? } ?>
        <? if($i < $max_index){ ?><strong style="font-size:15px;"><a class="normal_link" href="?dwn=<? echo $list->vars["id"] ?>">˅</a></strong> <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
		<input name="allow_<? echo $list->vars["id"]; ?>" type="text" id="allow_<? echo $list->vars["id"]; ?>" size="3" value="<? echo $list->vars["allow"]; ?>" />
    </td><?php */?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if(!$list->vars["available"]){echo "<strong>";} ?>
		<a href="?ed=<? echo $list->vars["id"]; ?>" class="normal_link" title="Change the List's status"><? echo $list->print_status(); ?></a>
        <? if(!$list->vars["available"]){echo "</strong>";} ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? $count = count_virgin_names($list->vars["id"]); echo $count["num"]?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? $count = count_all_cknames($list->vars["id"]); echo $count["num"]?>
    </td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? if ($list->vars["agent_list"]) { echo "Yes"; }else { echo "No"; } ?>
    </td>
   <? if ($current_clerk->im_allow("reset_list"))  { ?>     
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="javascript:;" title="Set all Names as Available" onclick="if(confirm('Are you sure you want to make all names on this list Available?')){location.href = '?reslist=<? echo $list->vars["id"] ?>'}">
        	Reset
        </a>
    </td>
     <? } ?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="names.php?lid=<? echo $list->vars["id"] ?>" title="View Names on this List">Names</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="allocate_list.php?lid=<? echo $list->vars["id"] ?>" title="View Clerks on this List">Clerks</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="calls.php?lid=<? echo $list->vars["id"] ?>" title="View Calls of this List">Calls</a>
    </td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
     <a href="geographical_list.php?lid=<? echo $list->vars["id"] ?>&name=<? echo $list->vars["name"]; ?>" class="normal_link" rel="shadowbox;height=430;width=400">Geo</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_list.php?lid=<? echo $list->vars["id"] ?>" title="Edit this List">Edit</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="upload_names.php?list=<? echo $list->vars["id"] ?>" title="Upload Names on this List">Upload</a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="1000"></td>
  </tr>
</table>
<div align="right"><input name="" type="submit" value="Update" /></div>
</form>

<br /><br />

<strong>Disabled List</strong>
<? 
$lists = get_all_names_list("0");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <!--<td class="table_header" align="center">Pos.</td>-->
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Av.</td>
    <td class="table_header" align="center">Total</td> 
    <td class="table_header" align="center">Agent</td>     
    <? if ($current_clerk->im_allow("reset_list"))  { ?>     
    <td class="table_header" align="center"></td>
     <? } ?>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <? foreach($lists as $list){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
		<? echo $list->vars["id"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal; font-size:11px;"><? echo $list->vars["name"]; ?></td>
        <?php /*?><td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo $list->vars["position"]; ?>&nbsp;&nbsp;&nbsp;
    </td><?php */?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if(!$list->vars["available"]){echo "<strong>";} ?>
		<a href="?ed=<? echo $list->vars["id"]; ?>" class="normal_link" title="Change the List's status"><? echo $list->print_status(); ?></a>
        <? if(!$list->vars["available"]){echo "</strong>";} ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? $count = count_virgin_names($list->vars["id"]); echo $count["num"]?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? $count = count_all_cknames($list->vars["id"]); echo $count["num"]?>
    </td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? if ($list->vars["agent_list"]) { echo "Yes"; }else { echo "No"; } ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="names.php?lid=<? echo $list->vars["id"] ?>" title="View Names on this List">Names</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="allocate_list.php?lid=<? echo $list->vars["id"] ?>" title="View Clerks on this List">Clerks</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="calls.php?lid=<? echo $list->vars["id"] ?>" title="View Calls of this List">Calls</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_list.php?lid=<? echo $list->vars["id"] ?>" title="Edit this List">Edit</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="upload_names.php?list=<? echo $list->vars["id"] ?>" title="Upload Names on this List">Upload</a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="1000"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>