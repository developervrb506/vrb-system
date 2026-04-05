<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("pph_ticker")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?
$ticker = get_pph_ticker(param('id'));
if(!is_null($ticker)){
	$ticker->delete();
	?>
    <script type="text/javascript">alert("Ticker has been Deleted");</script>
    <?
}
?>
