<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<body style="background:#fff; padding:20px;">

<?
set_time_limit(0); 
$link="ftp://monitor:Gravaci0nes@192.168.10.50//";
$callid = $_GET["id"];
$main_path = "/websites/www.vrbmarketing.com/audio/";



$local_file = $callid.'.gsm';

$conn_id = ftp_audio_conecction(); 

// download server file
if (ftp_get($conn_id, $main_path.$local_file, $local_file, FTP_ASCII))
  { 
  $path = BASE_URL . "/audio/".$local_file;
  header("Location: $path");
  ?>
  <div id = "audio" name= "audio" style="color:#FFF">
   <?php /*?> <!--   
    <embed width='248' src='\" . BASE_URL . \"/audio/<? echo $local_file ?>' urlsubstitute='<samplestring>:<http://localhost:8080/ck/images/reload.png>'>--><?php */    ?>
     FILE DOWNLOADED SUCCESSFULLY, You can use this program to hear the file<BR>
     <a href="http://www.videolan.org/vlc/download-windows.html" target="_blank"><strong>VLC</strong></a>
    </div>
  <? }
else
  {
  echo "Error getting the Call.";
  }
  
?>
</body>
</html>