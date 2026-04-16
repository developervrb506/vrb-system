<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upacc = get_betting_group($_POST["update_id"]);
		$upacc->vars["name"] = $_POST["name"];
		$upacc->vars["description"] = $_POST["description"];
		$upacc->update();
	}else{
		$newacc = new _betting_group();
		$newacc->vars["name"] = $_POST["name"];			
		$newacc->vars["description"] = $_POST["description"];
		$newacc->insert();			
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Groups</title>
<script type="text/javascript" src="includes/js/bets.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<? 
if(isset($_GET["detail"])){
	//details
	$group = get_betting_group($_GET["acc"]);
	if(is_null($group)){
		$title = "Add new Group";
	}else{
		$title = "Edit Group";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$group->vars["id"] .'" />';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"name",type:"null", msg:"Name is required"});
    </script>
    <a href="betting_groups.php" class="normal_link">&lt;&lt; Back to Groups List</a>
	<div class="form_box" style="width:400px;">
        <form method="post" action="betting_groups.php?e=39" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>        
		<table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Name</td>
            <td colspan="2"><input name="name" type="text" id="name" value="<? echo $group->vars["name"] ?>" /></td>
          </tr>          
          <tr>
            <td>Description</td>
            <td colspan="2"><textarea name="description" id="description"><? echo $group->vars["description"] ?></textarea></td>
          </tr> 
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
	?>
    <span class="page_title">Betting Groups</span><br /><br />
    <a href="?detail" class="normal_link">+ Add Group</a><br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Description</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $groups = get_all_betting_groups();
	   foreach($groups as $grp){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $grp->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="left" ><? echo $grp->vars["description"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&acc=<? echo $grp->vars["id"]; ?>" class="normal_link">Edit</a>
        </td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
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