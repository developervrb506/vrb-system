<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?

$campaign   = get_campaigne($_POST["cid"]);
$text   = $_POST["text_content"];

$promo = new promo(0, $text . "_-_" . $current_affiliate->id . "_-_", "t");

insert_promo($promo, $campaign);
	
header("Location: http://localhost:8080/dashboard/text_links.php?cid=". $campaign->id . "&e=8");	 

?>