<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("line_blocker")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />


<title>Agent Money Line Blocker</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Agent Money Line Blocker</span><br /><br />

<a href="create_agent_money_line_blocker.php" class="normal_link"  title="Add New">
	Add New
</a>

<br /><br />
<? include "includes/print_error.php" ?> 

 
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_money_line_blocker.php"); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>