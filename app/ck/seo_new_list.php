<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>

<?
if(isset($_GET["lid"])){
	$update = true;
	$group = get_seo_list($_GET["lid"]);
	$title = "Edit ".$group->vars["name"]." List";
}else{
	$update = false;
	$title = "Create New List";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<title>Create SEO entry</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/seo_new_list.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $group->vars["id"] ?>" /><? } ?>
	<table width="300" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $group->vars["name"] ?>" /></td>
      </tr>
      <tr>
        <td>Clerks</td>
        <td>
        <? $clerks = get_all_clerks(); ?>
        <? $lclerks = get_all_clerks_by_seo_list($group->vars["id"]); ?>
        <? foreach($clerks as $clk){ if($clk->im_allow("seo_system")){ ?>
        	<input name="clk_<? echo $clk->vars["id"] ?>" type="checkbox" id="clk_<? echo $clk->vars["id"] ?>" <? if(!is_null($lclerks[$clk->vars["id"]])){ ?>checked="checked"<? } ?> value="1" />
            <label for="clk_<? echo $clk->vars["id"] ?>"><? echo $clk->vars["name"] ?></label> <br />
        <? }} ?>
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
