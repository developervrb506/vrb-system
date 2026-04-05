<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$account = get_betting_account($_POST["aid"]);
$settings = get_betting_auto_settings($account->vars["id"]);

if(is_null($settings)){	
	//new
	$settings = new _betting_auto_settings();	
	$action = "\$settings->insert();";
}else{
	$action = "\$settings->update();";
}

$settings->vars["account"] = $account->vars["id"];
$settings->vars["url"] = $_POST["url"];
$settings->vars["site_name"] = $_POST["sname"];
$settings->vars["site_domain"] = $_POST["sdomain"];
$settings->vars["software"] = $_POST["betting_software_list"];
$settings->vars["password"] = $_POST["password"];
$settings->vars["username"] = $_POST["username"];
$settings->vars["proxy"] = $_POST["proxy"];

//amounts
$sports = get_betting_sports();
$types = get_betting_line_types();
$detailed = $_POST["detailed_max"];
foreach($sports as $sp){
	foreach($types as $tp){ 
		if($detailed){
			$settings->vars[$sp["name"] . "_" . $tp["short"]] = $_POST[$sp["name"] . "_" . $tp["short"]];
		}else{
			$settings->vars[$sp["name"] . "_" . $tp["short"]] = $_POST["max"];
		}
   }
} 
$settings->vars["detailed_max"] = $detailed;

eval($action);

//groups
$settings->update_groups($_POST["groups"]);



header("Location: ../../betting_accounts_auto_settings.php?e=67&aid=".$account->vars["id"]);
?>
<? }else{echo "Access Denied";} ?>