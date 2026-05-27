<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("player_notes")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Player's Notes</title>

</head>
<body>
<? $page_style = " width:1900px;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;"><br /><br />
<span class="page_title">Player's Notes</span><br /><br />



<? include "./includes/postups_brands.php" ?>

<?
$page_index = param("page_index");
if(!is_numeric($page_index)){$page_index = 0;}
$items_per_page = 100;
	

$b = $_GET["brand"];
$acc = $_GET["acc"];
if($b == ""){$b = "SBO"; }
?>
<form method="get" id="former">
<input type="hidden" value="<? $page_index ?>" name="page_index" id="page_index" />
Brand:
<select name="brand" >
 <? foreach ($postup_brands as $brand){ ?> 
 <option <? if ($b == $brand["id"] && $brand["id"] != 2){ echo 'selected="selected"'; }?> value="<? echo $brand["id"]?>"><? echo $brand["site"]?></option> 
 <? } ?>
</select>
&nbsp;&nbsp;
Player:
<input type="text" name="acc" value="<? echo $acc ?>"/>

<input type="submit" value="Search" />
</form>
<br />
<?
$data = "?b=".$b."&page_index=".$page_index."&acc=".$acc;
?>

<? include "includes/print_error.php" ?> 
 
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_player_notes.php".$data); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>