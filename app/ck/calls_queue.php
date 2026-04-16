<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? set_time_limit(0); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")&& !$current_clerk->im_allow("just_queue_calls")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$conn_id = ftp_audio_conecction(); // Open Ftp Conection.
//phone_db();
//var_dump($conn_id);
$all_option = true;
$names_per_page = 100;
$page_index =  $_POST["page_index"];
if (!isset($_POST["page_index"])){
 $page_index =  1;	
}

$ax_queue =  get_asterisk_queue();

$ax_agent =  get_asterisk_agent();


$charlist = "\n\r\0\x0B";
$report_line = "Date \t Name \t Account \t AFF \t Phone \t Clerk \t Queue \t Duration \t Call \t \n";


if (isset($_POST["from"])){
	$s_from =  $_POST["from"];
	$s_to =  $_POST["to"];
	$s_queue =  $_POST["queue"];
	$s_clerk = $_POST["clerk_list"];
	$calls = array();
}
else {
	$login = 0;
	$s_queue = 0;	
	$s_clerk = 0;
	$s_from = date("Y-m-d");
	$s_to = date("Y-m-d");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?> Calls</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};

</script>
<script type="text/javascript">
var str_html = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td class='table_header' align='center'>AFF</td><td class='table_header' align='center'>Name</td><td class='table_header' align='center'>Total</td></tr>";

function print_aff(aff,cant,name,style){
	
	
	if (style == 1) {
		str_html = str_html.concat('<tr><td class="table_td1" align="center">'+aff+'</td>'+'<td class="table_td1" align="center">'+name+'</td>'+'<td class="table_td1" align="center">'+cant+'</td></tr>');
	}
	else {
		str_html = str_html.concat('<tr><td class="table_td2" align="center">'+aff+'</td>'+'<td class="table_td2" align="center">'+name+'</td>'+'<td class="table_td2" align="center">'+cant+'</td></tr>');
	}

}

function show_aff_table(){

str_html =	 str_html.concat("</table>");

document.getElementById("aff_div").innerHTML = str_html;
document.getElementById("a_link").style.display = "block";
}

</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title"><? echo $title ?>Incoming Queue Calls </span>
 
<br /><br />

<? include "includes/print_error.php" ?>

<form action="calls_queue.php" method="post" id="form_search">
<input name="search" type="hidden" id="search" value="1" />
<input name="page_index" type="hidden" id="page_index" value="<? echo $page_index ?>" />

