<?
$d1 = $_POST["d1"];
$d2 = $_POST["d2"];
$agentID = $_POST["agentID"];

$d1 = str_replace("\'","",$d1);
$d1 = "'".$d1."'";

$d2 = str_replace("\'","",$d2);
$d2 = "'".$d2."'";

header("Content-Type: application/csv");
header("Content-Disposition: attachment;Filename=conversion-report.csv");
$result = file_get_contents('http://lb.wagerweb.com/vrb/reports/ag_elDoradoNewCustomers-csv.asp?d1='.$d1.'&d2='.$d2.'&agentID='.$agentID);
$result = trim($result);
echo $result;
?>