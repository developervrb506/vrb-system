<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
require_once(ROOT_PATH . "/process/functions.php");
require_once(ROOT_PATH . '/ck/db/connection.php');
require_once(ROOT_PATH . '/ck/db/manager.php');
function check_login($email, $pass){
	affiliates_db();
	global $mysqli;
	$cus_id = "";
	$sql_pass = "";
	if($pass != "09b6637cce1d37d522f8dc987f05d88a"){
		$sql_pass = " AND a.password = '$pass' ";
	}
	$login_sql =  "SELECT a.id, a.isadmin FROM affiliates as a, affiliates_by_sportsbook as abs
			       WHERE (a.email = '$email' OR a.id = '$email' OR abs.affiliatecode LIKE '$email') 
			       $sql_pass AND a.id = abs.idaffiliate";
			   
	$login_sql_res  = mysqli_query($mysqli,$login_sql) or die(mysqli_error($mysqli));
	if($login_info  = mysqli_fetch_array($login_sql_res,MYSQLI_ASSOC)) {
		$cus_id = $login_info['id']; 
		$admin  = $login_info['isadmin']; 
	}
	return $cus_id . "/" . $admin;
}


function get_custom_campaigns_by_affiliate($aid){
	affiliates_db();
	global $mysqli;
	$campaignes = array();
	$selections_sql = "SELECT * FROM custom_campaign WHERE affiliate = '$aid' AND deleted = 0 AND id <> 1000026 ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['description'];
		$campaignes[] = new custom_campaign($id, $name, $desc, $aid, 0);
	}
	return $campaignes;
}

function get_custom_campaign($cid){
	affiliates_db();
	global $mysqli;
	$campaign = NULL;
	$selections_sql = "SELECT * FROM custom_campaign WHERE id = '$cid'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['description'];
		$campaign = new custom_campaign($id, $name, $desc, $aid, 0);
	}
	return $campaign;
}


function insert_custom_campaign($camp){
	affiliates_db();
	global $mysqli;
	$update = "INSERT INTO custom_campaign (name,description,affiliate)
			   VALUES('". $camp->name ."','". $camp->desc ."','". $camp->affiliate ."')";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function update_custom_campaign($camp){
	affiliates_db();
	global $mysqli;
	$update = "UPDATE custom_campaign SET name = '". $camp->name ."', description = '". $camp->desc ."', deleted = '". $camp->deleted ."'
				WHERE id = '". $camp->id ."'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function delete_custom_campaign($cid){
	affiliates_db();
	global $mysqli;
	$update = "DELETE FROM custom_campaign WHERE id = '$cid'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	
	$update = "DELETE FROM impressions WHERE idcampaign = '$cid'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	$update = "DELETE FROM impressions_month WHERE idcampaign = '$cid'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	$update = "DELETE FROM impressions_week WHERE idcampaign = '$cid'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	
	$update = "DELETE FROM clicks WHERE idcampaign = '$cid'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	$update = "DELETE FROM clicks_month WHERE idcampaign = '$cid'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	$update = "DELETE FROM clicks_week WHERE idcampaign = '$cid'";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function get_all_campaignes(){
	affiliates_db();
	global $mysqli;
	$campaignes = array("");
	$selections_sql = "SELECT * FROM campaignes ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$category = get_category($selections_info['category']);
		$book = get_sportsbook($selections_info['id_sportsbook']);
		$promos = get_promos_by_campaigne($id);		
		if(contains(strtolower($name),"default")){
			$campaignes[0] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}else{
			$campaignes[] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}	
	}
	if($campaignes[0]==""){unset($campaignes[0]);}
	return $campaignes;
}

function get_popular_campaignes($book, $limit = 2,$size=""){
	affiliates_db();
	global $mysqli;
	$sql_size ="";
	if ($size != ""){
	$sql_size = " and id IN (SELECT idcampaigne FROM promotypes WHERE name like  '%".$size."%') ";	
	}
	$campaignes = array();
	$selections_sql = "SELECT * FROM campaignes WHERE popular = 1 AND id_sportsbook = '$book' $sql_size ORDER BY RAND() LIMIT 0,$limit";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$category = get_category($selections_info['category']);
		$book = get_sportsbook($selections_info['id_sportsbook']);
		$promos = get_promos_by_campaigne($id);
		$campaignes[] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
	}
	return $campaignes;
}

function get_all_campaignes_by_sportbook($book){
	affiliates_db();
	global $mysqli;
	$campaignes = array("");
	$selections_sql = "SELECT * FROM campaignes WHERE id_sportsbook = '".$book->id."' ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$category = get_category($selections_info['category']);
		$promos = get_promos_by_campaigne($id);		
		if(contains(strtolower($name),"default")){
			$campaignes[0] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}else{
			$campaignes[] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}
	}
	if($campaignes[0]==""){unset($campaignes[0]);}
	return $campaignes;
}

function search_campaign($book, $category, $affiliate = "-8"){
	affiliates_db();
	global $mysqli;
	$campaignes = array("");
	$selections_sql = "SELECT * FROM campaignes WHERE id_sportsbook = '".$book->id."' 
						AND category = '".$category->id."' AND active = 1 
						AND (affiliate = 0 OR affiliate = '$affiliate')
						ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$promos = get_promos_by_campaigne($id);
		if(contains(strtolower($name),"default")){
			$campaignes[0] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}else{
			$campaignes[] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}		
	}
	if($campaignes[0]==""){unset($campaignes[0]);}
	return $campaignes;
}

