<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$text   = $_POST["text_content"];

$link = clean_url($_POST["text_url"],true);

$book = $_POST["text_book"];

$promo = new promo(0, $text . "_-_" . $current_affiliate->id . "_-_" . $link . "_-_" . $book, "t");
$campaign = new campaigne(-1, "", "", "", NULL, "");

insert_promo($promo, $campaign);
	
header("Location: http://localhost:8080/dashboard/personal_text_links.php?b=$book&e=8");	 

?>