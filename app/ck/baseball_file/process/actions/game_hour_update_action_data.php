<? 
require_once(ROOT_PATH . "/ck/process/security.php");
require_once(ROOT_PATH . '/../../../../includes/html_dom_parser.php');  
require_once('../functions.php');
ini_set('memory_limit', '-1');
set_time_limit(0);
$gid = "gid=".$_GET["gid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body style="background:#fff; padding:20px;">
<div style="display:none">
<?
require_once("http://localhost:8080/ck/baseball_file/jobs/espn_games.php");

echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_by_game.php?".$gid);
echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_data_home.php?".$gid);
echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_data_away.php?".$gid);
echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_velocity_home.php?".$gid);
echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_velocity_away.php?".$gid);
echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_groundball.php?".$gid);

?>
</div>
Update Completed
</body>
<script type="text/javascript">
parent.location.href="http://localhost:8080/ck/baseball_file/report.php"
</script>
</html>

