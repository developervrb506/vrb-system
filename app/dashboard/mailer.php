<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Mailer</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<?
$cid = $_GET["cid"];
if(!isset($cid)){$cid = 0;}
$campaigne = get_campaigne($cid);
$mailers = get_mailers_by_campaigne($campaigne->id);
$aff_code = get_affiliate_code($current_affiliate->id, $campaigne->book->id);
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}
?>
<span class="page_title"><? echo ucwords($campaigne->name) ?> Mailers</span><br /><br />
<span class="error"><? if (isset($_GET["e"])) { echo "<br />" . get_error($_GET["e"]) . "<br />"; }?></span><br /><br /><br />

<? foreach($mailers as $mail){ ?>
	<? $code = file_get_contents($mail->name."?acode=".$aff_code."&aname=".str_replace(" ","_xax_",$current_affiliate->web_name) ."&aid=" . $current_affiliate->id); ?>
	<div class="conte_banners">
            <div class="conte_banners_header"><strong><a href="<? echo $mail->name."?acode=".$aff_code."&aname=".$current_affiliate->web_name ."&aid=" . $current_affiliate->id ?>" target="_blank" class="normal_link">Click here for Preview</a></strong><br /><strong>PID:</strong> <? echo $mail->id; ?> </div>
        <br />
        <form action="../../../process/actions/send_mailer.php" method="post">
        <input name="email" type="hidden" id="email" value="<? echo $current_affiliate->email ?>" />
        <input name="campaigne_id" type="hidden" id="campaigne_id" value="<? echo $campaigne->id ?>" />
        <input name="campaigne_name" type="hidden" id="campaigne_name" value="<? echo $campaigne->name ?>" />
        <input name="mail_id" type="hidden" id="mail_id" value="<? echo $mail->id ?>" />
      <textarea name="code_<? echo $mail->id ?>" cols="90" rows="10" readonly="readonly" id="code_<? echo $mail->id ?>"><? echo $code; ?></textarea><br />
      <input onclick="select_value('code_<? echo $mail->id ?>')" name="" type="button" value="Select HTML Code" /> <input onclick="" name="" type="submit" value="Send a Copy to my Email" />
      </form>
    </div>
<? } ?>

</div>
<? include "../includes/footer.php" ?>