<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/includes/bunnyCDN/bunnycdn-storage.php"); ?>

<? if($current_clerk->im_allow("main_brands_sports")){ ?>
<?

$start_time = $_POST["from"]." ".$_POST["start_hour"].":".$_POST["start_minute"]." ".$_POST["start_data"];
$start_time = date("Y-m-d H:i:s",strtotime($start_time));

$end_time = $_POST["to"]." ".$_POST["end_hour"].":".$_POST["end_minute"]." ".$_POST["end_data"];
$end_time = date("Y-m-d H:i:s",strtotime($end_time));
$image = $_POST["image"];
$type = $_POST["type"];
$url   = $_POST["url"];

if( empty($url) or $url == ""){
	$url = "javascript:;";
}

$alt_text = $_POST["alt_text"];
$priority = $_POST["priority"];

if (isset($_GET["id"])){
	$headline  = get_pph_sports_headline($_GET["id"]);
	$head_type = $headline->vars["type"];
	$headline->delete();	
	
	if($head_type == "b"){//pph headline
       $file_path = "headlines/pph/";
    }elseif($head_type == "m"){//mobile headline
       $file_path = "mobile_headlines/";
    }
			
	//Removes the headline's file hosted on the server
	
	$bunnyCDNStorage = new BunnyCDNStorage("sbodata","203275c1-3c2d-4ff8-bc508230fea8-357c-4d06","de");
	
	$bunnyCDNStorage->deleteObject("/sbodata/".$file_path.$headline->vars["image"].".jpg");		
	
}
else{
	if (isset($_POST["update"])){
		
		$headline = get_pph_sports_headline($_POST["update"]);
		$headline->vars["image"] = $image;
		$headline->vars["type"] = $type;		
	    $headline->vars["start_time"] = $start_time; 	
	    $headline->vars["end_time"] = $end_time;
		$headline->vars["url"] = $url;
		$headline->vars["alt_text"] = $alt_text;
		$headline->vars["priority"] = $priority;		
		$headline->update();
	
	}else{
		
	 $headline = new _pph_sports();
	 $headline->vars["image"] = $image;
 	 $headline->vars["type"] = $type;			 
	 $headline->vars["start_time"] = $start_time; 	
	 $headline->vars["end_time"] = $end_time;
	 $headline->vars["url"] = $url;
	 $headline->vars["alt_text"] = $alt_text;
	 $headline->vars["priority"] = $priority;
	 $headline->insert();
	
	}
}

header("Location: http://localhost:8080/ck/sports_headlines.php?e=82");
?>
<? }else{echo "Access Denied";} ?>