function search_campaign_exclude($book, $category, $affiliate = "-8"){
	affiliates_db();
	global $mysqli;
	$campaignes = array("");
	$selections_sql = "SELECT * FROM campaignes WHERE id_sportsbook = '".$book->id."' 
						AND category = '".$category->id."' AND id NOT IN (30,31) 
						AND (affiliate = 0 OR affiliate = '$affiliate')
						AND active = 1 ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$promos = get_promos_by_campaigne($id);		
		if(contains(strtolower($name),"default")){
			$campaignes[0] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}else{
			$campaignes[] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
		}		
	}
	if($campaignes[0]==""){unset($campaignes[0]);}
	return $campaignes;
}

function get_all_campaignes_for_affiliate($aff){
	affiliates_db();
	global $mysqli;
	$campaignes = array();
	$selections_sql = "SELECT c.id, c.name, c.desc, c.url, c.id_sportsbook, c.category FROM campaignes as c, affiliates_by_sportsbook as abs
						WHERE  c.id_sportsbook = abs.idbook AND (abs.idaffiliate = ". $aff->id ." OR abs.idaffiliate = ". get_parent_account($aff->id) .")
						 AND abs.affiliatecode != 'NULL' ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$category = get_category($selections_info['category']);
		$book = get_sportsbook($selections_info['id_sportsbook']);
		$promos = get_promos_by_campaigne($id);
		$campaignes[] = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
	}
	return $campaignes;
}

function get_campaigne($id){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT * FROM campaignes WHERE id = '$id'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$category = get_category($selections_info['category']);
		$book = get_sportsbook($selections_info['id_sportsbook']);
		$promos = get_promos_by_campaigne($id);
		$campaigne = new campaigne($id,$name,$desc,$url,$promos,$book,$category);
	}
	return $campaigne;
}

function insert_campaigne($camp){
	affiliates_db();
	global $mysqli;
	$update = "INSERT INTO campaignes (name,campaignes.desc,url,id_sportsbook)
			   VALUES('". $camp->name ."','". $camp->desc ."','". $camp->url ."', ". $camp->book->id .")";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function get_promos_by_campaigne($camp_id){
	affiliates_db();
	global $mysqli;
	$promos = array();
	$selections_sql = "SELECT * FROM promotypes WHERE idcampaigne = $camp_id AND enabled = 1 ORDER BY type";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$type = $selections_info['type'];
		$promos[] = new promo($id,$name,$type);
	}
	return $promos;
}

function get_personal_promos($aff_id){
	affiliates_db();
	global $mysqli;
	$promos = array();
	
	$selections_sql = "SELECT * FROM promotypes WHERE name LIKE '%_-_".$aff_id."_-_%' AND idcampaigne = -1 ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$type = $selections_info['type'];
		$promos[] = new promo($id,$name,$type);
	}
		
	$selections_sql = "SELECT * FROM promotypes WHERE name LIKE '%_-_all_-_%' AND idcampaigne = -1 ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$type = $selections_info['type'];
		$promos[] = new promo($id,$name,$type);
	}	
	
	return $promos;
}

function get_casino_games_links($bid){
	affiliates_db();
	global $mysqli;
	$promos = array();
	
	$selections_sql = "SELECT * FROM promotypes WHERE name LIKE '%_-_".$bid."' AND type = 'c' ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$type = $selections_info['type'];
		$promos[] = new promo($id,$name,$type);
	}
	
	return $promos;
}

function get_mailers_by_campaigne($camp_id){
	affiliates_db();
	global $mysqli;
	$promos = array();
	$selections_sql = "SELECT * FROM promotypes WHERE idcampaigne = $camp_id AND type = 'm' ORDER BY id DESC LIMIT 0,1";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$type = $selections_info['type'];
		$promos[] = new promo($id,$name,$type);
	}
	return $promos;
}


function get_all_promos(){
	affiliates_db();
	global $mysqli;
	$promos = array();
	$selections_sql = "SELECT * FROM promotypes ORDER BY type";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$type = $selections_info['type'];
		$promos[] = new promo($id,$name,$type);
	}
	return $promos;
}

function get_promo($id){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT * FROM promotypes WHERE id = '$id'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$type = $selections_info['type'];
		$promo = new promo($id,$name,$type);
	}
	return $promo;
}

function update_promo($promo){
	affiliates_db();
	global $mysqli;
	$update = "UPDATE promotypes SET name = '" . $promo->name . "', type = '" . $promo->type . "' WHERE id = " . $promo->id . "";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function insert_promo($promo, $campaigne){
	affiliates_db();
	global $mysqli;
	$update = "INSERT INTO promotypes (name, type, 	idcampaigne) VALUES('". $promo->name ."','". $promo->type ."',". $campaigne->id .")";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	$selections_sql = "SELECT MAX(id) as last_id FROM promotypes";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['last_id'];
	}
	return $id;
}

function insert_affiliate($affiliate) {
   affiliates_db();
   global $mysqli;
		   
   $firstname = $affiliate->name;
   $lastname  = $affiliate->last_name;
   $address   = $affiliate->adress;
   $city      = $affiliate->city;
   $state     = $affiliate->state;
   $country   = $affiliate->country;
   $zipcode   = $affiliate->zip;
   $email     = $affiliate->email;
   $phone     = $affiliate->phone;
   $websitename = $affiliate->web_name;
   $websiteurl  = $affiliate->web_url;
   $password    = $affiliate->password; 
   $newsletter  = $affiliate->newsletter;
   $sub = $affiliate->parent_account;
   $referrer = $affiliate->referrer_account;
   
   $add_affiliate = "INSERT INTO affiliates (password, nepass, firstname, lastname, email, city, address, country, state, zipcode, phone, registered, websitename, websiteurl, isadmin, sub, newsletter, referrer) VALUES
					('".md5($password)."','".two_way_encript($password)."','".$firstname."','".$lastname."','".$email."','".$city."','".$address."','".$country."',
					 '".$state."','".$zipcode."','".$phone."',now(),'".$websitename."' ,'".$websiteurl."',0,$sub,'".$newsletter."','".$referrer."')";				
									  
   $add_affiliate_res = mysqli_query($mysqli,$add_affiliate) or die(mysqli_error($mysqli));
   
   $selections_sql = "SELECT MAX(id) as last_id FROM affiliates";
   $selections_sql_res = mysqli_query($mysqli,$selections_sql);
   
   if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
	  $id = $selections_info['last_id'];
   }
   
   return $id;   
}

