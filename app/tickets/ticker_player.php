<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$number = 958777;
$account = clean_str_ck($_GET["wpx"]) - $number;
$tk = clean_str_ck($_GET["tk"]) -  $number;
$type = clean_str_ck($_GET["t"]);
$agent = clean_str_ck($_GET["a"]) -  $number;;
$player = two_way_enc($_GET["p"],true);

if($web == ""){$web = "vrb";}
$ticket = get_ticket_player_agent($player,$agent,$tk);


if(is_null($ticket)){
	
       $ticker = get_ticker_message($tk);
		
		$data["why"] = "play_agent";
		$data["subject"] = "Player Agent Communication";
		$data["acc"] = $player;
		$data["data"] = $agent;
		$data["pre"] = $tk;		
		$data["message"] = $ticker->vars["message"];
		$data["cat"] = 45;
		$ticket = do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/send_tiket.php",$data);	

      
}

$ticket = get_ticket_player_agent($player,$agent,$tk);

if(!is_null($ticket)){
//$ticket->vars["pread"] = 1;
//$ticket->update(array("pread"));
?>
<? if (isset($mobile) and $mobile == 1) { ?>
<? include("header_top_mobile.php") ?>
<? } ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"message",type:"null", msg:"Please Write a Message"});

</script>
<? if (isset($mobile) and $mobile == 1) { ?>
</head>
<body>
<div class="mobile_container">
<? } else { ?>
<div class="container">
<? } ?>
<? include("header.php") ?>

<p><? if($_GET["show_back"]){ ?><a href="javascript:;" onClick="history.back();">&lt;&lt; Back to tickets</a><? } ?></p>
<?


?>

<span class="title"><? echo $ticket->vars["subject"] ?></span><br />
Created on <? echo $ticket->vars["tdate"] ?><br />
<? if(!$ticket->vars["open"]){ echo "This ticket is Closed";} ?>
<br /><br />

<? echo nl2br($ticket->vars["message"]) ?>

<br /><br />

<? $responses = get_ticket_responses($ticket->vars["id"]); ?>
<? foreach($responses as $res){ ?>
 
<? if($ticket->is_me($res->vars["by"])){$stl = "1";}else{$stl = "2";} ?>
<?

  
 ?>

<div class="res<? echo $stl ?>">
    <strong><? if($ticket->is_me($res->vars["by"])){echo "Me";}else{echo $res->vars["by"];} ?></strong> on <? echo $res->vars["rdate"] ?><br />
    <? echo nl2br($res->vars["message"]) ?>
</div>



<? } ?>

<? if($ticket->vars["open"]){ ?>
<br /><br />
Respond:<br />
<form method="post" action="actions/respond.php" onSubmit="return validate(validations)">
<? if ($master) { ?>
<input name="master" type="hidden" id="tid" value="<? echo $account ?>">
<? } ?>
<input name="acc" type="hidden" id="acc" value="<? echo $player ?>">
<input name="control" type="hidden" id="control" value="1">
<input name="tid" type="hidden" id="tid" value="<? echo $ticket->get_password() ?>">
<input name="dept_id" type="hidden" id="dept_id" value="<? echo $ticket->vars["dep_id_live_chat"] ?>">
<? if (isset($mobile) and $mobile == 1) { ?>
<input name="mobile" type="hidden" id="mobile" value="<? echo $mobile ?>">
<? } ?>
<textarea name="message" cols="40" rows="10" id="message"></textarea><br />
<input name="" type="submit" value="Submit">
</form>
<? } ?>
<br /><br />
<? if(!$ticket->vars["open"]){ echo "This ticket is Closed";} ?>

</div>
<? if (isset($mobile) and $mobile == 1) { ?>
<div class="goback_container"><br />
	<a style="color:#FFF;" class="goback" href="http://<? echo return_domain_name($web); ?>/">Go back to website</a>
</div>
</body>
</html>
<? } ?>
<? }else{echo "No Ticket Available";} ?>
