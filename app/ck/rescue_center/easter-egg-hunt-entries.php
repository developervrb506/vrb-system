<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="myhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<script type="text/javascript" src="/ck/rescue_center/js/scripts.js"></script>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

<script type="text/javascript" src="/ck/includes/js/jquery-1.9.1.js"></script>
<!-- For draggable -->
<script src="/ck/includes/js/jquery-ui.js"></script>
<script src="/ck/includes/js/scrollbar-top.js"></script>
<link href="/css/scrollbar.css" rel="stylesheet" type="text/css" />
<title>Easter egg hunt entries</title>
</head>
<body>
<? $page_style = " width:2000px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>

<div id="wrapper1" class="draggable">
    <div id="div1"></div>
</div>

<div class="page_content" style="padding-left:10px;" id="container" class='table-container'>
<? $data = "&cid=".$current_clerk->vars['id']."&clerk=".str_replace(" ","_",$current_clerk->vars['name'])."&pg=eh"; ?>
<? echo @file_get_contents("https://www.rescuecenter.com/utilities/ui/easter-egg-hunt-entries/list.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$data); ?>

</div>

<script src="/ck/includes/js/scrollbar-bottom.js"></script>

<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>