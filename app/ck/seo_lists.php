<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO Lists</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO Lists</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="seo_new_list.php" class="normal_link">New Lists</a>

<br /><br />
<?
$lists = get_all_seo_list();
$clerks = get_all_clerks_index("", "", false,true);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">ID</td>
    <td class="table_header">Name</td>
    <td class="table_header">Websites</td>
    <td class="table_header">Ready</td>
    <td class="table_header">Active</td>
    <td class="table_header">Open</td>
    <td class="table_header">Clerks</td>
    <td class="table_header">Edit</td>
    <td class="table_header">Upload</td>
  </tr>
  <? foreach($lists as $list){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>

  <tr>
    <td class="table_td<? echo $style ?>"><? echo $list->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $list->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>">
    <? 
	$count = count_seo_websites_by_list($list->vars["id"]);
	echo $count["total"];
	?>
    </td>
    
    <td class="table_td<? echo $style ?>">
    <? 
	$count = count_seo_websites_by_list($list->vars["id"],"r");
	echo $count["total"];
	?>
    </td>
    <td class="table_td<? echo $style ?>">
    <? 
	$count = count_seo_websites_by_list($list->vars["id"],"a");
	echo $count["total"];
	?>
    </td>
    <td class="table_td<? echo $style ?>">
    <? 
	$count = count_seo_websites_by_list($list->vars["id"],"o");
	echo $count["total"];
	?>
    </td>
    
    <td class="table_td<? echo $style ?>">
    <? 
	$lcids = get_all_clerks_by_seo_list($list->vars["id"]);
	$lclerks = array();
	foreach($lcids as $lc){
		$lclerks[] = $clerks[$lc["clerk"]]->vars["name"];
	}
	echo implode(",",$lclerks);
	?>
    </td>
    <td class="table_td<? echo $style ?>"><a href="seo_new_list.php?lid=<? echo $list->vars["id"]; ?>" class="normal_link">Edit</a></td>
    <td class="table_td<? echo $style ?>"><a href="seo_upload_webs.php?lid=<? echo $list->vars["id"]; ?>" class="normal_link">Upload</a></td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>