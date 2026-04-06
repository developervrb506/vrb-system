<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?

$website = new _seo_website();
$website->vars["website"] = clean_str_ck($_POST["website"]);
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
$website->vars["network_solutions"] = clean_str_ck($_POST["networknetwork"]);
$website->vars["type"] = clean_str_ck($_POST["type"]);
$website->vars["status"] = clean_str_ck($_POST["status"]);
$website->vars["clerk"]  =$current_clerk->vars["id"];
$website->vars["last_modification"] = date("Y-m-d H:i:s");
$website->vars["last_modification_by"] = $current_clerk->vars["id"];
$website->insert();


header("Location: " . BASE_URL . "/ck/seo_get_lead.php");
?>
<? }else{echo "Access Denied";} ?>