function update_affiliate($affiliate) {
   affiliates_db();
   global $mysqli;
		   
   $id          = $affiliate->id;
   $firstname   = $affiliate->name;
   $lastname    = $affiliate->last_name;
   $address     = $affiliate->adress;
   $city        = $affiliate->city;
   $state       = $affiliate->state;
   $country     = $affiliate->country;
   $zipcode     = $affiliate->zip;
   $email       = $affiliate->email;
   $phone       = $affiliate->phone;
   $websitename = $affiliate->web_name;
   $websiteurl  = $affiliate->web_url;   
   $password    = $affiliate->password; 
   
   if($password != ""){
	   $sql_pass = "nepass  = '".two_way_encript($password)."',";
	   $password    = md5($password);  
	   $sql_pass .= " password  = '$password',";
   }
   
   $update_affiliate = "UPDATE affiliates
                        SET $sql_pass
						    firstname = '$firstname',
							lastname  = '$lastname',
							email     = '$email',
							city      = '$city',
							address   = '$address',
							country   = '$country',
							state     = '$state',
							zipcode   = '$zipcode',
							phone     = '$phone',
							websitename = '$websitename',
							websiteurl = '$websiteurl'						    
				        WHERE id = '". $id . "'";
						
   $update_affiliate_res = mysqli_query($mysqli,$update_affiliate) or die(mysqli_error($mysqli));
   
   if($id != "" && $id != "0" && strlen($id) > 3){
	   
	   $update_affiliate = "UPDATE affiliates
							SET $sql_pass
								firstname = '$firstname',
								lastname  = '$lastname',
								email     = '$email',
								city      = '$city',
								address   = '$address',
								country   = '$country',
								state     = '$state',
								zipcode   = '$zipcode',
								phone     = '$phone'						    
							WHERE sub = '". $id . "'";
							
	   $update_affiliate_res = mysqli_query($mysqli,$update_affiliate) or die(mysqli_error($mysqli));
   }
   
   return $id;   
}

function check_email($email,$id) {
	affiliates_db();
	global $mysqli;
	$sql =  "SELECT count(*) as cant
             FROM affiliates
			 WHERE email = '$email' and 
			       id <> '$id'";
				   
	$sql_res = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
					  
	if($info = mysqli_fetch_array($sql_res,MYSQLI_ASSOC)) {
		$cant = $info['cant']; 
	}
	
	return $cant;
}

function get_all_sportsbooks(){
	affiliates_db();
	global $mysqli;
	$sportsbooks = array();
	$selections_sql = "SELECT * FROM sportsbooks where id <> 10 ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id     = $selections_info['id'];
		$name   = $selections_info['name'];		
		$url    = $selections_info['url'];		
		$sportsbooks[] = new book($id,$name,$url);
	}
	return $sportsbooks;
}

function affiliate_in_book($id_aff, $id_book){
	affiliates_db();
	global $mysqli;
	$in = false;
	$selections_sql = "SELECT * FROM affiliates_by_sportsbook WHERE idbook = $id_book AND (idaffiliate = $id_aff OR idaffiliate = ". get_parent_account($id_aff) .")";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$in = true;
	}
	return $in;
}

function get_affiliate_sportsbooks($id_aff){
	affiliates_db();
	global $mysqli;
	$sportsbooks = array();
	$selections_sql = "SELECT s.id, s.name, s.url FROM sportsbooks as s, affiliates_by_sportsbook as abs
						 WHERE (abs.idaffiliate = $id_aff OR abs.idaffiliate = ". get_parent_account($id_aff) .") 
						 AND abs.idbook = s.id AND abs.affiliatecode IS NOT NULL AND s.id <> 10 ORDER BY id ASC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id     = $selections_info['id'];
		$name   = $selections_info['name'];		
		$url    = $selections_info['url'];		
		$sportsbooks[] = new book($id,$name,$url);
	}
	return $sportsbooks;
}

function get_sportsbook($id){
	affiliates_db();
	global $mysqli;
	$sportsbook = NULL;
	$selections_sql = "SELECT * FROM sportsbooks WHERE id = '$id'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$name   = $selections_info['name'];		
		$url    = $selections_info['url'];	
		$folder    = $selections_info['folder'];		
		$sportsbook = new book($id,$name,$url, $folder);
	}
	return $sportsbook;
}

function insert_books_affiliate($aff_id,$books) {
   affiliates_db();
   global $mysqli;
   foreach ($books as $idbook){  
	   $add_record = "INSERT INTO affiliates_by_sportsbook (idbook,idaffiliate)
    	              VALUES ('".$idbook."','".$aff_id."')";
	   $add_record_res = mysqli_query($mysqli,$add_record) or die(mysqli_error($mysqli));				 
	}	 
    return;   
}

