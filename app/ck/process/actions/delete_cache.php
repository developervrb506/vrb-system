<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$log = new _cashier_log();
$log->vars["player"] = clean_str_ck($_GET["player"]);
$log->vars["transaction"] = clean_str_ck($_GET["transaction"]);
$log->vars["method"] = clean_str_ck($_GET["method"]);
$log->vars["tdate"] = date("Y-m-d H:i:s");
$log->vars["ip"] = $_SERVER['REMOTE_ADDR'];
$log->vars["url"] = clean_str_ck(str_replace("_AmP_","&",$_GET["url"]));
$log->insert();
?>