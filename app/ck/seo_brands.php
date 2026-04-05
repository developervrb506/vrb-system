<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO Brands</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO Brands</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="seo_new_brand.php" class="normal_link">New Brand</a>

<br /><br />
<?
$lists = get_all_seo_brands();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">ID</td>
    <td class="table_header">Name</td>
    <td class="table_header">Edit</td>
  </tr>
  <? foreach($lists as $list){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>

  <tr>
    <td class="table_td<? echo $style ?>"><? echo $list->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $list->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>"><a href="seo_new_brand.php?lid=<? echo $list->vars["id"]; ?>" class="normal_link">Edit</a></td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>