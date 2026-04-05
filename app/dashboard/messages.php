<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Messages</title>
</head>

<body>

<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<?
$messages = get_messages($current_affiliate);
read_all_messages($current_affiliate);
?>
<span class="page_title">Inbox</span><br />

<span class="error"><? if (isset($_GET["e"])) { echo "<br />" . get_error($_GET["e"]) . "<br /><br />"; }?></span>

<br /><br />


<? foreach($messages as $message){ ?>
	<div class="delete_box" onclick="location.href = '../process/actions/delete_message_action.php?mid=<? echo $message->id ?>'">Delete</div>
	<div class="conte_banners">
            <div class="conte_banners_header"><strong class="message_date"><? echo date('F jS h:i:s A',strtotime($message->m_date)); ?></strong> </div>
        <br />
        <span class="message_subject"><? echo ucwords($message->subject);  ?></span><br /><br />
        <span class="message_content"><? echo nl2br($message->content);  ?></span><br /><br />
    </div>
<? } ?>
<? if(count($messages)<1){echo "No Messages";} ?>
</div>
<? include "../includes/footer.php" ?>