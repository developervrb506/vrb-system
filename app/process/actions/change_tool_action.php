<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$parent = $_SESSION['parent_aff_id'];
if($parent == ""){$parent = $current_affiliate->id;}
if(check_affiliate_website($parent, $_POST["website"])){
	session_start();
	$_SESSION['aff_id'] = $_POST["website"];
	$_SESSION['parent_aff_id'] = $current_affiliate->id;
}
$book = $_POST["book"];
$category = $_POST["product"];
$tool = $_POST["tool"];
$_SESSION['cc'] = $_POST["camp_list"];


switch ($tool) {
    case "1":
        header("Location: ../../dashboard/campaignes_list_new.php?book=$book&category=$category&tool=1");
        break;
    case "2":
        header("Location: ../../dashboard/odds_ticker.php?book=$book");
        break;
    case "3":
        header("Location: ../../dashboard/lines_new.php?book=$book&category=$category");
        break;
	case "4":
        header("Location: ../../dashboard/campaignes_list_new.php?book=$book&category=$category&tool=4");
        break;
	case "5":
        header("Location: ../../dashboard/personal_text_links.php?b=$book");
        break;
	case "6":
        header("Location: ../../dashboard/campaignes_list_new.php?book=$book&category=$category&tool=6");
        break;
	case "7":
        header("Location: ../../dashboard/endorsement_new.php?book=$book");
        break;
	case "8":
        header("Location: ../../dashboard/review_new.php?book=$book&category=$category");
        break;
	case "9":
        header("Location: ../../dashboard/xml.php?book=$book");
        break;
	case "10":
        header("Location: ../../dashboard/trainer_new.php?book=$book&category=$category");
        break;
	case "11":
        header("Location: ../../dashboard/twitter_widget.php?book=$book&category=$category");
        break;
	case "12":
        header("Location: ../../dashboard/writer_page.php?book=$book&category=$category");
        break;
	case "13":
        header("Location: ../../dashboard/writer_feed.php?book=$book&category=$category");
        break;
	case "14":
        header("Location: ../../dashboard/twitter_page.php?book=$book&category=$category");
        break;
	case "15":
        header("Location: ../../dashboard/trends_widget.php?book=$book&category=$category");
        break;
	case "16":
        header("Location: ../../dashboard/odds_widgets.php?book=$book");
        break;
	case "17":
		header("Location: ../../dashboard/press_feed.php?book=$book&category=$category");
		break;
	case "18":
		header("Location: ../../dashboard/casino_games_links.php?b=$book");
		break;
	case "20":
		header("Location: ../../dashboard/contest_widget.php?book=$book");
		break;
	default:
       header("Location: ../../dashboard/tools.php");
}
?>