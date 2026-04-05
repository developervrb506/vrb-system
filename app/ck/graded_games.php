<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<script type="text/javascript" src="http://localhost:8080/process/js/ajax.js"></script>
<? if($current_clerk->im_allow("graded_games_checker")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../process/js/jquery.js"></script>
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="http://localhost:8080/includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="http://localhost:8080/includes/calendar/jsDatePick.min.1.3.js"></script>
<? /*
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
	};
</script> */ ?>
<title>Graded Games</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Graded Games</span><br /><br />
<? include "includes/print_error.php" ?> 


<?
$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d");}
$search = $_GET["search"];
$t = $_GET["t"];
$l = explode("_",$_GET["l"]);
$l = $l[0];

$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ); 


//echo "http://www.sportsbettingonline.ag/utilities/process/reports/graded_games.php?from=$from&search=$search&user=".urlencode($current_clerk ->vars["name"])."&l=".$l."&t=".$t;

    //echo file_get_contents('http://www.sportsbettingonline.ag/test.php', false, stream_context_create($arrContextOptions));
   // echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games.php?from=$from&search=$search&user=".urlencode($current_clerk ->vars["name"])."&l=".$l."&t=".$t, false, stream_context_create($arrContextOptions)); 
    echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games.php?from=$from&search=$search&user=".urlencode($current_clerk ->vars["name"])."&l=".$l."&t=".$t); 



?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>