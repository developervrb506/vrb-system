<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")  && !$current_clerk->im_allow("just_queue_calls")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
set_time_limit(0); 
$link="ftp://monitor:Gravaci0nes@192.168.10.50//";
$callid = $_GET["id"];
$main_path = "/websites/www.vrbmarketing.com/audio/";

$local_file = $callid.'.gsm';

$conn_id = ftp_audio_conecction(); 

if($conn_id){ echo 'OK';}

// download server file


if (ftp_get($conn_id, $main_path.$local_file, $local_file, FTP_ASCII))
  { 
  $path = BASE_URL . "/audio/".$local_file;
  header("Location: $path");
  }
else
  {
  echo "Error getting the Call.";
  }
  
?>