Queue:
<select name="queue" id="queue">
<option  <? if ($s_queue == '' && (!isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value=""  >All</option>
<?
  foreach($ax_queue as $q){ ?>
	<option <? if ($q['qname_id'] == $s_queue) { echo 'selected="selected"'; }?> value="<? echo $q['qname_id']?>"><? echo $q['queue']?></option> 
	  
  <? } ?>


<? /*
<option  <? if ($s_queue == "AFFIL" && (isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value="AFFIL" >AFFILIATE</option>
<option  <? if ($s_queue == "CSD" && (isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value="CSD" >CSD</option>
<option  <? if ($s_queue == "WAGERING" && (isset($_POST["queue"]))) { echo 'selected="selected"'; } ?> value="WAGERING" >WAGERING</option>
<option  <? if ($s_queue == "holl" && (isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value="holl" >hollywood</option>
<option  <? if ($s_queue == 'PAYOUTS' && (isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value="PAYOUTS" >PAYOUTS</option>
<option   <? if ($s_queue == 'CREDITC' && (isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value="CREDITC" >CREDITC</option>
<option   <? if ($s_queue == 'PPH' && (isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value="PPH" >PPH</option>
<option   <? if ($s_queue == 'SALES' && (isset($_POST["queue"]))) { echo 'selected="selected"'; }?> value="SALES" >SALES</option>
*/ ?>
</select>
&nbsp;&nbsp;&nbsp;
Clerk:
<?  //$clerks_available=1; $clerks_admin = "2,4,5"; include "includes/clerks_list.php" ?>
<? 
$clerks_logins = get_all_clerk_with_phone_logins();
?>
<select name="clerk_list" id="clerk_list" onchange="">
      <option value="">All</option>    
    <? foreach ($clerks_logins as $ck){ ?>
    <option <? if($s_clerk == $ck->vars["id"]){ echo ' selected="selected" ';}?>  value="<? echo $ck->vars["id"]?>"><? echo $ck->vars["name"]?></option>  
    <? } ?>
    </select>

&nbsp;&nbsp;&nbsp;
<? //} ?> 
<br /><br />
From:
<input name="from" type="text" id="from" value="<? echo $s_from ?>" />
&nbsp;&nbsp;&nbsp;
to:
<input name="to" type="text" id="to" value="<? echo $s_to ?>" />
&nbsp;&nbsp;&nbsp;

<input name="" type="submit" value="Filter" onclick="document.getElementById('page_index').value = '0';" />
&nbsp;&nbsp;&nbsp;
</form>
<br /><br />
<? $data = "?from=$s_from&to=$s_to&queue=$s_queue&clerk_list=$s_clerk"; ?>

<?php /*?>
  <div id="aff_totals">Loading Affiliate Info...</div>
   <br />
     // COMMMENT ON 09/01/2016, According to Frank that is not used 
    <script type="text/javascript">
	load_url_content_in_div('<?= BASE_URL ?>/ck/calls_queue_complete.php<? echo $data ?>',"aff_totals");
    </script><?php */?>
	

 <div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form').submit();" class="normal_link">
	Export
	</a>
  </div>

<br/><br/>

<? 

$no_login = false;
if ($s_clerk != 0){ 
  $clerk_logins = get_all_clerk_phone_logins($s_clerk);
  $login = array();
  $k = 0;

 foreach ($clerk_logins as $clerk_login){
   $login[$k] = $clerk_login->vars["login"]; 
  $k++;
 }

 if (count($login)==0) { 
   $no_login = true;
   $login =0;
 }
}
  
if ($no_login){
  echo "This Clerk does not have any Login asigned";
}
else {
 
 //$count_calls = get_call_by_queue($login,$s_queue,$s_from, $s_to,$page_index,$names_per_page,false,true); 
// $calls = get_call_by_queue($login,$s_queue,$s_from, $s_to,($page_index * $names_per_page),$names_per_page,true); 


$count_calls = get_call_by_queue($s_from,$s_to,$page_index,$names_per_page,$s_queue,false,true);

$records = get_call_by_queue($s_from,$s_to,($page_index * $names_per_page),$names_per_page,$s_queue,true);



//$call = new _phone_record();

$j=0;
foreach ($records as $r){
	
  // if($i==0){ $control = $r->vars['uniqueid']; }
   
 /*
   echo "<pre>";
   print_r($r);
   echo "</pre>";
*/
   if($r->vars['qevent'] == 3){	
    $calls[$r->vars['uniqueid']]->vars["uniqueid"] = $r->vars['uniqueid'];
     $calls[$r->vars['uniqueid']]->vars["calldate"] = $r->vars['datetime'];
	  $calls[$r->vars['uniqueid']]->vars["src"] = $r->vars['info2'];
   }
   if($r->vars['qevent'] == 4){	
      $calls[$r->vars['uniqueid']]->vars["queue"] = $ax_queue[$r->vars['qname']]['queue'];
	 
	  $calls[$r->vars['uniqueid']]->vars["agent"] = $ax_agent[$r->vars['qagent']]['agent'];
   }
 
     if($r->vars['qevent'] == 6){	
      $calls[$r->vars['uniqueid']]->vars["uniqueid"] = $r->vars['uniqueid'];
	  $calls[$r->vars['uniqueid']]->vars["duration"] = $r->vars['info2'];
	 //if($r->vars['info2'] == 0){ unset($calls[$r->vars['uniqueid']]);$j++; }
   }
 //  } else {break;}
 //  $i++;
}
/*
echo "<pre>";
print_r($calls);
echo "</pre>";
*/

//$count_calls[""]->vars["num"] = $count_calls[""]->vars["num"] - $j;

$str_phone = "";
$str_player = "";
$account = array();

if(is_null($calls)) { $calls = array();}
foreach($calls as $call){
  $str_phone .= "'".$call->vars["src"]."',";	
}
$str_phone = substr($str_phone,0,-1);

$names = get_names_by_phone_list($str_phone);
$clerks = get_all_clerks_phone_login();
  

foreach($calls as $call){
	foreach ($names as $name){
	 
	  if (isset($names[$call->vars["src"]]->vars["acc_number"])){
		  $names[$call->vars["src"]]->vars["acc_number"] = strtoupper($names[$call->vars["src"]]->vars["acc_number"]);
		 			 
			 if (!isset($account[$name->vars["acc_number"]])){
			   $account[$name->vars["acc_number"]] = $name->vars["acc_number"]; 
			   }
	  }
	}
}
if (count($account)>0){

foreach ($account as $_account){
  if ($_account != ""){
    $str_player .= "'".trim(strtoupper($_account))."',";	
  }
}
$str_player = substr($str_player,0,-1);


$data = "?str_player=$str_player";
$affiliates = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_players_by_list.php".$data));
}

?>

<? echo $count_calls[""]->vars["num"]." Calls Found" ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Account</td>    
    <td class="table_header" align="center">AFF</td>        
    <td class="table_header" align="center">Phone</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Queue</td>
    <td class="table_header" align="center">Duration</td>
    <td class="table_header" align="center">Call</td>
  </tr>
  
  <? $aff = array(); ?>  
  <? foreach($calls as $call){if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;
	  $str_login = str_center("Local/","@",$call->vars["dstchannel"]); 
	  $str="";
      $str_name="";
	  $str_account = "";
	  $str_agent = "";
 
	  
	 	  
  ?>
  
  <tr>
     <td class="table_td<? echo $style ?>" align="center"><? echo date("M jS, Y / g:i a",strtotime($call->vars["calldate"])); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
		 <? if (isset($names[$call->vars["src"]])) { ?>
        
         <a href="call_history.php?account_name=<?  echo $names[$call->vars["src"]]->vars["acc_number"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $names[$call->vars["src"]]->full_name() ?> Call History" class="normal_link">
			<? echo $names[$call->vars["src"]]->full_name(); 
			   $str_name = $names[$call->vars["src"]]->full_name();
			?>
         </a> 
        <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo strtoupper($names[$call->vars["src"]]->vars["acc_number"]); $str_account = strtoupper($names[$call->vars["src"]]->vars["acc_number"]);  ?></td>
    <td class="table_td<? echo $style ?>" align="center">
	<? if (isset($names[$call->vars["src"]]->vars["acc_number"]) && ($names[$call->vars["src"]]->vars["acc_number"] != "") ){
		 echo $affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent; 
          $str_agent = $affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent; 
		  if (!isset($aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent])) {
		  	 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Total"] = 1;
			 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Name"] = $affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Name;  
			 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["aff"] = $affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent;
		  }
		  else {
			$aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Total"]++;			  
  
			  }
		 
		 
	  } ?>
    
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["src"]; ?> </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $clerks[$str_login]->vars["name"]; ?> </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["queue"]; ?></td>  
    <td class="table_td<? echo $style ?>" align="center"><? echo gmdate("i:s", $call->vars["duration"])?></td> 
       <td class="table_td<? echo $style ?>" align="center">
	
	<? if (check_ftp_audio_exist($call->vars["uniqueid"],$conn_id)){ ?>
        <a href="<?= BASE_URL ?>/ck/process/actions/audio_process.php?id=<? echo $call->vars["uniqueid"] ?>" class="normal_link"> GET Call </a>
   <?  $str = "Listen"; } else {   if ($current_clerk->vars["id"] == 86){ echo $call->vars["uniqueid"];  }}  ?> 
    </td>
  </tr>
  
  <?
  $line =  date("M jS, Y / g:i a",strtotime($call->vars["calldate"]))." \t ".$str_name." \t ".$str_account." \t  ".$str_agent." \t ".$call->vars["src"]." \t ".$clerks[$str_login]->vars["name"]." \t ".$call->vars["lastdata"]." \t  ".gmdate("i:s", $call->vars["duration"])." \t  ".$str." \t  ";		
  
 $line = str_replace(str_split($charlist), ' ', $line);
 $report_line .= $line."\n ";
 ?>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  
  </tr>
</table>
<br /><br />



<?

//ftp_audio_close($conn_id); // Closing the FTP conection.

$num_pages = ceil($count_calls[""]->vars["num"] / $names_per_page);
for($i=0;$i<$num_pages;$i++){
	if($i == $page_index){echo $i + 1 ."&nbsp;&nbsp;-&nbsp;&nbsp;";}
	else{
		?>
	 <a onclick="change_index('<? echo $i ?>')" href="javascript:;" class="normal_link"><? echo $i + 1 ?></a>&nbsp;&nbsp;-&nbsp;&nbsp;
		<?
	}
	

} //No login

/*
if (count($account)>0){

	foreach ($aff as $_aff){ 
	 if($i % 2){ $style = "1";}else{$style = "2";}$i++;
	?>
		<script type="text/javascript">	
		print_aff('<? echo $_aff["aff"] ?>','<? echo $_aff["Total"] ?>','<? echo $_aff["Name"] ?>','<? echo $style ?>');
		</script>
	<? } ?>
	<script type="text/javascript">	
	show_aff_table();
	</script> 

<? } ?>
*/ ?>

<form method="post" action="./process/actions/excel.php" id="xml_form">
<input name="name" type="hidden" id="name" value="Incoming_Calls">
<input name="content" type="hidden" id="content" value="<? echo $report_line ?>">
</form>

<script type="text/javascript">
function change_index(index){
	document.getElementById("page_index").value = index;
	document.getElementById("form_search").submit();
}
</script>

    
</div>

<? include "../includes/footer.php" ; }








?>