<? 
if (!$current_clerk->vars["level"]->vars["is_sales"] && !$current_clerk->vars["level"]->vars["is_admin"]){
	session_destroy();
	header("Location: " . BASE_URL . "/index.php?3");
}
?>