function add_click($id_promo, $id_aff, $custom_campaign){
	if(!has_impresions($id_promo, $id_aff)){add_impresion($id_promo, $id_aff, $custom_campaign);}
	affiliates_db();
	global $mysqli;
	$update = "INSERT INTO clicks (idbanner,idcampaign,idaffiliate,ip,impdate) 
			   VALUES('$id_promo','$custom_campaign',$id_aff,'". $_SERVER['REMOTE_ADDR'] ."','". date("Y-m-d H:i:s") ."')";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	
	$update = "INSERT INTO clicks_week (idbanner,idcampaign,idaffiliate,ip,impdate) 
				VALUES('$id_promo','$custom_campaign',$id_aff,'". $_SERVER['REMOTE_ADDR'] ."','". date("Y-m-d H:i:s") ."')";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	
	$update = "INSERT INTO clicks_month (idbanner,idcampaign,idaffiliate,ip,impdate) 
				VALUES('$id_promo','$custom_campaign',$id_aff,'". $_SERVER['REMOTE_ADDR'] ."','". date("Y-m-d H:i:s") ."')";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function clean_clicks($type){
	affiliates_db();
	global $mysqli;
	
	if($type == "w"){
		$table = "clicks_week";
		$date = date("Y-m-d",time()-691200);
	}else if($type == "m"){
		$table = "clicks_month";
		$date = date("Y-m-d",time()-3196800);
	}
	
	$update = "DELETE FROM $table WHERE DATE(impdate) <= '$date' ";
    $update_res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function clean_impressions($type){
	affiliates_db();
	global $mysqli;
	
	if($type == "w"){
		$table = "impressions_week";
		$date = date("Y-m-d",time()-691200);
	}else if($type == "m"){
		$table = "impressions_month";
		$date = date("Y-m-d",time()-3196800);
	}
	
	$update = "DELETE FROM $table WHERE DATE(impdate) < '$date' ";
    $update_res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function has_impresions($id_promo, $id_aff){
	affiliates_db();
	global $mysqli;
	$has = false;
	$selections_sql = "SELECT * FROM impressions_week WHERE idbanner = '$id_promo' AND idaffiliate = '$id_aff'
						AND DATE(impdate) = '".date("Y-m-d")."' LIMIT 0,1";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$has = true;
	}
	return $has;
}

function add_impresion($id_promo, $id_aff, $custom_campaign){
	affiliates_db();
	global $mysqli;
	$noimps = array(1057,1704);
	if(!in_array($id_aff, $noimps)){
		$update = "INSERT INTO impressions (idbanner,idcampaign,idaffiliate,ip,impdate) 
					VALUES($id_promo,'$custom_campaign',$id_aff,'". $_SERVER['REMOTE_ADDR'] ."','". date("Y-m-d H:i:s") ."')";
		$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
		
		$update = "INSERT INTO impressions_week (idbanner,idcampaign,idaffiliate,ip,impdate) 
					VALUES($id_promo,'$custom_campaign',$id_aff,'". $_SERVER['REMOTE_ADDR'] ."','". date("Y-m-d H:i:s") ."')";
		$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
		
		$update = "INSERT INTO impressions_month (idbanner,idcampaign,idaffiliate,ip,impdate) 
					VALUES($id_promo,'$custom_campaign',$id_aff,'". $_SERVER['REMOTE_ADDR'] ."','". date("Y-m-d H:i:s") ."')";
		$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	}
}

function get_all_affiliates(){
	affiliates_db();
	global $mysqli;
	$affiliates = array();
	$selections_sql = "SELECT * FROM affiliates WHERE isadmin = 0 ORDER BY id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
	  $id           = $selections_info['id'];
	  $password     = $selections_info['password'];		
	  $firstname    = $selections_info['firstname'];
	  $lastname     = $selections_info['lastname'];
	  $email        = $selections_info['email'];
	  $city         = $selections_info['city'];
	  $address      = $selections_info['address'];
	  $country      = $selections_info['country'];
	  $state        = $selections_info['state'];
	  $zipcode      = $selections_info['zipcode'];
	  $phone        = $selections_info['phone'];
	  $registered   = $selections_info['registered'];
	  $websitename  = $selections_info['websitename'];
	  $websiteurl   = $selections_info['websiteurl'];
	  $isadmin      = $selections_info['isadmin'];
	  $newsletter   = $selections_info['newsletter'];
	  
	  $affiliates[] = new affiliate($id,$firstname,$lastname,$address,$city,$state,$country,$zipcode,$email,$phone,$websitename,$websiteurl,$isadmin,$registered,$password,$newsletter,array());  
	  
	}
	return $affiliates;
}

function get_subaccounts($aff_id){
	affiliates_db();
	global $mysqli;
	$affiliates = array();
	$selections_sql = "SELECT * FROM affiliates WHERE isadmin = 0 AND (sub = $aff_id OR id = $aff_id) ORDER BY id ASC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
	  $id           = $selections_info['id'];
	  $password     = $selections_info['password'];		
	  $firstname    = $selections_info['firstname'];
	  $lastname     = $selections_info['lastname'];
	  $email        = $selections_info['email'];
	  $city         = $selections_info['city'];
	  $address      = $selections_info['address'];
	  $country      = $selections_info['country'];
	  $state        = $selections_info['state'];
	  $zipcode      = $selections_info['zipcode'];
	  $phone        = $selections_info['phone'];
	  $registered   = $selections_info['registered'];
	  $websitename  = $selections_info['websitename'];
	  $websiteurl   = $selections_info['websiteurl'];
	  $isadmin      = $selections_info['isadmin'];
	  $newsletter   = $selections_info['newsletter'];
	  
	  $affiliates[] = new affiliate($id,$firstname,$lastname,$address,$city,$state,$country,$zipcode,$email,$phone,$websitename,$websiteurl,$isadmin,$registered,$password,$newsletter,array());  
	  
	}
	return $affiliates;
}

function get_all_affiliates_pending_approval(){
	affiliates_db();
	global $mysqli;
	$pendings = array();
	$selections_sql = "SELECT idaffiliate, idbook
			           FROM affiliates_by_sportsbook as b
			           WHERE (b.affiliatecode is null or b.affiliatecode = '') 
					   ORDER BY b.idaffiliate DESC";
	$selections_sql_res    = mysqli_query($mysqli,$selections_sql);
	
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
	  $idaffiliate = $selections_info['idaffiliate'];
	  $idbook      = $selections_info['idbook'];	  	  	  	  
	  $affiliate   = get_affiliate($idaffiliate); 
	  $book        = get_sportsbook($idbook);
	  $pendings[]  = array($affiliate,$book);	  
	}
	
	return $pendings;
}

