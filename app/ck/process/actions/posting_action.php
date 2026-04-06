<? 
include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("posting")){

// Variables
$type  = $_POST["posting_type"];
$brand  = $_POST["posting_brand"];
$league  = $_POST["posting_league"];
$category  = $_POST["posting_category"];
$title  = htmlentities($_POST["title"], ENT_QUOTES);
$seo_title  = htmlentities($_POST["seo_title"], ENT_QUOTES);
$sub_title  = htmlentities($_POST["sub_title"], ENT_QUOTES);
$image  = $_POST["image"];
$image_alt  = htmlentities($_POST["image_alt"], ENT_QUOTES);
$content  = htmlentities($_POST["content"], ENT_QUOTES);
$autor  = $current_clerk->vars["id"];
$metatag_id  = $_POST["post_metatag"];
$post_date  = $_POST["public_date"];
$year  = date('Y');
$month = date('F');
$month_posting = date('m',strtotime($post_date));
$day_posting   = date('d',strtotime($post_date));
$edit = false;
$status = 0;

//Page Logic
if (isset($_POST["publish"])) { $status = $_POST["publish"]; }

if (isset($_POST["post_id"])){
  $edit = true;
  $post_id =  $_POST["post_id"];
}

if (is_null($post_date) or $post_date == "") {
  $post_date = date("Y-m-d");
}
else {
  $post_date = date("Y-m-d",strtotime($post_date));	
}


// Rigth Domain Acording Brand and Type.
switch ($brand) {
	
   case (($brand == 3) && ($type == 1)):  //Articles SBO
   		$main_link = "http://sports-news.sbo.ag/"; 
		$site =  str_replace("http://","",$main_link);
 		break;
   case (($brand == 3) && ($type == 2)): // PR SBO
   		$main_link = "http://press-releases.sbo.ag/";
   		$site =  str_replace("http://","",$main_link);
		break;
   case (($brand == 3) && ($type == 3)):  // InfoGrafics SBO
   		$main_link = "http://infographics.sbo.ag/";
   		$site =  str_replace("http://","",$main_link);
		break;	
		
   case (($brand == 6) && ($type == 1)):  //Articles PBJ
   		$main_link = "http://sports-news.playblackjack.com/"; 
		$site =  str_replace("http://","",$main_link);
   		break;
   case (($brand == 6) && ($type == 2)): // PR PBJ
   		$main_link = "http://press-releases.playblackjack.com/";
   		$site =  str_replace("http://","",$main_link);
		break;
   case (($brand == 6) && ($type == 3)):  // InfoGrafics PBJ
   		$main_link = "http://infographics.playblackjack.com/";
   		$site =  str_replace("http://","",$main_link);
		break;		
		
   case (($brand == 8) && ($type == 1)):  //Articles BITBET
   		$main_link = "http://news.bitbet.com/"; 
		$site =  str_replace("http://","",$main_link);
   		break;
   case (($brand == 8) && ($type == 2)): // PR OWI
   		$main_link = "http://news.bitbet.com/";
   		$site =  str_replace("http://","",$main_link);
		break;
   case (($brand == 8) && ($type == 3)):  // InfoGrafics OWI
   		$main_link = "http://news.bitbet.com/";
   		$site =  str_replace("http://","",$main_link);
		break;
		
 case (($brand == 7) && ($type == 1)):  //Articles OWI
   		$main_link = "http://sports-news.betowi.com/"; 
		$site =  str_replace("http://","",$main_link);
   		break;
   case (($brand == 7) && ($type == 2)): // PR OWI
   		$main_link = "http://press-releases.betowi.com/";
   		$site =  str_replace("http://","",$main_link);
		break;
   case (($brand == 7) && ($type == 3)):  // InfoGrafics OWI
   		$main_link = "http://infographics.betowi.com/";
   		$site =  str_replace("http://","",$main_link);
		break;	
		
				
		
   case (($brand == 9) && ($type == 1)):  //Articles HRB
   		$main_link = "http://sports-news.horseracingbetting.com/"; 
		$site =  str_replace("http://","",$main_link);
   		break;
   case (($brand == 9) && ($type == 2)): // PR HRB
   		$main_link = "http://press-releases.horseracingbetting.com/";
   		$site =  str_replace("http://","",$main_link);
		break;
   case (($brand == 9) && ($type == 3)):  // InfoGrafics HRB
   		$main_link = "http://infographics.horseracingbetting.com/";
   		$site =  str_replace("http://","",$main_link);
		break;		
		
   /*case (($brand == 10) && ($type == 1)):  //Articles BETLION
   		$main_link = "http://sports-news.betlion365.com/"; 
		$site =  str_replace("http://","",$main_link);
   		break;
   case (($brand == 10) && ($type == 2)): // PR BETLION
   		$main_link = "http://press-releases.betlion365.com/";
   		$site =  str_replace("http://","",$main_link);
		break;
   case (($brand == 10) && ($type == 3)):  // InfoGrafics BETLION
   		$main_link = "http://infographics.betlion365.com/";
   		$site =  str_replace("http://","",$main_link);
		break;*/			
		
}

//Full Patht and Filename for the Notice

$html_name = str_replace(".","-",$seo_title);
$html_name = str_replace(" ","-",$html_name);
$html_name = preg_replace('/[^A-Za-z0-9\-]/', '', $html_name); 

$slug = $main_link.$year."/".$month."/".$month_posting."-".$day_posting."-".$html_name.".html";
$slug = htmlentities($slug, ENT_QUOTES);
$html_name = $month_posting."-".$day_posting."-".$html_name.".html";

//Update the metatag URL
 $metatag = get_metatag($metatag_id);

 if (!is_null($metatag)) {	 
   $metatag->vars["url"]   = $slug;
   $metatag->update(array("url"));
 }

if (!$edit){ // ADD NEW POST

	$posting = new _posting();
	$posting->vars["post_type"] = $type;
	$posting->vars["post_title"] = $title;
	$posting->vars["post_sub_title"] = $sub_title;
	$posting->vars["post_seo_title"] = $seo_title;	
	$posting->vars["post_slug"] = $slug;
	$posting->vars["post_image"] = $image;
	$posting->vars["post_image_alt"] = $image_alt;
	$posting->vars["post_content"] = $content;
	$posting->vars["post_author"] = $autor;
	$posting->vars["post_date"] = $post_date;
	$posting->vars["post_status"] = $status;
	$posting->vars["post_category"] = $category;
	$posting->vars["post_brand"] = $brand;
	$posting->vars["post_league"] = $league;
	$posting->vars["post_metatag_id"] = $metatag_id;
	$posting->insert();

}
else { // UPDATE POST	

    $posting = get_posting($post_id);
	$posting->vars["post_type"] = $type;
	$posting->vars["post_title"] = $title;
	$posting->vars["post_sub_title"] = $sub_title;
	$posting->vars["post_seo_title"] = $seo_title;	
	$posting->vars["post_slug"] = $slug;
	$posting->vars["post_image"] = $image;
	$posting->vars["post_image_alt"] = $image_alt;
	$posting->vars["post_content"] = $content;
	$posting->vars["post_author"] = $autor;
	$posting->vars["post_date"] = $post_date;
	$posting->vars["post_status"] = $status;
	$posting->vars["post_category"] = $category;
	$posting->vars["post_brand"] = $brand;
	$posting->vars["post_league"] = $league;
	$posting->vars["post_metatag_id"] = $metatag_id;	
	$posting->update();
	
} 

// Create the Html File and upload it to the rigth Server
if ($posting->vars["id"] != ""){
 
  include(ROOT_PATH . "/ck/posting/posting_creator.php");
  
}
  
if ($edit){ $action = 'u'; }
else { $action = 'a'; }

header("Location: " . BASE_URL . "/ck/posting/posting_view.php?a=".$action);
	
?>
<? } else { echo "ACCESS DENIED"; }?>