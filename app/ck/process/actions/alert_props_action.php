<?   include(ROOT_PATH . "/ck/process/security.php");
 require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/
$alert = get_props_alert($_POST["id"]);
$alert->vars["reviewed"] = $current_clerk->vars['id'];
$alert->vars["reviewed_date"] = date("Y-m-d H:i:s");
$alert->vars["comment"] = $_POST["comment"];
$alert->update();


header("Location: ../../props_alerts.php");
?>