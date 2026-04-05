<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if (!$current_clerk->im_allow("rules")){ ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");}} ?>
<?

$vars["title"] = clean_get("title");
$vars["content"] = clean_get("content");

if(isset($_POST["update_id"])){
	$vars["id"] = clean_get("update_id");
	$rule = new rule($vars);
	$rule->delete_reads();
	$rule->update();
	$rule->insert_no_reads("2");
	header("Location: ../../rules.php?e=12");
}else{

   $total_clerk = $_POST["total_clerks"];  
   $rule = new rule($vars);
  $rule->insert();
   for ($x=1; $x<$total_clerk;$x++){
 
	 if(isset($_POST["clerk_".$x])){
	  	$rule->insert_no_reads($_POST["clerk_".$x]); 
	 }
   
   }
   header("Location: ../../rules.php?e=13");
}

?>