<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("all_schedules")){ ?>
<?
$result = new _late_result();
$result->vars["user"] = $_POST["user"];
$result->vars["date"] = $_POST["date"];
$result->vars["hours"] = $_POST["hours"];
$result->vars["in_hour"] = date("G:i:s",strtotime($_POST["in_hour"]));
$result->vars["out_hour"] = date("G:i:s",strtotime($_POST["out_hour"]));
$result->vars["schedule_in"] = date("G:i:s",strtotime($_POST["schedule_in"]));
$result->vars["schedule_out"] = date("G:i:s",strtotime($_POST["schedule_out"]));
$result->vars["result"] = $_POST["result"];
$result->vars["by"] = $current_clerk->vars["id"];
$result->insert();

header("Location: http://localhost:8080/ck/late_report.php");
exit;
?>
<? }else{echo "Access Denied";} ?>