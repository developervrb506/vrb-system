<?php
set_time_limit(0);
ini_set("memory_limit","2048M");
include_once("./ck/process/functions.php");

//Array of databases to backup  

global $dbs_include_sbo;

$dbs_include_sbo = array('live_odds');

$folder = './db/db_backups/sbo_backups/'; 

foreach($dbs_include_sbo as $db) { 
   f_backup_dbs('192.168.10.24','main','sdft101404',$db,$folder,$tables = '*');
}

?>