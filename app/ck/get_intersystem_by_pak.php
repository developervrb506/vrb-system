<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$pak = clean_str_ck($_GET["p"]);
$trans = get_intersystem_by_pak($pak);
$accs = $trans->get_accounts();
$trans->vars["destination"] = $accs["to_account"]["name"] . " (". $accs["to_system"]["name"].")";
echo json_encode($trans);
?>
