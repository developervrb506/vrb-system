<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Conversion for El Dorado</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%m/%d/%Y"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%m/%d/%Y"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<?
$from_date = $_POST["from"];
$to_date = $_POST["to"];
$split = $_POST["split"];
$def_endo = "WagerWeb - located in Costa Rica, started over a decade ago and has grown into one of the largest operations in San Jose. WagerWeb offers many betting options, a complete bonus package and an awesome website, filled with news, stories, contests, live radio and more. For year-round players, WagerWeb offers a graduated line on baseball and has a solid rebate driven rewards program. Off Shore Gaming Association (OSGA)";
?>
<div class="page_content" style="padding-left:50px;">
<div style="text-align:right"><a class="normal_link" href="../process/login/logout.php">Logout</a></div>
<span class="page_title">Conversion for El Dorado</span><br /><br />

<form method="post" action="conversion_el_dorado.php">
<input name="run" type="hidden" id="run" value="1" />
From: <input name="from" type="text" id="from" size="10" value="<? echo $from_date ?>" /> &nbsp;&nbsp;
To: <input name="to" type="text" id="to" size="10" value="<? echo $to_date ?>" /> &nbsp;&nbsp;
Split Endorsement <input <? if($split){echo 'checked="checked"';} ?> name="split" type="checkbox" id="split" value="1" />
<input name="" type="submit" value="Search" /><br /><br />
</form>

<br /><br />

<? 
$content = @file_get_contents("http://lb.wagerweb.com/vrb/reports/ag_GetConversionForElDorado.asp?txtDate='$from_date'&txtDate2='$to_date'");

$key1 = "endorsement-";

$aff_count = substr_count ($content , $key1);

for($i=0;$i<$aff_count;$i++){
	$pos_a = strpos($content,$key1);
	$endo_code = substr($content,$pos_a,27);
	$parts = explode("-",$endo_code);
	$af_num = $parts[1];
	$affiliate = get_affiliate_by_AF($af_num);
	$endo_array = get_endorsement($affiliate->id, 1);
	$endorsement = $endo_array[0]." ".$endo_array[1];
	if($endo_array[0] == ""){$endorsement = $def_endo;}
	if($split){
		$content = str_replace(' style="display:none"',"",$content);				
		$parts = explode(" ",$endorsement);
		$half = count($parts) / 2;
		$p1 = implode(" ",array_slice($parts,0,$half));
		$p2 = implode(" ",array_slice($parts,$half));

		$content = str_replace("endorsement-$af_num-endorsement",$p1,$content);
		$content = str_replace("endorsement2-$af_num-endorsement2",$p2,$content);
	}else{
		$content = str_replace("endorsement-$af_num-endorsement",$endorsement,$content);
	}
	
}

echo $content;
?>
</div>
<? include "../includes/footer.php" ?>