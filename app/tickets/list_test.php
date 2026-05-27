<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
$web    = clean_str_ck($_GET["web"]); 
$mobile = clean_str_ck($_GET["mobile"]);
$account = clean_str_ck($_GET["wpx"]);

if($web == ""){$web = "vrb";}
$list = get_tickets_by_player(two_way_enc($account,true));
$master_list = get_master_tickets_by_player(two_way_enc($account,true));

//$list = get_tickets_by_player($_GET["acc"]);
//$master_list = get_master_tickets_by_player($_GET["acc"]);

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
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
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
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>

<div class="container">
<? include("header.php") ?>

<span class="title">Tickets List</span>&nbsp;&nbsp;(<a href="http://vrbmarketing.com/tickets/?cat=agents&web=<? echo $web ?>&wpx=<? echo $account ?>">Click here to create a new alert</a>)

<table width="100%" border="0" cellpadding="5">
  <tr style="background:#666; text-transform:uppercase;">
    <td></td>
    <td><strong>Subject</strong></td>
    <td><strong>Placed</strong></td>
    <td></td>
  </tr>
  <? foreach($list_tickets as $item){ ?>
  <tr <? if($item->vars["pread"]){ ?>style="color:#999"<? } ?>>
    <td>
    
        <a href="javascript:;" onClick="if(confirm('Are you sure you want to delete this conversation?')){location.href = 'actions/delete.php?tid=<? echo $item->get_password() ?>&mobile=<? echo $mobile ?>&web=<? echo $web ?>&wpx=<? echo $account ?>&master=<? if($item->vars["master"]) {echo 1;}?>'}">X</a>
      
    </td>
    <td><? echo $item->vars["subject"] ?></td>
    <td><? echo $item->vars["tdate"] ?></td>
    <td>
    	<a href="<?= BASE_URL ?>/tickets/ticket.php?show_back=1&tid=<? echo $item->get_password() ?>&deptid=<? echo $item->vars["dep_id_live_chat"] ?>&mobile=<? echo $mobile ?>&wpx=<? echo $account ?>&master=<? if($item->vars["master"]){echo 1;}?>">View</a>
    </td>
  </tr>
  <? } ?>
</table>

<div align="center" style="color:#F00;"><p>Important: If you have asked to be contacted via email make sure to check your spam folder if you don't see a response in the next few minutes.</p></div>

</div>



<? } ?>