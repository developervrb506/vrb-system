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
    <script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Partners Login</title>
    <link href="css/style-new_design.css" rel="stylesheet" type="text/css" />   
    <link rel="shortcut icon" href="<?= BASE_URL ?>/images/favicon.jpg" type="image/x-icon" />
    </head>
    <body>
     <? if(strcontains(current_URL(),"vrbprocessing.com")){ ?>
        <!--vrbprocessing Home page-->    
        <? include "includes/header-new_processing.php" ?>    
     <? }else{ ?>        
		<? include(ROOT_PATH . "/includes/new_design/header.php"); ?>
        <? include(ROOT_PATH . "/includes/new_design/headlines.php"); ?>
        <? include(ROOT_PATH . "/includes/new_design/container-home.php"); ?>    
        <? include(ROOT_PATH . "/includes/new_design/footer.php"); ?> 
    <? } ?>
<? } ?>   