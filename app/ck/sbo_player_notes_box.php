<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("player_notes")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="http://localhost:8080/includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="http://localhost:8080/includes/calendar/jsDatePick.min.1.3.js"></script>

</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Online Messages</span><br />
<br />
<? 
$player = param('player');
$msg_id = param('msg');
$d = param('delete');
$n = param('new');
$c = param('close');
$expiration_date = param('expire',false);
$hour = param('hour',false);
$minute = param('minute',false);
$msg = str_replace(" ","_",param('msg_str'));


?>
<div class="form_box">
  
 <? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_player_notes_box.php?player=".$player."&msg=".$msg_id."&msg_str=".$msg."&delete=".$d."&new=".$n."&expiration_date=".$expiration_date."&hour=".$hour."&minute=".$minute."&close=".$c); ?>  
  
</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>