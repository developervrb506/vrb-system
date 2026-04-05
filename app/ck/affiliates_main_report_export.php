<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php");

$filename ="affiliates_main_report_".date("Y_m_d").".xls";

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

if ($_POST["show_report_by"] == "6"){
   $brand_name = "Brand \t";
}else{
   $brand_name = "";	
}

if ($_POST["show_report_by"] == "7"){
   $campaign_name = "Campaign \t";
}else{
   $campaign_name = "";	
}

if ($_POST["show_report_by"] == "1" or $_POST["show_report_by"] == "6" or $_POST["show_report_by"] == "7"){

	echo "$campaign_name$brand_name Affiliate ID \t First Name \t Last Name \t Email \t Website Name \t Country \t State \t Deal \t Join Date \t Language \t Status \t Impressions \t Clicks \t Ctr \t Sign ups \t First deposit count \t Conversion rate \t Clicks to funded \t First deposit volumen \t Total deposit volumen \t Active Customers \t Net Revenue \t Casino Net Revenue \t Sports Net Revenue \t Horses Net Revenue \t Revenue Share \t Carried Balance \t Current Balance \t \n";
	
}elseif ($_POST["show_report_by"] == "2" ){
	
	echo "Month \t Year \t Impressions \t Clicks \t Ctr \t Signups \t First Deposit Count \t Conversion Rate \t Clicks To Funded \t First Deposit Volume \t Total Deposit Volumen \t Active Customers \t Net Revenue \t Casino Net Revenue \t Sports Net Revenue \t Horses Net Revenue \t Carried Balance \t \n";
	
}elseif ($_POST["show_report_by"] == "3" ){
	
	echo "Affiliate ID \t First Name \t Last Name \t Email \t Website Name \t Country \t State \t Deal \t Join Date \t Language \t Status \t Month \t Year \t Impressions \t Clicks \t Ctr \t Sign ups \t First deposit count \t Conversion rate \t Clicks to funded \t First deposit volumen \t Total deposit volumen \t Active Customers \t Net Revenue \t Casino Net Revenue \t Sports Net Revenue \t Horses Net Revenue \t Revenue Share \t Carried Balance \t Current Balance \t \n";
	
}elseif ($_POST["show_report_by"] == "4" ){
	
	echo "Month \t Year \t Affiliate ID \t First Name \t Last Name \t Email \t Website Name \t Country \t State \t Deal \t Join Date \t Language \t Status \t Impressions \t Clicks \t Ctr \t Sign ups \t First deposit count \t Conversion rate \t Clicks to funded \t First deposit volumen \t Total deposit volumen \t Active Customers \t Net Revenue \t Casino Net Revenue \t Sports Net Revenue \t Horses Net Revenue \t Revenue Share \t Carried Balance \t Current Balance \t \n";
	
}

echo $_POST["lines"];
?>