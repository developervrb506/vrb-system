<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("props_system")) {
ini_set('memory_limit', '-1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Import Odds To Win</title>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="http://www.sportsbettingonline.ag/utilities/js/validate.js?exp_date=20190716"></script>


</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Import Odds To Win</span><br /><br />
<? include "includes/print_error.php" ?>

<? $keywords = clean_str_ck($_POST["keywords"]); ?>
<? $book = param('book'); ?>
<? $league = param('l'); ?>
<? $sport = param('s',false); ?>

  
  <strong>Book:</strong> 
  <select id ="book"  onchange="reload_page();">
  <option value="">Select a Book</option>
  <option <? if($book == "B") { echo ' selected="selected" '; }?>  value="B">BOVADA</option>
  <option <? if($book == "J") { echo ' selected="selected" '; }?> value="J">JAZZ</option>
  </select>
  <BR><BR>

<? if($book == "J") { ?>

<form method="post">
Keywords (comma separated):<br />
<input name="keywords" type="text" id="keywords" value="<? echo $keywords; ?>" />
<input name="book" type="hidden" id="" value="<? echo $book; ?>" />
<br /><br />
<input name="sent" type="submit" id="sent" value="Search" />
</form>

<? } ?>
<? //echo "http://www.sportsbettingonline.ag/utilities/process/reports/import_odds_new_test.php?kw=".urlencode($keywords)."&b=".$book."&s=".$sport; ?>
<? if($book != "") { ?>
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/import_odds_new_test.php?kw=".urlencode($keywords)."&b=".$book."&s=".$sport."&l=".$league); ?>
<? } ?>

</div>
<script type="text/javascript">
	
 function reload_page(){
 	var book = document.getElementById('book').value;
 	window.location.href = "http://localhost:8080/ck/import_odds_test.php?book="+book;
 	//alert(book);
 }
 
</script>
<? include "../includes/footer.php" ?>

<? } ?>
