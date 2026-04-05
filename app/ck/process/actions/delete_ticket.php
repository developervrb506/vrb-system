<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?

if(isset($_GET["action"])){
	
	$tks = explode(",",$_GET["tks"]);
	//print_r($tks);
	foreach($tks as $_tk){
	 $tk = get_ticket($_tk);
	 
	 if(!is_null($tk)){
	      
		 if($_GET["action"]== 'rm'){ 
		    $tk->vars["removed"] = 1;
			$tk->update(array("removed"));	
		 }
   	   if($_GET["action"]== 'del'){ 
			$tk->vars["deleted"] = 1;
			$tk->update(array("deleted")); 
		 }
	 }
	  	
	 	
	}
	?>
			<script type="text/javascript">alert("Tickets were updated");</script>
	<?
	
	
}else {

	$tk = get_ticket($_GET["id"]);
	if(!is_null($tk)){
		
		
		
		if(!isset($_GET["removed"])){
			$tk->vars["deleted"] = 1;
			$tk->update(array("deleted"));
			?>
			<script type="text/javascript">alert("Ticket has been Deleted");</script>
			<?
		}else {
			$tk->vars["removed"] = 1;
			$tk->update(array("removed"));
			?>
			<script type="text/javascript">alert("Ticket has been Removed");</script>
			<?
		}
		
		if(isset($_GET["v"])){
			
		 ?>
			<script type="text/javascript">
			window.location = "http://localhost:8080/ck/tickets.php"; 
			</script>
			<?
		  // header("Location: http://localhost:8080/ck/tickets.php");	
		}
		
		
	}
}
?>
