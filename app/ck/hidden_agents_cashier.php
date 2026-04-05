<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_ticker")){ ?>
<script>
function delete_account(id){	
 if(confirm("Are you sure to delete this account?")){   	  
    document.location.href = 'http://localhost:8080/ck/process/actions/hidden_agent_cashier.php?id='+ id;   
 }
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Hidden Agents Cashier</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Hidden Agents Cashier</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="hidden_agent_cashier_new.php" class="normal_link">New Account</a>

<br /><br />
<?
$accounts = get_all_hidden_agents_cashier();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">ID</td>
    <td class="table_header">Account</td>
    <td class="table_header">Delete</td>
  </tr>
  <? foreach($accounts as $account){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>

  <tr>
    <td class="table_td<? echo $style ?>"><? echo $account->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $account->vars["account"]; ?></td>
    <td class="table_td<? echo $style ?>"><a onClick="delete_account('<? echo $account->vars["id"] ?>')" class="normal_link" href="javascript:;">Delete</a></td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>