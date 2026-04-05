<? include(ROOT_PATH . "/process/functions.php"); redir_www(); ?>
<? session_start(); if ($_SESSION["ses_loged"] == "y"){ header("Location: dashboard/index.php"); } ?>
<? session_start(); if ($_SESSION["wuloged"]){ header("Location: wu/index.php"); } ?>
<? session_start(); if ($_SESSION["ckloged"]){ header("Location: ck/index.php"); } ?>
<? if( strcontains(current_URL(),"ezpay.com") || strcontains(current_URL(),"buybitcoins.com") ){ ?>
   <? include "includes/header-new_ezpay.php" ?>
<? }else{ ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Partners Login</title>
    <link href="css/style-new.css" rel="stylesheet" type="text/css" />
    <link href="css/skins/tango/skin.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="http://localhost:8080/images/favicon.jpg" type="image/x-icon" />
    </head>
    <body>
    
    <? if(strcontains(current_URL(),"vrbprocessing.com")){ ?>
        <!--vrbprocessing Home page-->
    
        <? include "includes/header-new_processing.php" ?>
    
    <? }else{ ?>
    
        <!--vrbmarketing Home page-->
        <? include "includes/header-new.php" ?>
        <div style="font-size:0px; color:#FFFFFF; text-decoration:none;>
          <a href="http://protomon.badhim.com">Server monitoring software</a>
        </div>  
        <? include "includes/headlines.php" ?>
        <div class="wrapper_content">
        <? include "includes/content_left.php" ?>
        <? include "includes/content_right.php" ?>        
        </div>
        <? include "includes/footer-new.php" ?>
    
    
    <? } ?>
<? } ?>