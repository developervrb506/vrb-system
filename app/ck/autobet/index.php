<? include(ROOT_PATH . "/ck/process/functions.php"); ?>
<? include("Snoopy.class.php"); ?>
<?


$snoopy = new Snoopy;
$snoopy->proxy_host = "76.108.146.118";
$snoopy->proxy_port = 808;
$snoopy->proxy_user = "florida";
$snoopy->proxy_pass = "gators";
//$snoopy->_isproxy = true;
//$snoopy->user = "florida";
//$snoopy->pass = "gators";



$snoopy->fetch(BASE_URL . "/ip.php");
print $snoopy->results;




?>