<?
$CustomerID = $_POST["CustomerID"];
$date1      = $_POST["date1"];
$date2      = $_POST["date2"];
header("Content-Type: application/csv");
header("Content-Disposition: attachment;Filename=payment-statement-by-date.csv");
$result = file_get_contents('http://lb.wagerweb.com/vrb/reports/Affiliates_PayoutsTracking-new-by-date-csv.asp?CustomerID='.$CustomerID.'&date1='.$date1.'&date2='.$date2);
$result = trim($result);
echo $result;
?>