function get_affiliate($id){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT * FROM affiliates WHERE id = $id";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
	  $password     = $selections_info['password'];		
	  $firstname    = $selections_info['firstname'];
	  $lastname     = $selections_info['lastname'];
	  $email        = $selections_info['email'];
	  $city         = $selections_info['city'];
	  $address      = $selections_info['address'];
	  $country      = $selections_info['country'];
	  $state        = $selections_info['state'];
	  $zipcode      = $selections_info['zipcode'];
	  $phone        = $selections_info['phone'];
	  $registered   = $selections_info['registered'];
	  $websitename  = $selections_info['websitename'];
	  $websiteurl   = $selections_info['websiteurl'];
	  $isadmin      = $selections_info['isadmin'];
	  $newsletter   = $selections_info['newsletter'];
	  $books = get_sportsbooks_by_affiliate($id);
	  
	  $affiliate = new affiliate($id,$firstname,$lastname,$address,$city,$state,$country,$zipcode,$email,$phone,$websitename,$websiteurl,$isadmin,$registered,$password,$newsletter,$books);  
	  
	}
	return $affiliate;
}

function get_sportsbooks_by_affiliate($aff_id){
	affiliates_db();
	global $mysqli;
	$sportsbooks = array();
	$selections_sql = "SELECT b.id, b.name, b.url, b.folder FROM sportsbooks as b, affiliates_by_sportsbook as abs 
					   WHERE abs.idaffiliate = $aff_id AND abs.idbook = b.id and b.id not in(1,7,10) ORDER BY b.id ASC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id     = $selections_info['id'];
		$name   = $selections_info['name'];		
		$url    = $selections_info['url'];
		$folder    = $selections_info['folder'];		
		$sportsbooks[] = new book($id,$name,$url,$folder);
	}
	return $sportsbooks;
}

function get_sportsbook_paypot_methods($book){
	affiliates_db();
	global $mysqli;
	$methods = array();
	$selections_sql = "SELECT * FROM cashier_conditions WHERE brand = '$book'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {	
		$methods[] = array("id"=>$selections_info['id'],"brand"=>$selections_info['brand'],
							"method"=>$selections_info['method'],"condition"=>$selections_info['condition']);
	}
	return $methods;
}

function get_pending_sportsbooks_by_affiliate($aff_id){
	affiliates_db();
	global $mysqli;
	$sportsbooks = array();
	$selections_sql = "SELECT * FROM sportsbooks WHERE id NOT IN (SELECT idbook 
                                                                  FROM affiliates_by_sportsbook
                                                                  WHERE idaffiliate = $aff_id and
																  idbook <> 10                                                                  )";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id     = $selections_info['id'];
		$name   = $selections_info['name'];		
		$url    = $selections_info['url'];		
		$sportsbooks[] = new book($id,$name,$url);
	}
	return $sportsbooks;
}

function get_landing_by_promo($promo){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT url FROM campaignes as c, promotypes as p WHERE p.id = ". $promo->id ." AND p.idcampaigne = c.id"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	$url = "";
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$url = $selections_info['url'];		
	}
	return $url;
}

function get_parent_account($aff_id){
	affiliates_db();
	global $mysqli;
	$id = 1;
	$selections_sql = "SELECT sub FROM affiliates WHERE id = $aff_id"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['sub'];
	}
	return $id;
}

function get_affiliate_code($aff_id, $book_id){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT affiliatecode FROM affiliates_by_sportsbook WHERE idbook = '$book_id' AND (idaffiliate = '$aff_id' OR idaffiliate = '". get_parent_account($aff_id) ."')"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	$code = "";
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$code = $selections_info['affiliatecode'];		
	}
	return $code;
}

function get_affiliate_password($aff_id, $book_id){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT password FROM affiliates_by_sportsbook WHERE idbook = $book_id AND (idaffiliate = $aff_id OR idaffiliate = ". get_parent_account($aff_id) .")"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	$password = "";
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$password = $selections_info['password'];		
	}
	return $password;
}

function get_affiliate_by_AF($aff_number){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT idaffiliate FROM affiliates_by_sportsbook WHERE affiliatecode = '$aff_number'"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	$affiliate = NULL;
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$affiliate = get_affiliate($selections_info['idaffiliate']);		
	}
	return $affiliate;
}

function get_promos_by_affiliate($affiliate, $bookid = "", $from = "", $to = "", $custom_campaign = ""){
	affiliates_db();
	global $mysqli;
	$promos = array();
	if($from != ""){$sql_from = " AND DATE(impdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(impdate) <= DATE('$to') ";}
	if($custom_campaign != ""){$sql_cc = " AND idcampaign = '$custom_campaign' ";}
	$selections_sql = "SELECT DISTINCT idbanner FROM impressions".get_marketing_table($from)." WHERE idaffiliate = '" . $affiliate->id . "'
						$sql_from $sql_to $sql_cc
						ORDER BY impdate DESC";
						
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {		
		$new_promo = get_promo($selections_info['idbanner']);
		$gbook = substr($new_promo->name,-5);
		if(!is_null($new_promo)){
			if($new_promo->get_campaigne()->book->id == $bookid || $bookid == "" || $bookid == "na" || contains($gbook,"-_".$bookid)){
				$promos[] = $new_promo;
			}
		}
	}
	return $promos;
}

