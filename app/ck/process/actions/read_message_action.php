<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$message = get_ck_message($_GET["m"]);
if($message->vars["from"]->vars["id"] == $current_clerk->vars["id"]){
	$type = "read_from";
}else{
	$type = "read_to";
}
$message->vars[$type] = 1;
$message->update(array($type));
?>