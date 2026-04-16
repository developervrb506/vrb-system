<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"web_name",type:"null", msg:"You need to write a Website Name"});
validations.push({id:"web_url",type:"null", msg:"You need to write a Website URL"});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>VRB Marketing Tools</title>
</head>
<body>
<? include "../includes/header.php";
include "../includes/menu.php"; ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Marketing Tools</span><br /><br />
<form method="post" action="../process/actions/change_tool_action.php">
<? $drop_style = "drop_down_list"; 
   $select_option = true;
?>
<table width="500" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td><strong>Step 1. </strong>&nbsp;&nbsp;&nbsp;Select Website:</td>
    <td>
        <? include(ROOT_PATH . "/includes/aff_webs.php"); ?>
    </td>
  </tr>
  <tr>
    <td><strong>Step 2. </strong>&nbsp;&nbsp;&nbsp;Select Brand:</td>
    <td>
        <? $books_on_change = "display_products2(this.value)"; include(ROOT_PATH . "/includes/books.php"); ?>
    </td>
  </tr>
  <tr>
    <td><strong>Step 3. </strong>&nbsp;&nbsp;&nbsp;Select Product:</td>
    <td>
        <select name="product" id="product" class="drop_down_list">
        <?
		$categories = get_all_categories();
		foreach($categories as $cat){
		?>
          <option value="<? echo $cat->id ?>" id="P_<? echo $cat->name ?>"><? echo $cat->name ?></option>
        <? } ?>
        </select>
    </td>
  </tr>
  
  <tr>
    <td><strong>Step 4. </strong>&nbsp;&nbsp;&nbsp;Select Custom Campaign:</td>
    <td>
        <? $none_option = true; include(ROOT_PATH . "/includes/aff_camps.php"); ?>
    </td>
  </tr>
  
  <tr>
    <td><strong>Step 5. </strong>&nbsp;&nbsp;&nbsp;Select Marketing Tool:</td>
    <td><div name="products_sportsbook" id="products_sportsbook"></div><td>
  </tr>
  <tr>
    <td><input style="display:none;" id="submit" type="image" src="../images/temp/submit.jpg" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
<? include "../includes/footer.php" ?>