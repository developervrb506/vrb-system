<?php 
include(ROOT_PATH . "/db/handler.php");

$afcode = clean_str($_POST["afcode"]);
$affid  = clean_str($_POST["affid"]);
$bookid = clean_str($_POST["bookid"]);

update_approved_affiliates($affid,$bookid,strtoupper($afcode));	

header("Location: http://jobs.inspin.com/wp-admin/partners_approve.php?e=4");

?>