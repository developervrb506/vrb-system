<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?

$name   = clean_str($_POST["name"]);
$desc   = clean_str($_POST["desc"]);

insert_custom_campaign(new custom_campaign("", $name, $desc, $current_affiliate->id, 0));

header("Location: " . BASE_URL . "/dashboard/custom_campaigns.php?e=16");	 

?>