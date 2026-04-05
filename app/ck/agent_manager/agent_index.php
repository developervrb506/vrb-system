<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("agent_manager")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Agent Manager</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">AGENT MANAGER</span><br /><br />

<? include "../includes/print_error.php" ?>


<table width="100%" border="0" cellpadding="10">
  
  <tr>
      <td width="50%">
        <a class="normal_link" href="agent_report_bd.php">Agent Reports DB</a><br />
        Manage the option to change the DataBase used for agent's reports
    </td>
  </tr>
  
  <tr>
      <td width="50%">
        <a class="normal_link" href="hide_cashier.php">Show Cashier</a><br />
        Manage the option to Show the Cashier in agents backend
    </td>
  </tr>
  
  <tr>
      <td width="50%">
        <a class="normal_link" href="enable_cashier.php">Enable PPH Player Cashier </a><br />
        Manage the option to enable the cashier to PPH Players
    </td>
  </tr>
   <tr>
      <td width="50%">
        <a class="normal_link" href="player_casino_access.php">Manage Player Casino Access  </a><br />
        Manage the Player access to Casinos
    </td>
  </tr>
   <tr>
      <td width="50%">
        <a class="normal_link" href="agent_report_access.php">Manage Agent Reports  Access </a><br />
        Manage the Access to the Agents Reports
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="agent_tool_access.php">Manage Agent Tools  Access </a><br />
        Manage the Access to the Agents Tools
    </td>
  </tr>
  <tr>
    <td width="50%">
        <a class="normal_link" href="../live_betting_access.php">Live Betting Access</a><br />
        Manage Access for Live Betting
    </td>
  </tr>
  
 
</table>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>