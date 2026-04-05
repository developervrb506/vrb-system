<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$name = get_ckname(clean_get("email_name_id"));
if($name->vars["on_the_phone"]){
	$name->vars["email"] = clean_get("email_address");
	$subject = clean_get("email_subject");
	$content = $_POST["email_body"];
	
	send_email_ck($name->vars["email"], $subject, $content, true, $current_clerk->vars["fake_email"]);
		
	$name->update(array("email"));
	
	?>
    <script type="text/javascript">
		alert("Email Sent");
	</script>
    <?
}else{
	?>
    <script type="text/javascript">
		alert("You are not allowed to email this person");
	</script>
    <?
}

echo $content;

?>