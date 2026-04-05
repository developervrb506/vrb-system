<?
$main_path = "/websites/www.vrbmarketing.com/audio/";

$files = glob($main_path.'*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
	
	
echo "DONE<BR>";
}
echo "END FILE";

?>