<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("expenses_admin") || $current_clerk->im_allow("office_expenses")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upagn = get_expense_category($_POST["update_id"]);
		$upagn->vars["name"] = $_POST["name"];
		$upagn->vars["not_expense"] = $_POST["not_expense"];
		$upagn->update();
	}else{
		$newagn = new _expense_category();
		$newagn->vars["name"] = $_POST["name"];
		$newagn->vars["not_expense"] = $_POST["not_expense"];
		$newagn->insert();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Expense Category</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	$category = get_expense_category($_GET["cat"]);
	if(is_null($category)){
		$title = "Add new Category";
	}else{
		$title = "Edit Category";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$category->vars["id"] .'" />';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"name",type:"null", msg:"Name is required"});
    </script>
	<div class="form_box" style="width:400px;">
        <form method="post" action="expense_categories.php?e=46" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Name</td>
            <td><input name="name" type="text" id="name" value="<? echo $category->vars["name"] ?>" /></td>
          </tr> 
          <tr>
            <td colspan="2">
            	Ignore From Income Statement 
                <input name="not_expense" type="checkbox" id="not_expense" value="1" <? if($category->vars["not_expense"]){echo 'checked="checked"';} ?> />
            </td>
          </tr> 
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
	?>
    <span class="page_title">Expense Categories</span><br /><br />
    <a href="?detail" class="normal_link">+ Add Category</a><br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Ignore From Income Statement</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $categories = get_all_expense_categories();
	   foreach($categories as $cat){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $cat->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
			<? if($cat->vars["not_expense"]){echo "YES";}else{echo "NO";} ?>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&cat=<? echo $cat->vars["id"]; ?>" class="normal_link">Edit</a>
        </td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>
      
    <?
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>