function get_reports($affiliate, $promo, $type, $from, $to){
	affiliates_db();
	global $mysqli;
	if($from != ""){$sql_from = " AND DATE(impdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(impdate) <= DATE('$to') ";}
	$reports = array();
	$selections_sql = "SELECT * FROM $type WHERE idaffiliate = " . $affiliate->id . " AND idbanner = " . $promo->id . $sql_from . $sql_to;
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id  = $selections_info['id'];	
		$ip = $selections_info['ip'];	
		$date = $selections_info['impdate'];		
		$reports[] = new report($id, $ip, $date);
	}
	return $reports;
}

function get_reports_count($affiliate, $promo, $type, $from, $to, $custom_campaign = ""){
	affiliates_db();
	global $mysqli;
	if($from != ""){$sql_from = " AND DATE(impdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(impdate) <= DATE('$to') ";}
	if($custom_campaign != ""){$sql_cc = " AND idcampaign = '$custom_campaign' ";}
	$reports = array(0,0);
	$selections_sql = "SELECT COUNT(*) as g_count, COUNT(DISTINCT ip) as unique_count FROM ".$type.get_marketing_table($from)."
						 WHERE idaffiliate = '" . $affiliate->id . "' AND idbanner = '" . $promo->id . "'" . $sql_from . $sql_to . $sql_cc;	
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$reports[0]  = $selections_info['g_count'];
		$reports[1]  = $selections_info['unique_count'];
	}
	return $reports;
}

function web_report_count($wid, $type, $from = "", $to = ""){
	/*Check if we do need these connection lines*/
	affiliates_db();
	global $mysqli;
	
	$count = 0;
	if($from != ""){$sql_from = " AND DATE(impdate) >= DATE('$from') ";}
	if($to  != ""){$sql_to = " AND DATE(impdate) <= DATE('$to') ";}
	$selections_sql = "SELECT count(id) as num FROM $type WHERE idaffiliate = '$wid' $sql_from $sql_to";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$count = $selections_info['num'];
	}
	return $count;
}

function get_week_stats($wid, $type, $from, $to, $book){
	
	/*Check if we do need these connection lines*/
	affiliates_db();
	global $mysqli;
	
	$count = 0;
	$selections_sql = "SELECT count(t.id) as num FROM ".$type."_week as t, promotypes as p, campaignes as c WHERE t.idaffiliate = '$wid' AND 
						DATE(impdate) >= DATE('$from') AND DATE(impdate) <= DATE('$to') AND t.idbanner = p.id AND p.idcampaigne = c.id
						AND c.id_sportsbook = '$book'";
	//echo $selections_sql.";<br /><br />";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$count += $selections_info['num'];
	}
	
	$selections_sql = "SELECT count(t.id) as num FROM ".$type."_week as t, promotypes as p WHERE t.idaffiliate = '$wid' AND 
						DATE(impdate) >= DATE('$from') AND DATE(impdate) <= DATE('$to') AND t.idbanner = p.id AND p.idcampaigne = '-1' 
						AND p.name LIKE '%_-_$book'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$count += $selections_info['num'];
	}
	
	return $count;
}

function get_general_reports($promo, $type, $from, $to){
	affiliates_db();
	global $mysqli;
	if($from != ""){$sql_from = " AND DATE(impdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(impdate) <= DATE('$to') ";}
	$reports = array();
	$selections_sql = "SELECT * FROM $type WHERE idbanner = " . $promo->id . $sql_from . $sql_to;
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id  = $selections_info['id'];	
		$ip = $selections_info['ip'];	
		$date = $selections_info['impdate'];		
		$reports[] = new report($id, $ip, $date);
	}
	return $reports;
}

function get_campaigne_by_promo($promo){
	affiliates_db();
	global $mysqli;
	$selections_sql = "SELECT c.id, c.name, c.desc, c.url, c.id_sportsbook, c.category
					   FROM campaignes as c, promotypes as p WHERE p.id = '". $promo->id ."' AND p.idcampaigne = c.id";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$name = $selections_info['name'];
		$desc = $selections_info['desc'];
		$url = $selections_info['url'];
		$category = get_category($selections_info['category']);
		$book = get_sportsbook($selections_info['id_sportsbook']);
		$campaigne = new campaigne($id,$name,$desc,$url,array(),$book,$category);
	}
	return $campaigne;
}

function update_approved_affiliates($affid,$bookid,$afcode) {
   affiliates_db();
   global $mysqli;
	   
   $update = "UPDATE affiliates_by_sportsbook
              SET affiliatecode  = '$afcode'
			  WHERE idbook = '$bookid' and
			       	idaffiliate = '$affid'";
   $update_res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	      
   return $id;   
}

function update_endorsement($affid,$id_book,$end,$end_signature,$image = "",$end_promo_code = "") {
    affiliates_db();
	global $mysqli;
    $exist = false;
	$selections_sql = "SELECT endorsement FROM endorsements WHERE id_book = $id_book AND id_affiliate = $affid";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$exist = true;
	}
	
	if($exist){
		$update = "UPDATE endorsements
              SET 	endorsement  = '$end', endorsement_signature = '$end_signature',  endorsement_image = '$image', endorsement_promo_code = '$end_promo_code'
			  WHERE id_book = '$id_book' and
			       	id_affiliate = '$affid'";
   		$update_res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	}else{
		$update = "INSERT INTO endorsements (id_book, id_affiliate, endorsement, endorsement_signature,endorsement_image,endorsement_promo_code)
				   VALUES($id_book, $affid, '$end', '$end_signature', '$image', '$end_promo_code')";
		$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	} 
   
}

