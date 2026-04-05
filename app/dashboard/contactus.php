<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"web_name",type:"null", msg:"You need to write a Website Name"});
validations.push({id:"web_url",type:"null", msg:"You need to write a Website URL"});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Contact Us</title>
</head>
<body>
<? 
include "../includes/header.php";
include "../includes/menu.php"; ?>
<div class="page_content" style="padding-left:20px;"> <span class="page_title">Contact Us</span><br />
  <br />
  Thank you for contacting VRB Marketing, we'll strive  to provide the best service possible.<br />
  <br />
  <?php /*?><strong>General Inquiries</strong> <br /><?php */?>
    <strong>
    <ul>
      <?php /*?><li style="list-style:none;">Toll Free Phone: <span style="font-size:16px;"> 1.800.<span style="display:none;">**</span>986.1152</span></li>
      <br />
      <li style="list-style:none;">Live Chat: <a style="color:#e94f04;" href="javascript:;" onclick="Javascript:window.open('http://localhost:8080/livehelp/request_email.php?l=admtop&amp;x=1&amp;deptid=1&amp;agsite=vrb','livehelp','width=530,height=410,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top">Click Here</a></li>      
      <br /><?php */?>
      <li style="list-style:none;">Message Us: <a style="color:#e94f04;" href="javascript:;" onClick="Javascript:window.open('http://vrbmarketing.com/tickets/?cat=agents&web=vrb','TicketAlert','width=597,height=460,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top">Click here to send us a message</a></li>     
    </ul>
    <?php /*?></strong><strong>Affiliate Team:</strong> <br />
    <ul>
      <li style="list-style:none;"> <span style="font-size:18px;"><strong>Kat Chaves</strong></span><br />
        <strong><span style="color:#e94f04">E-mail:</span></strong> katvrbmarketing(at)gmail.com<br />
        <strong><span style="color:#e94f04">Skype:</span></strong> katchaves<br />
        <br />
        <strong><span style="font-size:18px;">Wendy Alvarez</span></strong><br />
        <strong><span style="color:#e94f04">E-mail:</span></strong> wendyvrbmarketing(at)gmail.com<br />
        <strong><span style="color:#e94f04">Skype:</span></strong> wendypph<br />         
      </li>
    </ul><?php */?> 
</div>
<? include "../includes/footer.php" ?>