<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?
$user = get_clerk($_GET["user"]);
if(!is_null($user)){
	$user->vars["deleted"] = 1;
	$user->update(array("deleted"));
	?>
    <script type="text/javascript">alert("<? echo $user->vars["name"] ?> has been Deleted");</script>
    <?
}
?>
