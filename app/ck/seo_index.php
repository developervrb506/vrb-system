<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system") || $current_clerk->im_allow("system_metatags") || $current_clerk->im_allow("posting")){ ?>
<script type="text/javascript">
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
Shadowbox.init();
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO System</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">SEO System</span><br /><br />

<? include "includes/print_error.php" ?>


<? include "seo_menu.php" ?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>