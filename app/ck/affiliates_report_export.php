<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php");

$filename ="affiliate_report_".date("Y_m_d").".xls";

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

echo "Affiliate ID \t Name \t Life Time Players \t Sign Ups \t First Time Depositors \t Earnings \t Running Balance \t Net Revenue \t Impressions \t Clicks \t \n";

echo $_POST["lines"];

?>