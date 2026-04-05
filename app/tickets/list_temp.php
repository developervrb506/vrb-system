<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
$web     = clean_str_ck($_GET["web"]); 
$mobile  = clean_str_ck($_GET["mobile"]);
$account = clean_str_ck($_GET["wpx"]);

if($web == ""){$web = "vrb";}
$list = get_tickets_by_player(two_way_enc($account,true));
$agent = false;
if($_GET["ag"] == 1){ $agent = true; }

if($agent){
  $agent_list = get_tickets_by_player_to_agent(two_way_enc($account,true));
}

$master_list = get_master_tickets_by_player(two_way_enc($account,true));

//$list = get_tickets_by_player($_GET["acc"]);
//$master_list = get_master_tickets_by_player($_GET["acc"]);

if(!is_null($agent_list)){
  if(is_null($master_list)) { $master_list = $agent_list;}
  else{
	$master_list = array_merge($master_list,$agent_list);  
  }	
	
}



$list_tickets = array();
if (!is_null($master_list)){
  $list_tickets_all = array_merge($master_list,$list);	
  
  
  foreach ($list_tickets_all as $ls){
	  $list_tickets[$ls->vars["tdate"]] = $ls;
	  
  }
  krsort($list_tickets);
	
}else {
	$list_tickets  = $list;
}


?>
<? if (isset($mobile) and $mobile == 1) { ?>
<? include("header_top_mobile.php") ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../process/js/functions.js"></script>
</head>
<body>
<div class="mobile_container">
<? include("header.php") ?>

<span class="title">Tickets List</span>
xxxx
</div>
</body>
</html>

<? } else { ?>

<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../process/js/functions.js"></script>

<div class="container">
<? include("header.php") ?>

<div class="main_title">Tickets List</div>&nbsp;&nbsp;<div class="tabs_titles"><a title="Click Here to create a Ticket" href="http://vrbmarketing.com/tickets/?cat=agents&web=<? echo $web ?>&wpx=<? echo $account ?>">Customer Service</a></div> <? if($agent) { ?> &nbsp;&nbsp;<div class="tabs_titles"><a title="Click Here to create a Ticket" href="http://vrbmarketing.com/tickets/index_player.php?cat=agents&web=<? echo $web ?>&wpx=<? echo $account ?>">Player</a></div> <? }else{ ?>&nbsp;&nbsp;<div class="tabs_titles"><a title="Click Here to create a Ticket" href="http://vrbmarketing.com/tickets/index_agent.php?cat=agents&web=<? echo $web ?>&wpx=<? echo $account ?>">Agent</a></div><? } ?>


<? if(two_way_enc($account,true) == 'OWI'){ ?>

	 <? if($agent ) { ?> (<a title="Click Here to create a Ticket" href="http://vrbmarketing.com/tickets/index_agent_agent.php?cat=agents&web=<? echo $web ?>&wpx=<? echo $account ?>">AGENT</a>)<? } ?>

<? } ?>

<br /><br />


<p><a href="actions/read_all.php?mobile=<? echo $mobile ?>&web=<? echo $web ?>&wpx=<? echo $account ?>&master=<? if($item->vars["master"]) {echo 1;}?>'}"><img src="images/mark.png" width="11" height="10" border="0" alt="Mark all as read" title="Mark all as read" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="if(confirm('Are you sure you want to delete all conversations?')){location.href = 'actions/delete_all.php?mobile=<? echo $mobile ?>&web=<? echo $web ?>&wpx=<? echo $account ?>&master=<? if($item->vars["master"]) {echo 1;}?>'}"><img src="images/delete.png" width="13" height="16" border="0" alt="Delete all tickets" title="Delete all tickets" /></a></p>

<table width="100%" border="0" cellpadding="5">
  <tr style="background:#666; text-transform:uppercase;">
    <td></td>
    <td><strong>Subject</strong></td>
    <td><strong>Placed</strong></td>
    <td></td>
  </tr>
  <? foreach($list_tickets as $item){ 

     if($item->vars["ticket_category"] == 45){ 
	    $last = get_ticket_last_response($item->vars["id"]);
     	//echo $last->vars["by"]." ".two_way_enc($account,true);
		if($last->vars["by"] != two_way_enc($account,true)){  // to check if the last 
	     $item->vars["pread"] = 0;
         } else { $item->vars["pread"] = 1;}
		   $item->update(array("pread")); 
	 }
     ?>
  
      <tr <? if($item->vars["pread"]){ ?>style="color:#999;"<? } ?>>

    <td>
    
        <a href="javascript:;" onClick="if(confirm('Are you sure you want to delete this conversation?')){location.href = 'actions/delete.php?tid=<? echo $item->get_password() ?>&mobile=<? echo $mobile ?>&web=<? echo $web ?>&wpx=<? echo $account ?>&master=<? if($item->vars["master"]) {echo 1;}?>'}"><img src="images/x.png" width="10" height="10" border="0" alt="Delete conversation" title="Delete conversation" /></a>
      
    </td>
    <td><? echo $item->vars["subject"] ?></td>
    <td><? echo $item->vars["tdate"] ?></td>
    <td>
    	<div class="view_link_container"><a <? if($item->vars["pread"]){ ?>style="color:#333;"<? } ?> href="http://localhost:8080/tickets/ticket.php?show_back=1&tid=<? echo $item->get_password() ?>&deptid=<? echo $item->vars["dep_id_live_chat"] ?>&mobile=<? echo $mobile ?>&wpx=<? echo $account ?>&master=<? if($item->vars["master"]){echo 1;}?>">View</a></div>
    </td>
  </tr>
  <? } ?>
</table>

<div align="center" style="color:#F00;"><p>Important: If you have asked to be contacted via email make sure to check your spam folder if you don't see a response in the next few minutes.</p></div>

</div>



<? } ?>