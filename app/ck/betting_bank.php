<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upagn = get_betting_bank($_POST["update_id"]);
		$upagn->vars["name"] = $_POST["name"];
		$upagn->vars["description"] = $_POST["description"];
		$upagn->update();
	}else{
		$newagn = new _betting_bank();
		$newagn->vars["name"] = $_POST["name"];
		$newagn->vars["description"] = $_POST["description"];
		$newagn->insert();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Bank Accounts</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	$agent = get_betting_bank($_GET["acc"]);
	if(is_null($agent)){
		$title = "Add new Bank Account";
	}else{
		$title = "Edit Bank Account";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$agent->vars["id"] .'" />';
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
        <form method="post" action="betting_bank.php?e=51" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Name</td>
            <td><input name="name" type="text" id="name" value="<? echo $agent->vars["name"] ?>" /></td>
          </tr> 
          <tr>
            <td>Description</td>
            <td><textarea name="description" id="description"><? echo $agent->vars["description"] ?></textarea></td>
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
    <span class="page_title">Bank Accounts</span><br /><br />
    <a href="?detail" class="normal_link">+ Add Bank Account</a><br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="600" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Description</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $banks = get_all_betting_bank();
	   foreach($banks as $acc){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($acc->vars["description"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&acc=<? echo $acc->vars["id"]; ?>" class="normal_link">Edit</a>
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