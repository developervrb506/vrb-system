<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?
$website = get_seo_website(clean_str_ck($_POST["web"]));

$website->vars["comments"] = clean_str_ck($_POST["comments"]);
$website->vars["name"] = clean_str_ck($_POST["name"]);
$website->vars["last_name"] = clean_str_ck($_POST["last_name"]);
$website->vars["email"] = clean_str_ck($_POST["email"]);
$website->vars["phone"] = clean_str_ck($_POST["phone"]);
$website->vars["contact_form"] = clean_str_ck($_POST["contact_form"]);
$website->vars["pr"] = clean_str_ck($_POST["pr"]);
$website->vars["alexa"] = clean_str_ck($_POST["alexa"]);
$website->vars["twitter"] = clean_str_ck($_POST["twitter"]);
$website->vars["facebook"] = clean_str_ck($_POST["facebook"]);
$website->vars["google_plus"] = clean_str_ck($_POST["google_plus"]);
$website->vars["other_social"] = clean_str_ck($_POST["other"]);
$website->vars["network_solutions"] = clean_str_ck($_POST["network"]);
$website->vars["type"] = clean_str_ck($_POST["type"]);

if(clean_str_ck($_POST["my_lead"]) != ""){
	$website->vars["clerk"] = $current_clerk->vars["id"];
	$website->vars["status"] = clean_str_ck($_POST["my_lead"]);
	
	$log = new _seo_log();
	$log->vars["website"] = $website->vars["id"];
	$log->vars["clerk"] = $current_clerk->vars["id"];
	$log->vars["ldate"] = date("Y-m-d H:i:s");
	$log->vars["action"] = "mo";
	$log->insert();
}

$website->update();

$action = clean_str_ck($_POST["action"]);
if($action != ""){
	$moved = false;
	switch($action){
		case "af":
			
			$lead = new _affiliate_lead();
	
			$lead->vars["name"] = $website->vars["name"];
			$lead->vars["last_name"] = $website->vars["last_name"];
			$lead->vars["website"] = $website->vars["website"];
			$lead->vars["email"] = $website->vars["email"];
			$lead->vars["phone"] = $website->vars["phone"];
			$lead->vars["country"] = "";
			$lead->vars["address"] = "";
			$lead->vars["state"] = "";
			$lead->vars["city"] = "";	
			$lead->vars["status"] = 1;//clean_get("status");
			$lead->vars["disposition"] = "Inserted From SEO System";
			$lead->vars["payment_method"] = "";
			$lead->vars["call_back_date"] = "";
			$lead->vars["rate"] = "";
			$lead->vars["plan"] = "";
			$lead->vars["rank"] = $website->vars["pr"];
			$lead->vars["alexa"] = $website->vars["alexa"];
			$lead->vars["aff_id"] = "";
			$lead->vars["ww_af"] = "";
			$lead->vars["site_type"] = "";
			$lead->vars["active_players"] = "";
			$lead->vars["level"] ="";
			$lead->vars["owner"] = "";
			$lead->vars["Notes"] = "";
			$lead->vars["last_contact"] = date("Y-m-d H:i:s");
			$lead->insert();
			
			$moved = true;
			
			$log = new _seo_log();
			$log->vars["website"] = $website->vars["id"];
			$log->vars["clerk"] = $current_clerk->vars["id"];
			$log->vars["ldate"] = date("Y-m-d H:i:s");
			$log->vars["action"] = "va";
			$log->insert();
			
			
		break;
		case "lk":
			
			$count  = clean_get("links_count");
			
			for($i=0;$i<$count;$i++){ $inx = $i+1;
			
				//if(clean_get("brand".$inx) != "" || clean_get("url".$inx) != ""){
					$link = new _seo_entry();
					$link->vars["brand"] = clean_get("brand".$inx);
					$link->vars["url"] = clean_get("url".$inx);
					$link->vars["keywords"] = clean_get("keywords".$inx);
					$link->vars["rank"] = clean_get("rank".$inx);
					$link->vars["amount"] = clean_get("amount".$inx);
					$link->vars["email"] = clean_get("email".$inx);
					$link->vars["method"] = clean_get("method".$inx);
					$link->vars["paid_date"] = clean_get("paid_date".$inx);
					$link->vars["article_type"] = clean_get("article_type".$inx).":".clean_get("article_type_desc".$inx);
					$link->vars["website"] = $website->vars["id"];
					$link->insert();
				//}
			
			}
			
			$moved = true;
			
			$log = new _seo_log();
			$log->vars["website"] = $website->vars["id"];
			$log->vars["clerk"] = $current_clerk->vars["id"];
			$log->vars["ldate"] = date("Y-m-d H:i:s");
			$log->vars["action"] = "vl";
			$log->insert();
			
		break;
		case "bo":
			
			$website->vars["is_betting_odds"] = '1';
			$website->update(array("is_betting_odds"));
			$moved = true;
			
			$log = new _seo_log();
			$log->vars["website"] = $website->vars["id"];
			$log->vars["clerk"] = $current_clerk->vars["id"];
			$log->vars["ldate"] = date("Y-m-d H:i:s");
			$log->vars["action"] = "vd";
			$log->insert();
			
		break;
		case "in":
		
			$website->vars["status"] = 'i';
			$website->update(array("status"));
			
			$log = new _seo_log();
			$log->vars["website"] = $website->vars["id"];
			$log->vars["clerk"] = $current_clerk->vars["id"];
			$log->vars["ldate"] = date("Y-m-d H:i:s");
			$log->vars["action"] = "mi";
			$log->insert();
			
		break;
	}
	
	if($moved){
		$website->vars["moved_to"] = $action;
		$website->vars["moved_by"] = $current_clerk->vars["id"];
		$website->vars["moved_date"] = date("Y-m-d H:i:s");
		$website->vars["status"] = 'm';
		$website->update(array("status","moved_to","moved_by","moved_date"));
	}
}


header("Location: " . BASE_URL . "/ck/seo_get_lead.php");
?>
<? }else{echo "Access Denied";} ?>