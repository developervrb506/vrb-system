<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Commission Accounts</title>
<?
if(isset($_GET["del"])){
	$del = new _betting_commission();
	$del->vars["id"] = $_GET["del"];
	$del->delete();
	?><script type="text/javascript">alert("Transaction has been Deleted");</script><?
}
?>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Commission Accounts</span><br /><br />

<a href="insert_commission_account.php" class="normal_link"  rel="shadowbox;height=250;width=450" title="Insert Account Move">
	+ Add Commission Account
</a>

<br /><br />
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center" width="30%">Account</td>
    <td class="table_header" align="center" width="30%">Commission<br />Account</td>
    <td class="table_header" align="center" width="30%">Percentage</td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
  $i=0;
   $coms = get_all_commission_relations();
   foreach($coms as $cm){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $cm->vars["account"]->vars["name"] ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $cm->vars["caccount"]->vars["name"] ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $cm->vars["percentage"] ?>%</td>
    <td class="table_td<? echo $style ?>" align="center">
        <a href="insert_commission_account.php?edit=<? echo $cm->vars["id"] ?>" class="normal_link"  rel="shadowbox;height=250;width=450">
        	Edit
        </a>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
        <a href="javascript:;" onclick="if(confirm('Are you sure you want to delete this Relation?')){location.href = 'betting_commisions.php?del=<? echo $cm->vars["id"] ?>'}" class="normal_link">Delete</a>
    </td>
  </tr>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>

</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>