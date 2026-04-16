<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_access")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Cashier Access</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Cashier Access</span>
<br />

<? $methods = get_all_cashier_methods(); ?>
<? include "includes/print_error.php" ?>

<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="changer"></iframe>
<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="updater"></iframe>
<table width="360" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header"><strong>Method</strong></td>
    <td class="table_header" align="center"><strong>Access by</strong></td>
    <td class="table_header" align="center"><strong>List</strong></td>
  </tr>
  <?
   $i=0; 
   foreach($methods as $mt){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>  
  <tr>
    <td class="table_td<? echo $style ?>"><? echo $mt->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<? 
		$data = array(array("id"=>"b","label"=>"Black List"),array("id"=>"w","label"=>"Allow List"));
		$onchange = "change_method_type('".$mt->vars["name"]."','".$mt->vars["id"]."','".$mt->vars["type"]."',this.value)";
		create_list("type_".$mt->vars["id"], "type_".$mt->vars["id"], $data, $mt->vars["type"], $onchange) 
		?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><a href="cashier_access_list.php?mid=<? echo $mt->vars["id"]; ?>" class="normal_link">Edit List</a></td>
  </tr>
  <? } ?>
   <tr>
    <td class="table_last" colspan="100" align="center"></td>
  </tr>

</table>

<script type="text/javascript">
function change_method_type(mname, mid, old_type, new_type){
	if(confirm("Are you sure you want to change the way access is managed for "+mname+"?")){
		location.href = "process/actions/change_cashier_method_type.php?mid="+mid+"&type="+new_type;
	}else{
		document.getElementById("type_"+mid).value = old_type;
	}
}
</script>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>