<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){ 

$cid      = $_POST["cid"];
$name     = $_POST["name"];
$desc     = $_POST["desc"];
$book     = $_POST["book"];
$url      = $_POST["url"];
$active   = $_POST["active"];
$aff      = $_POST["affiliate"];
$category = $_POST["category"];

if (isset($active)) {
  $active = 1;	
}
else {
  $active = 0;	
}

$camp = get_campaign_by_id($cid);
$camp->vars["name"] = $name;
$camp->vars["desc"] = $desc;  
$camp->vars["url"] = $url;
$camp->vars["id_sportsbook"] = $book;
$camp->vars["category"] = $category;
$camp->vars["active"] = $active;
$camp->vars["affiliate"] = $aff;
$camp->update();

//header("Location: http://localhost:8080/ck/affiliates/partners_campaignes.php");
?>
<script>location.href = "http://localhost:8080/ck/affiliates/partners_campaignes.php";</script>
<? } else { echo "ACCESS DENIED"; }?>