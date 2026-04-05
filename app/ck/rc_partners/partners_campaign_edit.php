<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rc_partners")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>

iframe {
    background-image: url("../images/round.gif");   
    background-repeat: no-repeat;
	background-size: 33px 33px;
   }
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Manage Campaign</title>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="/process/js/jquery.js"></script>
<script type="text/javascript">
Shadowbox.init();

$('#foo').ready(function () {
    $('#loadingMessage').css('display', 'none');
});
$('#foo').load(function () {
    $('#loadingMessage').css('display', 'none');
});

</script>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;" >
<?
$error = $_GET["e"]; 

if(isset($error) and !empty($error)){
	$error = "e=".$error;
}else{
	$error = "";
}

$security_phrase = "RcVRB2019";
$security_number = "2150";
$security_param = md5($security_phrase); /* Encrypted Code: ef837f484ad91dc97c684e53934d4e0d */

$src = "https://www.rescuecenterpartners.com/admin/campaigns/partners_campaign_edit.php?n=".$security_number."&p=".$security_param."&".$error."&".$_SERVER['QUERY_STRING'];

?>

<iframe width="100%" height="1200px"  frameborder="0" scrolling="yes" src="<? echo $src ?>" id="foo"></iframe>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>