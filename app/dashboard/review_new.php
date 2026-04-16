<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? $book = $_GET["book"]; ?>
<? $category = $_GET["category"]; ?>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reviews</title>
</head>
<body>
<? include "../includes/header.php" ?>
  <? include "../includes/menu.php" ?>
<? $code = get_affiliate_code($current_affiliate->id, $book); ?>  
<div class="page_content" style="padding-left:20px;"> 
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title">Reviews</span><br /><br /><br />
<? 
switch($book){
	case "1":
		if($category == "1"){include("reviews/ww_book.php");}
		else if($category == "2"){include("reviews/ww_casino.php");}
	break;
	case "3":
		if($category == "1"){include("reviews/sbo_book.php");}
		else if($category == "2"){include("reviews/sbo_casino.php");}
	break;
	case "4":
		include("reviews/bol.php");
	break;
	case "6":
		include("reviews/pbj.php");
	break;
	case "7":
		include("reviews/bowi.php");
	break;
}
?>
</div>
<? include "../includes/footer.php" ?>