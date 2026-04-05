<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if(!is_numeric($_GET["dis"])){ ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="includes/js/jquery-1.8.0.min.js"></script>
    <title>PPH Billing Report</title>
    </head>
    <body>
    <? include "../includes/header.php" ?>
    <? include "../includes/menu_ck.php" ?>
    <div class="page_content">
    <span class="page_title">PPH Agents</span><br /><br />

<? } ?>


<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_pph_agents.php?dis=".$_GET["dis"]); ?>


<? if(!is_numeric($_GET["dis"])){ ?>
    </div>
    <? include "../includes/footer.php" ?>
<? } ?>