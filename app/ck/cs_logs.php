<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cs_logs")){  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Customer Service Logs</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"rdate",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<div class="page_content" style="margin:0; padding:0;">

<div class="form_box">
<? 
$rdate = $_POST["rdate"]; 
if($rdate == ""){$rdate = date("Y-m-d");}
$host = $_POST["host"]; 
?>
<form method="post">
Date: <input name="rdate" type="text" id="rdate" value="<? echo $rdate ?>" />
&nbsp;&nbsp;
<input type="submit" value="Go" />
</form>
</div>

<p><iframe frameborder="0" width="300" height="25" scrolling="no" src="includes/tickets_alerts.php"></iframe></p>

<iframe frameborder="0" scrolling="auto" width="100%" height="1000" src="cs_logs_tikets.php?rdate=<? echo $rdate ?>">></iframe>
<?php /*?><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="table_header" width="33%">Chats</td>
    <td class="table_header" width="33%">Tickets</td>
    <td class="table_header" width="33%">
    	Emails
        <? create_list("host", "host", get_accounts_hosts(), $host, "change_email_host(this.value)", "", "All") ?>
    </td>
  </tr>
  <tr>
    <td class="table_td2"><iframe frameborder="0" scrolling="auto" width="100%" height="1000" src="cs_logs_chats.php?rdate=<? echo $rdate ?>"></iframe></td>
    <td class="table_td2"><iframe frameborder="0" scrolling="auto" width="100%" height="1000" src="cs_logs_tikets.php?rdate=<? echo $rdate ?>">></iframe></td>
    <td class="table_td2"><iframe id="emails_box" frameborder="0" scrolling="auto" width="100%" height="1000" src="cs_logs_emails.php?rdate=<? echo $rdate ?>"></iframe></td>
  </tr>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table><?php */?>

<script type="text/javascript">
function change_email_host(new_host){
	document.getElementById("emails_box").src = "cs_logs_emails.php?rdate=<? echo $rdate ?>&host="+new_host;
}
</script>

</div>
<?  }else{echo "Access Denied";} ?>