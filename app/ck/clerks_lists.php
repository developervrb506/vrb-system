<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Clerk Lists</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Clerk Lists</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$clerks = get_all_clerks(1,"2,5,4");

//Public list were commented on 27-09-2013

  /*$public = get_all_public_names_list(1);
  $public_str = "";
  foreach($public as $pu){
	  $public_str .= ", " . $pu->vars["name"];
  }
  $public_str = substr($public_str,2);
 */

$private_lists = get_all_clerks_str_lists();
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header">Clerk</td>
    <td class="table_header">Lists</td>
  </tr>
  
  <? foreach($clerks as $clerk){
	  if($i % 2){$style = "1";}else{$style = "2";} $i++;	  
  ?>
  
  <tr>
	<td class="table_td<? echo $style ?>"><? echo $clerk->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>">
		<?
		if(!is_null($private_lists[$clerk->vars["id"]]["lists"])){
			echo $private_lists[$clerk->vars["id"]]["lists"];
		}else{
			echo $public_str;
		}
		?>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>
<br /><br />

</div>

<? include "../includes/footer.php" ;

?>