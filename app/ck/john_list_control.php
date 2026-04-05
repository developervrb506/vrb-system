<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("john_list_control")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>List</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content">
<span class="page_title">List</span><br /><br />

<? include "includes/print_error.php" ?>

<? 
$lists = get_all_johns_names_list(1);
$max_index = count($lists);
?>
<form method="post" action="process/actions/allow_action.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Av.</td>
    <td class="table_header" align="center">Total</td>     
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <? foreach($lists as $list){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
		<? echo $list->vars["id"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal; font-size:11px;"><? echo $list->vars["name"]; ?></td>
       

    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? $count = count_virgin_names($list->vars["id"]); echo $count["num"]?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? $count = count_all_cknames($list->vars["id"]); echo $count["num"]?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="names.php?lid=<? echo $list->vars["id"] ?>" title="View Names on this List">Names</a>
    </td>
    
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="calls.php?lid=<? echo $list->vars["id"] ?>" title="View Calls of this List">Calls</a>
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
$lists = get_all_johns_names_list("0");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Av.</td>
    <td class="table_header" align="center">Total</td> 
    <td class="table_header" align="center">Agent</td>     

    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <? foreach($lists as $list){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
		<? echo $list->vars["id"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal; font-size:11px;"><? echo $list->vars["name"]; ?></td>
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
    	<a class="normal_link" href="calls.php?lid=<? echo $list->vars["id"] ?>" title="View Calls of this List">Calls</a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="1000"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>

<? }else{echo "Access Denied"; } ?>