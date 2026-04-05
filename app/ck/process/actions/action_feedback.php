<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?
if(isset($_GET["important"])){
	
	$tks = explode(",",$_GET["tks"]);
	$important = $_GET["important"];
	foreach($tks as $_tk){
	 $tk = get_ticket($_tk);
	 
		 if(!is_null($tk)){
				$tk->vars["important"] = $important;
				$tk->update(array("important"));
		 }
	  	
	 	
	}
header("Location: http://localhost:8080/ck/tickets_feedback.php?t");	
		
}
?>
