<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cs_logs")){  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? if(!isset($_GET["yesterday"])){ ?><META HTTP-EQUIV="refresh" CONTENT="60"><? } ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Phone Logs</title>
</head>
<body>
<div class="page_content" style="margin:0; padding:0;">

<div class="form_box">

<? include "includes/phone_home_reports.php" ?>

</div>
<?  }else{echo "Access Denied";} ?>