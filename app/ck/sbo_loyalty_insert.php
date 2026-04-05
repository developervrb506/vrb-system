<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_loyalty")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:20px; background:#fff;">
<?
$qs = "?p=".$_GET["p"];
$qs .= "&l=".$_GET["l"];
$qs .= "&e=".$_GET["e"];
?>

<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_loyalty_insert.php$qs"); ?>


</div>
<? }else{echo "Acces Denied";} ?>