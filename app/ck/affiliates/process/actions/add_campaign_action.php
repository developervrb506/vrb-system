<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
 if($current_clerk->im_allow("affiliates_system")){
 
$name = $_POST["name"];
$desc = $_POST["desc"];
$book = $_POST["book"];
$url  = $_POST["url"];
$aff  = $_POST["affiliate"];
$category = $_POST["category"];

if(!is_numeric($aff)){$aff = 0;}

$camp = new _affiliate_campaign();
$camp->vars["name"] = $name;
$camp->vars["desc"] = $desc;
$camp->vars["url"] = $url;
$camp->vars["id_sportsbook"] = $book;
$camp->vars["category"] = $category;
$camp->vars["popular"] = 0;
$camp->vars["active"] = 1;
$camp->vars["affiliate"] = $aff;	
$camp->insert();


//header("Location: http://localhost:8080/ck/affiliates/partners_campaignes.php");

?>
<script>location.href = "http://localhost:8080/ck/affiliates/partners_campaignes.php";</script>
<? } else { echo "ACCESS DENIED"; }?>