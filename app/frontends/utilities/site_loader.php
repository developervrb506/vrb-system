<?php
include($_SERVER['DOCUMENT_ROOT']."/frontends/utilities/ui/header.php");


switch($page){ 
	case "terms":
		$page = "terms.php";
	break;
	default :
		$page = "headlines.php";
	break;
}

include($_SERVER['DOCUMENT_ROOT']."/frontends/utilities/ui/$page");	

include($_SERVER['DOCUMENT_ROOT']."/frontends/utilities/ui/footer.php");	

?>