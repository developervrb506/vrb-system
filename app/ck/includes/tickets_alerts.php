<? set_time_limit(300); ?>
<? $no_log_page = true; ?>
<?
include(ROOT_PATH . "/ck/process/security.php");

if($current_clerk->im_allow("all_tickets")){
  $livechat_dept_id = 0; 
}
else {
  //$livechat_dept_id = $current_clerk->vars["user_group"]->vars["chat_dept_id"]; 
  $user_group_id = $current_clerk->vars["user_group"]->vars["id"]; 
  $chats_ids_per_group = get_all_user_groups_per_chat_department($user_group_id);
	  
  foreach($chats_ids_per_group as $chat_id){		  
	 $livechat_id = $chat_id->vars["id_chat_dept"];
	 $livechat_dept_ids = $livechat_dept_ids.','.$livechat_id;		 		  
  }
	  
  $livechat_dept_ids =  substr($livechat_dept_ids,1);
}
?>

<META HTTP-EQUIV="refresh" CONTENT="180">
<? 
//$count = count(get_unatended_tikets("agents",$livechat_dept_ids)); 
$tickets = get_unatended_tikets("agents",$livechat_dept_ids,$current_clerk->vars["id"]);
$count = count($tickets); 

$str_pending = "";
if ($count > 0){
  foreach($tickets as $tk){
	  $str_pending .= $tk->vars["id"]." - ";
  }
  $str_pending = substr($str_pending,0,-3);
}
	

if($count > 0){
  /* include("sound_alert.php"); */
?>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
body {
	background-color: #FFF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<span style="font-size:24px">
  	<a href="http://localhost:8080/ck/tickets.php"  title="<? echo  $str_pending ?>" target="_blank" style="color:#F00;"><? echo $count ?> Unattended Tickets!</a>
</span>
<? } ?>