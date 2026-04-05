<?
function cleaner($str) {	
	$str = preg_replace("/[^A-Za-z0-9,.]/", "", $str);
	return $str;  
}
function check_query($text){
	global $words;
	foreach($words as $word){
		if(contains_ck($text,$word)){
			?>
            <script type="text/javascript">
			document.getElementById("alerts").innerHTML += '<br /> <strong><? echo $word ?> found:</strong>&nbsp;&nbsp;&nbsp; <? echo $text ?>';
			</script>
            <?
		}
	}
}
$words = explode(",",cleaner($_GET["a"]));
session_start();
if($_SESSION["printallow"] != "yes"){
	if(isset($_POST["user"])){
		if(md5($_POST["user"]) == "c8afdba99725fdada06c908bf7afcb2a" && md5($_POST["pass"]) == "9400c2096d43b49ca4fb5acf8b678d38"){
			$_SESSION["printallow"] = "yes";
		}
		header("Location: print_font.php?".mt_rand());
	}else{
		?>
		<form method="post">
        User: <input name="user" type="text" />
        <br />
        Pass: <input name="pass" type="password" />
        <input name="send" type="submit" value="Send" />
        </form>
        <?	
	}
}else{
?>
<meta http-equiv="refresh" content="10" >
<style type="text/css">
body,td,th {
	color: #0F0;
}
body {
	background-color: #000;
}
</style>
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

$sql = "select * from mysql.general_log ORDER BY event_time DESC LIMIT 0,200";
$res = get_str($sql);
?>
<p>VRB</p>
<div id="alerts" style="color:#F00;"></div>
 <table width="100%" border="0" cellpadding="10"> <?
foreach($res as $row){
	$parts = explode("#system query:",$row["argument"]);
	$argument = $parts[0];
	$url = $parts[1];
	
	$small_t = strtolower($argument);
	if(contains_ck($small_t ,"insert")){$color = "F00";}
	else if(contains_ck($small_t ,"update")){$color = "FF0";}
	else if(contains_ck($small_t ,"delete")){$color = "fff";}
	else{$color = "0F0";}
	
	if(contains_ck(strtolower($row["user_host"]) ,"root")){$ucolor = "F00";}
	else{$ucolor = "0F0";}
	?>
    
      <tr>
        <td><? echo $row["event_time"] ?></td>
        <td style="color:#<? echo $ucolor; ?>"><? echo $row["user_host"] ?></td>
        <td><? echo $row["command_type"] ?></td>
        <td style="color:#<? echo $color; ?>"><? echo $argument; check_query($argument) ?></td>
        <td style="color:#<? echo $color; ?>"><? echo $url ?></td>
      </tr>
    
    <?
}
?> </table> <?

?>

<? } ?>