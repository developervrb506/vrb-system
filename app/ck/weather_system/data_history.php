<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />

<title>History</title>
<script type="text/javascript" src="http://www.sportsbettingonline.ag/utilities/js/validate.js?exp_date=20190716"></script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.0.min.js"></script>
</head>

<? 
  $from = param('from',false);
  $location = param('location');
  $data = "from=".$from."&location=".$location;
?>
<body style="background:#fff; padding:20px;">


<span class="page_title">History</span><br /><br />

<div class="form_box">

<?
 echo @file_get_contents('http://www.sportsbettingonline.ag/utilities/process/weather/data_history.php?'.$data);
?>
</div>