<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$vars = explode(",",$_GET["v"]);
$ids = get_excel_ids($vars[0], $vars[1], $vars[2], $vars[3], $vars[4], $vars[5], $vars[6], $vars[7], $vars[8]);

$filename ="vrb_list_".date("Y_m_d").".xls";

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

echo "Id \t List \t Name \t Last Name \t Street \t City \t State \t Zip \t Email \t Phone \t Available \t Status \t On the Phone \t Current Call \t Clerk \t Call Back Date \t Note \t Book \t Account \t Affiliate \t Deposit Amount \t \n";

foreach($ids as $id){
	$name = get_ckname($id["id"]);
	$line = $name->vars["id"] . " \t " . $name->vars["list"]->vars["name"] . " \t " . $name->vars["name"] . " \t " . $name->vars["last_name"] . " \t " . $name->vars["street"] . " \t " . $name->vars["city"] . " \t " . $name->vars["state"] . " \t " . $name->vars["zip"] . " \t " . $name->vars["email"] . " \t " . $name->vars["phone"] . " \t " . $name->vars["available"] . " \t " . $name->vars["status"]->vars["name"] . " \t " . $name->vars["on_the_phone"] . " \t " . $name->vars["current_call"] . " \t " . $name->vars["clerk"]->vars["name"] . " \t " . $name->vars["next_date"] . " \t " . $name->vars["note"] . " \t " . $name->vars["book"] . " \t " . $name->vars["acc_number"] . " \t " . $name->vars["aff_id"] . " \t " . $name->vars["deposit_amount"] . " \t";
	
	$charlist = "\n\r\0\x0B";
	
	$line = str_replace(str_split($charlist), ' ', $line);
	
	echo $line . "  \n";
	
}

?>