<?
ini_set('memory_limit', '-1');
set_time_limit(0);

$filename = $_POST["name"]."_".date("Y_m_d").".xls";
header('Content-type: application/ms-excel',true);
//header('Content-Disposition: attachment; filename='.$filename);

//$filename = $_POST["name"]."_".date("Y_m_d").".csv";
//  header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');




echo $_POST["content"];
?>