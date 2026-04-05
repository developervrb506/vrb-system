<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$list = new names_list();
if(isset($_POST["preview"])){
	$path = "csv/";
	$file_name = upload_file("csv", $path, "webs_".mt_rand());
	if($file_name == ""){
		header("Location: upload_webs.php?list=".$list->vars["id"]."&e=1");
	}else{
		$file_name = $path.$file_name;
		$diplay_list = true;
		$preupload = true;
		$first = $_POST["first"];
		$webs = $list->load_websites_from_CSV($file_name, $first);
	}
}
if(isset($_POST["cancel"])){	
	if (file_exists($_POST["cancel"])){unlink($_POST["cancel"]);}
}
if(isset($_POST["upload"])){
	$diplay_list = true;
	$preupload = false;
	$webs = $list->load_websites_from_CSV($_POST["upload"], $_POST["first"], true);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Upload Websites</title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"csv",type:"null", msg:"Please Select a File"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Upload Websites</span><br /><br />

<? include "includes/print_error.php" ?>

<? if($diplay_list){ ?>

<? if($preupload){ ?>Please Check the Website list before Upload it<br /><br /><? } ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Affiliate</td>
    <td class="table_header" align="center">Name</td>
  </tr>
  <? foreach($webs as $web){if($i % 2){$style = "1";}else{$style = "2";} $i++;?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $web->vars["affiliate"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $web->vars["name"]; ?></td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>
<? if($preupload){ ?>
<div align="right">
<table width="200" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td align="right">
    	<form action="upload_webs.php" method="post">
            <input name="cancel" type="hidden" id="cancel" value="<? echo $file_name ?>" />
            <input name="" type="submit" value="Cancel" />
        </form>
    </td>
    <td align="right">
    	<form action="upload_webs.php?e=17" method="post">
            <input name="upload" type="hidden" id="upload" value="<? echo $file_name ?>" />
            <input name="first" type="hidden" id="first" value="<? echo $first ?>" />
            <input name="" type="submit" value="Upload List" />
        </form>
    </td>
  </tr>
</table>
</div>
<? } ?>

<? }else{ ?>

<div class="form_box" style="width:550px;">
	<form method="post" action="upload_webs.php" onsubmit="return validate(validations)" enctype="multipart/form-data">
    <input name="preview" type="hidden" id="preview" value="1" />
	<table width="80%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td colspan="2"><strong>CSV Format:</strong> Affiliate Id, Web Name</td>
      </tr>
      <tr>
        <td>CSV File</td>
        <td><input name="csv" type="file" id="csv" /></td>
      </tr>
      <tr>
        <td>First line is the Columns Names</td>
        <td><input name="first" type="checkbox" id="first" value="1" /></td>
      </tr>
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>

<? } ?>

</div>
<? include "../includes/footer.php" ?>