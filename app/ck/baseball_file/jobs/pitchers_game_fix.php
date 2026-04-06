<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../process/js/functions.js"></script>

</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Pitcher Fix</span><br />
<br />

<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  
set_time_limit(0);

$data = "?date=".$_GET["date"]."";

if(isset($_GET["player"])){
	$player_team =  new _baseball_player_teams();
	$player_team->vars["player"]=$_GET["player"];  
	$player_team->vars["team"]=$_GET["team"]; 
    $player_team->vars["season"]=date("Y");  
	$player_team->insert();
	header("Location: pitchers_game_fix.php".$data);
}

?>
<div id="pitcher">Loading Info, this proccess take some minutes Please Wait...</div>
   <br />
    <script type="text/javascript">
	load_url_content_in_div('<?= BASE_URL ?>/ck/baseball_file/jobs/pitchers_game_fix_data.php<? echo $data ?>',"pitcher");
    </script>
</div>	

</body>
</html>