function get_endorsement($affid, $bookid){
	affiliates_db();
	global $mysqli;
	$endorsement = array();
	$selections_sql = "SELECT endorsement, endorsement_signature, endorsement_image, endorsement_promo_code FROM endorsements WHERE id_book = '$bookid' AND id_affiliate = '$affid'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$endorsement[] = $selections_info['endorsement'];
		$endorsement[] = $selections_info['endorsement_signature'];
		$endorsement[] = $selections_info['endorsement_image'];
		$endorsement[] = $selections_info['endorsement_promo_code'];
	}
	return $endorsement;
}

function get_messages($aff, $read = ""){
	affiliates_db();
	global $mysqli;
	$sql_read = "";
	if($read != ""){$sql_read = " AND `read` = $read ";}
	$messages = array();
	$selections_sql = "SELECT m.id, m.subject, m.content, m.date FROM message as m, message_per_affiliate as mpa
							WHERE (mpa.id_affiliate = ". $aff->id ." OR mpa.id_affiliate = ".get_parent_account($aff->id).") $sql_read AND mpa.id_message = m.id ORDER BY m.id DESC";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id  = $selections_info['id'];	
		$sub = $selections_info['subject'];	
		$conte = $selections_info['content'];		
		$date = $selections_info['date'];
		$messages[] = new message($id, $sub, $conte, $date);
	}
	return $messages;
}

function read_all_messages($aff){
	affiliates_db();
	global $mysqli;
	$update = "UPDATE message_per_affiliate SET `read` = '1' WHERE (id_affiliate = ". $aff->id . " OR id_affiliate = ".get_parent_account($aff->id).") AND `read` = '0'";
   $update_res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function delete_message($aff, $mid){
	affiliates_db();
	global $mysqli;
	$update = "DELETE FROM message_per_affiliate WHERE (id_affiliate = ". $aff->id ." OR id_affiliate = ".get_parent_account($aff->id).") AND id_message = $mid";
   $update_res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function delete_website($web_id, $aff){
	affiliates_db();
	global $mysqli;
	$update = "UPDATE affiliates SET sub = (sub * -1) WHERE id = $web_id AND sub = $aff";
    $update_res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function is_affiliate_website($aff_id, $web_id){
	affiliates_db();
	global $mysqli;
	$is = false;
	$selections_sql = "SELECT sub FROM affiliates WHERE id = $web_id";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
	  $sub = $selections_info['sub'];
	}
	if($sub == $aff_id){$is = true;}
	return $is;
}

function insert_book_signup($name, $email, $phone, $book_id){
	affiliates_db();
	global $mysqli;
	$update = "INSERT INTO books_signups (name,email,phone,signup_date,book_id)
			   VALUES('$name','$email','$phone',NOW(),$book_id)";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function get_book_signups($book, $from = ""){
	affiliates_db();
	global $mysqli;
	if($from != ""){$sql_from = " AND DATE(signup_date ) >= DATE('$from') ";}
	$contacts = array();
	$selections_sql = "SELECT name, email, phone, signup_date FROM books_signups WHERE book_id = $book $sql_from";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$name = $selections_info['name'];
		$emnail = $selections_info['email'];
		$phone = $selections_info['phone'];
		$su_dste = $selections_info['signup_date'];
		$contacts[] = new contact($emnail, $name, $phone, $su_dste, "");
	}
	return $contacts;
}

function change_default($id_def, $id_new){
	affiliates_db();
	global $mysqli;
	$def = get_campaigne($id_def);
	$new = get_campaigne($id_new);	
	$update = "UPDATE campaignes SET url = '". $new->url ."' WHERE id = '" . $def->id . "'";
	$res = mysqli_query($mysqli,$update) ;//or die(mysqli_error($mysqli));
	
	$mailers = 0;
	foreach($def->promos as $def_promo){
		if($def_promo->type == 'b'){
			$parts = explode("_",$def_promo->name);
			$selections_sql = "SELECT name FROM promotypes WHERE type = 'b' AND idcampaigne = '" . $new->id . "' AND name LIKE '%". $parts[1] ."'";
			//echo $selections_sql."<br />";
			$selections_sql_res = mysqli_query($mysqli,$selections_sql);
			while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
				$new_name = $selections_info['name'];
				$update = "UPDATE promotypes SET name = '$new_name' WHERE id = " . $def_promo->id;
				//echo $update."<br /><br />";
				$res = mysqli_query($mysqli,$update) ;//or die(mysqli_error($mysqli));
			}
		}else if($def_promo->type == 'm'){
			$selections_sql = "SELECT name FROM promotypes WHERE type = 'm' AND idcampaigne = '" . $new->id . "' LIMIT $mailers,1";
			$mailers++;
			//echo $selections_sql."<br />";
			$selections_sql_res = mysqli_query($mysqli,$selections_sql);
			while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
				$new_url = $selections_info['name'];
				$update = "UPDATE promotypes SET name = '$new_url' WHERE id = " . $def_promo->id;
				//echo $update."<br /><br />";
				$res = mysqli_query($mysqli,$update) ;//or die(mysqli_error($mysqli));
			}
		}
	}
}

function create_campaign_from_campaign($id_camp, $new_name){
	affiliates_db();
	global $mysqli;
	$new = get_campaigne($id_camp);
	$update = "INSERT INTO campaignes (name, campaignes.desc, url, id_sportsbook) 
			   VALUES ('$new_name','". $new->desc ."','". $new->url ."','". $new->book->id ."')";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
	
	$selections_sql = "SELECT MAX(id) as maxi FROM campaignes";
	$id = -1;
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['maxi'];
	}
	if($id != -1){
		foreach($new->promos as $promo){
			$update = "INSERT INTO promotypes (name, type, idcampaigne) 
					   VALUES ('". $promo->name ."','". $promo->type ."','$id')";
			$res = mysqli_query($mysqli,$update) ;//or die(mysqli_error($mysqli));
		}
	}
}

function get_news($id){
	affiliates_db();
	global $mysqli;
	$new = "";
	$selections_sql = "SELECT content FROM news WHERE id = '$id'"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
	  $new = $selections_info['content'];		
	}
	return $new;
}

