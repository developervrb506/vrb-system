<?php 
session_start();
include(ROOT_PATH . "/simplecaptcha/simple-php-captcha.php");
$_SESSION['captcha'] = captcha();
$_SESSION['vrb_form_code'] = md5(strtolower($_SESSION['captcha']['code']));

header("Location: simplecaptcha/simple-php-captcha.php?_CAPTCHA&t=".mt_rand());

?>