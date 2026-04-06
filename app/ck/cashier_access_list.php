<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_access")){ ?>
<?
$method = get_cashier_method($_GET["mid"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $method->vars["name"] . " " . $method->get_by_str(); ?></title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title"><? echo $method->vars["name"] . " " . $method->get_by_str(); ?></span>

<? $players = $method->get_list(); ?>

<br /><? include "includes/print_error.php" ?><br />

<form method="post" action="process/actions/add_cashier_access.php">
	<strong>Add account to the list:</strong>&nbsp;&nbsp;
    <input name="mid" type="hidden" id="mid" value="<? echo $method->vars["id"] ?>" />
    <input name="new_acc" type="text" id="new_acc" /> 
    <input type="submit" value="Add" />
</form>


<br />



<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header"><strong>Account</strong></td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0; 
   foreach($players as $pl){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>  
  <tr>
    <td class="table_td<? echo $style ?>"><? echo $pl->vars["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="javascript:;" class="normal_link" title="Remove from this list" onclick="if(confirm('Are you sure you want to remove this account from the list?')){location.href = 'process/actions/delete_cashier_acess.php?mid=<? echo $method->vars["id"]; ?>&acc=<? echo $pl->vars["player"]; ?>';}">Remove</a>
    </td>
  <? } ?>
   <tr>
    <td class="table_last" colspan="100" align="center"></td>
  </tr>

</table>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>