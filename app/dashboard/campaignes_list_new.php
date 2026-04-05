<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$gb = $_GET["book"];
$gc = $_GET["category"];
$gt = $_GET["tool"];
if($gb == "" || $gc == "" || $gt == ""){
	$gb = $_COOKIE["banbook"]; 
	$gc = $_COOKIE["bancat"]; 
	$gt = $_COOKIE["battool"]; 
}else{
	setcookie("banbook", $gb); 
	setcookie("bancat", $gc);
	setcookie("battool", $gt); 
}
$book = get_sportsbook($gb);
$category =  get_category($gc);
$tool =  $gt;
?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Campaigns</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title">Select a Campaign</span><br /><br />
<?
if ($tool <> "4") {
  $campaignes = search_campaign($book, $category, $current_affiliate->id); 
}
else {
  $campaignes = search_campaign_exclude($book, $category, $current_affiliate->id);	
}
echo ucwords($book->name) . " " . ucwords($category->name) . " Campaigns for <strong>" . ucwords($current_affiliate->web_name) . "</strong><br /><br />";
?>

<? if($_GET["tool"] == 6){ ?>
Please contact us at <a href="mailto:vrbaffiliates@gmail.com" class="normal_link">vrbaffiliates@gmail.com</a> or 1.800.986.1152 to request your custom email template. <br /><br />

<? } ?>

<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Name</td>
    <td class="table_header"></td>
  </tr>
	<? 
    $i = 0;
    foreach($campaignes as $camp){ 
		if($i % 2){$style = "1";}else{$style = "2";}
    ?>
  <tr>
    <td class="table_td<? echo $style ?>"><? echo strtoupper($camp->name) ?></td>
    <?
	switch ($tool) {
    case "1":
        ?><td class="table_td<? echo $style ?>"><a href="campaigne_promos.php?cid=<? echo $camp->id ?>" class="normal_link">Get Banners</a></td><?
        break;
    case "4":
        ?><td class="table_td<? echo $style ?>"><a href="text_links.php?cid=<? echo $camp->id ?>" class="normal_link">Get Text Links</a></td><?
        break;
    case "6":
        ?><td class="table_td<? echo $style ?>"><a href="mailer.php?cid=<? echo $camp->id ?>" class="normal_link">Get Email Templates</a></td><?
        break;
	}
	?> 
  </tr>
  	<? $i++ ?>
<? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>
</div>

<? include "../includes/footer.php" ?>