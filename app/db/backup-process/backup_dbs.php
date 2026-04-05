<?php
set_time_limit(0);
ini_set("memory_limit","2048M");
include_once("./ck/process/functions.php");
//Array of databases to backup  
global $dbs_include;

$dbs_include = array('vrbmarke_accounting','vrbmarke_baseball_file','vrbmarke_betting','vrbmarke_clerks','vrbmarke_im','vrbmarke_livehelp','vrbmarke_mails','vrbmarke_tickets','vrbmarke_tweet','vrbmarke_tweets');

$folder = './db/db_backups/'; 

foreach($dbs_include as $db) { 
   f_backup_dbs('localhost','vrbmarke_ckuser','8H9Ss4;7:r9s=uw=qa%V',$folder,$db,$tables = '*');
}

?>