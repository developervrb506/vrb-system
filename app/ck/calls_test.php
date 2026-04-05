<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?

$conn_id = ftp_audio_conecction(); // Open Ftp Conection.
$all_option = true;
$names_per_page = 100;
$page_index =  $_POST["page_index"];


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
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
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
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title"><? echo $title ?>Incoming Queue Calls</span><br /><br />

<? include "includes/print_error.php" ?>

<form action="calls_test.php" method="post" id="form_search">
<input name="search" type="hidden" id="search" value="1" />
<input name="page_index" type="hidden" id="page_index" value="<? echo $page_index ?>" />

Queue:
<select name="queue" id="queue">
<option  <? if ($s_queue == '0') { echo 'selected="selected"'; }?> value="0"  >All</option>
<option  <? if ($s_queue == "CSD") { echo 'selected="selected"'; }?> value="CSD" >CSD</option>
<option  <? if ($s_queue == "WAGERING") { echo 'selected="selected"'; } ?> value="WAGERING" >WAGERING</option>
<option  <? if ($s_queue == "hollywood-agent") { echo 'selected="selected"'; }?> value="hollywood-agent" >hollywood</option>
<option  <? if ($s_queue == 'PAYOUTS') { echo 'selected="selected"'; }?> value="PAYOUTS" >PAYOUTS</option>
<option   <? if ($s_queue == 'CREDITC') { echo 'selected="selected"'; }?> value="CREDITC" >CREDITC</option>
</select>
&nbsp;&nbsp;&nbsp;
Clerk:
<? $clerks_admin = "2,4,5"; include "includes/clerks_list.php" ?>
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
 
 $count_calls = get_call_by_queue($login,$s_queue,$s_from, $s_to,$page_index,$names_per_page,false,true); 
 $calls = get_call_by_queue($login,$s_queue,$s_from, $s_to,($page_index * $names_per_page),$names_per_page,true); 
 // $count_calls = count($calls);
  
  ?>

<? echo $count_calls[0]->vars["num"]." Calls Found" ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Phone</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Queue</td>
    <td class="table_header" align="center">Duration</td>
    <td class="table_header" align="center">Call</td>
  </tr>
  
  <? foreach($calls as $call){if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;
	  $name =  get_names_by_phone($call->vars["src"]);
	  
     $str_login = str_center("Local/","@",$call->vars["dstchannel"]); 
     $name_clerk = get_clerk_by_phone_login($str_login);
	 $s_clerk = $name_clerk->vars["agent"];

     $clerk = get_clerk($s_clerk);	   
	  
	 	  
  ?>
  
  <tr>
     <td class="table_td<? echo $style ?>" align="center"><? echo date("M jS, Y / g:i a",strtotime($call->vars["calldate"])); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
		 <? if (isset($name[0]->vars["id"])) { ?>
         <a href="call_history.php?nid=<? echo $name[0]->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $name[0]->full_name() ?> Call History" class="normal_link">
			<? echo $name[0]->full_name(); ?>
        </a> 
        <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["src"]; ?> </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $clerk->vars["name"]; ?> </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["lastdata"]; ?></td>  
    <td class="table_td<? echo $style ?>" align="center"><? echo gmdate("i:s", $call->vars["duration"])?></td> 
       <td class="table_td<? echo $style ?>" align="center">
	
	<? if (check_ftp_audio_exist($call->vars["uniqueid"],$conn_id)){ ?>
        <a href="http://localhost:8080/ck/audio_box.php?id=<? echo $call->vars["uniqueid"] ?>" class="normal_link" rel="shadowbox;height=150;width=250"> Listen </a>
   <? } ?>
    </td>
  </tr>
  
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
ftp_audio_close($conn_id); // Closing the FTP conection.

$num_pages = ceil($count_calls[0]->vars["num"] / $names_per_page);
for($i=0;$i<$num_pages;$i++){
	if($i == $page_index){echo $i + 1 ."&nbsp;&nbsp;-&nbsp;&nbsp;";}
	else{
		?>
	 <a onclick="change_index('<? echo $i ?>')" href="javascript:;" class="normal_link"><? echo $i + 1 ?></a>&nbsp;&nbsp;-&nbsp;&nbsp;
		<?
	}
	

} //No login

?>
<script type="text/javascript">
function change_index(index){
	document.getElementById("page_index").value = index;
	document.getElementById("form_search").submit();
}
</script>
</div>

<? include "../includes/footer.php" ; }








?>