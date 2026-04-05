<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?  if($current_clerk->im_allow("cs_logs")){  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$today = $_GET["rdate"];
if($today == ""){$today = date("Y-m-d");}
?>
<? if($today == date("Y-m-d")){ ?><META HTTP-EQUIV="refresh" CONTENT="60"><? } ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Customer Service Logs</title>

<style type="text/css">
body {
	background-color: #FFF;
}
</style>
</head>
<body>
<div id="chat_content">
<?
$emails = get_emails_by_date($today, $today, $_GET["host"]);
$bodys = array();
?>

<? if(count($emails)<1){echo "<strong>NO EMAILS TO SHOW</strong>";} ?>

<? foreach($emails as $email){ ?>
   <?
	if (!contains_ck($email->vars["from_address"],"@asana.com"))
    {
			 
	$body_hash = md5($email->vars["subject"].$email->vars["body"]);
	if(!in_array($body_hash,$bodys) && !contains_ck($email->vars["subject"],"*SPAM*")){
		$replys = get_email_replys($email);
	?>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" class="table_header_samll">
                <? echo $email->vars["subject"] ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="table_header_samll">
                <? echo $email->vars["edate"] ?>
            </td>
          </tr>
          <tr>
            <td class="table_header_samll">FROM: <? echo $email->vars["from_address"] ?></td>
            <td class="table_header_samll">TO: <? echo $email->vars["to_address"] ?></td>
          </tr>
          <tr>
            <td colspan="2" class="table_td1">
                <? 
                $bodys[] = $body_hash;
                echo nl2br($email->vars["body"]);
				
				foreach($replys as $reply){
					?>
                    <div class="form_box" style="background:#fbfdc2">
                    	<strong>FROM:</strong> <? echo $reply->vars["from_address"] ?>
                        <br />
                        <strong>TO:</strong> <? echo $reply->vars["to_address"] ?>
                        <br />
                        <? echo $reply->vars["edate"] ?>
                        <br /><br />
                        <? echo nl2br($reply->vars["body"]); ?>
                    </div>
                    <?
				}
				
                ?>
            </td>
          </tr>
          <tr>
            <td class="table_last" colspan="101"></td>
          </tr>
        </table>
        
        <br /><hr><br />
     <? } ?>     
    <? } ?>
    
<? } ?>
</div>

<? }else{echo "Access Denied";}  ?>