<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? if ( $_SESSION["aff_id"] == 1033 or $_SESSION["aff_id"] == 1035 ) {
	header("Location: ../reports/index.php");
}
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
<title>XML Feeds</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title">Live Odds XML Feeds</span><br /><br />
	<a href="<?= BASE_URL ?>/process/xml_feed.php?le=NFL&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">NFL Feed</a> <br /><br />
    <a href="<?= BASE_URL ?>/process/xml_feed.php?le=NCAAF&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">NCAAF Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/xml_feed.php?le=NBA&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">NBA Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/xml_feed.php?le=NCAAB&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">NCAAB Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/xml_feed.php?le=MLB&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">MLB Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/xml_feed.php?le=NHL&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">NHL Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/xml_feed.php?le=MMA&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">MMA Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/xml_feed.php?le=BOXING&bk=<? echo $_GET["book"] ?>" target="_blank" class="normal_link">Boxing Feed</a> 
    <br /><br />
    <span class="small_black">Landing Page URL:&nbsp;&nbsp;</span>
    <input name="landing_url" type="text" id="landing_url" value=BASE_URL . "/process/custom_redir.php?pid=1323&aid=<? echo $current_affiliate->id ?>&tgt=http://www.wagerweb.com&bk=<? echo $_GET["book"] ?>" size="63" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;<input onclick="select_value('landing_url')" name="" type="button" value="Select" />
  
  </div>
<? include "../includes/footer.php" ?>