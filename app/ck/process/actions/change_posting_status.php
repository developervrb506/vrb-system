<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$id        = $_GET["id"];
$status_id = $_GET["status_id"];

$posting = get_posting($id);

if(!is_null($posting)){	
  $posting->vars["post_status"] = $status_id;  		
  $posting->update(array("post_status"));	
}

header("Location: " . BASE_URL . "/ck/posting/posting_view.php");

?>
