<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<?
$names = get_signups_names(false, $_GET["ls"], $_GET["frm"], $_GET["to"], $_GET["st"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div style="background:#fff; padding:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Last Name</td>
    <td class="table_header" align="center">Email</td>
    <td class="table_header" align="center">Phone</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Calls</td>
  </tr>
  <? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";} $i++;?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["last_name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["phone"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? 
		if(is_null($name->vars["clerk"])){
			echo "Free";
		}else{
			echo "<strong>".$name->vars["clerk"]->vars["name"]."</strong>";
		}
		?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo $name->vars["status"]->vars["name"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a href="calls.php?nid=<? echo $name->vars["id"] ?>" target="_blank" class="normal_link">Calls</a>
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
</div>
</body>
</html>