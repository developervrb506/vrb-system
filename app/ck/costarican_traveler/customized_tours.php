<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("costarican_traveler")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Customized Tours</title>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<h1>Customized Tours</h1>
<? //echo file_get_contents("URL del sitio/page.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING']); ?>
<? $data = "&cid=".$current_clerk->vars['id']."&clerk=".str_replace(" ","_",$current_clerk->vars['name'])."&pg=ct"; ?>
<? echo @file_get_contents("https://www.costaricantraveler.com/utilities/ui/customized_tours/list.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$data); ?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>