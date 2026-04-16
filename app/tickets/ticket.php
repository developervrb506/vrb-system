<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<script type="text/javascript">
function disable_btn(id){
  document.getElementById(id).disabled = true;
  document.getElementById("frm_1").submit();
}
</script>
<?
$account = clean_str_ck($_GET["wpx"]);
$acc = two_way_enc($account,true);

if (!$_GET["master"]){
$master = false;
$ticket  = get_ticket(clean_str_ck(get_ticket_id($_GET["tid"])));

} else {
$master = true;
  $ticket = get_master_ticket(clean_str_ck(get_ticket_id($_GET["tid"])));
;
}


$mobile  = clean_str_ck($_GET["mobile"]);
$nologo  = clean_str_ck($_GET["nologo"]);
$web     = $ticket->vars["website"];
$dept_id = $ticket->vars["dep_id_live_chat"];

if(!is_null($ticket)){

  
   if($ticket->vars["ticket_category"] == 45 || $ticket->vars["ticket_category"] == 47){ 	 
	 $last = get_ticket_last_response($ticket->vars["id"]);
     if($last->vars["by"] != $acc){  // to check if the last 
	   $ticket->vars["pread"] = 1; echo "ON"; 
	 }
	 else  {$ticket->vars["pread"] = 0; echo "OFF";}
	 
	  $ticket->update(array("pread")); 
   }else{
    $ticket->vars["pread"] = 1;
    $ticket->update(array("pread"));
   }
  

?>
<? if (isset($mobile) and $mobile == 1) { ?>
<? include("header_top_mobile.php") ?>
<? } ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"message",type:"null", msg:"Please Write a Message"});
<?php /*?>
Only the clerk can close the ticket, so the last record of responses will have a clerk id attached on it.
function close_ticket(id,mobile){
	if(confirm("Are you sure you want to Close this Ticket?")){
		location.href = "actions/close.php?tid="+id+"&mobile="+mobile;
	}
}<?php */?>
</script>
<? if (isset($mobile) and $mobile == 1) { ?>
</head>
<body>
<div class="mobile_container">
<? } else { ?>
<div class="container">
<? } ?>
<? //include("header.php") ?>

<p><? if($_GET["show_back"]){ ?><a href="javascript:;" onClick="history.back();">&lt;&lt; Back to tickets</a><? } ?></p>
<?

$all_clerks = get_all_clerks_index(1, "",  false,true,"name");


?>

<span class="title"><? echo $ticket->vars["subject"] ?></span><br />
Created on <? echo $ticket->vars["tdate"] ?><br />
<? if($ticket->vars["open"]){ 



?>
<?php /*?>
Only the clerk can close the ticket, so the last record of responses will have a clerk id attached on it.
<a href="javascript:;" onClick="close_ticket('<? echo $ticket->get_password() ?>','<? echo $mobile ?>')">Close this Ticket</a><?php */?>
<? }else{echo "This ticket is Closed";} ?>
<br /><br />

<? echo nl2br($ticket->vars["message"]) ?>

<br /><br />

<? $responses = get_ticket_responses($ticket->vars["id"]); ?>
<? foreach($responses as $res){ ?>
 
<? if($ticket->is_me($res->vars["by"])){$stl = "1";}else{$stl = "2";} ?>
<?

  if (isset($all_clerks[$res->vars["by"]])){
	
	if ($all_clerks[$res->vars["by"]]->vars["image"] != "no_image"){
	
	  ?>
	  <div style="margin-bottom:10px; float:left;"><img style="width:50px; height:50px; border:4px solid #036;" src="<?= BASE_URL ?>/images/profile_images/<? echo $all_clerks[$res->vars["by"]]->vars["image"] ?>"></div>
	  <?
	  
	}
  }

 ?>

<div class="res<? echo $stl ?>">
    <strong>
	  <?
	   if($ticket->vars["ticket_category"] == 45 || $ticket->vars["ticket_category"] == 47){ 	 
	     echo $res->vars["by"];
	   }else {
	    if($ticket->is_me($res->vars["by"])){echo "Me";}else{echo $res->vars["by"];} 
	   } ?>
       
    </strong> on <? echo $res->vars["rdate"] ?><br />
    <? echo nl2br($res->vars["message"]) ?>
</div>

<?
/* Change made by Andy Hines and requested by Jamie: 09/22/2014, so everytime a customer replies a ticket this will put it unattended and shows the alert to the clerks*/
$clerk = " ";
//$res->vars["clerk"] = $clerk;
$res->vars['clerk'] = ($clerk === '' || $clerk === null) ? null : (int)$clerk;
$res->update(array("clerk"));
?>

<? } ?>

<? if($ticket->vars["open"]){ ?>
<br /><br />
Respond:<br />
<form id="frm_1" method="post" action="actions/respond.php" onSubmit="return validate(validations)">
<? if ($master) { ?>
<input name="master" type="hidden" id="tid" value="<? echo $account ?>">
<? } ?>
<input name="acc" type="hidden" id="acc" value="<? echo $acc ?>">
<input name="tid" type="hidden" id="tid" value="<? echo $ticket->get_password() ?>">
<input name="dept_id" type="hidden" id="dept_id" value="<? echo $dept_id ?>">
<? if (isset($mobile) and $mobile == 1) { ?>
<input name="mobile" type="hidden" id="mobile" value="<? echo $mobile ?>">
<? } ?>
<textarea name="message" cols="40" rows="10" id="message"></textarea><br />
<input id="btn2" onClick="disable_btn('btn2')" name="" type="submit" value="Submit">
</form>
<? } ?>
<br /><br />
<? if($ticket->vars["open"]){ ?>
<?php /*?>
Only the clerk can close the ticket, so the last record of responses will have a clerk id attached on it.
<a href="javascript:;" onClick="close_ticket('<? echo $ticket->get_password() ?>','<? echo $mobile ?>')">Close this Ticket</a><?php */?>
<? }else{echo "This ticket is Closed";} ?>

</div>
<? if (isset($mobile) and $mobile == 1) { ?>
<div class="goback_container"><br />
	<a style="color:#FFF;" class="goback" href="http://<? echo return_domain_name($web); ?>/">Go back to website</a>
</div>
</body>
</html>
<? } ?>
<? }else{echo "No Ticket Available";} ?>
