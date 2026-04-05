<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("line_blocker")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?
//print_r($_POST);
if (isset($_POST["id"])){
$id = $_POST["id"];
$limit = $_POST["limit"];
}
else {
 $id = $_GET["id"];
 $limit = $_GET["limit"];	

}


echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_money_line_blocker_action.php?id=".$id."&limit=".$limit);

header("Location: ../../agent_money_line_blocker.php");


?>
