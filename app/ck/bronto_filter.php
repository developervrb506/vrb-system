<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("bronto_filter")){ ?>
<?
$filter = get_bronto_filter();
if(isset($_POST["process"])){
	$filter->vars["emails"] = str_replace(" ","",$_POST["emails"]);
	$filter->update();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Bronto Filter</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:30px;">

<strong>Block this Emails:</strong><br /><br />

<form method="post">
<input name="process" type="hidden" id="process" value="1" />
<textarea name="emails" cols="90" rows="20" id="emails"><? echo $filter->vars["emails"] ?></textarea>
<br /><br />
<input name="" type="submit" value="Submit" />
</form>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>