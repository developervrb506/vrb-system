<? 
require_once(ROOT_PATH . "/ck/process/security.php");
require_once(ROOT_PATH . '/../../../../includes/html_dom_parser.php');  
require_once('../functions.php');
$game = get_baseball_game($_POST["gid"]);
$game->vars["startdate"] = $_POST["startdate"];
$game->update(array("startdate"));
$data = "?gid=".$_POST["gid"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../../process/js/functions.js?v=2"></script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Game Hour</span><br />
<br />
<div id="pitcher">Loading Info, this proccess take some minutes Please Wait...</div>
   <br />
    <script type="text/javascript">
	load_url_content_in_div('<?= BASE_URL ?>/ck/baseball_file/process/actions/game_hour_update_action_data.php<? echo $data ?>',"pitcher");
    </script>
</div>	

<!--<script type="text/javascript">parent.location.href="<?= BASE_URL ?>/ck/baseball_file/report.php"</script>-->
</body>
</html>

