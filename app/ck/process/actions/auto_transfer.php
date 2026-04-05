<? $no_log_page = true; ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<meta http-equiv="refresh" content="15; url=http://localhost:8080/ck/process/actions/auto_transfer.php?<? echo mt_rand() ?>"> 
<?
if(!is_null(get_transfer_relation($current_clerk->vars["id"],"1"))){
	if(is_null(get_open_call($current_clerk->vars["id"]))){
		?><script type="text/javascript">parent.location.href='http://localhost:8080/ck/transfering.php';</script><?
	}
}
?>