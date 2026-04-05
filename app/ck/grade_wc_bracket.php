<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("wc_bracket_admin")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />

<title>World Cup Braket Grading</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">World Cup Braket Grading</span><br /><br />

<iframe frameborder="0" width="100%" height="1000" src="http://www.sportsbettingonline.ag/world_cup_bracket/process/admin_login_process.php?pass=b7185ce51e047076bfd71ec775f03e81" scrolling="no"></iframe>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>