<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$mobile = clean_str_ck($_GET["mobile"]);
$web = clean_str_ck($_GET["web"]);
$account = clean_str_ck($_GET["wpx"]);


//Functionality here
get_tickets_to_update_field_by_account('pread',1,two_way_enc($account,true));

header("Location: ../list.php?wpx=$account&mobile=$mobile&web=$web");	
?>