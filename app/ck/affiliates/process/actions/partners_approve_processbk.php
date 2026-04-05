<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){ 

$afcode     = $_POST["afcode"];
$afpassword = $_POST["afpassword"];
$affid      = $_POST["affid"];
$bookid     = $_POST["bookid"];

update_affiliates_by_sportbook($affid,$bookid,strtoupper($afcode),$afpassword);


header("Location: http://localhost:8080/ck/affiliates/partners_approve.php?e=4");
?>
<? } else { echo "ACCESS DENIED"; }?>