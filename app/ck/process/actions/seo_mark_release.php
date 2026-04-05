<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?

$website = get_seo_website(clean_str_ck($_GET["id"]));

$website->vars["status"] = 'r';
$website->vars["clerk"] = 0;
$website->update(array("status","clerk"));

$log = new _seo_log();
$log->vars["website"] = $website->vars["id"];
$log->vars["clerk"] = $current_clerk->vars["id"];
$log->vars["ldate"] = date("Y-m-d H:i:s");
$log->vars["action"] = "re";
$log->insert();

header("Location: http://localhost:8080/ck/seo_get_lead.php?e=72");
?>
<? }else{echo "Access Denied";} ?>