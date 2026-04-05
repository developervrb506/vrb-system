<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?
$site = $_GET["site"];
$book = $_GET["book"];
$url = $_GET["content"];
if ($url == "" || $url == "Add url target"){ $url = 0;}

$book_url = get_site_target_books($site,$book);


if (!is_null($book_url)){
	
	
	$book_url->vars["target"] = $url;
	$book_url->update(array("target"));
	

}else{
	   
	   $book_new_url = new _sites_target_books();
	   $book_new_url->vars["site"] = $site;
	   $book_new_url->vars["book"] = $book;
       $book_new_url->vars["target"]= $url;
	   $book_new_url->insert();
}
				
				

?>
