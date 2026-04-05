<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<?
$keyword = new _tweet_keyword();

$keyword->vars["keyword"] = clean_get("name");
$keyword->vars["added_date"] = date("Y-m-d");


if(isset($_POST["update_id"])){
	$keyword->vars["available"] = $_POST["available"];
	$keyword->vars["id"] = clean_get("update_id");
	$keyword->update();
	header("Location: ../../tweet_keyword.php?e=87");
}else{
	
	$keyword->vars["available"] = 1;
	$keyword->insert();
	header("Location: ../../tweet_keyword.php?e=88");
}
?>
<? }else{echo "Access Denied";} ?>

