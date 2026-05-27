<? include(ROOT_PATH . "/ck/process/functions.php"); ?>
<? session_start(); if ($_SESSION["ckloged"]){ header("Location: ck/index.php"); } ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/process/js/functions.js?v=2"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VRB Marketing Consultants</title>
<link href="css/style-new_design.css" rel="stylesheet" type="text/css" />   
<link rel="shortcut icon" href="/images/favicon.jpg" type="image/x-icon" />
</head>
<body>
<div align="center">
<?
$token = new _login_token();
$token->generate();
?>
<form id="f1" name="f1" method="post" action="<?= BASE_URL ?>/process/login/login-process_out.php">

    <input name="email" type="text" id="email_login" size="16" value="Your username" onblur="reverse_msg(this, 'Your username');" onfocus="reverse_msg(this, 'Your username');" />


    <input name="pass" type="password" id="pass" size="16" value="passwordXaX" onblur="reverse_msg(this, 'passwordXaX');" onfocus="reverse_msg(this, 'passwordXaX');" />

    <? echo $_SESSION['token'][0] ?><input name="t1" type="password" id="t1" size="4" />

    <? echo $_SESSION['token'][1] ?><input name="t2" type="password" id="t2" size="4" />

    <? echo $_SESSION['token'][2] ?><input name="t3" type="password" id="t3" size="4" />

    <input name="loginbtn" type="image" id="loginbtn" value="Login" src="/images/new_design/login_btn.png" />

</form>
</div>
</body>
</html>