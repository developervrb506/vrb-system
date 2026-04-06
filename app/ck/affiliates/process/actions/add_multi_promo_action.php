<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){
 
 
$comment = $_POST["comment"];
$type   = $_POST["promo_type"];
$cid = $_POST["cid"];

if($type == "t" || $type == "m"){
	$name = $_POST["link_text"];
	$promo = new _promo_type();
	$promo->vars["name"] = $name;
	$promo->vars["type"] = $type;
	$promo->vars["comment"] = $comment;
	$promo->vars["idcampaigne"] = $cid;
	$promo->insert();
	}else if($type == "b"){
	
	$files=array();
	$fdata=$_FILES['imageURL'];
	if(is_array($fdata['name'])){
	for($i=0;$i<count($fdata['name']);++$i){
			$files[]=array(
		'name'    =>$fdata['name'][$i],
		'type'  => $fdata['type'][$i],
		'tmp_name'=>$fdata['tmp_name'][$i],
		'error' => $fdata['error'][$i], 
		'size'  => $fdata['size'][$i]  
		);
		}
	}else $files[]=$fdata;
	
	foreach ($files as $file) { 
		$path = "C:/websites/jobs.inspin.com/partners/images/banners/";
		if ($file['tmp_name'] != "") {
		  list($width, $height, $type_file, $attr) = getimagesize($file['tmp_name']);
		}
		//COMMENTED UNTIL IMAGE IS ACTIVATED
		$name = upload_file("image_banner", $path, rand()."_".$width."x".$height, $file);
		$name = "no_image";
		
		if($_POST["replace"]){
			$same_sizes = get_all_same_size_banners_affilaites($cid, $width."x".$height);
		}else{
			$same_sizes = array();
		}
			
		
		if(count($same_sizes)>0){
			foreach($same_sizes as $same_size){
				if(file_exists($path.$same_size->vars["name"])){@unlink($path.$same_size->vars["name"]);}
				$same_size->vars["name"] = $name;
				$same_size->update(array("name"));
			}
		}else{
			
			$promo = new _promo_type();
			$promo->vars["name"] = $name;
			$promo->vars["type"] = $type;
			$promo->vars["comment"] = $comment;
			$promo->vars["idcampaigne"] = $cid;
			$promo->insert();
			
		}
		
		
	}
	
}
header("Location: " . BASE_URL . "/ck/affiliates/partners_campaigne_view.php?cid=".$cid);
	

?>
<? } else { echo "ACCESS DENIED"; }?>