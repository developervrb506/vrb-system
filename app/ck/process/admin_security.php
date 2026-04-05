<? 
if (!$current_clerk->admin()){
	session_destroy();
	header("Location: http://localhost:8080/index.php");
}
?>