<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){

if( isset($_GET["id"]) ) {	
	$testimonial = get_testimonials_affiliate($_GET["id"]);
	$testimonial->delete();
	$action = "d";
}else {
	if( isset($_POST["testimonial_id"]) ) {	
	
	  $testimonial = get_testimonials_affiliate($_POST["testimonial_id"]);
	  $testimonial->vars["description"] = str_replace("'","\'",$_POST["description"]);
	  $testimonial->vars["person_name"] = str_replace("'","\'",$_POST["person_name"]);
	  $testimonial->update();
	  $action = "u";
	  
	}
	else{
	  $testimonial = new _affiliate_testimonial;
	  $testimonial->vars["description"] = str_replace("'","\'",$_POST["description"]);
	  $testimonial->vars["person_name"] = str_replace("'","\'",$_POST["person_name"]);
	  $testimonial->insert();
	  $action = "a";	
	}
}

header("Location: " . BASE_URL . "/ck/affiliates/partners_testimonials.php?a=".$action);
	
?>
<? } else { echo "ACCESS DENIED"; }?>