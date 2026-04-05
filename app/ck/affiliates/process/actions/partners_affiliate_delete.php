<?php
include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){

$affid = $_GET["affid"];

delete_affiliate($affid);

if (!isset($_GET["approve"])) {
  header("Location: ../../partners_affiliates.php");
} else {
  header("Location: ../../partners_approve.php");	
}
?>
<? } else { echo "ACCESS DENIED"; }?>