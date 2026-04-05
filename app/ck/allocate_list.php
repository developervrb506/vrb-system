<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$clerks = get_all_clerks("","1,2,4,5"); 
$list = get_names_list($_GET["lid"]);

if(isset($_POST["save"])){
	delete("list_by_clerk","","list = '".$list->vars["id"]."'");
	foreach($clerks as $clrk){		
		if($_POST["clerk_".$clrk->vars["id"]]){
			$new = array("clerk"=>$clrk->vars["id"],"list"=>$list->vars["id"]);
			insert($new,"list_by_clerk");
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Add Specific Clerks</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Add Specific Clerks to <? echo $list->vars["name"] ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="allocate_list.php?lid=<? echo $list->vars["id"] ?>&e=16" onsubmit="return validate(validations)">
    <table width="200" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Name</td>
      </tr>
      <?      
	  $relations = get_list_clerks($list->vars["id"]);
	  ?>
      <? foreach($clerks as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
      	<? 
		$group = array("clerk"=>$clerk->vars["id"],"list"=>$list->vars["id"]);
		if(in_array($group,$relations)){$sel = true;}else{$sel = false;}
		?>
        
      <tr>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
            <? echo $clerk->vars["name"]; ?>
        </td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
            <input <? if($sel){echo 'checked="checked"';} ?> name="clerk_<? echo $clerk->vars["id"]; ?>" type="checkbox" id="clerk_<? echo $clerk->vars["id"]; ?>" value="1" />
        </td>
      </tr>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
    </table>
    <br /><br />
    <input name="save" type="hidden" id="save" value="1" />
    <input name="" type="submit" value="Submit" />
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>