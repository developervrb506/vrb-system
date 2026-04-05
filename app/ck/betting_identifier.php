<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upid = get_betting_identifier($_POST["update_id"]);
		$upid->vars["name"] = $_POST["name"];
		$upid->vars["description"] = $_POST["description"];
		$upid->update();
	}else{
		$newid = new _betting_identifier();
		$newid->vars["name"] = $_POST["name"];
		$newid->vars["description"] = $_POST["description"];
		$newid->insert();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Identifiers</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	$identifier = get_betting_identifier($_GET["idf"]);
	if(is_null($identifier)){
		$title = "Add new Identifier";
	}else{
		$title = "Edit Identifier";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$identifier->vars["id"] .'" />';
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
        <form method="post" action="betting_identifier.php?e=40" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Number</td>
            <td><input name="name" type="text" id="name" value="<? echo $identifier->vars["name"] ?>" /></td>
          </tr> 
          <tr>
            <td>Name</td>
            <td><input name="description" type="text" id="description" value="<? echo $identifier->vars["description"] ?>" /></td>
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
    <span class="page_title">Betting Identifiers</span><br /><br />
    <a href="?detail" class="normal_link">+ Add Identifier</a><br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Number</td>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $identifiers = get_all_betting_identifiers();
	   foreach($identifiers as $idf){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $idf->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $idf->vars["description"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&idf=<? echo $idf->vars["id"]; ?>" class="normal_link">Edit</a>
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