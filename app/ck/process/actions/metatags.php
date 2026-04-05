<? 
include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("seo_menu")){

if( isset($_GET["id"]) ) {	
	$metatag = get_metatag($_GET["id"]);
	$metatag->delete();
	$action = "d";
}else {
	if( isset($_POST["metatag_id"]) ) {	
	
	  $metatag = get_metatag($_POST["metatag_id"]);
	  $metatag->vars["url"]   = clean_str_ck($_POST["url"]);
	  $metatag->vars["title"] = clean_str_ck($_POST["title"]);	  
	  $metatag->vars["description"] = clean_str_ck( $_POST["description"]);
	  $metatag->vars["keywords"] = clean_str_ck($_POST["keywords"]);
	  $metatag->vars["h1"] = clean_str_ck($_POST["h1"]);
	  $metatag->vars["body_text"] = clean_str_ck($_POST["body_text"]);
	 
	  $metatag->update();
	  $action = "u";
	  
	}
	else{
	  $metatag = new _metatags;
	  $metatag->vars["url"]   = clean_str_ck($_POST["url"]);
	  $metatag->vars["title"] = clean_str_ck($_POST["title"]);  
	  $metatag->vars["description"] = clean_str_ck($_POST["description"]);
	  $metatag->vars["keywords"] = clean_str_ck($_POST["keywords"]);
	  $metatag->vars["h1"] = clean_str_ck($_POST["h1"]);
	  $metatag->vars["body_text"] = clean_str_ck($_POST["body_text"]);
	  
	  $metatag->insert();
	  $action = "a";	
	}
}

header("Location: http://localhost:8080/ck/metatags.php?a=".$action);
	
?>
<? } else { echo "ACCESS DENIED"; }?>