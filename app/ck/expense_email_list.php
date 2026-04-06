<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<?

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Expenses Email</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"email",type:"email", msg:"Email is required"});
</script>


</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Expenses Email</span>

<? $names = get_all_expense_emails(); ?>

<br /><? include "includes/print_error.php" ?><br />

<form method="post" action="process/actions/add_expense_email.php" onsubmit="return validate(validations)">
	<strong>Add email to the list:</strong>&nbsp;&nbsp;
      <BR>
     Name: <input name="name" type="text" id="name" /> 
     Email: <input name="email" type="text" id="email" />  
    <input type="submit" value="Add" />
</form>


<br />



<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header"><strong>Name</strong></td>
    <td class="table_header"><strong>Email</strong></td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0; 
   foreach($names as $_names){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>  
  <tr>
    <td class="table_td<? echo $style ?>"><? echo $_names->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $_names->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="javascript:;" class="normal_link" title="Remove from this list" onclick="if(confirm('Are you sure you want to remove this Email?')){location.href = 'process/actions/delete_expense_email.php?id=<? echo $_names->vars["id"]; ?>';}">Remove</a>
    </td>
  <? } ?>
   <tr>
    <td class="table_last" colspan="100" align="center"></td>
  </tr>

</table>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>