function update_news($id, $content){
	affiliates_db();
	global $mysqli;
	$update = "UPDATE news SET content = '$content' WHERE id = '$id' ";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function get_all_categories(){
	affiliates_db();
	global $mysqli;
	$cat = array();
	$selections_sql = "SELECT * FROM category"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$cat[] = new category($selections_info['id'],$selections_info['name']);		
	}
	return $cat;
}

function get_category($id){
	affiliates_db();
	global $mysqli;
	$cat = NULL;
	$selections_sql = "SELECT * FROM category WHERE id = '$id' "; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	if($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$cat = new category($selections_info['id'],$selections_info['name']);		
	}
	return $cat;
}

function get_all_endorsements($bookid){
	affiliates_db();
	global $mysqli;
	$endorsements = array();
	$selections_sql = "SELECT * FROM endorsements_default WHERE idbook = '$bookid'";
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$id = $selections_info['id'];
		$endorsement = $selections_info['endorsement'];				
		$endorsements[] = new endorsement($id,$endorsement);
	}
	return $endorsements;
}


//signups tracking
function insert_signup_traking($pid, $cc, $aid, $player, $sdate){
	affiliates_db();
	global $mysqli;
	$update = "INSERT INTO signups (pid, cc, affiliate, player, sudate) 
			   VALUES('$pid','$cc','$aid','$player','$sdate')";
	$res = mysqli_query($mysqli,$update) or die(mysqli_error($mysqli));
}

function get_signups_by_promo($pid, $aid, $from, $to){
	affiliates_db();
	global $mysqli;
	$sgns = array();
	$selections_sql = "SELECT * FROM signups WHERE pid = '$pid' AND affiliate = '$aid'
						AND DATE(sudate) >= '$from' AND DATE(sudate) <= '$to' ORDER BY sudate DESC"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$sgns[] = array("player"=>$selections_info['player'],"date"=>$selections_info['sudate']);		
	}
	return $sgns;
}

function count_signups_by_promo($pid, $aid, $from, $to, $custom_campaign = ""){
	affiliates_db();
	global $mysqli;
	$num = 0;
	if($custom_campaign != ""){$sql_cc = " AND cc = '$custom_campaign' ";}
	$selections_sql = "SELECT COUNT(*) as num FROM signups WHERE pid = '$pid' AND affiliate = '$aid'
						AND DATE(sudate) >= '$from' AND DATE(sudate) <= '$to' $sql_cc"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$num = $selections_info['num'];		
	}
	return $num;
}

function count_signups_by_agent($aid, $book, $from, $to){
	affiliates_db();
	global $mysqli;
	$num = 0;
	$selections_sql = "SELECT COUNT(*) as num FROM signups as s, promotypes as p, campaignes as c WHERE s.affiliate = '$aid'
						AND p.idcampaigne = c.id AND c.id_sportsbook = '$book' AND s.pid = p.id
						AND DATE(sudate) >= '$from' AND DATE(sudate) <= '$to'"; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$num = $selections_info['num'];		
	}
	
	$sbook = get_sportsbook($book);
	
	$bookurl = str_replace("http://www.","",$sbook->url);
	$bookurl = str_replace("https://www.","",$sbook->url);
	
	$selections_sql = "SELECT COUNT(*) as num FROM signups as s, promotypes as p WHERE s.affiliate = '$aid'
						AND s.pid = p.id AND p.`name` LIKE '%$bookurl%'
						AND DATE(sudate) >= '$from' AND DATE(sudate) <= '$to' "; 
	$selections_sql_res = mysqli_query($mysqli,$selections_sql);
	while($selections_info = mysqli_fetch_array($selections_sql_res,MYSQLI_ASSOC)) {
		$num += $selections_info['num'];		
	}
	
	return $num;
}

/* OLD
function count_signups_by_agent($aid, $book, $from, $to){
	affiliates_db();
	$num = 0;
	$selections_sql = "SELECT COUNT(*) as num FROM signups as s, promotypes as p, campaignes as c WHERE s.affiliate = '$aid'
						AND p.idcampaigne = c.id AND c.id_sportsbook = '$book' AND s.pid = p.id
						AND DATE(sudate) >= '$from' AND DATE(sudate) <= '$to'"; 
	$selections_sql_res = mysql_query($selections_sql);
	while($selections_info = mysql_fetch_array($selections_sql_res)) {
		$num = $selections_info['num'];		
	}
	return $num;
}
*/

//Headlines

function get_all_headlines(){
	affiliates_db();
	$sql = "SELECT * FROM headlines WHERE status = 1 ORDER BY position ASC";
	return get($sql, "headlines");
}

//News and updates

function get_all_news_updates(){
	affiliates_db();
	$sql = "SELECT * FROM news_updates ORDER BY id DESC";
	return get($sql, "news_updates");
}

//Products (Marketing Tools)

function get_products(){
	affiliates_db();
	$sql = "SELECT * FROM products ORDER BY position ASC";
	return get($sql, "product");
}

function get_product($id){
	affiliates_db();
	$sql = "SELECT * FROM products WHERE id = '$id'";
	return get($sql, "product", true);
}

function get_products_category($idCategory){
	affiliates_db();
	$sql = "SELECT p.id,p.name FROM products_category as pc, products as p WHERE p.id = pc.id and pc.idcategory = '$idCategory' ORDER BY p.position ASC";
   	return get_str($sql);

}

function get_products_sportsbook($idbook){
	affiliates_db();
	$sql = "SELECT a.id, a.name FROM products as a, products_sportsbook as b WHERE a.id = b.id and b.idbook = '$idbook' ORDER BY a.position ASC";
	return get($sql, "product");

}
?>