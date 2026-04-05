<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("relesed_names")){ ?>
<? $show_all = $_GET["all"]; ?>
<?
if(isset($_GET["cid"])){
	$cname = get_ckname($_GET["cid"]);
	$cname->vars["release_email_sent"] = 1;
	$cname->update(array("release_email_sent"));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Released Names</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content">
<span class="page_title">Released Names</span><br /><br />

<? include "includes/print_error.php" ?>

<? 
$names = get_released_cknames($show_all);
?>

<? if($show_all){ ?>
	<a href="?" class="normal_link">Show just pending ones</a>
<? }else{ ?>
	<a href="?all=1" class="normal_link">Show all</a>
<? } ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header">Name</td>
    <td class="table_header">Email</td>
    <td class="table_header">Phone</td>
    <td class="table_header">Account</td>
    <td class="table_header">List</td>
    <td class="table_header">Release Date</td>
    <td class="table_header"></td>
  </tr>
  <? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $name->full_name(); ?></td>
    <td class="table_td<? echo $style ?>"><? echo $name->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $name->vars["phone"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $name->vars["acc_number"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $name->vars["list"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $name->vars["released_date"]; ?></td>
    <td class="table_td<? echo $style ?>">
    	<? 
		if($name->vars["release_email_sent"]){
			echo "Email Sent";
		}else{
			?><a href="javascript:;" onclick="if(confirm('Are you sure you want to mark this name as Complete?')){location.href = 'relesed_names.php?all=<? echo $show_all ?>&cid=<? echo $name->vars["id"]; ?>'}" class="normal_link">Complete</a><?
		}
		?>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="1000"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? } ?>