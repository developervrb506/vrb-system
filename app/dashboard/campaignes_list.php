<? include(ROOT_PATH . "/process/login/security.php"); ?>
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

<span class="page_title">Select a Campaign</span><br /><br />


<?
$aff_books = get_affiliate_sportsbooks($current_affiliate->id);
foreach($aff_books as $book){
$campaignes = get_all_campaignes_by_sportbook($book); 
echo ucwords($book->name) . " Campaigns<br /><br />";
?>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Name</td>
    <td class="table_header">Banners</td>
    <td class="table_header">Text Links</td>
    <td class="table_header">Mailers</td>
  </tr>
	<? 
    $i = 0;
    foreach($campaignes as $camp){ 
	if($i % 2){$style = "1";}else{$style = "2";}
    ?>
  <tr>
    <td class="table_td<? echo $style ?>"><? echo strtoupper($camp->name) ?></td>
    <td class="table_td<? echo $style ?>"><a href="campaigne_promos.php?cid=<? echo $camp->id ?>" class="normal_link">Get Banners</a></td>
    <td class="table_td<? echo $style ?>"><a href="text_links.php?cid=<? echo $camp->id ?>" class="normal_link">Get Text Links</a></td>
    <td class="table_td<? echo $style ?>"><a href="mailer.php?cid=<? echo $camp->id ?>" class="normal_link">Get Mailers Codes</a></td>
  </tr>
  	<? $i++ ?>
<? } ?>
<? if($i % 2){$style = "2";}else{$style = "1";} ?>
   <tr>
    <td class="table_td<? echo $style ?>"><? echo strtoupper($book->name) ?> CUSTOM TEXT LINKS</td>
    <td class="table_td<? echo $style ?>"></td>
    <td class="table_td<? echo $style ?>"><a href="personal_text_links.php?b=<? echo $book->id ?>" class="normal_link">Get Text Links</a></td>
    <td class="table_td<? echo $style ?>"></td>
  </tr>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>
<br /><br />
<? } ?>
</div>

<? include "../includes/footer.php" ?>