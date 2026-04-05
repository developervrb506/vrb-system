<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? if ( $_SESSION["aff_id"] == 1033 or $_SESSION["aff_id"] == 1035 ) {
	header("Location: ../reports/index.php");
}
?>
<?
$book = get_sportsbook($_GET["book"]);
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Press Releases Feeds</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<? if($book->id == 3){ ?>
<span class="page_title">Press Releases Feeds</span><br /><br />
	<a href="http://www.sportsbettingonline.ag/utilities/feeds/press_releases.php?aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">Press Releases Feed</a>
    
<? }else{echo "This Tool is not available for " . $book->name;} ?>
	</div>
<? include "../includes/footer.php" ?>