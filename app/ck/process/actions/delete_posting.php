<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$posting = get_posting($_GET["id"]);

if(!is_null($posting)){	
  $posting->delete();	
}

header("Location: " . BASE_URL . "/ck/posting/posting_view.php");

?>
