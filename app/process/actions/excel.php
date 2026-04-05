<?
$filename = $_POST["name"]."_".date("Y_m_d").".xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $_POST["content"];
?>