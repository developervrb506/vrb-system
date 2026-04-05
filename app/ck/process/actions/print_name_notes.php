<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333;
}
body {
	background-color: #FFF;
	margin-left: 20px;
	margin-top: 20px;
	margin-right: 20px;
	margin-bottom: 20px;
}
</style>
<? 

$name = get_ckname_by_account($_GET["player"]);

if(!is_null($name)){
	echo nl2br($name->vars["note"]);
}


?>