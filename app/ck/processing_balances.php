<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("processing_balances")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Processing Balance Sheet</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<table width="100%" border="0" cellpadding="20">
  <tr>
    <td width="50%" valign="top">
        <!--Assets-->
    	<span class="page_title">Assets</span>
        <? $total_assets = 0; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <!--Processing-->
          <? include("balances/processing_assets.php"); ?>
          <!--End Processing-->
          
        </table>        
        
        <!--END Assets-->
    </td>
    <td width="50%" valign="top">
        <!--LIABILITIES-->
        <span class="page_title">Liabilities</span>
        <? $total_lia = 0; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <!--Processing-->
          <? include("balances/processing_liabilities.php"); ?>
          <!--End Processing-->          
          
        </table>
        <!--END LIABILITIES-->
    </td>
  </tr>
  <tr>
  	<td colspan="2" align="center">
    <!--Global-->
    <table width="50%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="table_header" align="center">Net</td>
          <td class="table_header" align="center"><? echo basic_number_format($total_assets-$total_lia) ?></td>
          <td class="table_header" align="center"><? echo basic_number_format($adj_total_assets-$adj_total_lia) ?></td>
        </tr> 
    </table>
    <!--End Global-->
    </td>
  </tr>
</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>