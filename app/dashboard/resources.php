<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? if ( $_SESSION["aff_id"] == 1033 or $_SESSION["aff_id"] == 1035 ) {
	header("Location: ../reports/index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Resources</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Resources</span><br /><br />

<div class="main_links_box"><a class="normal_link" href="campaignes_list.php">Get Banners, Texlinks or Mailers Codes</a></div>
<? if(affiliate_in_book($current_affiliate->id,1)){?>
<div class="main_links_box"><a class="normal_link" href="widgets.php">Get Odds/Scores Widget Codes</a></div>
<div class="main_links_box"><a class="normal_link" href="lines.php">Get Live Betting Lines Page Code</a></div>
<div class="main_links_box"><a class="normal_link" href="xml.php">Get Live Odds XML Feeds</a></div>
<? } ?>
<div class="main_links_box"><a class="normal_link" href="endorsement.php">Add your Endorsement</a></div>
<br />

<img src="../images/temp/msg.jpg" width="545" height="108" />

</div>
<? include "../includes/footer.php" ?>