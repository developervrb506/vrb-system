<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

 header('Access-Control-Allow-Origin: *'); 
session_start(); 
//set_time_limit(0);


$url1 = "https://evanalytics.com/mlb/research/umpire-rankings";
$url2 = 'https://evanalytics.com/admin/model/datatableQuery.php';
   

    $doc = new DomDocument;
    $doc->validateOnParse = true;
    @$doc->loadHtml($url1);
    echo $doc->saveHTML();


	$doc2 = new DomDocument;
    $doc2->validateOnParse = true;
    @$doc2->loadHtml($url2);
	echo $doc2->saveHTML();



	exit;
	/*

$doc = new DOMDocument();
$doc->loadHTMLFile("https://evanalytics.com/mlb/research/umpire-rankings");
//file_get_contents('https://evanalytics.com/mlb/research/umpire-rankings');
$json = file_get_contents('https://evanalytics.com/admin/model/datatableQuery.php');
echo $json;
$data = json_decode($json,true);
print_r($data);

*/
$url1 = "https://evanalytics.com/mlb/research/umpire-rankings";
$url2 = 'https://evanalytics.com/admin/model/datatableQuery.php';

/*
$xml = simplexml_load_file($url1); // or simplexml_load_string()
$json = json_encode($xml);
echo $json;

$xml = simplexml_load_file($url2); // or simplexml_load_string()
$json = json_encode($xml);
echo $json;

*/
function url_check($url) {
    $headers = @get_headers($url);
    return is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false;
};

function clean($text){
    $clean = html_entity_decode(trim(str_replace(';','-',preg_replace('/\s+/S', " ", strip_tags($text)))));// remove everything
    return $clean;
    echo '\n';// throw a new line
}



if(url_check($url1)){

$url1 = "https://evanalytics.com/mlb/research/umpire-rankings";
$url2 = 'https://evanalytics.com/admin/model/datatableQuery.php';
   

    $doc = new DomDocument;
    $doc->validateOnParse = true;
    @$doc->loadHtml(file_get_contents($url1));
    echo $doc->saveHTML();


	$doc2 = new DomDocument;
    $doc2->validateOnParse = true;
    @$doc2->loadHtml(file_get_contents($url2));
	echo $doc2->saveHTML();


    // echo file_get_contents($url2);
  //  $output = clean($doc->getElementByClass('r')->textContent);
    echo $output . '<br>';
}else{
    echo 'URL not reachable!';// Throw message when URL not be called
}

exit;
?>





<script>

/*
   $.get("https://evanalytics.com/admin/model/datatableQuery.php", function(data)  {
  
     dat = JSON.parse(data);
     console.log(dat);     

    }) ;*/

</script>
<?
 url_get_contents ($url);


function url_get_contents ($Url) {

    if (!function_exists('curl_init')){ 

        die('CURL is not installed!');

    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $Url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);

    curl_close($ch);

    return $output;

}




$date = date("Y-m-d");
//$date = "2018-04-13";

echo "------------------<BR>";
echo "UPMPIRES EVA ANALYTICS .$date<br>";
echo "------------------<BR><BR>";

$dat = url_get_contents('https://evanalytics.com/admin/model/datatableQuery.php');
var_dump($dat);
print_r($dat);

$data = get_umpire_eva();

function get_umpire_eva(){

$json = file_get_contents('https://evanalytics.com/admin/model/datatableQuery.php');

echo $json;

$data = json_decode($json,true);


echo "<pre>";

print_r($data);
echo "dsadsdsa";
//exit;

/* $html = file_get_html($data);
 
 	
  $data = array();
  $control = false;
 $k=0;  
		
  if(!empty($html)) {		
		echo "ASS";
      foreach($html->find('div[id="goodQuery"]') as $elementa) { 
		   
		    foreach ($elementa->find("div") as $div){
                    echo $div->plaintext." **  ";
            }

		       echo $elementa->plaintext." -  ";
		     $line = false; 
			 foreach ($elementa->find("table tr") as $tr){
				  foreach($tr->find("td") as $td){
			        echo $td->plaintext." -  ";
				 	$k++;
				   }
					
			     }
			  }
				 
	 $html->clear();
 
  }// html
 
    return $data;	
*/
}
?>