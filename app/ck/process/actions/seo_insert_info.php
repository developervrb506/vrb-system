<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?

$website = get_seo_website(clean_str_ck($_POST["web"]));

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
$website->vars["status"] = 'r';
$website->vars["last_modification"] = date("Y-m-d H:i:s");
$website->vars["last_modification_by"] = $current_clerk->vars["id"];
$website->update();

$log = new _seo_log();
$log->vars["website"] = $website->vars["id"];
$log->vars["clerk"] = $current_clerk->vars["id"];
$log->vars["ldate"] = date("Y-m-d H:i:s");
$log->vars["action"] = "if";
$log->insert();


header("Location: http://localhost:8080/ck/seo_insert_info.php?e=72");
?>
<? }else{echo "Access Denied";} ?>