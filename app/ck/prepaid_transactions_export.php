<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php");

$filename ="prepaid_transactions".date("Y_m_d").".xls";

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

echo $_POST["columns"];

echo $_POST["lines"];

?>

