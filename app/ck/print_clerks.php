<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$clerks = get_all_clerks_index(1,  "", false,true,"id");

echo json_encode($clerks);



?>
