<?
include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("posting")){

 set_include_path('C:\Program Files (x86)\PHP\PEAR\phpseclib');
 ini_set('include_path', 'C:\Program Files (x86)\PHP\PEAR\phpseclib');
 include('Net/SSH2.php');
 include('Net/SFTP.php');


$title =   html_entity_decode($title, ENT_QUOTES); 
$sub_title = html_entity_decode($sub_title, ENT_QUOTES); 
$content =   html_entity_decode($content, ENT_QUOTES); 
$breadcrum = explode(" ",$seo_title);
$bookname =  get_sportsbooks_partner($brand);
$typename =  get_posting_type_by_id($type);


$main_path = "/websites/www.vrbmarketing.com/ck/posting/templates/";
$local_path = $main_path.$site.$year."/".$month;
$main_remote = './public_html/'.$site;
$remote_path = $main_remote.$year."/".$month;


// Connection to FTP Server using special Library for SSL
$sftp = new Net_SFTP('gn400.whpservers.com',22);
if (!$sftp->login('gm1q5icx', 'wt3rYjTtv;IY')) {
    exit('sftp Login Failed');
}

// Create the Local path to save the Generated file.
if (!file_exists($local_path)) {
   mkdir($local_path, 0777, true);
   chmod($local_path, 0777);
 
}

//Create the Remote Path to save the Generated File
$sftp->mkdir($main_remote.$year); // 
$sftp->mkdir($remote_path); // 

/// Create the Local HTML File

$header = file_get_contents($bookname["url"].'/utilities/ui/header/main.php?metatag_id='.$metatag_id);

$js = "<div id='fb-root'></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=285873501459652&version=v2.0';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Place this tag in your head or just before your close body tag. -->
<script src='https://apis.google.com/js/platform.js' async defer></script>";

$type_description = $typename["description"];

if ($brand == 8){
	
	$type_description = explode(" ",$type_description);
	
	$type_description = $type_description[1];
	
	$body1 = '<div class="main_container">
                    <div class="content_container main_container_adjust">
                     <div class="left left_news">';  
}
elseif ($brand == 6){
	
	$type_description = explode(" ",$type_description);
	
	$type_description = $type_description[1];
	
	$body1 = '<div class="bk-main-content">
                 <div class="main-content-internal" style="color:#fff;">';  
}
else { $body1 = "";}

$body1 .= '<div class="content1_main">
    <p id="breadcrumbs"><a href="'.$bookname["url"].'" title="'.$bookname["name"].'">'.$bookname["name"].'</a> &raquo; <strong><a href="'.$main_link.'">'.$type_description.'</a> | '.$breadcrum[0].' '.$breadcrum[1].' </strong></p>  
    <h1><span class="writesr_title_article">'.$title.'</span></h1><br />
    <br />
    <hr size="1">
    <div class="fb-share-button" data-href="'.$slug.'" data-layout="button_count"></div> &nbsp; <a href="https://twitter.com/share" class="twitter-share-button"     data-via="SportsBettingOn">Tweet</a>';
	
$body2 = " <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> 
<div class='g-plus' data-action='share'></div>
<hr size='1'>
    <div id='text'>
    <br />
    <div id='sub_title'><h1><strong>".$sub_title."</strong></h1></div><br />";

$body3 = $content.'</div>';

if (($typename["id"] == 2) && ($bookname["id"] == 3 )) { //just for press release and sbo
	$info = "<br /><br /><hr size='1' style='color:#999'>
	<p>For an interview request regarding one of our PR/'s please email <a href='mailto:pressrelease@sbo.ag'>pressrelease@sbo.ag</a>. <br />
	Add the name of the PR in the subject field. We will do interview requests for any type of media. </p>";
}

$footer = "";
if ($brand == 8){
  $footer .= "</div></div></div>";	
}elseif ($brand == 6){
  $footer .= "</div></div>";	
}


$footer .= file_get_contents($bookname["url"].'/utilities/ui/footer/main.php');
$links_botton = file_get_contents('http://'.$site.'includes/links-bottom.php');
$links_botton .= '</div>';

$data = $header.$js.$body1.$body2.$body3.$info.$links_botton.$footer;

$doc = new DOMDocument();
@$doc->loadHTML($data);
$doc->saveHTMLFile($local_path."/".$html_name);

//Upload the File to the Server
$sftp->put($remote_path."/".$html_name, $data); 
$sftp->chmod(0777, $remote_path."/".$html_name);

?>
<? } else { echo "ACCESS DENIED"; }?>