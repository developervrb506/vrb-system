<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("backend_permissions")){?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Agent Backend</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Agent Backend</span> &nbsp;&nbsp;&nbsp; <a href="backends_list.php" class="normal_link">View Full List</a><br /><br />

<? include "includes/print_error.php" ?>

<? echo file_get_contents("http://www.sportsbettingonline.ag//utilities/process/reports/sbo_backends.php?".http_build_query($_GET));  ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>