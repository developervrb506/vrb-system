<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_balances")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PPH Balance Sheet</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<!--Assets-->
<span class="page_title">Assets</span>
<? $total_assets = 0; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  
  
  <!--Credit-->
  <? include("balances/pph_assets.php"); ?>
  <!--End credit-->
  
  
</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>