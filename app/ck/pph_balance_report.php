<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>PPH Balance Report</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

    <span class="page_title">PPH Balance Report</span><br /><br />
    
    <br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Account</td>
        <td class="table_header" align="center">Balance</td>
        <td class="table_header" align="center">Phone<br />Price</td>
        <td class="table_header" align="center">Internet<br />Price</td>
        <td class="table_header" align="center">Base<br />Price</td>
        <td class="table_header" align="center">Max<br />Payers</td>
        <td class="table_header" align="center">Description</td>
        <td class="table_header" align="center">Payments</td>
      </tr>
      <?
	  $i=0;
	   $agents = get_all_pph_accounts();
	   foreach($agents as $acc){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["balance"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["phone_price"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["internet_price"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["base_price"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["max_players"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($acc->vars["description"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><a href="#" class="normal_link">View</a></td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last" colspan="100"></td>
      </tr>
  
    </table>
      
  

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>