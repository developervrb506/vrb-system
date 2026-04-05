<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_admin")){ ?>
<? 
$note_num = clean_str_ck($_GET["num"]);
$account = clean_str_ck($_GET["player"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">

<div class="form_box">
	<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_player_note.php?player=$account&num=$note_num"); ?>
</div>


</div>



<? }else{echo "Access Denied";} ?>