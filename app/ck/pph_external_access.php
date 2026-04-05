<?
include(ROOT_PATH . "/ck/db/handler.php");

$account = get_pph_account_by_name($_GET["acc"]);

if(!is_null($account)){echo "1";}else{echo "0";}

?>