<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 

if(isset($_GET["st"])){
	
	
	$st = $_GET["st"];
	$wind = $_GET["wd"];

	$wind_stats =  get_stadium_wind_data($st);
    $i = 0;
}

?>
<body style="background:#CCC; padding:0px;">
<div   style="background-color:#696" id="pitcher">

<table width="100%" border="0" cellspacing="" >
<tr>

<td  width="120"  class="table_header" align="center">WIND</td>
<td  width="120"  class="table_header" align="center">R AVG</td>
<td  width="120"  class="table_header" align="center">HR AVG</td>
<td  width="120"  class="table_header" align="center">GAMES</td>
</tr>

<? foreach ($wind_stats as $ws){ if($i % 2){$style = "1";}else{$style = "2";} $i++;	$sw=false;?>
<? if($wind == $ws->vars["wind"] ){ $sw = true; }?>
    <tr>
    <td class="table_td<? echo $style ?>" align="center" <? if($sw){?> style="background-color:#0C0" <? } ?> >
	<a id="wind" style="" target="_blank" href="wind_direction_report.php?stadium=<? echo $st ?>&wind=<? echo $wind ?>" class="normal_link" >
	<? echo $ws->vars["wind"] ?></a>
	</td> 
    <td class="table_td<? echo $style ?>" align="center" <? if($sw){?> style="background-color:#0C0" <? } ?>><? echo $ws->vars["avg_runs"] ?></td> 
    <td class="table_td<? echo $style ?>" align="center" <? if($sw){?> style="background-color:#0C0" <? } ?>><? echo $ws->vars["avg_homeruns"] ?></td> 
    <td class="table_td<? echo $style ?>" align="center" <? if($sw){?> style="background-color:#0C0" <? } ?>><? echo $ws->vars["games"] ?></td> 
    </tr>
<? } ?>
</table>
</div>



</body>
</html>

