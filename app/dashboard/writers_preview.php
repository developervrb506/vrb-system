<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Writers Page Preview</title>
</head>

<body>
<?
$aff_id = $_GET["aid"];
$top_banner = $_GET["tb"];
$footer_banner = $_GET["fb"];
?>
<? include "../includes/header.php" ?>
<div class="page_content" style="padding-left:50px;">

<span class="page_title">Writers Page Preview</span><br /><br />

<iframe width="<? echo $_GET["w"]; ?>" height="<? echo $_GET["h"]; ?>" frameborder="0" src="http://vrbmarketing.com/process/writers_page.php?le=<? echo $_GET["l"]; ?>&aid=<? echo $aff_id ?>&pid_top=<? echo $top_banner ?>&pid_bot=<? echo $footer_banner ?>&brand=<? echo $_GET["br"] ?>&tp=<? echo $_GET["cat"] ?>"></iframe>

</div>
<? include "../includes/footer.php" ?>