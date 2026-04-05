<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(($current_clerk->im_allow("balance_adjustment")) || ($current_clerk->im_allow("balance_disbursements")) || ($current_clerk->im_allow("balance_receipt"))  ){ ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SBO</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Balance Manager</span><br /><br />

<? include "includes/print_error.php" ?>


<table width="100%" border="0" cellpadding="10">
  
   <tr>
    <? if($current_clerk->im_allow("balance_adjustment")){ ?>
    <td width="50%">    	
        <a href="balance_adjustments.php" class="normal_link">Balance Adjustments</a><br />
        Make an Adjustment to a Player or Agent
    </td>
    <? } ?>
  </tr>
  
    <tr>
    <? if($current_clerk->im_allow("balance_disbursements")){ ?>
    <td width="50%">    	
        <a href="balance_in_out.php?d" class="normal_link">Balance Disbursements</a><br />
        Make an Disbursement to a Player or Agent
    </td>
    <? } ?>
  </tr>
  
    <tr>
    <? if($current_clerk->im_allow("balance_receipt")){ ?>
    <td width="50%">    	
        <a href="balance_in_out.php?r" class="normal_link">Balance Receipts</a><br />
        Make an Receipt to a Player or Agent
    </td>
    <? } ?>
  </tr>
  
  
 
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>