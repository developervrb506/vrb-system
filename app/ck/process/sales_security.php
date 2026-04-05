<? 
if (!$current_clerk->vars["level"]->vars["is_sales"] && !$current_clerk->vars["level"]->vars["is_admin"]){
	session_destroy();
	header("Location: http://localhost:8080/index.php?3");
}
?>