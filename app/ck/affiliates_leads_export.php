<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php");

$filename ="affiliate_leads_report_".date("Y_m_d").".xls";

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

echo "Level \t AffId \t Name \t Website \t Email \t Phone \t Owner \t LCD \t Status \t Disposition \t CBD \t \n";

echo $_POST["lines"];

?>

