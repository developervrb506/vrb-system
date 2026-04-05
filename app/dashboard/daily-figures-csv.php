<?
$agentID = $_POST["agentID"];
$period  = $_POST["period"];

header("Content-Type: application/csv");
header("Content-Disposition: attachment;Filename=daily-figures.csv");
$result = file_get_contents('http://lb.playblackjack.com/daily-figures-csv.asp?agentID='.$agentID.'&period='.$period);
echo $result;
?>
