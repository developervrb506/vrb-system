<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/ajax.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
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
<?php /*?><span class="page_title">Marketing Tools</span><br /><br /><?php */?>
<form method="post" action="../process/actions/change_tool_action.php">
<? $drop_style = "drop_down_list"; 
   $select_option = true;
?>
<table width="500" border="0" cellspacing="0" cellpadding="10">
  <tr class="marketing_tools_title">
    <td colspan="4">MARKETING TOOLS</td>    
  </tr>  
  <tr class="marketing_tools_tr_top">
    <td colspan="4"></td>   
  </tr>
  <tr class="marketing_tools_tr">
    <td><strong>Step 1. </strong><span class="mt_text">Select Website:</span></td>
    <td class="splitter_mt_td">&nbsp;</td>
    <td>&nbsp;</td>
    <td>
        <? include(ROOT_PATH . "/includes/aff_webs.php"); ?>
    </td>
  </tr>
  <tr class="marketing_tools_tr">
    <td><strong>Step 2. </strong><span class="mt_text">Select Brand:</span></td>
    <td class="splitter_mt_td">&nbsp;</td>
    <td>&nbsp;</td>
    <td>
        <? $books_on_change = "from(this.value,'category_sportsbook','../process/actions/sportsbookcategory.php')";
		include(ROOT_PATH . "/includes/books.php"); ?>
    </td>
  </tr>
   <tr class="marketing_tools_tr">
    <td><strong>Step 3. </strong><span class="mt_text">Select Category:</span></td>
    <td class="splitter_mt_td">&nbsp;</td>
    <td>&nbsp;</td>
    <td>
       <? 
		$onchange = "from(this.value,'products_sportsbook','../process/actions/productscategory.php')";       
		?>
        <div name="category_sportsbook" id="category_sportsbook">
        <select onchange="<? echo $onchange ?>" name="product" id="product"  class="drop_down_list">
 
        <option value="0" id="select" selected="selected">Select an Option</option>
    
        </select>
        </div>
    </td>
  </tr>  
  <tr class="marketing_tools_tr">
    <td><strong>Step 4. </strong><span class="mt_text">Select Custom Campaign:</span></td>
    <td class="splitter_mt_td">&nbsp;</td>
    <td>&nbsp;</td>
    <td>
        <? $none_option = true; include(ROOT_PATH . "/includes/aff_camps.php"); ?>
    </td>
  </tr>  
  <tr class="marketing_tools_tr">
    <td><strong>Step 5. </strong><span class="mt_text">Select Product:</span></td>
    <td class="splitter_mt_td">&nbsp;</td>    
    <td>    
    <td>
    <div name="products_sportsbook" id="products_sportsbook">
    
    <select name="tool" id="tool"  class="drop_down_list">
     <option value="0" id="select" selected="selected">Select an Option</option> 
    </select>
    
    </div>
    <BR>
    
    
    <td>
  </tr>
  <tr class="marketing_tools_tr">
    <td><input style="display:block;" id="submit" type="image" src="../images/temp/submit.jpg" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table>
</form>
</div>
<? include "../includes/footer.php" ?>