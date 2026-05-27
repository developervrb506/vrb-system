<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){


$id = $_POST["id"];

if ( !isset($id) ) {
  $id = "";	
}

$firstname   =  $_POST["firstname"];
$lastname    =  $_POST["lastname"];
$address     =  $_POST["address"];
$city        =  $_POST["city"];
$state       =  $_POST["state"];
$country     =  $_POST["country"];
$zipcode     =  $_POST["zipcode"];
$email       =  $_POST["email"];
$clerk       =  $_POST["clerk"];
$phone       =  $_POST["phone"];
//$websitename =  $_POST["websitename"];
$websitename =  "";
$websiteurl  =  $_POST["websiteurl"];
$password    =  $_POST["password"];
$affcode     =  $_POST["affcode"];
$comments    =  $_POST["comments"];
$affpassword = $_POST["affpassword"];
$books       = $_POST['chkboxes'];



$file_name = "no_image"; // For All the users that are excluded 
/*	 IMAGE IS COMMENT UNTIL THE IMAGE 
if(isset($_FILES["ufile"])){
				   
   $file_name = upload_file("ufile", "C:/websites/jobs.inspin.com/partners/images/affiliates_images/",$firstname."_".$lastname."_".rand(0,10000),"image");
					
    if ($file_name == ""){$file_name = "no_image"; }
					
    if ($file_name == "-1"){
    	$file_name = "no_image";
    
		?>
	    <script>
		history.go(-1);
	    </script>
	  <? }
   }
*/		


$check_mail = check_email_affiliate($email,$id);
$emaile = $check_mail["cant"];

$sportsbooks   = get_all_sportsbooks_partner();
$current_books = array();
		
foreach($sportsbooks as $book) {
  $current_books[] = $book["id"];	  
}

if($emaile == 0 || isset($_GET["edit"])) {
	
	//$affiliate = new affiliate($id,$firstname,$lastname,$address,$city,$state,$country,$zipcode,$email,$clerk,$phone,$websitename,$websiteurl,0,"",$password,array(),$file_name);
	//$affiliate->comments = $comments;

    if ( !isset($_GET["edit"]) ) {		
	  
		/* It is not required VRB
		$aff_id = insert_affiliate($affiliate);
		
		if ( isset($books) ) {  	  
		   insert_books_affiliate($aff_id,$books,$current_books);	
		}
		  
		//$content  = "Your email address: ".$email."\n";
		//$content .= "Your password: ".$password; 
		  
		//send_email_partners($email, 'Your Registration Details', $content);
		header("Location: ../../index.php?e=0");
		*/
	}
		
	else {
		
	  if($password != ""){
		   $nepass = aff_two_way_encript($password,false);
		   $password    = md5($password);  
		   $sql_pass = "password  = '$password',";
		   $sql_nepass = "nepass  = '$nepass',";
	       
	   } 
		
		$affiliate = get_affiliate_partner($id);
		
		$affiliate->vars["firstname"]= $firstname;
		$affiliate->vars["lastname"]= $lastname;
		$affiliate->vars["email"]= $email;
		$affiliate->vars["city"]= $city;
		$affiliate->vars["address"]= $address;
		$affiliate->vars["state"]= $state;
		$affiliate->vars["country"]= $country;
		$affiliate->vars["zipcode"]= $zipcode;
		$affiliate->vars["clerk"]= $clerk;
		$affiliate->vars["phone"]= $phone;
		$affiliate->vars["websitename"]= $websitename;
		$affiliate->vars["websiteurl"]= $websiteurl;
		if($password != ""){
		   $affiliate->vars["password"]= $password;
		   $affiliate->vars["nepass"]= $nepass;
		} else {
		     $affiliate->vars["password"]=  md5($affiliate->vars["password"]);	
		}
		$affiliate->vars["comments"]= $comments;
		$affiliate->vars["image"]= $file_name;
		/*
		echo "<pre>";
		print_r($_POST);
		print_r($affiliate);
		echo "</pre>";
		*/
		
		
		if (!is_null($affiliate)) {
		 $affiliate->update();
		}
		
		//Updating sub info
		if ($affiliate->vars["sub"] > 0){
			
			
			$sub_affiliate = get_affiliate_partner($affiliate->vars["sub"]);
			$sub_affiliate->vars["firstname"]= $firstname;
			$sub_affiliate->vars["lastname"]= $lastname;
			$sub_affiliate->vars["email"]= $email;
			$sub_affiliate->vars["clerk"]= $clerk;
			$sub_affiliate->vars["city"]= $city;
			$sub_affiliate->vars["state"]= $state;
			$sub_affiliate->vars["zipcode"]= $zipcode;
			$sub_affiliate->vars["phone"]= $phone;
			$sub_affiliate->vars["comments"]= $comments;
			if (!is_null($sub_affiliate)){
			  $sub_affiliate->update(array("firstname","lastname","email","clerk","city","state","zipcode","phone","comments"));
			}
			
		}
		
		
		$aff_books = explode("-",$_POST['aff_books']);
		
		
		foreach($aff_books as $aff_book){
			$affiliate_info = get_affiliates_by_sportbook($id,$aff_book);
			
			if (!is_null($affiliate_info)){ 
			  update_affiliates_by_sportbook($id,$aff_book,$_POST['affcode_'.$aff_book],$_POST['affpassword_'.$aff_book]);
			}
		}
		
								
			if ( isset($books) ) {  	  
				 
				 $aff_id = $id;
				
				 foreach ($current_books as $idbook) {  
		   
				   if ( in_array($idbook, $books) ) {
					  
					  $return = check_book_affiliate($aff_id, $idbook);
				   
					  if ( $return == FALSE ) {
				   
						  $new_data =  new _affiliates_by_sportsbook();
						  $new_data->vars["idbook"] = $idbook;
						  $new_data->vars["idaffiliate"] = $aff_id;
						  @$new_data->insert(); 
						
					   }
			
					}
					else {
								   
						 delete_affiliates_by_sportbook($aff_id,$idbook);
										 
				   } 
			    }
			}
		//header("Location: http://jobs.inspin.com/wp-admin/partners_affiliates.php?e=3");		
	
	}
} 
	
 	if ( $id != "" ) {	
 	 header("Location: " . BASE_URL . "/ck/affiliates/partners_affiliate_detail.php?affid=".$id."");
	} else {
	   header("Location: " . BASE_URL . "/ck/affiliates/partners_affiliates.php");	
	   
	}
?>
<? } else { echo "ACCESS DENIED"; }?>