<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?

$list = $current_clerk->vars["list"];
if($list == "" || $list < 1){$list = 34;}

$vars["name"] = clean_get("name");
$vars["list"] = $list;/*clean_get("list_list");*/
$vars["last_name"] = clean_get("last_name");
$vars["street"] = clean_get("street");
$vars["city"] = clean_get("city");
$vars["state"] = clean_get("state");
$vars["zip"] = clean_get("zip");
$vars["email"] = clean_get("email");
$vars["phone"] = clean_get("phone");
$vars["phone2"] = clean_get("phone2");
$vars["source"] = clean_get("source");
$vars["clerk"] = $current_clerk->vars["id"];
$vars["note"] = clean_get("note");
$vars["status"] = "11";
$vars["added_date"] = date("Y-m-d H:i:s");

$name = new ck_name($vars);
$name->insert();

$start = clean_get("start_date");
$name->open_call($current_clerk->vars["id"], false, $start);
$name->close_call();

header("Location: ../../index.php?e=10");
?>