<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("tweets")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?

$tweet = get_tweet($_GET["tweet"]);
if(!is_null($tweet)){
	$tweet->vars["available"] = 0;
	$tweet->update(array("available"));
	?>
    <script type="text/javascript">alert("Tweet has been Disabled");</script>
    <?
}

?>
