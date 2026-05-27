<?php
include(ROOT_PATH . "/ck/process/security.php");
if($current_clerk->im_allow("affiliates_system")){ 

$afcode     = strtoupper($_POST["afcode"]);
//$afpassword = $_POST["afpassword"];
$afpassword = $afcode;
$affid      = $_POST["affid"];
//$bookid   = $_POST["bookid"];

//Stephanie wants that all the new affiliates promote these brands: SBO, PBJ, OWI, BITBET and HRB

//Date of change: 02/23/2022

$books = sportsbooks_to_promote();

foreach ($books as $bookid){
   update_affiliates_by_sportbook($affid,$bookid,$afcode,$afpassword);
}

header("Location: " . BASE_URL . "/ck/affiliates/partners_approve.php?e=4");
?>
<? } else { echo "ACCESS DENIED"; }?>