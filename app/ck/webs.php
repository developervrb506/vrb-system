<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Names Lists</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Names Lists</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="upload_webs.php" class="normal_link">Upload Websites</a><br /><br />

<form action="webs.php" method="post">
Affiliate:<input name="saff" type="text" id="saff" value="<? echo $_POST["saff"] ?>" />
&nbsp;&nbsp;&nbsp;&nbsp;

Web Name:<input name="sname" type="text" id="sname" value="<? echo $_POST["sname"] ?>" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="" type="submit" value="Search" />
</form>

<br /><br />

<? 
$webs = get_all_ckwebs($_POST["saff"],$_POST["sname"]);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Affiliate</td>
    <td class="table_header" align="center">Web Name</td>
    <td class="table_header" align="center">Edit</td>
  </tr>
  <? foreach($webs as $web){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $web->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $web->vars["affiliate"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $web->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="edit_web.php?wid=<? echo $web->vars["id"] ?>">Edit</a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>