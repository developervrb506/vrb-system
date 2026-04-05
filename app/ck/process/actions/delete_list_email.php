<? include(ROOT_PATH . "/ck/process/security.php");
$name = new _list_email();
$name->vars["id"] = $_GET["id"];
$name-> delete();

header("Location: http://localhost:8080/ck/".$_GET["url"]."?e=79");
?>