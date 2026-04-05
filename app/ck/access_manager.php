<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("access_manager")){?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/js/jquery-1.8.0.min.js"></script>
<title>Access Manager</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<? include "includes/print_error.php" ?>

<? echo file_get_contents("http://www.sportsbettingonline.ag//utilities/process/reports/sbo_access_manager.php?".http_build_query($_GET));  ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>