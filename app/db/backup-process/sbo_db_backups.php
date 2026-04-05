<?php
set_time_limit(300);	
include_once('./ck/process/functions.php');

$dbs_list = $_GET["dbs"];
$domain = $_GET["domain"];
$dbs_list = explode(",",$dbs_list);
$path = './db/db_backups/sbo_backups/';
$url  = 'http://'.$domain.'/utilities/jobs/db-backups/dbs/';

foreach($dbs_list as $db) { 
   $file = $db.'-'.date('Y-m-d').'.gz';
   f_download_files_to_server($path,$url,$file);
   
   //FTP to doughflow server:
   
   /*$arch = $path.$file;
   $remote_file = $file;
   $ftp_server = "190.241.11.147";
   $ftp_user = "vrb_canada";
   $ftp_pass = "VRBftp!";
  
   // connects to host
   $ftp=ftp_connect($ftp_server);
   // Opens the file that is going to be transfered
   $fp=fopen($arch, "r");
   // access the host
   ftp_login($ftp, $ftp_user, $ftp_pass);
   //transfers the file
   ftp_fput($ftp, $remote_file, $fp, FTP_BINARY);
   // close ftp
   ftp_close($ftp);
   fclose($fp); 
   */  
}
?>


