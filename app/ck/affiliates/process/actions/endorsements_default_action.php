<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){

if( isset($_GET["id"]) ) {	
	$end = get_endorsement_default_affiliate($_GET["id"]);
	$end->delete();
	$action = "d";
}else {
	if( isset($_POST["update"]) ) {	
	
	  $end = get_endorsement_default_affiliate($_POST["id"]);
	  $end->vars["endorsement"] = str_replace("'","\'",$_POST["endorsement"]);
	  $end->vars["idbook"] = $_POST["text_book"];
	  $end->update();
	  $action = "u";
	  
	}
	else{
	  $end = new _endorsements_default();
	  $end->vars["endorsement"] = str_replace("'","\'",$_POST["endorsement"]);
	  $end->vars["idbook"] = $_POST["text_book"];
	  $end->insert();
	  $action = "a";	
	}
}

header("Location: http://localhost:8080/ck/affiliates/endorsements_default.php?a=".$action);
	
?>
<? } else { echo "ACCESS DENIED"; }?>