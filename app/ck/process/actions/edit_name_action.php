<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin") && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$vars["name"] = clean_get("name");
$vars["list"] = clean_get("list_list");
$vars["last_name"] = clean_get("last_name");
$vars["street"] = clean_get("street");
$vars["city"] = clean_get("city");
$vars["state"] = clean_get("state");
$vars["zip"] = clean_get("zip");
//if($current_clerk->vars["level"]->vars["is_admin"]){
	$vars["email"] = clean_get("email");
	$vars["phone"] = clean_get("phone");
	$vars["phone2"] = clean_get("phone2");
//}
$vars["status"] = clean_get("status_list");
$vars["clerk"] = clean_get("clerk_list");
$vars["next_date"] = clean_get("next_date");
$vars["note"] = clean_get("note");
$vars["book"] = clean_get("book");
$vars["free_play"] = clean_get("free_play");
$vars["acc_number"] = clean_get("acc_number");
$vars["aff_id"] = clean_get("aff_id");
$vars["deposit_amount"] = clean_get("deposit_amount");
$vars["source"] = clean_get("source");
$vars["clerk_source"] = clean_get("csource");
$vars["why_stop"] = clean_get("whyno");
$vars["email_desc"] = clean_get("email_desc");

if($vars["deposit_amount"]>0){
	$vars["available"] = "0";
	$vars["payment_method"] = clean_get("payment_method_list");
	$vars["deposit_date"] = clean_get("deposit_date");
}

if($vars["status"] == 13){
	$vars["available"] = "0";
	$vars["deposit"] = "1";
}

$vars["id"] = clean_get("update_id");

$name = new ck_name($vars);
$name->update();

$call = get_name_last_call($name->vars["id"]);
if(!is_null($call)){
	$call->vars["final_status"] = $name->vars["status"];
	$call->update(array("final_status"));
}

header("Location: ../../edit_name.php?nid=".$name->vars["id"]."&e=8");

?>