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
<title>Writers Feeds</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<? if($book->id == 1){ ?>
<span class="page_title">Sports Betting Articles Feeds</span><br /><br />
	<a href="<?= BASE_URL ?>/process/writers_xml_feed.php?le=NFL&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">NFL Articles Feed</a> <br /><br />
    <a href="<?= BASE_URL ?>/process/writers_xml_feed.php?le=NCAAF&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">NCAAF Articles Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/writers_xml_feed.php?le=NBA&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">NBA Articles Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/writers_xml_feed.php?le=NCAAB&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">NCAAB Articles Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/writers_xml_feed.php?le=MLB&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">MLB Articles Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/writers_xml_feed.php?le=NHL&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">NHL Articles Feed</a><br /><br />
    <a href="<?= BASE_URL ?>/process/writers_xml_feed.php?le=BOXING/MMA&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">BOXING/MMA Articles Feed</a>
 
 
<? }else if($book->id == 3){ ?>  
    
    <? if($_GET["category"] == "1"){ ?>
    <span class="page_title">Sports Betting Articles Feeds</span><br /><br />
    <a href="http://www.sportsbettingonline.ag/utilities/feeds/water_cooler.php?type=sportsbook&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">Sportsbook Articles Feed</a><br /><br />
    <a href="http://racebook.sportsbettingonline.ag/utilities/feeds/water_cooler.php?type=racebook&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">Racebook Articles Feed</a><br /><br />
    <? }else if($_GET["category"] == "2"){ ?>
    <span class="page_title">Casino Articles Feeds</span><br /><br />
    <a href="http://casino.sportsbettingonline.ag/utilities/feeds/water_cooler.php?type=casino&aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">Casino Articles Feed</a><br /><br />
    <? } ?>
    
<? }else{echo "This Tool is not available for " . $book->name;} ?>
	</div>
<? include "../includes/footer.php" ?>