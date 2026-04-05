<?php
//require_once(ROOT_PATH . "/process/functions.php");
session_start();
session_destroy();
//$sessionid = GetSessionId();
//$value = Logout2($sessionid);
header("Location: ../../index.php");
exit;
?>