<? include(ROOT_PATH . "/process/login/admin_security.php"); ?>
<?

$name   = clean_str($_POST["name"]);
$desc   = clean_str($_POST["desc"]);
$book   = clean_str($_POST["book"]);
$url   = clean_str($_POST["url"]);

$camp = new campaigne(0, $name, $desc, $url, array(),get_sportsbook($book));
insert_campaigne($camp);
	
header("Location: http://jobs.inspin.com/wp-admin/partners_campaignes.php");	 

?>