<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("pph_ticker")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?
$message = get_agent_message(param('id'));
if(!is_null($message)){
	$message->delete();
	?>
    <script type="text/javascript">alert("The message has been deleted");</script>
    <?
}
?>
