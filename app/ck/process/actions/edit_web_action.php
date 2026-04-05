<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<?
$vars["name"] = clean_get("name");
$vars["affiliate"] = clean_get("affiliate");
$vars["id"] = clean_get("update_id");


$web = new ck_website($vars);
$web->update();
header("Location: ../../webs.php?e=18");

?>