<? 
if (!$current_clerk->admin()){
	session_destroy();
	header("Location: " . BASE_URL . "/index.php");
}
?>