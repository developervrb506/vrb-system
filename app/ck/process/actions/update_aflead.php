<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if($current_clerk->im_allow("affiliate_leads")){

	$lead = get_affiliate_lead(clean_get("lead"));
	
	$lead->vars["name"] = clean_get("name");
	$lead->vars["last_name"] = clean_get("last_name");
	$lead->vars["website"] = clean_get("website");
	$lead->vars["email"] = clean_get("email");
	$lead->vars["phone"] = clean_get("phone");
	$lead->vars["country"] = clean_get("country");
	$lead->vars["address"] = clean_get("address");
	$lead->vars["state"] = clean_get("state");
	$lead->vars["city"] = clean_get("city");	
	$lead->vars["status"] = clean_get("status");
	$lead->vars["payment_method"] = clean_get("p_method");
	$lead->vars["disposition"] = clean_get("disposition");
	$lead->vars["call_back_date"] = clean_get("call_back_date");
	$lead->vars["rate"] = clean_get("rate");
	$lead->vars["plan"] = clean_get("plan");
	$lead->vars["rank"] = clean_get("rank");
	$lead->vars["alexa"] = clean_get("alexa");
	$lead->vars["aff_id"] = clean_get("aff_id");
	$lead->vars["ww_af"] = clean_get("ww_af");
	$lead->vars["site_type"] = clean_get("site_type");
	$lead->vars["active_players"] = clean_get("active_players");
	$lead->vars["level"] = clean_get("level");
	$lead->vars["owner"] = clean_get("owner");
	$lead->vars["Notes"] = clean_get("Notes");
	$lead->vars["last_contact"] = date("Y-m-d H:i:s");
	$lead->update();
	
	$call = new _affiliate_lead_call();
	$call->vars["lead"] = $lead->vars["id"];
	$call->vars["owner"] = $current_clerk->vars["id"];
	$call->vars["status"] = $lead->vars["status"];
	$call->vars["disposition"] = $lead->vars["disposition"];
	$call->vars["cdate"] = date("Y-m-d H:i:s");
	$call->insert();	
	
	header("Location: ../../open_affiliates_lead.php?l=".$lead->vars["id"]."&e=74");

}
?>