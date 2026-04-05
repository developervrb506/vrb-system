<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_lists")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Access Lists</title>
</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	Access Lists for:
    &nbsp;&nbsp;
    
    <? 
	$ccustomer = param("ccx");
	if(!is_numeric($ccustomer)){$ccustomer = 2002;}
	?>
    
    <select name="ccx" id="ccx" onchange="location.href = 'lists.php?ccx='+this.value;">
    	<option value="2002">SBO</option>
        <option value="2004" <? if($ccustomer == 2004){echo 'selected="selected"';} ?>>PPH</option> 
    </select>
    
</span>
<br /><br />



<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/lists.php?c=$ccustomer&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>