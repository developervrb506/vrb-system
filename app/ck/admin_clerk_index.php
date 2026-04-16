<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Phone System</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px; display:inline-block; width:929px;">
<span class="page_title">Welcome:</span> <span class="orange_title"><? echo $current_clerk->vars["name"]?></span>

<br /><br />

<? include "includes/print_error.php" ?>

<? $admin_is_clerk = true; include("index_clerk.php"); ?>

</div>
<? include "../includes/footer.php" ?>