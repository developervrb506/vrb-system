<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? if($_GET["isagent"]){include("icon_agent.php");}else{ ?>
<? 
$web    = clean_str_ck($_GET["web"]); 
$mobile = clean_str_ck($_GET["mobile"]);
$account = clean_str_ck($_GET["wpx"]);


if($web == ""){$web = "vrb";}
$count = count_unread_tickets_by_player(two_way_enc($account,true));
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="600">
<style type="text/css">
body {
	margin-left: 10px;
	margin-top: 15px;
	margin-right: 10px;
	margin-bottom: 10px;
}
.circle_alert{
	background:url(images/circle_alert.png) no-repeat;
	width:26px;
	height:26px;
	text-align:center;
	font-size:13px;
	color:#fff;
	line-height:26px;
	left: 45px;
  	top: 5px;
	position:absolute;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
</style>
</head>
<body>
<? if($count["num"] > 0){ ?><div class="circle_alert"><? echo $count["num"] ?></div><? } ?>

<a href="javascript:;" onClick="Javascript:window.open('http://vrbmarketing.com/tickets/list.php?cat=agents&web=<? echo $web ?>&wpx=<? echo $account ?>&mobile=<? echo $mobile ?>','TicketAlert','width=597,height=560,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top"><img src="images/tickets.png" width="48" height="38" alt="Tickets"></a>

</body>

<? }?>