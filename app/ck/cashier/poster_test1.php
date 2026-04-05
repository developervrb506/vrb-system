<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 

if(!isset($_POST["way"]) &&  isset($_GET["way"]) ){
 $_POST = $_GET;	
}


$_POST["sip"] = get_ip();
$_POST["by"] = $current_clerk->vars["id"];
/*
echo "<pre>";

print_r($_POST);
echo "</pre>";
*/
if($current_clerk->im_allow("cashier_admin")){ 
	$target = clean_str_ck($_POST["way"]);
	echo do_post_request('http://cashier.vrbmarketing.com/utilities/process/actions/admin/'.$target.'.php', $_POST);
	//echo 'http://cashier.vrbmarketing.com/utilities/process/actions/admin/'.$target.'.php';
}
?>