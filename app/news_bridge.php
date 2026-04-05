<?   
$action = $_GET["action"];
$search = $_GET["search"];

switch ($action){
	case "news_sbo":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=3&type=1&search=".$search;
	break;
	
	case "press_releases_sbo":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=3&type=2&search=".$search;
	break;
	
	case "infographics_sbo":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=3&type=3&search=".$search;
	break;
	
	case "news_owi":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=7&type=1&search=".$search;
	break;
	
	case "news_hrb":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=9&type=1&search=".$search;
	break;
	
	case "press_releases_hrb":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=9&type=2&search=".$search;
	break;
	
	case "infographics_hrb":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=9&type=3&search=".$search;
	break;
	
	case "news_pbj":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=6&type=1&search=".$search;
	break;
	
	case "news_bitbet":
	  $link = "http://www.sportsbettingonline.ag/utilities/process/postings/print_posting.php?brand=8&type=1&search=".$search;
	break;
}

echo file_get_contents($link);
?>