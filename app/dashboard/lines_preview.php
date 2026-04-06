<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Lines Preview</title>
</head>

<body>
<?
$aff_id = $_GET["aid"];
$top_banner = $_GET["tb"];
$footer_banner = $_GET["fb"];
$books = $_GET["bks"];
?>
<? include "../includes/header.php" ?>
<div class="page_content" style="padding-left:50px;">

<span class="page_title">Betting Lines Preview</span><br /><br />

<iframe width="<? echo $_GET["w"]; ?>" height="<? echo $_GET["h"]; ?>" frameborder="0" src="<?= BASE_URL ?>/process/live_lines.php?bks=<? echo $books ?>&le=<? echo $_GET["l"]; ?>&aid=<? echo $aff_id ?>&tb=<? echo $top_banner ?>&fb=<? echo $footer_banner ?>"></iframe>

</div>
<? include "../includes/footer.php" ?>