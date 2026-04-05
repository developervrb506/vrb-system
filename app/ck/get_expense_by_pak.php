<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$pak = clean_str_ck($_GET["p"]);
$trans = get_expense_by_pak($pak);
echo json_encode($trans);
?>
