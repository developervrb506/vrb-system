<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$hour_range = 8;
$date = date( "Y-m-d H:i:s", strtotime( "-".$hour_range." hours", strtotime(date( "Y-m-d H:i:s")))); 

echo denied_expired_moneypak_sell($date);




?>