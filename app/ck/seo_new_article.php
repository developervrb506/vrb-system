<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>

<?
if(isset($_GET["lid"])){
	$update = true;
	$group = get_seo_article($_GET["lid"]);
	$title = "Edit ".$group->vars["name"]." ";
}else{
	$update = false;
	$title = "Create New Brand";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<title><? echo $title ?></title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"brand",type:"null", msg:"Brand is required"});
validations.push({id:"keyword",type:"null", msg:"Keyword is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>
<? $brands = get_all_seo_brands(); ?>
<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/seo_new_article.php" onsubmit="return validate(validations)" enctype="multipart/form-data">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $group->vars["id"] ?>" /><? } ?>
	<table width="300" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $group->vars["name"] ?>" /></td>
      </tr>
      <tr>
        <td>Brand</td>
        <td><? create_objects_list("brand", "brand", $brands, "name", "name", "-- Select --", $group->vars["brand"]) ?></td>
      </tr>
      <tr>
        <td>Keyword</td>
        <td><input name="keyword" type="text" id="keyword" value="<? echo $group->vars["keyword"] ?>" /></td>
      </tr> 
      <tr>
        <td>File</td>
        <td>
        	<? if($group->vars["file"] != ""){ ?>
            <a href="<?= BASE_URL ?>/ck/csv/<? echo $group->vars["file"]; ?>" target="_blank" class="normal_link">View File</a><br />
            <? } ?>
        	<input name="afile" type="file" id="afile" />
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
<? }else{echo "Access Denied";} ?>
