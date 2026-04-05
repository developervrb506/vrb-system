<?php	
/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*') { 

$backup_name = 'db-affiliates-compressed_'.date('Y-m-d').'.sql';
	
$link = @mysql_connect($host,$user,$pass);
mysql_select_db($name,$link);

$excluded_tables = array('clicks','clicks_month','clicks_week','impressions','impressions_month','impressions_week');

    //get all of the tables
    if($tables == '*') {
 
     $tables = array();
     $result = mysql_query('SHOW TABLES');
	   
     while($row = mysql_fetch_row($result)) {       		 
		 if ( !in_array($row[0], $excluded_tables) ) {
			$tables[] = $row[0];		  		   
		 } 		 		 
       }
     }
	 	 
     else { 
       $tables = is_array($tables) ? $tables : explode(',',$tables);
     }

     //cycle through
     foreach($tables as $table) {
 
       $result = mysql_query('SELECT * FROM '.$table);
       $num_fields = mysql_num_fields($result);
       $return.= 'DROP TABLE '.$table.';';
       $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
       $return.= "\n\n".$row2[1].";\n\n";

       for ($i = 0; $i < $num_fields; $i++) {
 
           while($row = mysql_fetch_row($result)) {
 
             $return.= 'INSERT INTO '.$table.' VALUES(';
													  
             for($j=0; $j<$num_fields; $j++) {

               $row[$j] = addslashes($row[$j]);
               $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
			   
               if (isset($row[$j])) {
			     $return.= '"'.$row[$j].'"' ;
			   }
			   
			   else {
			      $return.= '""'; 
			   }  
				  
               if ($j<($num_fields-1)) {
			     $return.= ',';
			   }
			   
             }
			 
             $return.= ");\n";
           }
         }
       $return.="\n\n\n";
    }

   //save file
   $handle = fopen('./db/db_backups/'.$backup_name,'w+');
   fwrite($handle,$return);
   fclose($handle);   
     
   $file = './db/db_backups/'.$backup_name.'.gz';
   $file_sql = './db/db_backups/'.$backup_name;
   $gzfile = $file;
   $fp = gzopen ($gzfile, 'w9'); // w9 == highest compression
   gzwrite ($fp, file_get_contents($file_sql));
   gzclose($fp);
   
   @unlink('./db/db_backups/'.$backup_name);      
}
   
backup_tables('db','vrbmarketing_admin','AKFtgOX29FTgbWlVf','vrbmarketing_affiliates',$tables = '*');
?>