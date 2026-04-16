<?   
require_once(ROOT_PATH . '/ck/process/functions.php');
require_once(ROOT_PATH . '/ck/db/connection.php');
require_once(ROOT_PATH . '/ck/db/manager.php');

$gsettings = _get_settings();

//if (!$no_log && !$no_log_page){ rec_page_log('5'); }	


function _get_settings(){
	clerk_db();
	$sql = "SELECT * FROM settings";
	return get($sql, "system_setting",false,"name");
}



function get_settings_ip($ip){
	clerk_db();
	$sql = "SELECT * FROM settings where id = 1 and value like '%$ip%'";
	return get($sql, "system_setting",false,"name");
}


function get_menu($level){
	clerk_db();
	$sql = "SELECT * FROM menu where parent = '$level' AND deleted = 0 ORDER BY position ASC, name ASC";
	return get($sql, "_menu");
}

function get_deleted_menu(){
	clerk_db();
	$sql = "SELECT * FROM menu where deleted = 1 ORDER BY name ASC";
	return get($sql, "_menu");
}

function get_menu_item($id){
	clerk_db();
	$sql = "SELECT * FROM menu where id = '$id'";
	return get($sql, "_menu", true);
}

function search_menu($str){
	clerk_db();
	$sql = "SELECT * FROM menu where name LIKE '%$str%' AND is_category = 0 AND deleted = 0 ORDER BY position ASC";
	return get($sql, "_menu");
}

function _get_buy_moneypaks_settings(){
	processing_db();
	$sql = "SELECT * FROM moneypak_sell_settings";
	return get($sql, "buymoneypaks_system_setting",false,"name");
}

function check_user_token($user,$c1,$c2,$c3,$val1,$val2,$val3){
	clerk_db();
	$sql = "SELECT * FROM `user_token` as u WHERE user = '$user'
	AND EXISTS (SELECT * FROM user_token WHERE user = u.user AND CONCAT(letter,number) = '$c1' AND value = '$val1')
	AND EXISTS (SELECT * FROM user_token WHERE user = u.user AND CONCAT(letter,number) = '$c2' AND value = '$val2')
	AND EXISTS (SELECT * FROM user_token WHERE user = u.user AND CONCAT(letter,number) = '$c3' AND value = '$val3')
	LIMIT 0,1";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;} 
}


function check_clerk_login($user, $pass){
	clerk_db();
	$sql = "SELECT * FROM user WHERE email = '$user' AND password = '".super_encript($pass)."' AND available = 1 AND deleted = 0";

	return get($sql, "clerk", true);
}
function get_clerk($id, $available = false){
	clerk_db();
	if($available){$sql_av = " AND available = 1 ";}
	$sql = "SELECT * FROM user WHERE id = '$id' $sql_av";
	return get($sql, "clerk", true);
}
function get_clerk_by_name($name){
	clerk_db();
	$sql = "SELECT * FROM user WHERE name LIKE '$name'";
	return get($sql, "clerk", true);
}
function get_clerk_by_email($email){
	clerk_db();
	$sql = "SELECT * FROM user WHERE email = '$email' AND available = 1 AND deleted = 0";
	return get($sql, "clerk", true);
}
function count_today_login_fails($uid){
	clerk_db();
	$sql = "SELECT COUNT(*) as num  FROM `log` WHERE `user` = '$uid' AND `fail` = 1 AND DATE(date) = DATE(NOW())";
	return get_str($sql, true);
}
function get_clerk_schedule($clerk_id,$day,$week){
	clerk_db();
	
	$sql = "SELECT * FROM user_schedule as s WHERE s.user = '".$clerk_id."' AND s.day = '".$day."' AND week_date = '".$week."' ";
	return get($sql, "clerk_schedule",true );
}


function get_all_schedule_by_clerk($clerk_id,$week){
	clerk_db();	
	$sql = "SELECT * FROM user_schedule as s WHERE s.user = '".$clerk_id."' AND week_date = '".$week."' ";
	return get($sql, "clerk_schedule",false,"day" );
}
function get_all_schedules_by_date($from,$to,$clerk = "",$group = ""){
	clerk_db();	
	if($clerk != ""){$sql_clerk = " AND user = '$clerk' ";}
	if($group != ""){$sql_group = " AND user_group = '$group' ";}
	$sql = "SELECT s.*, CONCAT(user,'-',day,'-',week_date) as  akey FROM user_schedule as s, user u 
	WHERE s.user = u.id AND DATE(week_date) >= DATE('$from') AND DATE(week_date) <= DATE('$to') $sql_clerk $sql_group";
	return get($sql, "clerk_schedule",false,"akey");
}

function get_clerk_last_schedule($clerk_id){
	clerk_db();	
	$sql = "SELECT * FROM `user_schedule` WHERE  user = '".$clerk_id."'  and week_date = (select max(week_date) from user_schedule where user = '".$clerk_id."');";
	//echo $sql;
	return get($sql, "clerk_schedule");
}

function get_all_clerk_vacations($clerk_id,$date1,$date2,$all_users = false){
	clerk_db();	
	if (!$all_users) {$sql_user =  " AND user = '".$clerk_id."' "; }
	
	$sql = "SELECT CONCAT(user,'_',vdate) as vacation  FROM `user_vacation` WHERE   vdate >= '".$date1."' and vdate <= '".$date2."' $sql_user";
	return get($sql, "_user_vacation",false,"vacation");
}

function get_clerk_vacation($clerk_id,$date){
	clerk_db();	
	$sql = "SELECT * FROM `user_vacation` WHERE  user = '".$clerk_id."'  and vdate = '".$date."'";
	return get($sql, "_user_vacation",true);
}



function get_clerks_week_salary_by_group($group,$week){
	clerk_db();	
	$sql = "SELECT * FROM clerk_salary as s, user as u WHERE
	u.user_group = '$group' AND u.id = s.clerk AND week = '$week'";
	return get($sql, "_salary",false,"clerk" );
}
function get_clerk_week_salary($cid,$week){
	clerk_db();	
	$sql = "SELECT * FROM clerk_salary WHERE
	week = '$week' AND clerk = '$cid'";
	return get($sql, "_salary",true);
}

function get_clerk_last_week_salary($clerk=""){
	clerk_db();	
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	$sql = "SELECT id, clerk, week, salary,
	type , caja, deductions, increases, notes FROM clerk_salary WHERE 1 $sql_clerk  order by week desc limit 1 ";
   //echo $sql;
	return get($sql, "_salary");
}

function get_backup_user($group,$date){
	clerk_db();
	$sql = "SELECT * FROM user_backup_day as s WHERE s.group_id = '".$group."' AND s.date = '".$date."'";
	return get($sql, "user_backup_day",true );

}

function get_clerk_last_backup_day($group,$last_date,$next_date){
	clerk_db();
	$sql = "SELECT * FROM user_backup_day as s WHERE s.group_id = '".$group."' AND (s.date >= '".$last_date."' && s.date <= '".$next_date."')";
	return get($sql, "user_backup_day");

}




function get_manager_replacements($from,$to){
	clerk_db();
	$sql = "SELECT u.id, u.name, CONCAT(group_id,'-',b.date) as akey  
	FROM user_backup_day as b, user as u
	WHERE DATE(b.date) >= '$from' AND DATE(b.date) <= '$to'
	AND u.id = user_backup";	
	return get_str($sql,false,"akey");
}




function get_clerk_permissions($cid, $gid = ""){
	clerk_db();
	$sql = "SELECT id, name, description FROM permission as p, permission_by_user as pu
	WHERE pu.user = '$cid' AND pu.permission = p.id";
	$res = get($sql, "permission");
	
	$sql = "SELECT id, name, description FROM permission as p, permission_by_group as pu
	WHERE pu.group = '$gid' AND pu.permission = p.id";
	return array_merge($res,get($sql, "permission"));
}

function get_clerk_manager_group($id){
	clerk_db();
	$sql = "SELECT * FROM user_group as ug WHERE ug.manager = '$id'";
	return get($sql, "user_group",true );	
	
}

function get_all_groups_by_manager($id, $schedule = ""){
	clerk_db();
	if($schedule != ""){$sql_sch = " AND schedule = '$schedule'";}
	$sql = "SELECT * FROM user_group as ug WHERE ug.manager = '$id' $sql_sch";
	return get($sql, "user_group");	
	
}

function get_all_permissions_clerk(){
	clerk_db();
	$sql = "SELECT * FROM permission ";
	return get_str($sql); 
}

function get_permissions_group($groupid){
	clerk_db();
	$sql = "SELECT permission FROM permission_by_group pg WHERE pg.group = ".$groupid." ";
	return get_str($sql,false,"permission"); 
}

function insert_permission_group($permision, $group){
	clerk_db();
	$sql = " INSERT INTO permission_by_group  VALUES ('".$permision."', '".$group."')";
	return execute($sql);
}

function delete_permission_group_by_list($group, $str_permission){
	clerk_db();
	$sql = "DELETE FROM permission_by_group WHERE permission_by_group.permission IN (".$str_permission.") AND permission_by_group.group = ".$group."";
	return execute($sql);
}

function get_all_permissions_by_clerk($clerk){
	clerk_db();
	$sql = "SELECT permission FROM permission_by_user pu  WHERE  pu.user = ".$clerk."";
	return get_str($sql, false,"permission");
}



function get_permissions_clerk($permision){
	clerk_db();
	$sql = "SELECT id,user FROM permission_by_user pu, permission p  WHERE p.id = pu.permission and p.name = '".$permision."'";
	return get($sql, "permission");
}

function insert_permission_clerk($permision, $clerk){
	clerk_db();
	$sql = " INSERT INTO permission_by_user (permission, user) VALUES ('".$permision."', '".$clerk."')";
	return execute($sql);
}
function delete_permission_clerk($permision, $clerk){
	clerk_db();
	$sql = "DELETE FROM permission_by_user WHERE permission_by_user.permission = ".$permision." AND permission_by_user.user = ".$clerk."";
	//echo $sql;
	return execute($sql);
}

function delete_permission_clerk_by_list($clerk, $str_permission){
	clerk_db();
	$sql = "DELETE FROM permission_by_user WHERE permission_by_user.permission IN (".$str_permission.") AND permission_by_user.user = ".$clerk."";
	return execute($sql);
}



function get_all_clerks($available = "", $level = "", $deleted = false){
	clerk_db();

	if($available != ""){$sql_available = " AND available = '$available' ";}
	if($level != ""){$sql_admin = " AND level IN ($level) ";}
	if(!$deleted){$sql_deleted = " AND deleted = '0' ";}
	$sql = "SELECT * FROM user WHERE 1 $sql_available $sql_admin $sql_deleted ORDER BY name ASC";
   	
	//echo $sql;	
	return get($sql, "clerk");
	
	
}

function get_all_clerks_indexed(){
	clerk_db();
	$sql = "SELECT * FROM user";
	return get($sql, "clerk", false, "id");
}

function get_all_clerks_index($available = "", $level = "", $deleted = false,$index = false,$field=""){
	clerk_db();

	if($available != ""){$sql_available = " AND available = '$available' ";}
	if($level != ""){$sql_admin = " AND level IN ($level) ";}
	if(!$deleted){$sql_deleted = " AND deleted = '0' ";}
	$sql = "SELECT * FROM user WHERE 1 $sql_available $sql_admin $sql_deleted ORDER BY name ASC";	
	$str_index = "";
	if ($index) { if($field != ""){ $str_index = $field; }else{ $str_index = "id"; }}
	return get($sql, "clerk",false,$str_index);
	
	
}



function get_all_clerks_by_group($gid,$clerk="", $deleted = false, $schedule = ""){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND id = '$clerk'";}
	if(!$deleted){$sql_deleted = " AND deleted = '0' ";}
	if($deleted != ""){$sql_deleted = " AND deleted = '$deleted' ";}
	if($schedule != ""){$sql_schedule = " AND use_schedule = '$schedule' ";}
	$sql = "SELECT * FROM user WHERE user_group = '$gid' $sql_clerk $sql_deleted $sql_schedule AND available = 1 ORDER BY name ASC";
	return get($sql, "clerk");
}

function get_all_clerks_by_group_shedule($gid,$manager, $deleted = false){
	clerk_db();
	if(!$deleted){$sql_deleted = " AND deleted = '0' ";}
	if($deleted != ""){$sql_deleted = " AND deleted = '$deleted' ";}
	$sql = "SELECT * FROM user WHERE (user_group = '$gid' or id = 1)  and id !=".$manager."  $sql_deleted ORDER BY ID DESC";
	return get($sql, "clerk");
}



function get_all_clerks_exclude_list($list="" ,$deleted = false,$include=false){
	clerk_db();
	if(!$deleted){$sql_deleted = " AND deleted = '0' ";}
	if($deleted != ""){$sql_deleted = " AND deleted = '$deleted' ";}
	$sql_exclusion = "";
	if($list != ""){$sql_exclusion = " AND id NOT IN ($list) ";}
	if ($include) {$sql_exclusion = " AND id IN ($list) "; }
	$sql = "SELECT * FROM user WHERE 1 $sql_exclusion $sql_deleted ORDER BY name ASC";
	return get($sql, "clerk");
}


function get_all_affiliates_by_clerk($id){
	clerk_db();
	$sql = "SELECT * FROM affiliate_by_clerk WHERE clerk = '$id'";
	return get($sql, "_affiliate_by_clerk");
}

function get_affiliates_by_clerk($id){
	clerk_db();
	$sql = "SELECT * FROM affiliate_by_clerk WHERE id = '$id'";
	return get($sql, "_affiliate_by_clerk",true);
}



function is_clerk_online_logged_vrb($clerk){
	clerk_db();
	$date = date("Y-m-d");
	$sql = "SELECT count(user) as total FROM `user_times` WHERE date like '%$date%' and user = '$clerk'";
	$res = get_str($sql,true);
	
	if  (!is_null($res)){ 
		if ($res["total"] == 1){return true;} else {return false;}
	}
	else {return false;}	  

}

function get_clerk_logged_vrb_date($date1,$date2){
	clerk_db();
	$sql = "SELECT DISTINCT concat_ws('_', DATE(date), user) as date FROM `user_times` WHERE date >= '".$date1."' and date <= '".$date2."'";
	
	return get_str($sql,false,"date");
	
}


//Phone System


function is_agent_online_loged_at_phone($login){
	
	/*qstats_db() ;
	$date = date("Y-m-d");
	$sql = "select count(qagent) as total  from queue_stats qs , qagent q  where q.agent_id = qs.qagent and datetime like  '%$date%' and qevent = 22  and q.agent like '%$login%'";
	
	$res = get_str($sql,true);
   
   if  (!is_null($res)){  	
		$t_login = $res["total"];
		
		$sql = "select count(qagent) as total  from queue_stats qs , qagent q  where q.agent_id = qs.qagent and datetime like  '%$date%' and qevent = 23  and q.agent like '%$login%'";
		
		$res = get_str($sql,true);
		$t_logout = $res["total"];
   
        if  ($t_login > $t_logout){ return true; }else { return false; }
   
   
   }
   else {return false;}	*/
   return false;

}


function get_agent_loged_at_phone_date($date1,$date2){
	
 /*qstats_db() ;
 $sql = "select DISTINCT CONCAT_WS('_',DATE(datetime),REPLACE(agent,'Agent/','')) as data from queue_stats qs, qagent qa where qa.agent_id = qs.qagent and qevent = 22 and datetime >= '".$date1." 03:00:00' and  DATE(datetime) <=   '".$date2."'";
 
 return get_str($sql,false,"data");*/
 return array();

}



function get_all_clerk_with_phone_logins(){
	clerk_db();
	$sql = "select * from `user` where id in (select distinct agent from login_by_user) and available = 1 and deleted = 0";
	return get($sql, "clerk");
}


function get_all_clerk_phone_logins($id){
	clerk_db();
	$sql = "SELECT * FROM login_by_user WHERE agent = '$id'";
	return get($sql, "_phone_login");
}



function get_clerks_with_login_by_description($description){
	clerk_db();
	$sql = "SELECT * FROM login_by_user WHERE comment = '$description'";
	return get_str($sql,false,"agent");
}


function get_clerk_by_phone_login($login){
	clerk_db();
	$sql = "SELECT * FROM login_by_user WHERE login = '$login'";
	return get($sql, "_phone_login",true);
}

function get_login_by_phone($id){
	clerk_db();
	$sql = "SELECT * FROM login_by_user WHERE id = '$id'";
	return get($sql, "_phone_login",true);
}

function get_all_clerks_phone_login(){
	clerk_db();
	$sql = "SELECT u.id, u.name ,lu.login FROM user u, login_by_user lu WHERE lu.agent = u.id";
	return get($sql, "_phone_login",false,"login");
}

function get_all_clerks_with_phone_login(){
	clerk_db();
	$sql = "SELECT DISTINCT agent FROM `login_by_user` WHERE 1";
	return get_str($sql);
}






function get_call_audio($ext,$login,$phone,$date1,$date2){
	phone_db();	
	$sql_login = "";
	foreach ($login as $_login){
		$sql_login .= " channel like '%/".$_login."%' || dstchannel like '%/".$_login."%' ||" ; 	
	}
	if ($ext ==0 ){$ext = "";}
	$sql_ext =  " channel like '%/".$ext."%' || dstchannel like '%/".$ext."%'";
	$sql = "Select calldate,src,dst,channel,dstchannel, uniqueid from cdr where (calldate >= '".$date1."' &&  calldate <= '".$date2."') AND (src like '%".clean_phone($phone)."%' || dst like '%".clean_phone($phone)."%') AND ($sql_login $sql_ext ) order by duration desc  limit 1";
  //echo $sql."<BR>";
	return get_str($sql,true);  
	
}


function get_call_name_by_src_phone($phones){
	phone_db();	

	$sql_phone ="";
	foreach($phones as $phone){
		$sql_phone .= " src LIKE '%".clean_phone($phone)."%' ||"; 
	}
	$sql_phone = substr($sql_phone,0,-2);

	if ($str_phone !=""){ $sql_phone = " AND src IN ($str_phone)"; }
	$sql = "Select calldate,src,dst,channel,dstchannel, uniqueid from cdr where 1  AND ($sql_phone) AND disposition NOT LIKE '%NO ANSWER%' group by src ";
	return get_str($sql,false,"src");  
}

function get_call_name_by_dst_phone($phones){
	phone_db();	
	$sql_phone ="";
	foreach($phones as $phone){
		$sql_phone .= " dst LIKE '%".$phone."%' ||"; 
	}
	$sql_phone = substr($sql_phone,0,-2);
	
	$sql = "Select calldate,src,dst,channel,dstchannel, uniqueid from cdr where 1 AND ($sql_phone) AND disposition NOT LIKE '%NO ANSWER%' group by dst ";
	return get_str($sql,false,"dst");  
	
}


/*
function get_call_by_queue($login,$queue,$from, $to,$index,$names_page,$limit=false,$selection=false){
  phone_db();	
  $sql_login = ""; 
  if ($login != 0){
    $sql_login = " AND ( ";
    foreach ($login as $_login){
      $sql_login .= " dstchannel like '%/".$_login."%' ||" ; 	
    }
	$sql_login = substr($sql_login,0,-2);
	$sql_login .= ")";
  }
  
  if (!$queue){
    $sql_queue = " ( lastdata  LIKE '%CSD%' || lastdata  LIKE '%WAGERING%' || lastdata  LIKE '%holl%' || lastdata  LIKE '%PAYOUTS%' || lastdata  LIKE '%CREDITC%' || lastdata  LIKE '%WANDA%')";	  
  }	 
  else { $sql_queue = " lastdata  LIKE '%".$queue."%'"; } 
	 
  if ($limit){
    $sql_limit = "LIMIT $index,$names_page";
  }
  if (!$selection){
	$sql_selection = "calldate, src, dstchannel,lastdata, duration, uniqueid" ;
  }
  else { $sql_selection = "COUNT(uniqueid) as num"; }
  	
  $sql = "select $sql_selection from cdr where lastapp = 'Queue'
and (DATE(calldate) >= '".$from."' && DATE(calldate) <= '".$to."' ) and  $sql_queue $sql_login $sql_limit";	
  
  //echo $sql;
  return get($sql,"_phone_record");
}
*/


function get_call_by_queue($from,$to,$index,$names_page,$queue = "",$limit=false,$selection=false){
	phone_db();	
	
	$to =  date( "Y-m-d", strtotime( "1 day", strtotime($to))); 
	if($queue != "" ){ $sql_queue = " And qname = $queue " ; }
	
	if ($limit){
		$sql_limit = "LIMIT $index,$names_page";
	}
	if (!$selection){
		$sql_selection = "*" ;
	}
	else { $sql_selection = "COUNT(uniqueid) as num"; }

	$sql = "select $sql_selection from queue_stats qs where qs.datetime >= '".$from."' AND qs.datetime <= '".$to."'  and qs.qevent < 7  $sql_queue ORDER BY qs.uniqueid $sql_limit";
    // echo $sql."<BR>";
	return get($sql,"_phone_record",false,"queue_stats_id");
}

function get_asterisk_queue(){
	phone_db();	
	$sql = "select * from qname";
	//echo $sql;
	return get_str($sql,false,"qname_id");
}
function get_asterisk_agent(){
	phone_db();	
	$sql = "select * from qagent";
	return get_str($sql,false,"qagent_id");
}



function get_break($id){
	clerk_db();
	$sql = "SELECT * FROM breaks WHERE id = '$id'";
	return get($sql, "ck_break", true); 
}
function get_current_break($idu){
	clerk_db();
	$sql = "SELECT * FROM breaks WHERE user = '$idu' AND end_time IS NULL";
	return get($sql, "ck_break", true); 
}
function get_log_in($cid, $date){
	clerk_db();
	$sql = "SELECT * FROM user_times WHERE user = '$cid' AND DATE('$date') = DATE(user_times.date) ORDER BY id DESC";
	return get($sql, "time_log", true); 
}
function get_all_logins_by_date($from, $to, $clerk = ""){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND user = '$clerk' ";}
	$sql = "SELECT *, CONCAT(user,'-',DATE(user_times.date),'-',user_times.out) as akey
	FROM user_times WHERE DATE(user_times.date) >= DATE('$from')
	AND DATE(user_times.date) <= DATE('$to') $sql_clerk";
	return get($sql, "time_log", false, "akey"); 
}
function get_all_lates_by_date($from, $to, $clerk = ""){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND user = '$clerk' ";}
	$sql = "SELECT *, CONCAT(user,'-',DATE(user_late_result.date)) as akey
	FROM user_late_result WHERE DATE(user_late_result.date) >= DATE('$from')
	AND DATE(user_late_result.date) <= DATE('$to') $sql_clerk";
	return get($sql, "_late_result", false, "akey"); 
}
function sum_all_lates_hours($from, $to, $type){
	clerk_db();
	$sql = "SELECT SUM(hours) as total, user
	FROM user_late_result WHERE DATE(user_late_result.date) >= DATE('$from')
	AND DATE(user_late_result.date) <= DATE('$to') AND result = '$type' GROUP BY user";
	return get_str($sql, false, "user"); 
}
function get_week_logins($cid, $week){
	clerk_db();
	$sql = "SELECT *, CONCAT(DATE(user_times.date),'-',user_times.out)  as akey FROM user_times WHERE user = '$cid' 
	AND DATE(user_times.date) >= '$week'
	AND DATE(user_times.date) <= '".date("Y-m-d",strtotime($week." + 6 days"))."'";
	return get($sql, "time_log", false, "akey"); 
}
function check_log_from_computer(){
	clerk_db();
	$computer = md5($_SERVER['HTTP_USER_AGENT']);
	$sql = "SELECT * FROM user_times WHERE computer = '$computer' AND DATE(NOW()) = DATE(user_times.date) AND user_times.out = 0";
	$res = get_str($sql, true);
	if(is_null($res)){return true;}else{return false;} 
}
function search_log_ins($cid, $date){
	clerk_db();
	$sql = "SELECT * FROM user_times WHERE user = '$cid' AND DATE('$date') = DATE(user_times.date) ORDER BY id ASC";
	return get($sql, "time_log"); 
}
function search_breaks($cid, $from, $to){
	clerk_db();
	$sql = "SELECT * FROM breaks WHERE user = '$cid' AND DATE('$from') <= DATE(start_time) AND DATE('$to') >= DATE(start_time) ORDER BY id ASC";
	return get($sql, "ck_break"); 
}
function get_current_breaks(){
	clerk_db();
	$sql = "SELECT * FROM breaks WHERE end_time IS NULL ORDER BY id ASC";
	return get($sql, "ck_break"); 
}
function get_pendings_logouts(){
	clerk_db();
	$sql = "SELECT * FROM `user_times` as ut WHERE DATE(ut.date) < DATE(NOW()) 
	AND NOT EXISTS (SELECT id FROM user_times as sut WHERE sut.user = ut.user AND DATE(sut.date) = DATE(ut.date) AND sut.out = 1)
	ORDER BY ut.date ASC";
	return get($sql, "time_log"); 
}

//Old
/*function set_all_names_available($lid){
	clerk_db();
	$sql = "UPDATE name SET status = '1', next_date = DATE(NOW()) WHERE list = '$lid' AND available = 1";
	return get_str($sql);
}
*/

function set_all_names_available($lid){
	clerk_db();
	$sql = "UPDATE name SET available = '1', by_releases ='0', release_email_sent = '0' WHERE list = '$lid' AND available = 0 and by_releases = '1' ";
	//return get_str($sql);
	execute($sql);
}

function get_states_by_list($lid){
	clerk_db();
	$sql = "SELECT DISTINCT state FROM `name` WHERE list = '".$lid."' and state != '' and available = 1 and country IN ('','US','USA') order by state";
	return get_str($sql);
}

function get_states_by_geo_list($lid){
	clerk_db();
	$sql = "SELECT state FROM `list_geo` WHERE list = '".$lid."' order by state";
	return get_str($sql,false,"state");
}

function delete_geo_list($lid,$state){
	clerk_db();
	$where= "list = '$lid' and state = '$state'";
	return delete("list_geo","", $where);
}

function insert_geo_list($lid, $state){
	clerk_db();
	$sql = "INSERT INTO list_geo VALUES(NULL,'$lid','$state')";
	return execute($sql);
}



function get_name_by_list_and_phone($lid, $phone){
	clerk_db();
	$sql = "SELECT * FROM name WHERE phone = '$phone' AND list = '$lid'";
	return get($sql, "ck_name", true);
}
function get_dup_in_available_lists($phone, $current = "-999"){
	clerk_db();
	$phone = preg_replace("/[^0-9]/", '', $phone);
	if(trim($phone) == ""){$phone = "NoSEt@";}
	$sql = "SELECT n.* FROM `name` as n, list as l WHERE (".clean_mysql_phone("phone")." = '$phone' 
	OR ".clean_mysql_phone("phone2")." = '$phone') AND l.id = n.list AND l.available = 1
	AND n.id != '$current' LIMIT 0,1";
	return get($sql, "ck_name", true);
}
function get_names_by_phone($phone, $email = "", $current = "-999", $just_one = false){
	clerk_db();
	if($just_one){$sql_one = " LIMIT 0,1 ";}
	$sql = "SELECT * FROM name WHERE 
	(REPLACE(REPLACE(REPLACE(phone,')',''),'(',''),'-','') = '$phone'
	AND id != '$current' AND REPLACE(REPLACE(REPLACE(phone,')',''),'(',''),'-','') != '')
	OR(REPLACE(REPLACE(REPLACE(phone2,')',''),'(',''),'-','') = '$phone'
	AND id != '$current' AND REPLACE(REPLACE(REPLACE(phone2,')',''),'(',''),'-','') != '')
	OR (email = '$email' AND email != '' AND id != '$current') $sql_one";
	return get($sql, "ck_name");
}

function get_names_by_phone_list($str_phone){
	clerk_db();
	$sql = "SELECT DISTINCT name, last_name, (REPLACE(REPLACE(REPLACE(phone,')',''),'(',''),'-','')) as phone, acc_number  FROM name WHERE REPLACE(REPLACE(REPLACE(phone,')',''),'(',''),'-','')IN ($str_phone) and acc_number != '' and acc_number NOT LIKE  '%/%'";
	//echo $sql."<BR>";
	return get($sql, "ck_name",false,"phone");
}

function get_name_historical($nid, $email, $phone, $phone2, $player){
	clerk_db();
	$phone = preg_replace("/[^0-9]/", '', $phone);
	$phone2 = preg_replace("/[^0-9]/", '', $phone2);
	if(trim($email) == ""){$email = "NoSEt@";}
	if(trim($phone) == ""){$phone = "NoSEt@";}
	if(trim($phone2) == ""){$phone2 = "NoSEt@";}
	if(trim($player) == ""){$player = "NoSEt@";}
	$sql = "SELECT *, 
	(SELECT call_end FROM `call` WHERE name = n.id ORDER BY id DESC LIMIT 0,1) as ldate 
	FROM `name` as n WHERE (email LIKE '".trim($email)."' OR ".clean_mysql_phone("phone")." = '$phone' 
	OR ".clean_mysql_phone("phone2")." = '$phone' OR acc_number = '$player' 
	OR ".clean_mysql_phone("phone")." = '$phone2' OR ".clean_mysql_phone("phone2")." = '$phone2')
	AND id != '$nid' AND (note != '' OR status != 1) AND list != '62' ORDER BY ldate DESC";
	return get($sql, "ck_name");
}

function get_names_list($id){
	clerk_db();
	$sql = "SELECT * FROM list WHERE id = '$id'";
	return get($sql, "names_list", true);
}
function get_names_list_by_position($pos){
	clerk_db();
	$sql = "SELECT * FROM list WHERE position = '$pos'";
	return get($sql, "names_list", true);
}
function get_all_names_list($available = ""){
	clerk_db();
	if($available != ""){$sql_av = " AND available = '$available' ";}
	$sql = "SELECT * FROM list WHERE 1 $sql_av ORDER BY name ASC";
	return get($sql, "names_list");
}
function get_all_johns_names_list($available = ""){
	global $gsettings;
	clerk_db();
	if($available != ""){$sql_av = " AND available = '$available' ";}
	$sql = "SELECT * FROM list WHERE 1 $sql_av AND id IN(".$gsettings["johns_lists_ids"]->vars["value"].") ORDER BY name ASC";
	return get($sql, "names_list");
}
function get_all_public_names_list($available = ""){
	clerk_db();
	if($available != ""){$sql_av = " AND available = '$available' ";}
	$sql = "SELECT * FROM list as l WHERE NOT EXISTS (SELECT * FROM list_by_clerk WHERE list = l.id) $sql_av ORDER BY name ASC";
	return get($sql, "names_list");
}
function get_next_available_list($prev_list, $index = 1){
	clerk_db();
	$sql = "SELECT * FROM list WHERE position > '". $prev_list->vars["position"] ."' AND available = 1 
	AND NOT EXISTS (SELECT * FROM list_by_clerk WHERE list = id)
	ORDER BY position ASC LIMIT 0,1";
	$next_list = get($sql, "names_list", true);
	
	if(is_null($next_list)){
		$sql = "SELECT * FROM list WHERE available = 1 
		AND NOT EXISTS (SELECT * FROM list_by_clerk WHERE list = id)
		ORDER BY position ASC LIMIT 0,1";
		$next_list = get($sql, "names_list", true);
	}
	
	$total = count(get_all_names_list());
	$tname = _get_random_name($next_list->vars["id"]);
	if(is_null($tname) && $index < $total){return get_next_available_list($next_list,$index+1);}else{return $next_list;}
}

function search_names_by_added_date($from="",$to="",$list="",$data=""){
	clerk_db();
	if($data != ""){$sql_list = " AND (".$data.")";}
	if ($list != ""){ $sql_list = "AND n.list = $list"; }
	$sql = "SELECT  n.name, n.last_name,n.acc_number, n.email,n.aff_id,n.deposit,l.name as list_name from name n ,list l WHERE n.list = l.id and n.added_date >= '$from' and n.added_date <= '$to' $sql_list ";
	return get($sql, "names_list");
}
function search_names_list_by_name($name=""){
	clerk_db();
	if($name != ""){$sql_av = " AND name LIKE '%".$name."%'";}
	$sql = "SELECT * FROM list WHERE 1 $sql_av ORDER BY position ASC";
	return get($sql, "names_list");
}


function get_all_clerks_str_lists(){
	clerk_db();
	$sql = "SELECT c.id as clerk, 
	(SELECT group_concat(l.name separator ', ')  FROM list as l, list_by_clerk as lbc
	WHERE l.id = lbc.list AND lbc.clerk = c.id) as lists
	FROM user as c
	GROUP BY c.id";
		
	return get_str($sql, false, "clerk");}



	function get_ckname($id){
		clerk_db();
		$sql = "SELECT * FROM name WHERE id = '$id'";		
		return get($sql, "ck_name", true);
	}
	function get_ckname_by_account($acc){
		clerk_db();
		$sql = "SELECT * FROM name WHERE acc_number = '$acc'";
		return get($sql, "ck_name", true);
	}
	function count_virgin_names($list){

		if ($list == 20){
			$count = array();
			$count["num"]=  count_new_signup_name();	
			return $count;

		}
		else{
			return count_available_name_list($list);	

	/*clerk_db();
	$states = get_CRM_available_states(true);
	$sql = "SELECT COUNT(*) as num FROM `name` as n, list_by_clerk as l, list as li WHERE n.list = l.list AND l.clerk != '0'
			AND li.id = l.list AND li.available = 1 AND on_the_phone = '0' AND n.available = '1' AND li.id = '$list'
			AND (n.state IN(".$states["available"].") OR n.state NOT IN(".$states["all"].") OR li.agent_list = 1)
			AND 
			(
				(n.status = '1' AND n.list != 20 AND n.list != 54)
				OR
				(status IN ('4','5') AND NOW() >= next_date)
				OR
				(n.clerk = '0' AND status IN (11,9,14) AND NOW() >= next_date AND n.list != 20)
			)";
	 return get_str($sql, "ck_name", true);
	 */
	}
}


function count_all_cknames($list = "", $available = "", $status = "", $clerk = "", $name = "", $email = "", $phone = "", $account = "", $lastname = "", $from_added = ""){
	clerk_db();
	if($list != ""){$sql_list = " AND list = '$list' ";}
	if($list == "-3"){$sql_list = " AND list IN(20,34) ";}
	if($available != ""){$sql_available = " AND available = '$available' ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	if($account != ""){$sql_account= " AND acc_number LIKE '%$account%' ";}
	if($from_added != ""){$sql_added = " AND DATE(added_date) >= '$from_added' ";}
	$sql = "SELECT COUNT(*) as num FROM name WHERE 1 AND name LIKE '%$name%' AND last_name LIKE '%$lastname%'  $sql_added
	AND email LIKE '%$email%' AND phone LIKE '%$phone%'
	$sql_list $sql_available $sql_status $sql_clerk $sql_account ORDER BY id ASC";
	return get_str($sql, "ck_name", true);
}
function get_all_cknames($list = "", $available = "", $status = "", $clerk = "", $name = "", $email = "", $phone = "", $index = 0, $account = "", $lastname = "", $from_added = "", $order = "id ASC"){
	clerk_db();
	if($list != ""){$sql_list = " AND list = '$list' ";}
	if($list == "-3"){$sql_list = " AND list IN(20,34) ";}
	if($available != ""){$sql_available = " AND available = '$available' ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	if($account != ""){$sql_account= " AND acc_number LIKE '%$account%' ";}
	if($from_added != ""){$sql_added = " AND DATE(added_date) >= '$from_added' ";}
	$sql = "SELECT * FROM name WHERE 1 AND name LIKE '%$name%' AND last_name LIKE '%$lastname%' AND email LIKE '%$email%' $sql_added AND 
	(phone LIKE '%$phone%' OR phone2 LIKE '%$phone%') 
	$sql_list $sql_available $sql_status $sql_clerk $sql_account ORDER BY $order  LIMIT $index, 100";
	return get($sql, "ck_name");
}
function get_released_cknames($all = false){
	clerk_db();
	if(!$all){$sql_all = " AND release_email_sent = 0";}
	$sql = "SELECT * FROM name WHERE available = 0 AND by_releases = 1 $sql_all ORDER BY released_date DESC";
	return get($sql, "ck_name");
}
function get_excel_ids($list = "", $available = "", $status = "", $clerk = "", $name = "", $email = "", $phone = "", $account = "", $lastname = ""){
	clerk_db();
	if($list != ""){$sql_list = " AND list = '$list' ";}
	if($available != ""){$sql_available = " AND available = '$available' ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	if($account != ""){$sql_account= " AND acc_number LIKE '%$account%' ";}
	$sql = "SELECT id FROM name WHERE 1 AND name LIKE '%$name%' AND last_name LIKE '%$lastname%'  AND email LIKE '%$email%' AND 
	(phone LIKE '%$phone%' OR phone2 LIKE '%$phone%') $sql_list $sql_available $sql_status $sql_clerk $sql_account ORDER BY id ASC";
	return get_str($sql);
}


function get_names_special_fields_report($field){
	clerk_db();
	$sql = "SELECT * FROM `name` WHERE $field != '' ORDER BY id DESC";
	return get($sql, "ck_name");
}

function get_name_status($id){
	clerk_db();
	$sql = "SELECT * FROM status WHERE id = '$id'";
	return get($sql, "status", true);
}
function get_conversation_status($id){
	clerk_db();
	$sql = "SELECT * FROM conversation_status WHERE id = '$id'";
	return get($sql, "status", true);
}
function get_all_name_status($admin = ""){
	clerk_db();
	if($admin != ""){$sql_admin = " AND admin = '$admin' ";}
	$sql = "SELECT * FROM status WHERE 1 $sql_admin ORDER BY position ASC";
	return get($sql, "status");
}
function get_all_conversation_status(){
	clerk_db();
	$sql = "SELECT * FROM conversation_status ORDER BY position ASC";
	return get($sql, "status");
}
function get_open_call($clerk_id){
	clerk_db();
	$sql = "SELECT * FROM name WHERE on_the_phone = '1' AND clerk = '$clerk_id'";
	return get($sql, "ck_name", true);
}
function count_release_calls($nid){
	clerk_db();
	$sql = "SELECT COUNT(*) as num FROM `call` WHERE name = '$nid' AND final_status = 14";
	$res = get_str($sql, true);
	return $res["num"];
}
function get_random_name($list_id){
	clerk_db();
	$sql = "SELECT * FROM name WHERE on_the_phone = '0' AND (clerk = '0' OR clerk = '$clerk_id') 
	AND available = '1' AND (status = '1' OR status = '5') 
	AND list = '$list_id' ORDER BY RAND() LIMIT 0,1";
	return get($sql, "ck_name", true);
}
function _get_random_name($list_id){
	clerk_db();
	global $signup_time;
	$order = "DESC"; 
	if ($list_id ==20){ 
		$order = "ASC";
		$control_signup="AND UNIX_TIMESTAMP(added_date) <= UNIX_TIMESTAMP('".date("Y-m-d H:i:s",time()- ($signup_time * 60))."')";
	}
	$sql = "SELECT * FROM name WHERE on_the_phone = '0' AND available = '1' AND list = '$list_id'
	AND ((status = '1') OR (status = '5' AND DATE(NOW()) >= DATE(next_date))  OR (status = '4' AND DATE(NOW()) >= DATE(next_date))  
	OR (clerk = '0' AND status IN (14,11,9) AND DATE(NOW()) >= DATE(next_date)) ) AND lead = 0 $control_signup
	ORDER BY id $order LIMIT 0,1";

	return get($sql, "ck_name", true);
}


//NEW CRM FUNCTIONS
function get_state_code($name){
	sbo_book_db();	
	$sql = "SELECT code FROM `states` WHERE name LIKE '$name'";
	$res = get_str($sql, true);
	if(!is_null($res)){return $res["code"];}else{return $name;}
}






function _get_new_signup_name(){
	clerk_db();	

	$states = get_CRM_available_states(true);	
	$list_states = get_str_states_by_list(20);
	if($list_states != ""){$sql_lstates = " AND state IN($list_states) ";}
	
	$sql = "SELECT *  FROM `name` WHERE `list` = 20 AND on_the_phone = '0' AND available = '1'
	AND (state IN(".$states["available"].") OR state NOT IN(".$states["all"]."))
	AND UNIX_TIMESTAMP(added_date) <= 
	UNIX_TIMESTAMP('".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " - 30 minutes "))."') 
	AND status = '1' $sql_lstates ORDER BY id DESC LIMIT 0,1 ";				
	$res = get($sql, "ck_name", true);
	if(is_null($res)){
		$sql = "SELECT *  FROM `name` WHERE `list` = 20 AND on_the_phone = '0' AND available = '1'
		AND (state IN(".$states["available"].") OR state NOT IN(".$states["all"]."))
		AND status = 14 AND NOW() >= next_date $sql_lstates ORDER BY added_date DESC LIMIT 0,1";				
		$res = get($sql, "ck_name", true);
	}
	return $res;
}

function count_new_signup_name(){
	clerk_db();	
	$rows=array(); 
	$states = get_CRM_available_states(true);	
	$list_states = get_str_states_by_list(20);
	if($list_states != ""){$sql_lstates = " AND state IN($list_states) ";}
	
	$sql = "SELECT count(*) as num  FROM `name` WHERE `list` = 20 AND on_the_phone = '0' AND available = '1'
	AND (state IN(".$states["available"].") OR state NOT IN(".$states["all"]."))
	AND UNIX_TIMESTAMP(added_date) <= 
	UNIX_TIMESTAMP('".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " - 30 minutes "))."') 
	AND status = '1' $sql_lstates ORDER BY id DESC $limit ";				
	$res = get_str($sql, true);
	$rows["num"] =  $res["num"];
	
	$sql = "SELECT  count(*) as num  FROM `name` WHERE `list` = 20 AND on_the_phone = '0' AND available = '1'
	AND (state IN(".$states["available"].") OR state NOT IN(".$states["all"]."))
	AND status = 14 AND NOW() >= next_date $sql_lstates ORDER BY added_date DESC $limit";				
	$res = get_str($sql, true);
	$rows["num"] = $rows["num"] + $res["num"];
	
	return $rows["num"];
}



function _get_new_deniedcc_name(){
	clerk_db();	
	$states = get_CRM_available_states(true);	
	$list_states = get_str_states_by_list(54);
	if($list_states != ""){$sql_lstates = " AND state IN($list_states) ";}
	
	global $signup_time;
	$sql = "SELECT *  FROM `name` WHERE `list` = '54' AND on_the_phone = '0' AND available = '1'
	AND (state IN(".$states["available"].") OR state NOT IN(".$states["all"]."))
	AND status = '1' $list_states ORDER BY id DESC LIMIT 0,1";				
	return get($sql, "ck_name", true);
}
function _can_attend_signups($cid){
	clerk_db();
	$sql = "SELECT * FROM `list_by_clerk` WHERE clerk = '$cid' AND list = 20";				
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}
function _is_allow_in_list($cid, $list){
	clerk_db();
	$sql = "SELECT * FROM `list_by_clerk` WHERE clerk = '$cid' AND list = '$list'";				
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}
function _get_new_random_name($cid){
	clerk_db();
	$states = get_CRM_available_states(true);	
	
	$sql = "SELECT n.* FROM `name` as n, list_by_clerk as l, list as li WHERE n.list = l.list AND l.clerk = '$cid'
	AND li.id = l.list AND li.available = 1 AND on_the_phone = '0' AND n.available = '1' 
	AND (n.state IN(".$states["available"].") OR n.state NOT IN(".$states["all"].") OR li.agent_list = 1)
	AND (n.clerk = 0 OR n.clerk = '$cid')
	AND 
	(
	(n.status = '1' AND n.list != 20 AND n.list != 54)
	OR
	(status IN ('4','5') AND NOW() >= next_date)
	OR
	(n.clerk = '0' AND status IN (11,9,14) AND NOW() >= next_date AND n.list != 20)
	)

	AND 
	(
	EXISTS(SELECT * FROM list_geo WHERE list = li.id AND state = n.state)
	OR
	NOT EXISTS(SELECT * FROM list_geo WHERE list = li.id)
	)
	ORDER BY status desc, next_date ASC, RAND() LIMIT 0,1";				
	return get($sql, "ck_name", true);
}

function count_available_name_list($list_id){
	
	clerk_db();
	$states = get_CRM_available_states(true);
	$list_states = get_str_states_by_list($list_id);
	if($list_states != ""){$sql_lstates = " AND n.state IN($list_states) ";}	
		
	$sql = "SELECT COUNT(DISTINCT n.id) as num FROM `name` as n, list_by_clerk as l, list as li WHERE n.list = l.list 
	AND n.list = $list_id
	AND li.id = l.list AND li.available = 1 AND on_the_phone = '0' AND n.available = '1' 
	AND (n.state IN(".$states["available"].") OR n.state NOT IN(".$states["all"].") OR li.agent_list = 1)
	AND 
	(
	(n.status = '1' AND n.list != 20 AND n.list != 54)
	OR
	(status IN ('4','5') AND NOW() >= next_date)
	OR
	(n.clerk = '0' AND status IN (11,9,14) AND NOW() >= next_date AND n.list != 20)
	)
	$sql_lstates
	ORDER BY status desc, next_date ASC";		

	return get_str($sql,true);
}


function _search_agent_name($clerk, $phone, $email, $name, $last){
	clerk_db();
	$phone = preg_replace("/[^0-9]/", '', $phone);
	if($phone != ""){ $sql_phone = " AND (".clean_mysql_phone("phone")." = '$phone' OR ".clean_mysql_phone("phone2")." = '$phone') ";}
	$sql = "SELECT n.* FROM `name` as n, list_by_clerk as l WHERE n.list = l.list AND l.clerk = '$clerk'
	AND email LIKE '%".trim($email)."%' AND name LIKE '%$name%'  $sql_phone
	AND last_name LIKE '%$last%'";				
	return get($sql, "ck_name");
}
function _search_clerk_name($phone, $email, $player){
	clerk_db();
	$phone = preg_replace("/[^0-9]/", '', $phone);
	if($phone != ""){ $sql_phone = " AND (".clean_mysql_phone("phone")." = '$phone' OR ".clean_mysql_phone("phone2")." = '$phone') ";}
	$sql = "SELECT n.* FROM `name` as n, list as l WHERE l.id = n.list AND l.agent_list = 0
	AND email LIKE '%".trim($email)."%' AND acc_number LIKE '%$player%' $sql_phone";				
	return get($sql, "ck_name");
}

function _full_search_clerk_name($name, $phone, $email, $player, $clerk){
	clerk_db();
	$phone = preg_replace("/[^0-9]/", '', $phone);
	if($phone != ""){ $sql_phone = " AND (".clean_mysql_phone("phone")." = '$phone' OR ".clean_mysql_phone("phone2")." = '$phone') ";}
	$sql = "SELECT n.* FROM `name` as n, list as l, list_by_clerk as lc WHERE l.id = n.list AND lc.clerk = '$clerk'
	AND lc.list = l.id AND email LIKE '%".trim($email)."%' AND acc_number LIKE '%$player%' $sql_phone
	AND (n.name LIKE '%$name%' OR n.last_name LIKE '%$name%')";				
	return get($sql, "ck_name");
}




function have_disconect_call($name){
	clerk_db();
	$sql = "SELECT * FROM call WHERE name = '$name' AND final_status = '14'";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}
function new_signups($time){
	clerk_db();
	$sql = "SELECT * FROM name WHERE on_the_phone = '0' AND available = '1' AND list = '20'
	AND ((status = '1' AND clerk = '0') OR (status = '5' AND DATE(NOW()) >= DATE(next_date))) AND lead = 0
	AND UNIX_TIMESTAMP(added_date) <= UNIX_TIMESTAMP('".date("Y-m-d H:i:s",time()- ($time * 60))."')  ORDER BY id ASC";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}
function get_lead_name(){
	clerk_db();
	$sql = "SELECT * FROM name WHERE on_the_phone = '0' AND available = '1' AND closer_attended = 0  
	AND lead = '1' AND deposit = '0' AND next_date <= NOW() 
	ORDER BY next_date DESC, RAND() LIMIT 0,1";
	return get($sql, "ck_name", true);
}
function get_all_lead_names($count = false, $index = "-1", $per_page = ""){
	clerk_db();
	if($count){$sql_count = " COUNT(*) as number ";}else{$sql_count = " * ";}
	if($index != "-1"){$sql_index = " LIMIT $index, $per_page ";}
	$sql = "SELECT $sql_count FROM name WHERE on_the_phone = '0' AND available = '1' 
	AND lead = '1' AND deposit = '0' 
	ORDER BY next_date ASC $sql_index";
	if($count){
		return get_str($sql,true);
	}else{
		return get($sql, "ck_name");
	}	
}
function get_specific_list_name($cid){
	clerk_db();
	$sql = "SELECT n.* FROM name as n, list_by_clerk as lbc, list as l WHERE on_the_phone = '0' AND n.available = '1' 
	AND 
	(
	(n.status = '1') OR (n.status = '5' AND DATE(NOW()) >= DATE(n.next_date)) 
	OR (n.status = '4' AND DATE(NOW()) >= DATE(n.next_date)) 
	OR (n.clerk = '0' AND status IN (14,11,9) AND DATE(NOW()) >= DATE(next_date))
	)    
	AND lbc.clerk = '$cid' AND lbc.list = l.id AND n.list = l.id AND l.available = 1  
	AND( n.clerk = 0 OR n.clerk = '$cid') ORDER BY status desc, next_date ASC, id DESC LIMIT 0,1";
	
	return get($sql, "ck_name", true);
}


function get_affiliate_description($id){
	clerk_db();
	$sql = "SELECT * FROM  affiliate_descriptions WHERE id = '$id'";
	return get($sql, "_affiliate_description", true);
}

function get_affiliate_aid_by_code($aff){
	affiliate_db();
	$sql = "select b.* from affiliates_by_sportsbook a , affiliates b where a.idaffiliate = b.id and a.affiliatecode = '".$aff."'";
	return get($sql, "_affiliate", true);
}



function get_affiliate_description_by_af($af){
	clerk_db();
	$sql = "SELECT * FROM  affiliate_descriptions WHERE affiliate = '$af'";
	return get($sql, "_affiliate_description", true);
}
function get_all_get_affiliate_descriptions(){
	clerk_db();
	$sql = "SELECT * FROM  affiliate_descriptions ORDER BY id ASC";
	return get($sql, "_affiliate_description");
}

function get_call($id){
	clerk_db();
	$sql = "SELECT * FROM `call` WHERE id = '$id'";
	//echo $sql;
	return get($sql, "call", true);
}

function get_duplicate_names_ids($name){
	clerk_db();
	$name = get_ckname($name);	
	$sql = "select * from name where phone Like '%".$name->vars["phone"]."%' ";
	$ck_names = get($sql,"ck_name");
	
	$str_name_id = "AND ( ";
	foreach ($ck_names as $ck_name){
		$str_name_id .= " c.name = '".$ck_name->vars["id"]."' ||";
	}
	$str_name_id = substr($str_name_id,0,-2);
	$str_name_id .= ")";
	return $str_name_id;
	
}


function search_calls($clerk = "", $name = "", $from = "", $to = "", $status = "", $list = "", $index = 0, $count = false, $setlimit = ""){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND c.clerk = '$clerk' ";}
	if($name != ""){
		$sql_name = get_duplicate_names_ids($name);

		
	}
	if($from != ""){$sql_from = " AND DATE(c.call_start) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(c.call_start) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND c.final_status = '$status' ";}
	if($list != ""){$sql_list = " AND c.name = n.id AND n.list = '$list' "; $sql_join = ", name as n";}
	if(!$count){$selection = "c.*"; $limit = "LIMIT $index,100";}else{$selection = "COUNT(c.id) as num"; $limit = "";}
	if($setlimit != ""){$limit = "LIMIT $setlimit";}
	
	$sql = "SELECT $selection FROM  vrbmarketing_clerks.call as c $sql_join
	WHERE 1 $sql_clerk $sql_from $sql_to $sql_name $sql_status $sql_list ORDER BY c.id DESC $limit";
	//echo $sql;
	if(!$count){return get($sql, "call");}
	else{return get_str($sql,true);}	
}

function count_calls_by_list($from, $to){
	clerk_db();	
	$sql = "SELECT l.name, l.available,
	(
	SELECT COUNT(*) FROM `call` as c, name as n
	WHERE c.name = n.id AND n.list = l.id
	AND DATE(c.call_start) >= DATE('$from')
	AND DATE(c.call_start) <= DATE('$to')
	)
	as calls_num
	FROM list as l
	ORDER BY l.available desc, l.name asc";
	return get_str($sql);
}

function get_call_back_name($id, $clerk_id){
	clerk_db();
	$sql = "SELECT * FROM name WHERE id = '$id' AND clerk = '$clerk_id' 
	AND ((DATE(NOW()) >= DATE(next_date) AND next_date >  '1990-12-31') OR status = '9' OR status = '11') AND available = 1";
	return get($sql, "ck_name", true);
}
function get_view_name($id){
	clerk_db();
	$sql = "SELECT * FROM name WHERE id = '$id' AND on_the_phone != 1";
	return get($sql, "ck_name", true);
}
function get_all_call_back_names($clerk_id, $lead = ""){
	clerk_db();
	if($lead != ""){$sql_lead = " AND lead = '$lead' ";}
	$sql = "SELECT * FROM name WHERE clerk = '$clerk_id' 
	AND DATE(NOW()) >= DATE(next_date) AND next_date >  '1990-12-31' AND available = 1 AND status != '5' AND deposit = 0 $sql_lead  
	ORDER BY status ASC, next_date ASC";
	return get($sql, "ck_name");
}
function get_all_call_back_names_light($clerk_id, $lead = ""){
	clerk_db();
	if($lead != ""){$sql_lead = " AND lead = '$lead' ";}
	$sql = "SELECT id, status, name, last_name, next_date, note, state, important, list FROM name WHERE clerk = '$clerk_id' 
	AND DATE(NOW()) >= DATE(next_date) AND next_date >  '1990-12-31' AND available = 1 AND status != '5' AND deposit = 0 $sql_lead  
	ORDER BY status ASC, important DESC, next_date ASC";
	return get($sql, "ck_name", false, "NO_FIELD", false);
}
function get_all_clerks_names_by_status($clerk_id,$status,$lead=""){
	clerk_db();
	if($lead != ""){$sql_lead = " AND lead = '$lead' ";}
	$sql = "SELECT * FROM name WHERE clerk = '$clerk_id' 
	AND available = 1 AND status = '$status' $sql_lead ORDER BY next_date ASC";
	return get($sql, "ck_name");
}
function get_all_clerks_names_by_status_light($clerk_id,$status,$lead=""){
	clerk_db();
	if($lead != ""){$sql_lead = " AND lead = '$lead' ";}
	$sql = "SELECT id, name, last_name, note, free_play FROM name WHERE clerk = '$clerk_id' 
	AND available = 1 AND status = '$status' $sql_lead ORDER BY next_date ASC";
	return get($sql, "ck_name", false, "NO_FIELD", false);
}
function get_name_last_call($name_id){
	clerk_db();
	$sql = "SELECT * FROM  vrbmarketing_clerks.call WHERE name = '$name_id' ORDER BY id DESC LIMIT 0,1";
	return get($sql, "call", true);
}

function get_call_by_status($name_id, $status){
	clerk_db();
	$sql = "SELECT * FROM  vrbmarketing_clerks.call WHERE name = '$name_id' AND final_status = '$status' ORDER BY id DESC LIMIT 0,1";
	return get($sql, "call", true);
}
function get_rule($id){
	clerk_db();
	$sql = "SELECT * FROM  rule WHERE id = '$id'";
	return get($sql, "rule", true);
}
function get_all_rules(){
	clerk_db();
	$sql = "SELECT * FROM  rule ORDER BY id DESC";
	return get($sql, "rule");
}
function get_ck_message($mid){
	clerk_db();
	$sql = "SELECT * FROM  message WHERE id = '$mid'";
	return get($sql, "ck_message", true);
}

function get_trash_messages(){
	clerk_db();
	$sql = "SELECT * FROM  message WHERE deleted = 1 ORDER BY last_date DESC";
	return get($sql, "ck_message");
}
function get_clerk_messages($clerk, $date = "1900-01-01", $title = ""){
	clerk_db();
	$sql = "SELECT * FROM  message WHERE (message.to = '".$clerk->vars["id"]."' OR message.from = '".$clerk->vars["id"]."') 
	AND reply_from = 0 AND deleted = 0 AND DATE(last_date) >= DATE('$date') AND title LIKE '%$title%'  ORDER BY last_date DESC";
	return get($sql, "ck_message");
}
function get_preview_messages($clerk, $date = "1900-01-01", $title = ""){
	clerk_db();
	$sql = "SELECT m.*, u.name FROM message as m, user as u 
	WHERE ((m.from = u.id AND m.from != '".$clerk->vars["id"]."') OR (m.to = u.id AND m.to != '".$clerk->vars["id"]."')) 
	AND (m.to = '".$clerk->vars["id"]."' OR m.from = '".$clerk->vars["id"]."')
	AND m.reply_from = '0' AND m.deleted = 0  
	AND DATE(last_date) >= DATE('$date')
	AND title LIKE '%$title%' 
	ORDER BY u.name ASC";
	return get($sql, "ck_message");
}
function get_ids_clerk_messages($clerk, $date = "1900-01-01", $title = ""){
	clerk_db();
	$sql = "SELECT id FROM  message WHERE (message.to = '".$clerk->vars["id"]."' OR message.from = '".$clerk->vars["id"]."') 
	AND reply_from = 0 AND deleted = 0 AND DATE(last_date) >= DATE('$date') AND title LIKE '%$title%'  ORDER BY last_date DESC";
	return get_str($sql);
}
function get_own_clerk_messages($clerk, $date = "1900-01-01", $title = ""){
	clerk_db();
	$sql = "SELECT * FROM  message WHERE (message.to = '".$clerk->vars["id"]."' AND message.from = '".$clerk->vars["id"]."') 
	AND reply_from = 0 AND deleted = 0 AND DATE(last_date) >= DATE('$date') AND title LIKE '%$title%'  ORDER BY last_date DESC";
	return get($sql, "ck_message");
}
function get_ids_preview_messages($clerk, $date = "1900-01-01", $title = ""){
	clerk_db();
	$sql = "SELECT m.id FROM message as m, user as u 
	WHERE ((m.from = u.id AND m.from != '".$clerk->vars["id"]."') OR (m.to = u.id AND m.to != '".$clerk->vars["id"]."')) 
	AND (m.to = '".$clerk->vars["id"]."' OR m.from = '".$clerk->vars["id"]."')
	AND m.reply_from = '0' AND m.deleted = 0  
	AND DATE(last_date) >= DATE('$date')
	AND title LIKE '%$title%' 
	ORDER BY u.name ASC";
	return get_str($sql);
}

function get_messages_by_ids($ids, $clerk, $order){
	clerk_db();
	if($order == "name"){
		$sql = "SELECT m.*, u.name FROM message as m, user as u WHERE m.id IN ($ids) AND
		((m.from = u.id AND m.from != '".$clerk->vars["id"]."') OR (m.to = u.id AND m.to != '".$clerk->vars["id"]."')) 
		AND (m.to = '".$clerk->vars["id"]."' OR m.from = '".$clerk->vars["id"]."')
		AND m.reply_from = '0' ORDER BY u.name ASC";
	}else{
		$sql = "SELECT * FROM message WHERE id IN ($ids) ORDER BY last_date DESC";
	}
	return get($sql, "ck_message");
}
/*function get_clerk_messages($clerk){
	clerk_db();
	if(!$clerk->admin()){ $sql_add = " (message.to = '".$clerk->vars["id"]."' OR message.from = '".$clerk->vars["id"]."') AND ";}
	$sql = "SELECT * FROM  message WHERE  $sql_add reply_from = 0 ORDER BY id DESC";
	return get($sql, "ck_message");
}*/
function get_message_replys($mid){
	clerk_db();
	$sql = "SELECT * FROM  message WHERE reply_from = '$mid' AND deleted = 0 ORDER BY id ASC";
	return get($sql, "ck_message");
}
function search_cknames($lastname,$str,$type){
	clerk_db();
	if($type == "phone"){
		$str = str_replace("-","",$str);
		$str = str_replace("-","",$str);
		$str = str_replace("-","",$str);
		$sql_type = " AND REPLACE(REPLACE(REPLACE(phone,')',''),'(',''),'-','') LIKE '%$str%' ";
	}
	else{$sql_type = " AND $type LIKE '%$str%' ";}
	$sql = "SELECT * FROM name WHERE last_name LIKE '%$lastname%' $sql_type AND clerk != '0' AND on_the_phone != 1 AND available = 1";
	return get($sql, "ck_name");
}

function get_list_pointer(){
	clerk_db();
	$sql = "SELECT * FROM  list_pointer";
	return get($sql, "list_pointer", true);
}
function get_all_ckwebs($affiliate = "", $name = ""){
	clerk_db();
	if($affiliate != ""){$sql_affiliate = " AND affiliate LIKE '%$affiliate%' ";}
	if($name != ""){$sql_name = " AND name LIKE '%$name%' ";}
	$sql = "SELECT * FROM  website WHERE 1 $sql_affiliate $sql_name ORDER BY id ASC";
	return get($sql, "ck_website");
}
function get_webs_by_aff($affiliate){
	clerk_db();
	$sql = "SELECT * FROM  website WHERE affiliate = '$affiliate' ORDER BY id ASC";
	return get($sql, "ck_website");
}
function get_ckweb($id){
	clerk_db();
	$sql = "SELECT * FROM  website WHERE id = '$id'";
	return get($sql, "ck_website", true);
}
function get_all_ck_levels($sales = false){
	clerk_db();
	if($sales){$sql_sales = " AND is_sales = '$sales' ";}
	$sql = "SELECT * FROM  levels WHERE 1 $sql_sales ORDER BY sort_id ASC";
	return get($sql, "ck_level");
}
function get_ck_level($id){
	clerk_db();
	$sql = "SELECT * FROM levels WHERE id = '$id'";
	return get($sql, "ck_level", true);
}
function get_all_user_groups($schedule = ""){
	clerk_db();
	if($schedule != ""){$sql_sch = " AND schedule = '$schedule'";}
	$sql = "SELECT * FROM  user_group WHERE 1 $sql_sch ORDER BY id ASC";
	return get($sql, "user_group");
}
function get_all_user_groups_chatids(){
	clerk_db();
	$sql = "SELECT * FROM  user_group ORDER BY id ASC";
	return get($sql, "user_group", false, "chat_dept_id");
}
function get_all_user_groups_per_chat_department($id){
	clerk_db();
	$sql = "SELECT * FROM user_groups_per_chat_department WHERE id_group = '$id' ORDER BY id_group ASC";
	
	return get($sql, "user_group_per_chat", false);
}
function get_user_group($id){
	clerk_db();
	$sql = "SELECT * FROM user_group WHERE id = '$id'";
	return get($sql, "user_group", true);
}
function get_attachments_by_message($mid){
	clerk_db();
	$sql = "SELECT * FROM attachment WHERE message = '$mid'";
	return get($sql, "attachment");
}
function get_today_first_log($cid,$date){
	clerk_db();
	$sql = "SELECT * FROM log WHERE user = '$cid' AND DATE(log.date) = DATE('$date') ORDER BY id ASC LIMIT 0,1";
	return get_str($sql, true);
}
function get_today_calls($cid,$date){
	clerk_db();
	$sql = "SELECT * FROM  vrbmarketing_clerks.call WHERE clerk = '$cid' AND DATE(call_start) = DATE('$date')";
	return get($sql, "call");
}
function get_last_call_of_day($cid,$date){
	clerk_db();
	$sql = "SELECT * FROM  vrbmarketing_clerks.call WHERE clerk = '$cid' AND DATE(call_start) = DATE('$date') ORDER by id DESC LIMIT 0,1";
	return get($sql, "call",true);
}
function get_calls_count_by_status($cid,$status,$date = ""){
	clerk_db();
	if($date != ""){$sql_date = " AND DATE(call_end) = DATE('$date') ";}
	if($status != ""){$sql_status = " AND final_status = '$status' ";}
	$sql = "SELECT COUNT(*) as number FROM  vrbmarketing_clerks.call WHERE clerk = '$cid' $sql_status $sql_date";
	return get_str($sql,true);
}
function get_player_in_calls_count_by_status($cid,$status,$from,$to){
	clerk_db();
	$sql = "SELECT DISTINCT acc_number as acc FROM  vrbmarketing_clerks.call as c, name as n 
	WHERE c.clerk = '$cid' AND final_status LIKE '%$status%'
	AND DATE(call_end) >= DATE('$from') AND DATE(call_end) <= DATE('$to') 
	AND c.name = n.id";
	return get_str($sql);
}
function get_no_read_rule($cid){
	clerk_db();
	$sql = "SELECT rule FROM  rule_by_reads WHERE clerk = '$cid' AND rule_by_reads.read = 0 ORDER BY rule ASC LIMIT 0,1";
	return get_str($sql,true);
}
function get_list_clerks($lid){
	clerk_db();
	$sql = "SELECT * FROM  list_by_clerk WHERE list = '$lid'";
	return get_str($sql);
}
function get_transfer_relation($cid, $pending = ""){
	clerk_db();
	if($pending != ""){$sql_pending = " AND ct.pending = 1 ";}
	$sql = "SELECT * FROM  call_transfer as ct WHERE (ct.from = '$cid' OR ct.to = '$cid') $sql_pending ORDER BY id DESC";
	return get($sql,"transfer_relation",true);
}

function get_payment_methods(){
	clerk_db();
	$sql = "SELECT * FROM  pay_methods";
	return get_str($sql);
}
function get_payment_method($id){
	clerk_db();
	$sql = "SELECT * FROM  pay_methods WHERE id = '$id'";
	return get_str($sql,true);
}
function search_signups_names($account){
	clerk_db();
	$sql = "SELECT n.* FROM name as n WHERE acc_number LIKE '%$account%'";
	return get($sql, "ck_name");
}
function get_signups_names($count, $list, $from, $to, $worked = ""){
	clerk_db();
	if($count){$sql_count = "COUNT(*) as total";}else{$sql_count = "*";}
	if($worked == "1"){$sql_status = " AND status != '1' ";}else if($worked == "-1"){$sql_status = " AND status = '1' ";}
	$sql = "SELECT $sql_count FROM name WHERE list = '$list' AND DATE(added_date) >= DATE('$from') 
	AND DATE(added_date) <= DATE('$to') $sql_status ORDER BY added_date DESC";
	if($count){
		return get_str($sql,true);
	}else{
		return get($sql, "ck_name");
	}	
}
function search_signup_name($account, $list = ""){
	clerk_db();
	if($list != ""){$sql_list = " AND list = '$list' ";}
	$sql = "SELECT n.* FROM name as n WHERE acc_number = '$account' $sql_list AND acc_number != '' LIMIT 0,1";
	return get($sql, "ck_name", true);
}
function search_deposits_names($from, $to, $method){
	clerk_db();
	$sql = "SELECT * FROM name WHERE DATE(deposit_date) >= DATE('$from') AND DATE(deposit_date) <= DATE('$to') 
	AND payment_method = '$method' ORDER BY deposit_date ASC, acc_number ASC";
	return get($sql, "ck_name");
}
function get_transaction_by_clerk_and_name($clerk, $name){
	clerk_db();
	$sql = "SELECT * FROM clerk_transaction WHERE  clerk = '$clerk' AND name = '$name'";
	return get($sql, "clerk_transaction", true);
}
function get_clerk_transaction($tid){
	clerk_db();
	$sql = "SELECT * FROM clerk_transaction WHERE id = '$tid'";
	return get($sql, "clerk_transaction", true);
}
function search_clerk_transactions($from, $to, $clerk){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	$sql = "SELECT * FROM clerk_transaction WHERE DATE(transaction_date) >= DATE('$from') AND DATE(transaction_date) <= DATE('$to') 
	$sql_clerk  ORDER BY id DESC";
	return get($sql, "clerk_transaction");
}
function get_transactions_by_clerk($clerk){
	clerk_db();
	$sql = "SELECT * FROM clerk_transaction WHERE clerk = '$clerk'  ORDER BY id DESC";
	return get($sql, "clerk_transaction");
}
function get_lead_transfer($name){
	clerk_db();
	$sql = "SELECT * FROM lead_transfer WHERE name = '$name' ORDER BY tdate DESC LIMIT 0,1";
	return get($sql, "lead_transfer",true);
}
function get_clerks_that_called($nid){
	clerk_db();
	$sql = "SELECT DISTINCT u.* FROM user as u, `call` as c 
	WHERE u.id = c.clerk AND c.name = '$nid' AND c.final_status NOT IN (2,3,4,5,10)
	ORDER BY c.call_start DESC";
	return get($sql, "clerk");
}
function get_deposits_number($from, $to, $clerk = ""){
	clerk_db();
	$number = 0;
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	$sql = "SELECT COUNT(*) as number FROM `call` 
	WHERE DATE(call_end) >= DATE('$from') AND DATE(call_end) <= DATE('$to') AND final_status = 13 $sql_clerk ";
	$result = get_str($sql,true);
	
	$number += $result["number"];
	
	$sql = "SELECT COUNT(*) as number FROM name 
	WHERE DATE(deposit_date) >= DATE('$from') AND DATE(deposit_date) <= DATE('$to') AND status != 13 AND deposit = 1 $sql_clerk";
	$result = get_str($sql,true);
	
	$number += $result["number"];
	
	if($clerk != ""){$sql_clerk = " AND t.clerk = '$clerk' ";}
	$sql = "SELECT COUNT(t.*) as number FROM clerk_transaction as t, name as n 
	WHERE DATE(deposit_date) >= DATE('$from') AND DATE(deposit_date) <= DATE('$to')
	AND t.name = n.id AND t.clerk != n.clerk $sql_clerk";
	$result = get_str($sql,true);
	
	$number += $result["number"];
	
	return $number;
}
function get_calls_count($from, $to, $clerk = "", $unique = false){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	if($unique){$sql_unique = "DISTINCT ";}
	$sql = "SELECT COUNT($sql_unique id) as number FROM `call` WHERE DATE(call_end) >= DATE('$from') AND DATE(call_end) <= DATE('$to') $sql_clerk";
	$result = get_str($sql,true);
	return $result["number"];
}
/*function get_new_calls_count($from, $to, $clerk = ""){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND c.clerk = '$clerk' ";}
	$sql = "SELECT COUNT(DISTINCT id) as number FROM `call` as c WHERE DATE(call_end) >= DATE('$from') AND DATE(call_end) <= DATE('$to')
			AND NOT EXISTS (SELECT id FROM `call` as nc WHERE DATE(nc.call_end) < DATE(c.call_end) AND nc.final_status != 5 AND c.name = nc.name  )
			 $sql_clerk";
	$result = get_str($sql,true);
	return $result["number"];
}*/
function get_new_calls_count($from, $to, $clerk = ""){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	$sql = "SELECT COUNT(*) as number FROM `call` 
	WHERE DATE(call_end) >= DATE('$from') AND DATE(call_end) <= DATE('$to') AND is_new = 1 $sql_clerk ";
	$result = get_str($sql,true);
	return $result["number"];
}
function get_closers_leads_number($from, $to, $clerk){
	clerk_db();
	$sql = "SELECT COUNT(l.name) as number FROM `lead_transfer` as l, name as n
	WHERE DATE(tdate) >= DATE('$from') AND DATE(tdate) <= DATE('$to') 
	AND n.id = l.name AND n.clerk = '$clerk'";
	$result = get_str($sql,true);
	return $result["number"];
}
function get_leads_number($from, $to, $clerk = ""){
	clerk_db();
	if($clerk != ""){$sql_clerk = " AND clerk = '$clerk' ";}
	$sql = "SELECT COUNT(*) as number FROM `call`
	WHERE DATE(call_end) >= DATE('$from') AND DATE(call_end) <= DATE('$to') AND new_lead = 1 $sql_clerk";
	$result = get_str($sql,true);
	return $result["number"];
}

//Security

function get_security_players_questions(){
	clerk_db();	
	$sql = "SELECT * FROM security_player_questions";	
	return get_str($sql);
}

function get_security_players_answers($player){	
	clerk_db();	;
	$sql = "SELECT * FROM security_player_answers WHERE player LIKE '%".$player."%' AND player NOT LIKE '%/bitaddress%'";	
	return get($sql, "_security_player_answers", true);
}



//DURANGO
function get_all_durango_period(){
	clerk_db();
	$sql = "SELECT * FROM `durango_period`";
	return get($sql, "period",false,'id');
}


function get_random_durango_name($type){
	clerk_db();
	$sql = "call sp_durango('".$type."')";
	return get($sql, "durango",true);
}

function get_durango_priority($period){
	clerk_db();
	$sql = "Select MAX(priority) as priority from durango_control where period = '$period' ";
	return  get_str($sql,true);
}


function get_durango_control($name){
	clerk_db();
	$sql = "Select id, name,date from durango_control where name = '$name' ";
	return  get_str($sql,true);
	
}



//BETTING

function get_active_future_games(){
	sbo_sports_db();
	$sql = "SELECT *  FROM `games` WHERE date(startdate) >= '".date("Y-m-d")."' ORDER BY league ASC, startdate ASC";
	return get($sql, "_sbo_games",false,"id");
}
function get_teams_by_list($list){
	sbo_sports_db();
	$sql = "SELECT *  FROM `teams` WHERE `id` IN ($list)";
	return get_str($sql,false,"id");
}
function get_bets_by_account_games($accounts, $identifiers, $games){
	betting_db();
	$sql = "SELECT * FROM  bet WHERE (account IN ($accounts) OR identifier IN ($identifiers)) AND gameid IN ($games)";
return get($sql, "_bet"/*,false,"gameid"*/);
}




function get_other_sports_games($date){
	betting_db();
	$sql = "SELECT * FROM  other_event as e WHERE DATE(e.date) = '$date' ORDER BY sport ASC, away_rotation ASC";
	return get($sql, "_inspin_game");
}

function get_betting_bank($id){
	betting_db();
	$sql = "SELECT * FROM  bank_account WHERE id = '$id'";
	return get($sql, "_betting_bank", true);
}
function get_all_betting_bank(){
	betting_db();
	$sql = "SELECT * FROM  bank_account ORDER BY name ASC";
	return get($sql, "_betting_bank");
}

function get_all_betting_softwares(){
	betting_db();
	$sql = "SELECT * FROM  software ORDER BY name ASC";
	return get($sql, "_betting_software", false, "id");
}
function get_betting_software($sid){
	betting_db();
	$sql = "SELECT * FROM  software WHERE id = '$sid'";
	return get($sql, "_betting_software", true);
}

function get_all_betting_groups(){
	betting_db();
	$sql = "SELECT * FROM  betting_group ORDER BY name ASC";
	return get($sql, "_betting_group");
}
function get_betting_group($gid){
	betting_db();
	$sql = "SELECT * FROM  betting_group WHERE id = '$gid'";
	return get($sql, "_betting_group", true);
}
function get_betting_auto_settings($acc){
	betting_db();
	$sql = "SELECT * FROM  auto_settings WHERE account = '$acc'";
	return get($sql, "_betting_auto_settings", true);
}
function get_all_betting_auto_settings(){
	betting_db();
	$sql = "SELECT * FROM  auto_settings";
	return get($sql, "_betting_auto_settings", false, "account");
}
function clean_account_betting_groups($acc){
	betting_db();
	$sql = "DELETE FROM betting_account_by_group WHERE account = '$acc'";
	return execute($sql);
}
function insert_account_betting_groups($acc, $group){
	betting_db();
	$sql = "INSERT INTO betting_account_by_group VALUES('$acc','$group')";
	return execute($sql);
}

function get_account_betting_groups($acc){
	betting_db();
	$sql = "SELECT g.* FROM betting_account_by_group as r, betting_group as g
	WHERE account = '$acc' AND g.id = r.group";
	return get($sql, "_betting_group", false, "id");
}
function get_betting_sports(){
	betting_db();
	$sql = "SELECT * FROM betting_sport ORDER BY id ASC";
	return get_str($sql);
}
function get_betting_line_types(){
	betting_db();
	$sql = "SELECT * FROM betting_line_type ORDER BY id ASC";
	return get_str($sql);
}
function get_auto_betting_accounts($group = ""){
	betting_db();
	if(is_numeric($group)){
		$sql = "SELECT a.* FROM  account as a, betting_account_by_group as g, auto_settings as s
		WHERE autobet = 1 AND a.id = g.account AND g.group = '$group' AND s.account = a.id";
	}else{
		$sql = "SELECT a.* FROM  account as a, auto_settings as s  WHERE autobet = 1 AND s.account = a.id";
	}
	
	return get($sql, "_betting_account",false,"id");
}
function get_auto_betting_accounts_by_list($list){
	betting_db();
	$sql = "SELECT * FROM  account WHERE autobet = 1 AND id IN ($list)";	
	return get($sql, "_betting_account",false,"id");
}
function get_betting_account($id){
	betting_db();
	$sql = "SELECT * FROM  account WHERE id = '$id'";
	return get($sql, "_betting_account", true);
}

function get_all_auto_betting_accounts(){
	betting_db();
	$sql = "SELECT * FROM  account WHERE autobet = 1 ORDER BY agent ASC";
	return get($sql, "_betting_account");
}


function get_betting_agent($id){
	betting_db();
	$sql = "SELECT * FROM  agent WHERE id = '$id'";
	return get($sql, "_betting_agent", true);
}
function get_all_accounts_transactions_by_account($aid, $from = "", $to = ""){
	betting_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT * FROM  account_transaction WHERE account = '$aid' $sql_from $sql_to ORDER BY id DESC";
	//echo $sql;
	return get($sql,"_account_transaction");
}
function get_all_accounts_transactions_ids(){
	betting_db();
	$sql = "SELECT DISTINCT transaction_id as id FROM  account_transaction ORDER BY tdate DESC";
	//echo $sql;
	return get_str($sql);
}

function get_all_accounts_transactions_ids_date_range($from,$to){
	betting_db();
	$sql = "SELECT transaction_id as id FROM account_transaction WHERE tdate >= '".$from."' AND tdate <= '".$to."' GROUP BY transaction_id ORDER BY MAX(tdate) DESC";
	//echo $sql; 
	return get_str($sql);
}



function get_all_accounts_transaction_parts($tid){
	betting_db();
	$sql = "SELECT * FROM  account_transaction WHERE transaction_id = '$tid'";
	return get($sql,"_account_transaction",false,"substract");
}
function get_betting_account_by_name($name){
	betting_db();
	$sql = "SELECT * FROM  account WHERE name = '$name'";	
	return get($sql, "_betting_account", true);
}
function get_all_betting_accounts(){
	betting_db();
	$sql = "SELECT * FROM  account ORDER BY agent ASC";
	return get($sql, "_betting_account");
}
function get_all_betting_accounts_for_sheet(){
	betting_db();
	$sql = "SELECT * FROM  account WHERE bank != 41 AND available = 1 ORDER BY bank ASC";
	return get($sql, "_betting_account");
}
function get_all_betting_accounts_by_agent($aid, $available = ""){
	betting_db();
	if($available != ""){$sql_available = " AND available = '$available' ";}
	$sql = "SELECT * FROM  account WHERE agent = '$aid' $sql_available ORDER BY name ASC";
	return get($sql, "_betting_account");
}
function get_all_betting_agents(){
	betting_db();
	$sql = "SELECT * FROM  agent ORDER BY name ASC";
	return get($sql, "_betting_agent");
}
function get_betting_identifier($id){
	betting_db();
	$sql = "SELECT * FROM  identifier WHERE id = '$id'";
	return get($sql, "_betting_identifier", true);
}
function get_betting_proxy($id){
	betting_db();
	$sql = "SELECT * FROM  proxy WHERE id = '$id'";
	return get($sql, "_betting_proxy", true);
}
function get_betting_identifier_by_name($name){
	betting_db();
	$sql = "SELECT * FROM  identifier WHERE name = '$name'";
	return get($sql, "_betting_identifier", true);
}
function get_all_betting_identifiers(){
	betting_db();
	$sql = "SELECT * FROM  identifier ORDER BY name ASC";
	return get($sql, "_betting_identifier");
}
function get_all_betting_proxys(){
	betting_db();
	$sql = "SELECT * FROM  proxy ORDER BY name ASC";
	return get($sql, "_betting_proxy", false, "id");
}
function get_all_periods(){
	betting_db();
	$sql = "SELECT name, sbo_name FROM  periods ORDER BY id ASC";
	return get_str($sql);
}
function get_betting_period($id){
	betting_db();
	$sql = "SELECT * FROM  periods WHERE id = '$id'";
	return get($sql,"_betting_period",true);
}
function search_bet($gid, $period, $team, $type, $identifier = ""){
	betting_db();
	if($identifier != ""){$sql_idef = " AND identifier = '$identifier' ";}
	$sql = "SELECT * FROM  bet WHERE gameid = '$gid' AND period = '$period' AND team = '$team' AND type = '$type' $sql_idef ORDER BY id DESC";
	return get($sql, "_bet");
}
function get_pending_bets($acc = ""){
	betting_db();
	if($acc != ""){$sql_grade = " AND account = '$acc' ";}
	$sql = "SELECT * FROM  bet WHERE status = 'n' $sql_grade ORDER BY id ASC";
	return get($sql, "_bet");
}
function search_bets_by_game($gid, $period,$identifier=""){
	betting_db();
	if($identifier != ""){$sql_idef = " AND identifier = '$identifier' ";}
	$sql = "SELECT * FROM  bet WHERE gameid = '$gid' AND period = '$period' $sql_idef  ";
	//echo $sql;
	return get($sql, "_bet");
}

function search_first_bet_by_game($gid, $period,$identifier=""){
	betting_db();
	if($identifier != ""){$sql_idef = " AND identifier = '$identifier' ";}
	$sql = "SELECT * FROM  bet WHERE gameid = '$gid' AND period = '$period' $sql_idef Order by id ASC LIMIT 1  ";
	//echo $sql;
	return get($sql, "_bet");
}

function get_all_games_with_bet_by_date($date,$identifier){
	betting_db();	
	$sql = "SELECT DISTINCT  gameid FROM `bet` WHERE  identifier = ".$identifier." and bdate='".$date."'";	
	return get_str($sql,false,"gameid"); 
}




function get_bets_by_account($aid, $graded = false, $from = "", $to = "",$weekday = ""){
	betting_db();
	if($graded){$sql_grade = " AND status != 'n' ";}
	if($from != "" && $to != ""){$sql_dates = " AND DATE(bdate) >= DATE('$from') AND DATE(bdate) <= DATE('$to') ";}
	if($weekday != "" || is_numeric($weekday) ){ $sql_weekday = " AND WEEKDAY(bdate) = $weekday"; }
	 $sql = "SELECT * FROM  bet WHERE account = '$aid' $sql_grade   $sql_dates $sql_weekday ORDER BY id DESC";
    return get($sql, "_bet");
}
function get_bets_by_identifier($iid, $graded = false, $from = "", $to = ""){
	betting_db();
	if($graded){$sql_grade = " AND status != 'n' ";}
	if($from != "" && $to != ""){$sql_dates = " AND DATE(bdate) >= DATE('$from') AND DATE(bdate) <= DATE('$to') ";}
	$sql = "SELECT * FROM  bet WHERE identifier = '$iid' $sql_grade $sql_dates ORDER BY id DESC";
	return get($sql, "_bet");
}
function get_betting_adjustments($aid = "", $commisions = true, $from = "", $to = ""){
	betting_db();
	if($aid!=""){$sql_account = " AND account = '$aid' ";}
	if(!$commisions){$sql_comm = "AND comment NOT LIKE '%Commission%'";}
	if($from!=""){$sql_from = " AND bdate >= '$from' ";}
	if($to!=""){$sq_lto = " AND bdate <= '$to' ";}
	$sql = "SELECT * FROM  bet WHERE type = 'adjustment' $sql_account $sql_comm $sql_from $sq_lto";
	return get($sql, "_bet");
}
function get_betstype_amount_balance_by_account($aid, $result, $from="", $to=""){
	betting_db();
	$balance = 0;
	if($result == "w"){$sql_amount = "win";}
	else if($result == "l"){$sql_amount = "risk";}
	if($from != ""){$sql_from = " AND DATE(bdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(bdate) <= DATE('$to') ";}

	$sql = "SELECT SUM($sql_amount) as amount FROM  bet WHERE account = '$aid' AND status = '$result' $sql_from $sql_to";

	return get_str($sql,true);
}
function get_betstype_amount_balance_by_identifier($iid, $result, $from="", $to=""){
	betting_db();
	$balance = 0;
	if($result == "w"){$sql_amount = "win";}
	else if($result == "l"){$sql_amount = "risk";}
	if($from != ""){$sql_from = " AND DATE(bdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(bdate) <= DATE('$to') ";}
	$sql = "SELECT SUM($sql_amount) as amount FROM  bet WHERE identifier = '$iid' AND status = '$result' $sql_from $sql_to";
	return get_str($sql,true);
}
function get_betstype_amount_balance_by_account_by_date($aid, $result, $from, $to){
	betting_db();
	$balance = 0;
	if($result == "w"){$sql_amount = "win";}
	else if($result == "l"){$sql_amount = "risk";}
	$sql = "SELECT DATE(bdate) as bdate, SUM($sql_amount) as amount FROM  bet WHERE account = '$aid' AND status = '$result'  
	AND DATE(bdate) >= DATE('$from') AND DATE(bdate) <= DATE('$to') GROUP BY DATE(bdate)";
	
	return get_str($sql,false,"bdate");
}
function get_trans_amount_balance_by_account($aid, $from = "", $to = ""){
	betting_db();
	$balance = 0;
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT substract, SUM(amount) as amount FROM `account_transaction` WHERE account = '$aid' $sql_from $sql_to GROUP BY substract";
	
	return get_str($sql,false,"substract");
}
/*function get_weekly_bet_balances_by_account($aid, $from, $to){
	betting_db();
	$sql = "SELECT DATE(bdate) as bdate, SUM(win) as win, SUM(risk) as risk FROM bet 
				WHERE account = '$aid' AND DATE(bdate) >= DATE('$from') AND DATE(bdate) <= DATE('$to') GROUP BY DATE(bdate)";
	return get_str($sql,false,"bdate");
}*/
function get_bet($id){
	betting_db();
	$sql = "SELECT * FROM  bet WHERE id = '$id'";
	return get($sql, "_bet", true);
}
function get_bet_comissions($bid){
	betting_db();
	$sql = "SELECT * FROM  bet WHERE parent = '$bid'";
	return get($sql, "_bet");
}
function get_results($gid, $period){
	betting_db();
	$sql = "SELECT * FROM  results WHERE game_id = '$gid' AND period = '$period'";
	return get($sql, "_result", true);
}
function get_all_commission_relations(){
	betting_db();
	$sql = "SELECT * FROM  commissions";
	return get($sql,"_betting_commission");
}
function get_account_commission_relations($aid){
	betting_db();
	$sql = "SELECT * FROM  commissions WHERE account = '$aid'";
	return get($sql,"_betting_commission");
}
function get_commission_relation($id){
	betting_db();
	$sql = "SELECT * FROM  commissions WHERE id = '$id'";
	return get($sql,"_betting_commission", true);
}
function get_commission_relation_x_account($account,$caccount){
	betting_db();
	$sql = "SELECT * FROM commissions WHERE account = '$account' AND caccount = '$caccount'";
	return get($sql,"_betting_commission", true);
}
function get_bet_changer_log($from,$to,$rot=""){
	betting_db();
	if($rot!= ""){ $sql_rot = " AND rot = $rot "; }
	$sql = "SELECT * FROM  bet_change_log WHERE game_date >= '$from' AND game_date <= '$to' $sql_rot ";
	return get_str($sql);
}
function get_sport_lines($date, $sport, $period,$unique_day=false){
	sbo_liveodds_db();
	if($unique_day){
		$op = "=";	
	}
	else{
		$op = ">=";		
	}
	
	$sql = "SELECT * FROM `line` WHERE DATE(line_date) $op DATE('$date') 
	AND league = '$sport'
	AND period = '$period'";
	//echo $sql;
	return get($sql, "_sbo_line", false, "away_rotation");
}
function get_sport_lines_by_dates($date_start,$date_end, $sport,$period){
	sbo_liveodds_db();
	$sql = "SELECT CONCAT_WS(' / ', line_date, away_rotation) as line_game,line_date,away_rotation,home_rotation,away_spread,away_total,away_money,home_spread,home_total,home_money  FROM `line` WHERE DATE(line_date) >= '".$date_start."' AND  
	DATE(line_date) <= '".$date_end."'
	AND league = '$sport'
	AND period = '$period' Order by id";
	
	//echo $sql."<BR>";
	return get($sql, "_sbo_line", false, "line_game");
}



function get_sport_team_lines_by_dates($date_start,$date_end, $sport){
	sbo_liveodds_db();
	$sql = "SELECT CONCAT_WS(' / ', line_date, away_rotation,team) as line_game,line_date,away_rotation, CONCAT('o', CONCAT_WS('', total_over, over_odds)) as 'away_total',CONCAT('u',CONCAT_WS('', total_under, under_odds)) as 'home_total' FROM `team_totals_line` WHERE DATE(line_date) >= '".$date_start."' AND  
	DATE(line_date) <= '".$date_end."'
	AND league = '$sport'";
	
	return get($sql, "_sbo_line", false, "line_game");
}

//_gambling_checklist

function get_gambling_checklist($id){
	betting_db();
	$sql = "SELECT * FROM  checklist WHERE id = '$id'";
	return get($sql,"_gambling_checklist", true);
}
function get_all_gambling_checklist(){
	betting_db();
	$sql = "SELECT * FROM  checklist ";
	return get($sql,"_gambling_checklist");
}
function get_all_gambling_checklist_by_day($date){
	betting_db();
	$sql = "select *, CONCAT_WS('_',day,item) as 'control' from checklist_by_day where day = '".$date."' ";
	return get($sql,"_gambling_checklist_by_day",false,"control");
}

function get_all_external_bets($from,$to){
	betting_db();
	$sql = "SELECT * FROM  external_bets where DATE(game_date) >= '".$from."' AND DATE(game_date) <= '".$to."' ";
	return get($sql,"_external_bets");
}

function get_external_bet($id){
	betting_db();
	$sql = "SELECT * FROM  external_bets where id = ".$id." ";
	return get($sql,"_external_bets",true);
}


//END BETTING

//Expenses
function get_expense_category($id){
	accounting_db();
	$sql = "SELECT * FROM  category WHERE id = '$id'";
	return get($sql, "_expense_category", true);
}
function get_all_expense_categories(){
	accounting_db();
	$sql = "SELECT * FROM  category WHERE not_expense = 0 ORDER BY NAME ASC";
	return get($sql, "_expense_category");
}
function get_expense($id){
	accounting_db();
	$sql = "SELECT * FROM  expense WHERE id = '$id'";
	return get($sql, "_expense", true);
}
function get_expense_by_pak($pid){
	accounting_db();
	$sql = "SELECT e.*, c.name FROM  expense a e, category as c WHERE note LIKE '%Moneypak Id:$pid%' AND c.id = e.category";
	return get($sql, "_expense", true);
}

function get_expense_by_list_pak($str_list){
	accounting_db();
	$paks = explode(",",$str_list);
	foreach($paks as $p){

		$sql_note .= "(note LIKE '%Moneypak Id:$p%') || ";	

	}
	$sql_note = substr($sql_note,0,-3);

	$sql = "SELECT e.*,(select name from category c where c.id = e.category) FROM expense as e WHERE $sql_note ";
	
	return get($sql, "_expense", false);
}



function get_current_expenses(){//not in use
	accounting_db();
	$sql = "SELECT * FROM  expense WHERE hidden = 0 ORDER BY id DESC";
	return get($sql, "_expense");
}
function count_current_expenses(){
	accounting_db();
	$sql = "SELECT COUNT(*) as num FROM  expense WHERE hidden = 0 ORDER BY id DESC";
	return get_str($sql, true);
}
function get_current_expenses_pagination($index, $block){
	accounting_db();
	$sql = "SELECT * FROM  expense WHERE hidden = 0 ORDER BY id DESC LIMIT $index , $block";
	return get($sql, "_expense");
}

function get_current_expenses_trasaction($syst,$cat,$from,$to){
	accounting_db();
	$sql = "SELECT id, id as 'key' ,edate as 'tdate', amount,note, (select `name` from category c where e.category = c.id) as category FROM expense e  WHERE  ( `system` like '%(".$syst."%' && `system` like '%".$cat."%') AND edate >= '".$from."' AND edate <= '".$to."' AND hidden = 0 ORDER BY id DESC";
	return get_str($sql);
}


function get_user_expenses(){
	accounting_db();
	$sql = "SELECT * FROM  expense WHERE hidden = 0 AND status = 'un' ORDER BY id DESC";
	return get($sql, "_expense");
}
function search_expenses($from, $to, $category, $status, $type){
	accounting_db();
	if($from!=""){$sql_from = " AND DATE(edate) >= DATE('$from') ";}
	if($to!=""){$sql_to = "AND DATE(edate) <= DATE('$to') ";}
	if($category!=""){$sql_category = " AND category = '$category' ";}
	if($status!=""){$sql_status = " AND status = '$status' ";}
	if($type=="p"){$sql_type = " AND amount < 0 ";}
	if($type=="r"){$sql_type = " AND amount > 0 ";}
	$sql = "SELECT * FROM  expense WHERE 1 $sql_from $sql_to $sql_category $sql_status $sql_type
	ORDER BY id DESC";
	return get($sql, "_expense");
}
function get_is_expenses($from, $to){
	accounting_db();
	if($from!=""){$sql_from = " AND DATE(edate) >= DATE('$from') ";}
	if($to!=""){$sql_to = "AND DATE(edate) <= DATE('$to') ";}
	$sql = "SELECT c.name, SUM(amount) as total FROM expense as e, category as c
	WHERE c.id = e.category $sql_from $sql_to AND e.category != 36 AND e.id >= 201 GROUP BY category";
	return get_str($sql);
}
function get_unposted_balance(){
	accounting_db();
	$sql = "SELECT SUM(amount) as total FROM expense WHERE status = 'un'";
	return get_str($sql,true);
}


function get_expenses_moved_deposits($category,$from, $to){
	accounting_db();
	if($from!=""){$sql_from = "  DATE(edate) >= DATE('$from') ";}
	if($to!=""){$sql_to = "AND DATE(edate) <= DATE('$to') ";}
	$sql = "SELECT * FROM expense as e WHERE  $sql_from $sql_to AND e.category = '".$category."' AND note LIKE '%Moneypak Id:%' ";
	return get_str($sql);
}

//END expenses

//Expense email

function get_all_expense_emails(){	
	accounting_db();
	$sql = "SELECT * FROM expense_email";	
	return get($sql, "_expense_email");
}
function get_expense_email($id){	
	accounting_db();
	$sql = "SELECT * FROM expense_email WHERE id = '$id'";	
	return get($sql, "_expense_email", true);
}


//emails Lists

function get_all_list_emails($list){	
	clerk_db();
	$sql = "SELECT * FROM email_list WHERE list = '$list'";	
	return get($sql, "_list_email");
}
function get_list_email($id){	
	clerk_db();
	$sql = "SELECT * FROM email_list WHERE id = '$id'";	
	return get($sql, "_list_email", true);
}

//Predefined Office Expenses
function get_predefined_office_expense($id){
	accounting_db();
	$sql = "SELECT * FROM  predefined_office_expense WHERE id = '$id'";
	return get($sql, "_predefined_office_expense", true);
}
function get_current_predefined_office_expenses(){
	accounting_db();
	$sql = "SELECT * FROM  predefined_office_expense  ORDER BY id DESC";
	return get($sql, "_predefined_office_expense");
}



//Office expenses
function get_office_expense($id){
	accounting_db();
	$sql = "SELECT * FROM  office_expense WHERE id = '$id'";
	return get($sql, "_office_expense", true);
}
function get_current_office_expenses($moneypak = ""){
	accounting_db();
	if($moneypak != ""){$sql_mp = " AND is_moneypak = '$moneypak' ";}
	$sql = "SELECT * FROM  office_expense WHERE paid = 0 $sql_mp ORDER BY id DESC";
	return get($sql, "_office_expense");
}
function search_office_expenses($fmonth, $fyear, $tmonth, $tyear, $category, $type){
	accounting_db();
	$from = "$fyear-$fmonth-01";
	$to = "$tyear-$tmonth-01";
	if($category!=""){$sql_category = " AND category = '$category' ";}
	if($type=="p"){$sql_type = " AND amount < 0 ";}
	if($type=="r"){$sql_type = " AND amount > 0 ";}
	$sql = "SELECT * FROM  office_expense WHERE  DATE(CONCAT(year,'-',month,'-01')) >= '$from' AND DATE(CONCAT(year,'-',month,'-01')) <= '$to'
	$sql_category $sql_status $sql_type ORDER BY id DESC";
	return get($sql, "_office_expense");
}
// End Office Expenses


//Michael's Expenses
function get_dj_expense_category($id){
	accounting_db();
	$sql = "SELECT * FROM  dj_category WHERE id = '$id'";
	return get($sql, "_dj_expense_category", true);
}
function get_all_dj_expense_categories(){
	accounting_db();
	$sql = "SELECT * FROM  dj_category ORDER BY NAME ASC";
	return get($sql, "_dj_expense_category");
}
function get_dj_expense($id){
	accounting_db();
	$sql = "SELECT * FROM  dj_expense WHERE id = '$id'";
	return get($sql, "_dj_expense", true);
}
function get_current_dj_expenses(){
	accounting_db();
	$sql = "SELECT * FROM  dj_expense WHERE paid = 0 ORDER BY id DESC";
	return get($sql, "_dj_expense");
}
function search_dj_expenses($fmonth, $fyear, $tmonth, $tyear, $category, $type){
	accounting_db();
	$from = "$fyear-$fmonth-01";
	$to = "$tyear-$tmonth-01";
	if($category!=""){$sql_category = " AND category = '$category' ";}
	if($type=="p"){$sql_type = " AND amount < 0 ";}
	if($type=="r"){$sql_type = " AND amount > 0 ";}
	$sql = "SELECT * FROM  dj_expense WHERE  DATE(CONCAT(year,'-',month,'-01')) >= '$from' AND DATE(CONCAT(year,'-',month,'-01')) <= '$to'
	$sql_category $sql_status $sql_type ORDER BY id DESC";
	return get($sql, "_dj_expense");
}
//END Michael's  expenses


//credit accounting

function get_credit_account($id){
	accounting_db();
	$sql = "SELECT * FROM  credit_account WHERE id = '$id'";
	return get($sql, "_credit_account", true);
}
function get_all_credit_accounts(){
	accounting_db();
	$sql = "SELECT * FROM  credit_account ORDER BY id ASC";
	return get($sql, "_credit_account");
}
function get_all_credit_accounts_list(){
	accounting_db();
	$sql = "SELECT * FROM  credit_account";
	return get($sql, "_credit_account", false, "id");
}
function search_credit_transaction($from, $to, $account = ""){
	accounting_db();
	if($account!=""){$sql_acc = " AND (from_account = '$account' OR to_account = '$account') ";}
	$sql = "SELECT * FROM `credit_transaction` WHERE DATE(tdate) >= '$from' AND DATE(tdate) <= '$to' $sql_acc 		
	ORDER BY id ASC";
	return get($sql, "_credit_transaction");
}




function search_credit_adjustments($from, $to, $account = ""){
	accounting_db();
	if($account!=""){$sql_acc = " AND account = '$account' ";}
	$sql = "SELECT * FROM `credit_adjustment` WHERE DATE(mdate) >= '$from' AND DATE(mdate) <= '$to' $sql_acc
	ORDER BY mdate DESC";
	return get($sql, "_credit_adjustment");
}
function get_credit_incomings($from, $to){
	accounting_db();
	$sql = "SELECT a.name, SUM( amount ) AS total
	FROM `credit_adjustment` AS b, credit_account AS a
	WHERE b.account = a.id
	AND mdate >= '$from'
	AND mdate <= '$to'
	GROUP BY account";
	return get_str($sql);
}
function get_all_systems(){
	accounting_db();
	$sql = "SELECT * FROM systems";
	return get_str($sql);
}
function get_all_systems_list(){
	accounting_db();
	$sql = "SELECT * FROM systems";
	return get_str($sql, false, "id");
}
function get_system($id){
	accounting_db();
	$sql = "SELECT * FROM systems WHERE id = '$id'";
	return get_str($sql,true);
}

// endcredit accounting

function get_all_agent_report_access($from, $to){
	sbo_book_db();
	$sql = "SELECT ar.id, ar.report, ar.url, count(arl.report) as total FROM agent_report_log arl, agent_reports ar where 
	DATE(access_date) >= '$from' AND DATE(access_date) <= '$to' and ar.id = arl.report  GROUP BY arl.report order by total desc";
	return get_str($sql);

}

function get_all_server_sites(){
	sbo_book_db();
	$sql = "SELECT * FROM server_sites"; 
	return get_str($sql);

}

function get_all_agent_tools_access($from, $to,$site=""){
	sbo_book_db();
	$sql_site = "";
	if ($site != ""){ $sql_site = " and site = $site "; }
	$sql = "SELECT at.id, at.tool, at.url, count(atl.tool) as total FROM agent_tools_log atl, agent_tools at where 
	DATE(access_date) >= '$from' AND DATE(access_date) <= '$to' and at.id = atl.tool $sql_site  GROUP BY atl.tool order by total desc";
	
	return get_str($sql);

}


function get_all_agent_tools_no_access($from, $to,$site=""){
	sbo_book_db();
	$sql_site = "";
	if ($site != ""){ $sql_site = " and site = $site "; }
	$sql = "SELECT at.id, at.tool, at.url, '0' as total FROM  agent_tools at where
	at.id not in  (select DISTINCT tool FROM agent_tools_log where DATE(access_date) >= '$from' AND DATE(access_date) <= '$to' $sql_site)  GROUP BY at.tool order by total desc";
	
	return get_str($sql);

}

//pph accounting
function is_pph_agent($agent){
	$agent = strtoupper(trim($agent));
	accounting_db();
	$sql = "SELECT * FROM pph_account WHERE name = '$agent'";
	$res = get_str($sql,true);
	if(is_null($res)){return false;}else{return true;}
}

function delete_all_cashier_methods_by_agent($aid){
	accounting_db();
	$sql = "DELETE FROM pph_account_by_cashier_method WHERE account = '$aid'";
	return execute($sql);
}

function insert_cashier_method_by_agent($aid, $mid){
	accounting_db();
	$sql = "INSERT INTO pph_account_by_cashier_method (account, method) VALUES ('$aid','$mid')";
	return execute($sql);
}

function get_cashier_methods_by_agent($aid){
	accounting_db();
	$sql = "SELECT * FROM pph_account_by_cashier_method WHERE account = '$aid'";
	return get_str($sql,false,"method");
}

function get_all_pph_accounts_by_method($mid){
	accounting_db();
	$sql = "SELECT a.* FROM  pph_account as a, pph_account_by_cashier_method as m WHERE m.method = '$mid' AND m.account = a.id";
	return get($sql, "_pph_account");
}


function get_pph_account($id){
	accounting_db();
	$sql = "SELECT * FROM  pph_account WHERE id = '$id'";
	return get($sql, "_pph_account", true);
}


function get_all_pph_accounts_for_billing($date){
	accounting_db();
	$sql = "SELECT * FROM  pph_account WHERE deleted = 0 AND last_billing < '$date' ORDER BY NAME ASC";
	return get($sql, "_pph_account");
}

function get_pph_account_external($id){
	accounting_db();
	$sql = "SELECT * FROM  pph_account_external WHERE id = '$id'";
	return get($sql, "_pph_account_external", true);
}

function get_pph_revert_account_by_name($account){
	accounting_db();
	$sql = "SELECT * FROM  pph_account WHERE deleted = 0 AND (name = '".$account."REVERT' OR name = '".$account." REVERT')";
	return get($sql, "_pph_account", true);
}
function get_pph_account_by_name($name){
	accounting_db();
	$sql = "SELECT * FROM  pph_account WHERE name = '$name'";
	return get($sql, "_pph_account", true);
}
function get_pph_account_by_list($list){
	accounting_db();
	if($list == ""){$list = "''";}
	$sql = "SELECT * FROM  pph_account WHERE name IN($list)";
	return get($sql, "_pph_account");
}
function get_all_pph_accounts(){
	accounting_db();
	$sql = "SELECT * FROM  pph_account WHERE deleted = 0 ORDER BY NAME ASC";
	return get($sql, "_pph_account", false, "id");
}

function get_all_pph_accounts_external(){
	accounting_db();
	$sql = "SELECT * FROM  pph_account_external WHERE deleted = 0 ORDER BY NAME ASC";
	return get($sql, "_pph_account_external", false, "id");
}

function search_pph_accounts($house = "", $deleted = "", $commission = ""){
	accounting_db();
	if($house != ""){$sql_house = " AND house = '$house'";}
	if($deleted != ""){$sql_deleted = " AND deleted = '$deleted'";}
	if($commission != ""){$sql_commission = " AND is_commission = '$commission'";}
	$sql = "SELECT * FROM  pph_account WHERE 1 $sql_deleted $sql_house $sql_commission ORDER BY NAME ASC";
	return get($sql, "_pph_account", false, "id");
}

function search_pph_accounts_external($house = "", $deleted = "", $commission = ""){
	accounting_db();
	if($house != ""){$sql_house = " AND house = '$house'";}
	if($deleted != ""){$sql_deleted = " AND deleted = '$deleted'";}
	if($commission != ""){$sql_commission = " AND is_commission = '$commission'";}
	$sql = "SELECT * FROM  pph_account_external WHERE 1 $sql_deleted $sql_house $sql_commission ORDER BY NAME ASC";
	return get($sql, "_pph_account_external", false, "id");
}

function search_pph_transaction($from, $to, $account = ""){
	accounting_db();
	if($account != ""){$sql_acc = " AND (from_account = '$account' OR to_account = '$account') ";}
	$sql = "SELECT * FROM `pph_transaction` WHERE DATE(tdate) >= '$from' AND DATE(tdate) <= '$to' $sql_acc
	ORDER BY id ASC";
	
	return get($sql, "_pph_transaction");
}

function search_all_pph_transaction($from, $to, $account){
	if($account == ""){$account = "''";}
	accounting_db();
	$sql = "(SELECT id, 0 as from_account, account as to_account, total as amount, tdate, note, 0 as external_id  FROM `pph_billing` WHERE `account` = $account AND DATE(tdate) >= '$from' AND DATE(tdate) <= '$to')
UNION
(SELECT id, from_account, to_account, amount, tdate, note, external_id  FROM `pph_transaction` WHERE (`from_account` = $account OR `to_account` = $account) AND DATE(tdate) >= '$from' AND DATE(tdate) <= '$to')
order by tdate DESC";
  
	return get($sql, "_pph_transaction");
}

function last_payment_pph_transaction($from, $to, $account){
	if($account == ""){$account = "''";}
	accounting_db();
	$sql = "(SELECT id, 0 as from_account, account as to_account, total as amount, tdate, note, 0 as external_id  FROM `pph_billing` WHERE `account` = $account AND DATE(tdate) >= '$from' AND DATE(tdate) <= '$to')
UNION
(SELECT id, from_account, to_account, amount, tdate, note, external_id  FROM `pph_transaction` WHERE (`from_account` = $account OR `to_account` = $account) AND DATE(tdate) >= '$from' AND DATE(tdate) <= '$to')
order by tdate DESC limit 0,1";
   
	return get($sql, "_pph_transaction", true);
}

function get_pph_transaction_by_exid($exid){
	accounting_db();
	$sql = "SELECT * FROM `pph_transaction` WHERE external_id = '$exid'";
	return get($sql, "_pph_transaction", true);
}

function get_pph_transaction($id){
	accounting_db();
	$sql = "SELECT * FROM `pph_transaction` WHERE id = '$id'";
	return get($sql, "_pph_transaction", true);
}

function search_pph_bill($from, $to, $account = ""){
	accounting_db();
	if($account != ""){$sql_acc = " AND account = '$account' ";}
	$sql = "SELECT * FROM `pph_billing` WHERE DATE(mdate) >= '$from' AND DATE(mdate) <= '$to' $sql_acc
	ORDER BY id DESC";
	//ORDER BY mdate DESC";
	//echo $sql;
	return get($sql, "_pph_bill");
}

function search_pph_bill_external($from, $to, $account = ""){
	accounting_db();
	if($account != ""){$sql_acc = " AND account = '$account' ";}
	$sql = "SELECT * FROM `pph_billing_external` WHERE DATE(mdate) >= '$from' AND DATE(mdate) <= '$to' $sql_acc
	ORDER BY mdate DESC";
	return get($sql, "_pph_bill_external");
}

function get_pph_balance_detail($account, $limit_date = "", $todate = ""){
	accounting_db();
	if($limit_date != ""){$sql_ldate = " AND mdate >= '$limit_date' "; $sql_ldate2 = " AND tdate >= '$limit_date' ";}
	if($todate != ""){$sql_todate = " AND mdate <= '$todate' "; $sql_todate2 = " AND tdate <= '$todate' ";}
	$sql = "SELECT `phone_count`, `phone_price`, `internet_count`, `internet_price`, `liveplus_count`, `liveplus_price`, `horsesplus_count`, `horsesplus_price`, `propsplus_count`, `propsplus_price`, total, `mdate`, `note`, 'billing' as ttype  FROM `pph_billing` WHERE `account` = $account $sql_ldate $sql_todate
	UNION
	SELECT 0 as `phone_count`, 0 as `phone_price`, 0 as `internet_count`, 0 as `internet_price`, 0 as `liveplus_count`, 0 as `liveplus_price`, 0 as `horsesplus_count`, 0 as `horsesplus_price`, 0 as `propsplus_count`, 0 as `propsplus_price`, abs(amount) as total, tdate as `mdate`, `note`, 'transaction' as ttype  FROM `pph_transaction` WHERE `to_account` = $account AND `from_account` != $account $sql_ldate2 $sql_todate2
	UNION
	SELECT 0 as `phone_count`, 0 as `phone_price`, 0 as `internet_count`, 0 as `internet_price`, 0 as `liveplus_count`, 0 as `liveplus_price`, 0 as `horsesplus_count`, 0 as `horsesplus_price`, 0 as `propsplus_count`, 0 as `propsplus_price`, abs(amount)*-1 as total, tdate as `mdate`, `note`, 'transaction' as ttype  FROM `pph_transaction` WHERE `from_account` = $account AND `to_account` != $account $sql_ldate2 $sql_todate2
	UNION
	SELECT 0 as `phone_count`, 0 as `phone_price`, 0 as `internet_count`, 0 as `internet_price`, 0 as `liveplus_count`, 0 as `liveplus_price`, 0 as `horsesplus_count`, 0 as `horsesplus_price`, 0 as `propsplus_count`, 0 as `propsplus_price`, amount as total, tdate as `mdate`, `note`, 'transaction' as ttype  FROM `pph_transaction` WHERE `from_account` = $account AND `to_account` = $account $sql_ldate2 $sql_todate2
	ORDER BY mdate DESC
	";
	return get($sql, "_pph_bill");
}
function get_current_pph_bills(){
	accounting_db();
	$sql = "select * from pph_billing WHERE date(tdate) = (SELECT date(tdate) from pph_billing order by tdate desc limit 0,1) ORDER BY id ASC";
	return get($sql, "_pph_bill");
}

function get_current_pph_bills_external(){
	accounting_db();
	$sql = "select * from pph_billing_external WHERE date(tdate) = (SELECT date(tdate) from pph_billing_external order by tdate desc limit 0,1) ORDER BY id ASC";
	return get($sql, "_pph_bill_external");
}

function get_reconciliation_pph_bills($from, $to){
	accounting_db();
	$sql = "select SUM(total) as total, account,
	(select SUM(amount) from pph_expense where date(tdate) >= date('$from') AND date(tdate) <= date('$to')) as expenses
	from pph_billing
	WHERE date(tdate) >= date('$from') AND date(tdate) <= date('$to')
	GROUP BY account";
	return get($sql, "_pph_bill");
}
function get_php_incomings($from, $to){
	accounting_db();
	$sql = "SELECT a.name, SUM( total ) AS total
	FROM `pph_billing` AS b, pph_account AS a
	WHERE b.account = a.id
	AND mdate >= '$from'
	AND mdate <= '$to'
	GROUP BY account";
	return get_str($sql);
}


// pph accounting


//intersystem

function search_intersystem_transactions($from, $to, $status){
	accounting_db();
	if($status != "" && $status != "all"){$sql_status = " AND status = '$status' ";}
	if($from!=""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to!=""){$sql_to = "AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT * FROM intersystem_transaction WHERE 1 $sql_from $sql_to $sql_status ORDER BY id DESC";
	return get($sql, "_intersystem_transaction");
}

function get_intersystem_by_pak($pak_id){
	accounting_db();
	$sql = "select *, '".$pak_id."' as pak  from intersystem_transaction where note LIKE '%Moneypak Id:$pak_id%'";
	return get($sql, "_intersystem_transaction", true);
}

function get_intersystem_by_list_pak($str_list){
	accounting_db();
	$paks = explode(",",$str_list);
	foreach($paks as $p){

		$sql_note .= "(note LIKE '%Moneypak Id:$p%') || ";	

	}
	$sql_note = substr($sql_note,0,-3);
	
	
	$sql = "select * from intersystem_transaction where $sql_note";
	//echo $sql;
	return get($sql, "_intersystem_transaction", false);
}


function search_intersystem_affliate_draw_transactions($from = "", $to = "" , $affiliate=""){
	accounting_db();
	if($affiliate != "" ){$sql_affiliate = " AND ( note Like '%Draw%' AND note like '%$affiliate%')";}
	if($from!=""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to!=""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT id,note, amount,tdate, inserted_by,reversed,dgs_ID FROM intersystem_transaction WHERE 1    $sql_from $sql_to AND afdraw = 1  $sql_affiliate ORDER BY id DESC";
	return get($sql, "_intersystem_transaction");
}


function get_intersystem_transaction($id){
	accounting_db();
	$sql = "SELECT * FROM intersystem_transaction WHERE id = '$id'";
	return get($sql, "_intersystem_transaction",true);
}


function get_intersystem_affliate_list(){
	accounting_db();
	$sql = "select TRIM(SUBSTRING(note from (LOCATE('AF Draw:',note)+8))) as aff , note FROM intersystem_transaction WHERE 1    AND afdraw = 1 and note like '%AF Draw:%'  ORDER BY id DESC";
	return get_str($sql, false,"aff");
}


function get_intersystem_moved_deposits($system,$account,$from,$to){
	accounting_db();
	$sql = "select id, tdate, amount,  note from intersystem_transaction where  to_system = '".$system."' AND to_account = '".$account."' AND (DATE(tdate) >= '".$from."' && DATE(tdate) <= '".$to."') AND   note LIKE '%Moneypak Id%'";
	
	//echo $sql;
	return get_str($sql);
}

function get_intersystem_moved_deposits_balance($system,$account,$from,$to,$direction = true){
	accounting_db();
	$field_system = " to_system ";
	$field_account = " to_account ";
	if(!$direction){
		$field_system = " from_system ";
		$field_account = " from_account ";	
	}
	$sql = "select id, tdate, amount, note, (select s.is_liability from systems s where i.from_system = s.id ) as 'from', (select s.is_liability from systems s where i.to_system = s.id ) as 'to' from intersystem_transaction i where  $field_system = '".$system."' AND $field_account = '".$account."' AND (DATE(tdate) >= '".$from."' && DATE(tdate) <= '".$to."') AND   note NOT LIKE '%Moneypak Id%'";
	
	//echo $sql."<BR><BR>";
	return get_str($sql);
}



//end intersystem



//pph agent freeplays

function get_agent_freeplay_amount($id){
	sbo_book_db();
	$sql = "SELECT * FROM  agent_freeplay_amounts WHERE id = '$id'";
	return get($sql, "_agent_freeplay_amount", true);
}
function get_agent_freeplay_amount_by_af($af){
	sbo_book_db();
	$sql = "SELECT * FROM  agent_freeplay_amounts WHERE agent = '$af'";
	return get($sql, "_agent_freeplay_amount", true);
}
function get_all_agent_freeplay_amounts($enable = ""){
	sbo_book_db();
	if($enable!=""){$sql_en = " AND enable = '$enable' ";}
	$sql = "SELECT * FROM  agent_freeplay_amounts WHERE 1 $sql_en ORDER BY id ASC";
	return get($sql, "_agent_freeplay_amount");
}

//end agent freeplays


//pph ticker

function get_all_pph_ticker(){
	sbo_book_db();
	$sql = "SELECT * FROM  pph_ticker_message";
	return get($sql, "_pph_ticker");
}

function get_pph_ticker($id){
	sbo_book_db();
	$sql = "SELECT * FROM  pph_ticker_message where id ='".$id."'";
	return get($sql, "_pph_ticker",true);
}

//Agents Messages

function get_all_agents_messages(){
	sbo_book_db();
	$sql = "SELECT * FROM agents_messages";
	return get($sql, "_agent_messages");
}

function get_agent_message($id){
	sbo_book_db();
	$sql = "SELECT * FROM agents_messages where id ='".$id."'";
	return get($sql, "_agent_messages",true);
}

//files
function get_all_player_files($player){
	sbo_book_db();
	$sql = "SELECT * FROM  player_file WHERE player = '$player' ORDER BY added_date DESC";
	return get($sql, "_sbo_player_file");
}
function get_player_file($fid){
	sbo_book_db();
	$sql = "SELECT * FROM  player_file WHERE id = '$fid'";
	return get($sql, "_sbo_player_file", true);
}
//end files

//goals

function get_goal($id){
	clerk_db();
	$sql = "SELECT * FROM  goals WHERE id = '$id'";
	return get($sql, "_goal", true);
}
function get_all_goals(){
	clerk_db();
	$sql = "SELECT * FROM  goals ORDER BY start_date DESC";
	return get($sql, "_goal");
}
function get_all_goals_by_group($group){
	clerk_db();
	$sql = "SELECT * FROM  goals WHERE ugroup = '$group' ORDER BY start_date DESC";
	return get($sql, "_goal");
}

//end goals


function get_bronto_filter(){
	sbo_book_db();
	$sql = "SELECT * FROM  bronto_filter WHERE id = 1";
	return get($sql, "_bronto_filter", true);
}

//prepaid
function get_prepaid_transaction($id){
	processing_db();
	$sql = "SELECT * FROM prepaid_transaction WHERE id = '$id'";
	return get($sql, "_prepaid_transaction", true);
}
function search_my_prepaid_transfers($from, $to, $status, $processor, $method=""){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != "" && $status != "all"){$sql_status = " AND processor_status = '$status' ";}
	if($processor != ""){
		$sql_prs1 = ", prepaid_processors as p "; 
		$sql_prs2 = " AND t.processor = p.id AND p.clerk = '$processor' ";
	}
	if($method != ""){$sql_method = " AND payment_method = '$method' ";}
	
	$sql = "SELECT t.*,
	(SELECT COUNT(*) FROM prepaid_transaction WHERE player = t.player AND status != 'de') as player_total
	FROM prepaid_transaction as t $sql_prs1 WHERE 1 
	$sql_customer $sql_from $sql_to $sql_player $sql_status $sql_type $sql_prs2
	AND status != 'pe' $sql_method
	ORDER BY tdate DESC";
	return get($sql, "_prepaid_transaction");
}
function get_prepaids_processor($id){
	processing_db();
	$sql = "SELECT * FROM prepaid_processors WHERE id = '$id'";
	return get($sql, "_prepaid_proc", true);
}
function get_all_prepaid_processors(){
	processing_db();
	$sql = "SELECT * FROM prepaid_processors";
	return get($sql, "_prepaid_proc");
}



//end prepaid

//moneypak
function get_intersystem_mp_ids(){
	accounting_db();
	$sql = "SELECT SUBSTRING(note,POSITION('Moneypak Id:' IN note)+12) as mp  FROM `intersystem_transaction` 
	WHERE `note` LIKE '%Moneypak Id:%'";
	return get_str($sql);
}
function get_intersystem_related_to_mps(){
	accounting_db();
	$sql = "SELECT *, SUBSTRING(note,POSITION('Moneypak Id:' IN note)+12) as mp  FROM `intersystem_transaction` 
	WHERE `note` LIKE '%Moneypak Id:%'";
	return get_str($sql, false, "mp");
}
function get_nonpayouts_mp_players(){
	processing_db();
	$sql = "SELECT COUNT(*) as total, player FROM `moneypack_transaction` as t WHERE type = 'de' AND status = 'ac'
	AND NOT EXISTS (SELECT * FROM moneypack_transaction WHERE status = 'ac' AND type = 'pa' AND player = t.player)
	GROUP BY player ORDER BY total desc ";
	return get_str($sql);
}
function get_total_mp_amounts($player, $from, $to){
	processing_db();
	$sql = "SELECT SUM(amount) as total FROM `moneypack_transaction` WHERE player = '$player' AND type = 'pa' AND status = 'ac'
	AND DATE(tdate) >= DATE('$from') AND DATE(tdate) <= DATE('$to')";
	return get_str($sql, true);
}
function count_mps_by_player_list($list){
	processing_db();
	$sql = "SELECT COUNT(*) as num, UPPER( player ) AS player FROM `moneypack_transaction` WHERE type = 'de' AND status = 'ac'
	AND player IN ($list) GROUP BY player";
	return get_str($sql, false, "player");
}
function get_moneypak_transaction($id){
	processing_db();
	$sql = "SELECT * FROM moneypack_transaction WHERE id = '$id'";
	return get($sql, "_moneypak_transaction", true);
}
function get_moneypaks_by_group_ids($ids){
	processing_db();
	$sql = "SELECT * FROM moneypack_transaction WHERE id IN($ids)";
	return get($sql, "_moneypak_transaction");
}
function search_my_moneypak_transfers($from, $to, $status, $archived, $safe = ""){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($safe != ""){$sql_safe = " AND safe = '$safe' ";}
	if($archived == "1"){
		$sql_arch = " AND archived = '1' AND active = 1";
	}else if($archived == "0"){
		$sql_arch = " AND (archived = '0' OR active = '0') ";
	}
	if($status != "" && $status != "all"){$sql_status = " AND status = '$status' ";}
	$sql = "SELECT t.* FROM moneypack_transaction as t WHERE 1 
	$sql_customer $sql_from $sql_to $sql_player $sql_status $sql_type $sql_arch AND type = 'de' $sql_safe
	ORDER BY tdate DESC";
	return get($sql, "_moneypak_transaction");
}
function search_my_moneypak_payouts($from, $to, $status, $limbo = ""){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != "" && $status != "all"){$sql_status = " AND status = '$status' ";}
	if($limbo != ""){$sql_limbo = " AND limbo = '$limbo' ";}
	$sql = "SELECT t.* FROM moneypack_transaction as t WHERE 1 
	$sql_from $sql_to $sql_player $sql_status AND type = 'pa' $sql_limbo AND method != 'k'
	ORDER BY tdate DESC";
	return get($sql, "_moneypak_transaction");
}

function search_moneypak_sell($from, $to, $status, $delivered){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($delivered == "1"){
		$sql_delivered = " AND delivered = '1' ";
	}else if($delivered == "0"){
		$sql_delivered = " AND delivered = '0' ";
	}
	if($status != "" && $status != "all"){$sql_status = " AND status = '$status' ";}
	$sql = "SELECT * FROM moneypak_sell WHERE 1 
	$sql_from $sql_to $sql_status $sql_delivered 
	ORDER BY tdate DESC";
	return get($sql, "_moneypak_sell");
}
function get_all_mp_sells_ids(){
	processing_db();
	$sql = "SELECT moneypak as id FROM moneypak_sell WHERE status != 'de'";
	return get_str($sql);
}

function get_moneypak_sell($id){
	processing_db();
	$sql = "SELECT * FROM moneypak_sell WHERE id = '".$id."'"; 
	return get($sql, "_moneypak_sell",true);
}

function denied_expired_moneypak_sell($date){
	processing_db();
	
	$sql2 = "UPDATE `moneypak_sell` 
	set comment = 'The transaction has Expired without receiving enough Bitcoins.' WHERE tdate < '".$date."' and status='pe'";
	execute($sql2);
	$sql = "UPDATE `moneypak_sell` 
	set status = 'de' WHERE tdate < '".$date."' and status='pe'";
	return execute($sql);
	
	
}


function get_waiting_mp_payouts(){
	processing_db();
	$sql = "SELECT t.* FROM moneypack_transaction as t WHERE  type = 'pa' AND aps = 'ac' AND limbo = 1
	AND status = 'pe' AND method != 'k'
	ORDER BY tdate DESC";
	return get($sql, "_moneypak_transaction");
}

function get_related_mp_for_check($cid){
	processing_db();
	$sql = "SELECT t.* FROM moneypack_transaction as t WHERE method = 'k' AND comments = '$cid'";
	return get($sql, "_moneypak_transaction", true);
}
function get_waiting_mp_checks_payouts(){
	processing_db();
	$sql = "SELECT t.* FROM check_transactions as t WHERE  aps = 'ac'
	AND status = 'pe' 
	ORDER BY tdate DESC";
	return get($sql, "_check_transaction");
}
function get_available_mps_for_payouts($player, $method = 'm'){
	processing_db();
	
	$sql = "SELECT *  FROM `moneypack_transaction` as mp WHERE type = 'de' AND
	status = 'ac' AND archived = 0  AND player != '$player' AND method = '$method'
	AND NOT EXISTS (SELECT * FROM moneypack_transaction 
	WHERE (deposit = mp.id OR deposit LIKE CONCAT('%,',mp.id,'%') OR deposit LIKE CONCAT('%',mp.id,',%')) AND status != 'de')
	ORDER BY manual ASC, tdate ASC";
	
	return get($sql, "_moneypak_transaction", false, "id");
}
function is_mp_available($mpid){
	processing_db();
	$sql = "SELECT *  FROM `moneypack_transaction` as mp WHERE type = 'de' AND
	status = 'ac' AND archived = 0 AND mp.id = '$mpid'
	AND NOT EXISTS (SELECT * FROM moneypack_transaction 
	WHERE (deposit = mp.id OR deposit LIKE CONCAT('%,',mp.id,'%') OR deposit LIKE CONCAT('%',mp.id,',%')) AND status != 'de')";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}
function is_mp_reserved($mpid){
	processing_db();
	$sql = "SELECT * FROM moneypack_transaction WHERE 
	(deposit = '$mpid' OR deposit LIKE '%,$mpid%' OR deposit LIKE '%$mpid,%') AND status != 'de'";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}
function get_mp_reserved_player($mpid){
	processing_db();
	$sql = "SELECT player FROM moneypack_transaction WHERE 
	(deposit = '$mpid' OR deposit LIKE '%,$mpid%' OR deposit  LIKE '%$mpid,%') AND status != 'de'";
	return get_str($sql, true);
}
function get_moneypak_payout_by_deposit($mpid){
	processing_db();
	$sql = "SELECT * FROM moneypack_transaction WHERE 
	(deposit = '$mpid' OR deposit LIKE '%,$mpid%' OR deposit  LIKE '%$mpid,%') AND status != 'de'";
	return get($sql, "_moneypak_transaction", true);
}

function get_mp_expense_item($id){
	accounting_db();
	$sql = "SELECT * FROM  moneypak_expense_item WHERE id = '$id'";
	return get($sql, "_mp_expense_item", true);
}
function get_all_mp_expense_items(){
	accounting_db();
	$sql = "SELECT * FROM moneypak_expense_item ORDER BY NAME ASC";
	return get($sql, "_mp_expense_item");
}


function count_accepted_moneypaks_by_player($player){
	processing_db();	
	$sql = "SELECT COUNT(*) as num FROM moneypack_transaction 
	WHERE player = '$player' AND status = 'ac' AND type = 'de' AND cmarked = 1";
	return get_str($sql,true);
}


function get_all_buy_moneypaks_promo($sent = "",$active = false){
	clerk_db();	
	if ($sent == '0' || $sent == "1" ) {
		$sql_sent = " AND sent = '".$sent."'" ;
	}
	if ($active) {$sql_active = " AND active = 1" ; }
	$sql = "SELECT *  FROM buy_moneypaks_promo
	WHERE 1 $sql_sent $sql_active ";
	return get($sql,"_buy_moneypaks_promo");
}

function get_buy_moneypaks_promo($id){
	clerk_db();	
	$sql = "SELECT *  FROM buy_moneypaks_promo
	WHERE id = $id";
	return get($sql,"_buy_moneypaks_promo",true);
}



//end moneypak

//reloadit
function get_reloadit_transaction($id){
	processing_db();
	$sql = "SELECT * FROM reloadit_transaction WHERE id = '$id'";
	return get($sql, "_reloadit_transaction", true);
}
function search_my_reloadit_transfers($from, $to, $status, $archived){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($archived != "" && $archived != "all"){$sql_arch = " AND archived = '$archived' ";}
	if($status != "" && $status != "all"){$sql_status = " AND status = '$status' ";}
	$sql = "SELECT t.* FROM reloadit_transaction as t WHERE 1 
	$sql_customer $sql_from $sql_to $sql_player $sql_status $sql_type $sql_arch AND type = 'de'
	ORDER BY tdate DESC";
	return get($sql, "_reloadit_transaction");
}
function is_reloadit_reserved($mpid){
	processing_db();
	$sql = "SELECT * FROM reloadit_transaction WHERE deposit = '$mpid'";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}



//end reloadit


// Checks Payouts
function get_checks_transactions(){
	processing_db();
	$sql = "SELECT * FROM check_transactions  WHERE  (DATE(tdate) = DATE(NOW()) OR cmarked = 0 ) ORDER BY tdate DESC";
	return get($sql, "_check_transaction");
}
function get_check_transaction($id){
	processing_db();
	$sql = "SELECT * FROM check_transactions  WHERE  id= '$id'";
	return get($sql, "_check_transaction",true);
}

function get_checks_transactions_for_process(){
	processing_db();
	$sql = "SELECT * FROM check_transactions WHERE
	aps = 'ac' AND cmarked = 0 AND status != 'de'
	ORDER BY tdate DESC";
	return get($sql, "_check_transaction");
}


// Payouts_question
function get_payout_question($id){
	clerk_db();
	$sql = "SELECT * FROM  payout_question WHERE id = '$id'";
	return get($sql, "_payout_question", true);
}

function get_all_payout_question(){
	clerk_db();
	$sql = "SELECT * FROM  payout_question ORDER BY id ASC";
	return get($sql, "_payout_question");
}

function get_payout_answers($id,$player){
	clerk_db();
	$sql = "SELECT * FROM  payout_answer WHERE idtransaction = '$id' and player = '$player' ";
	return get($sql, "_payout_answer", false, "question");
}

//tickets  /*  ADDED t.deleted =0 AND  12/28/15 */ 
/*function get_unatended_tikets($cat = "agents", $livechat_dept_ids = 0){
	tickets_db();
	if($cat != "all"){
		$sql_cat = " AND category = '$cat' ";
	}
	if($livechat_dept_ids != 0){
		$sql_dept = " AND dep_id_live_chat in ($livechat_dept_ids) ";
	}
	$sql = "SELECT * FROM ticket as t WHERE t.open = 1 AND t.deleted =0 AND  (for_agent IS NULL OR for_agent = '') AND 
			NOT EXISTS (SELECT * FROM response 
			WHERE ticket = t.id AND clerk IS NOT NULL) $sql_cat $sql_dept AND date(tdate) >= DATE('".date("Y-m-d",strtotime(date("Y-m-d")." -1 month"))."')";
	
	//echo $sql;
	return get($sql, "_ticket");
}
*/

function get_unatended_tikets($cat = "agents", $livechat_dept_ids = 0, $clerk_id = ""){
	tickets_db();
	if($cat != "all"){
		$sql_cat = " AND category = '$cat' ";
	}
	if($livechat_dept_ids != 0 ){
		$sql_dept = " AND ( dep_id_live_chat IN ($livechat_dept_ids) OR  
		dep_id_live_chat IN ( SELECT id_chat_dept
		FROM vrbmarketing_clerks.users_per_chat_department
		WHERE id_user = '$clerk_id'
		)
	) ";
}
$sql = "SELECT * FROM ticket as t WHERE t.open = 1 AND t.deleted =0 AND t.removed =0 AND  (for_agent IS NULL OR for_agent = '') AND 
NOT EXISTS (SELECT * FROM response 
WHERE ticket = t.id AND clerk IS NOT NULL) $sql_cat $sql_dept AND date(tdate) >= DATE('".date("Y-m-d",strtotime(date("Y-m-d")." -1 month"))."')";

	//echo $sql;
return get($sql, "_ticket");
}

/*function search_tickets($from, $to, $open, $email, $cat = "agents", $livechat_dept_ids = 0,$keyword = ""){
	tickets_db();
	if($cat != "all"){
		$sql_cat = " AND category = '$cat' ";
	}
	if($livechat_dept_ids != 0){
		$sql_dept = " AND dep_id_live_chat in ($livechat_dept_ids) ";
	}	
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($open != ""){$sql_open = " AND open = '$open' ";}
	if($keyword != ""){$sql_keyword = " AND ( message LIKE '%$keyword%' ||  subject LIKE '%$keyword%' )";}
	$sql = "SELECT * FROM ticket WHERE email LIKE '%$email%' 
	$sql_from $sql_to $sql_open $sql_cat $sql_dept  $sql_keyword AND (for_agent IS NULL OR for_agent = '') AND deleted = 0 ORDER BY id DESC";	
					
	return get($sql, "_ticket");
}
*/

function search_tickets($from, $to, $open, $email, $cat = "agents", $livechat_dept_ids = 0,$keyword = "", $clerk_id = "", $removed = true,$tk_cat = "",$acc="",$pending_ans = "",$count=false,$display=0,$index=0,$completed=""){
	tickets_db();
	
	 $handycappers = array();
     $handycappers[234] = 'Scratch Caddy'; // Jamie
	 $handycappers[251] = 'Sports Betting Handicapper'; // Esteban
	 $handycappers[135] = 'Sports Betting Handicapper'; // Esteban
	 $handycappers[25] = 'Handicapper 911'; // Kevin
	 $handycappers[283] = 'Sports Handicapper'; // Seal
	 $handycappers[284] = 'Squatch Picks'; // Dan The Man


	 if($clerk_id == 25  ) { // Kevin 
	 	$sql_remove_handy = " AND ticket_category != 52 " ;  // This apply to remove the HAndiccappers tickets to Admins, just leave Mike
	 }
 	 
	
	if($removed){
		$sql_removed= "AND removed = 0";	
	}
	
	if($tk_cat != ""){
		$sql_tkcat = " AND ticket_category = '$tk_cat' ";
	}
	
	if($acc != ""){
		$sql_acc = " AND player_account = '$acc' ";
	}
	
	if($cat != "all"){
		$sql_cat = " AND category = '$cat' ";
	}
	
	if($pending_ans != ""){
		$sql_pending_ans = " AND pending_answer = 1 ";
	}
	
	if($completed != ""){
		if($completed == "0"){	
			$sql_completed = " AND completed = 0 ";
		}else{
			$sql_completed = " AND completed = 1 ";
		}
	}	
		
	if($livechat_dept_ids != 0){			
		$sql_dept = " AND ( dep_id_live_chat IN ($livechat_dept_ids) OR  
		dep_id_live_chat IN ( SELECT id_chat_dept
		FROM vrbmarketing_clerks.users_per_chat_department
		WHERE id_user = '$clerk_id'
		)
	) ";
}	
if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
if($open != ""){$sql_open = " AND open = '$open' ";}
if($keyword != ""){$sql_keyword = " AND ( message LIKE '%$keyword%' ||  subject LIKE '%$keyword%' )";}

if($display>0){
	$sql_limit = " LIMIT $index, $display";
}

if($count){
	$sql_select = "COUNT(*) as total";
}else{
	$sql_select = "*";
}

if(isset($handycappers[$clerk_id]) && !$count){  // Handicappers Category = 52

	$sql_union = " UNION SELECT $sql_select from ticket where ticket_category = 52 AND website = '".$handycappers[$clerk_id]."'";
}


$sql = "SELECT $sql_select FROM ticket WHERE email LIKE '%$email%' 
$sql_from $sql_to $sql_open $sql_cat $sql_dept $sql_keyword $sql_completed 
AND (for_agent IS NULL OR for_agent = '') AND deleted = 0  $sql_removed $sql_tkcat $sql_acc $sql_pending_ans $sql_remove_handy  $sql_union ORDER BY id DESC
$sql_limit";

//echo $sql;	

if($count){$res = get_str($sql, true);}else{$res = get($sql, "_ticket");}
	//echo $sql."<BR>";
return $res;
}

function get_tickets_by_player($player){
	tickets_db();
	$sql = "SELECT * FROM ticket WHERE player_account LIKE '$player' AND player_account != '' AND player_account != 'null' AND deleted = 0 ORDER BY id DESC";
	return get($sql, "_ticket");
}

function get_tickets_by_player_to_agent($player){
	tickets_db();
	$sql = "SELECT * FROM ticket WHERE trans_id LIKE '$player' AND player_account != '' AND player_account != 'null' AND deleted = 0 ORDER BY id DESC";
	return get($sql, "_ticket");
}


function count_unread_tickets_by_player($player){
	tickets_db();
	$sql = "SELECT count(*) as num FROM ticket WHERE player_account LIKE '$player' AND player_account != '' AND player_account != 'null' AND pread = 0 AND deleted = 0";
	return get_str($sql,true);
}

function count_unread_tickets_by_player_to_agent($player){
	tickets_db();
	$sql = "SELECT count(*) as num FROM ticket WHERE trans_id LIKE '$player' AND player_account != '' AND player_account != 'null' AND pread = 0 AND deleted = 0";
	return get_str($sql,true);
}


function get_ticket_clerk($tid){
	tickets_db();
	$sql = "SELECT clerk FROM response WHERE ticket = '$tid' AND (clerk IS NOT NULL AND clerk <> 0) || (message like '%The ticket was assigned%') ORDER BY id DESC";
	$id = get_str($sql,true);
	return get_clerk($id["clerk"]);
}

function get_response_time($tid){
	tickets_db();
	$sql = "SELECT rdate FROM response WHERE ticket = '$tid' AND clerk IS NOT NULL AND clerk <> 0 ORDER BY id ASC";
	$id = get_str($sql,true);
	return $id["rdate"];
}

function get_master_tickets_by_player($player){
	tickets_db();
	$sql = "select * from master_ticket where open = 1 and  id not in (select id_ticket from master_players_tickets where account = '".$player."')
	AND exp_date >= '".date("Y-m-d")."' ;";
	return get($sql, "_master_ticket");
}

function get_all_master_ticket(){
	tickets_db();
	$sql = "SELECT * FROM master_ticket ";
	return get($sql, "_master_ticket");
}

function get_master_ticket($id){
	tickets_db();
	$sql = "SELECT * FROM master_ticket WHERE id = '$id'";
	return get($sql, "_master_ticket", true);
}

function get_master_ticket_action($tk,$type){
	// type = d /DELETE  r/Replied
	tickets_db();
	$sql = "select count(*) as total from master_players_tickets where id_ticket = $tk and control = '".$type."'";
	return get_str($sql, true);
}

function get_tickets_to_close(){
	tickets_db();
	$from = date("Y-m-d",strtotime(date("Y-m-d")." - 1 month"));
	$sql = "SELECT  id, (select MAX(rdate) from response where t.id = ticket  ) as last from ticket t 
	WHERE  t.id in (select ticket from response) and t.open = 1 AND DATE(tdate) >= DATE('$from')
	AND (for_agent IS NULL OR for_agent = '') AND category = 'agents' AND (light = 1 || removed = 1 || completed = 1 || deleted = 1) AND pending_answer = 0 ORDER BY id DESC";	
	//echo $sql;
	return get($sql, "_ticket");
}

function search_tickets_by_time($from, $to, $time, $livechat_dept_id = 0, $cat = "agents"){
	tickets_db();
	if($cat != "all"){
		$sql_cat = " AND category = '$cat' ";
	}
	if($livechat_dept_id != 0){
		$sql_dept = " AND dep_id_live_chat = '$livechat_dept_id' ";
	}	
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "select t.*,  TIMEDIFF((select rdate from response where ticket = t.id ORDER BY rdate asc LIMIT 0,1),tdate) 
	as answered from ticket as t WHERE 1 $sql_from $sql_to $sql_cat $sql_dept AND (for_agent IS NULL OR for_agent = '') ORDER BY answered DESC";	
	return get($sql, "_ticket");
}

function search_ezpay_tickets($from, $to){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT id, tdate, subject, 'ezpay' as website, fixed, content as message FROM ticket WHERE 1
	$sql_from $sql_to ORDER BY id DESC";
	return get($sql, "_ticket");
}

/*function search_buybitcoins_tickets($from, $to){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT id, tdate, subject, 'buybitcoins' as website, fixed, content as message FROM ticket WHERE 1
	$sql_from $sql_to ORDER BY id DESC";
	return get($sql, "_ticket");
}*/

function get_ticket($id){
	tickets_db();
	$sql = "SELECT * FROM ticket WHERE id = '$id'";
	return get($sql, "_ticket", true);
}

function get_ticket_feedback(){
	tickets_db();
	$sql = "select * from ticket where ticket_category = 6 and important = 0 and CHAR_LENGTH(message) > 5";
	return get($sql, "_ticket");
}

function get_ticket_response($rid){
	tickets_db();
	$sql = "SELECT * FROM response WHERE id = '$rid'";
	return get($sql, "_ticket_response",true);
}

function get_ticket_responses($tid){
	tickets_db();
	$sql = "SELECT * FROM response WHERE ticket = '$tid' ORDER BY id ASC";
	//echo $sql;
	return get($sql, "_ticket_response");
}
function get_ticket_last_response($tid){
	tickets_db();
	$sql = "SELECT * FROM response WHERE ticket = '$tid' ORDER BY id DESC LIMIT 0,1";
	return get($sql, "_ticket_response", true);
}

function get_ticket_responses_to_sync($ticket_category,$new = false){
	tickets_db();
	if($new){
		$sql_new = " AND id_external = 0 ";
	}
	//$sql = "SELECT * FROM response WHERE updated = 0 AND ticket IN (Select id FROM ticket where ticket_category = 52) $sql_new ORDER BY id ASC";
	
	$sql = "SELECT * FROM response WHERE updated = 0 AND ticket IN (Select id FROM ticket where ticket_category = '$ticket_category') $sql_new ORDER BY id ASC";	
	
	return get($sql, "_ticket_response");
}

function get_tickets_to_sync($ticket_category,$new = false){
   tickets_db();
	if($new){
		$sql_new = " AND id_external = 0 ";
	}
	
	//$sql = "SELECT * FROM ticket WHERE updated = 0 and ticket_category = 52 $sql_new";
	
	$sql = "SELECT * FROM ticket WHERE updated = 0 and ticket_category = '$ticket_category' $sql_new";	
		
	return  get($sql, "_ticket");
}


function get_ticket_player_agent($account,$agent,$ticket){
	tickets_db();
	$sql = "SELECT * FROM ticket WHERE player_account = '".$account."' AND comment = '".$agent."' and related_ticket = '".$ticket."'";
	
	return get($sql, "_ticket", true);
}


function get_ezpay_ticket_responses($tid){
	processing_db();
	$sql = "SELECT r.*, u.name FROM ticket_response as r, user as u WHERE ticket = '$tid'  AND u.id = r.user ORDER BY id DESC";
	return get($sql, "_ticket_response");
}

function search_pph_tickets($from, $to, $resolved, $agent){
	tickets_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($resolved != ""){$sql_resolved = " AND resolved = '$resolved' ";}
	$sql = "SELECT * FROM pph_ticket WHERE agent LIKE '%$agent%'
	$sql_from $sql_to $sql_resolved ORDER BY tdate DESC";
	return get($sql, "_pph_ticket");
}
function get_pph_ticket($id){
	tickets_db();
	$sql = "SELECT * FROM pph_ticket WHERE id = '$id'";
	return get($sql, "_pph_ticket", true);
}

function get_department_ticket($id){
	tickets_db();
	$sql = "SELECT * FROM department_ticket WHERE id = '$id'";
	return get($sql, "_department_ticket", true);
}

function search_department_tickets($from, $to, $resolved, $agent,$department=""){
	tickets_db();
	if ($department != "") {
		$sql_department = " AND department = $department";
        if (!$department) { $sql_department = "";} // This is for the ALL Option   
    }
    if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
    if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
    if($resolved != ""){$sql_resolved = " AND resolved = '$resolved' ";}
    $sql = "SELECT * FROM department_ticket WHERE agent LIKE '%$agent%'
    $sql_from $sql_to $sql_resolved $sql_department ORDER BY tdate DESC";

    return get($sql, "_department_ticket");
}

function get_tickets_transfers_log($from, $to){
	tickets_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT * FROM transfers_log WHERE 1
	$sql_from $sql_to ORDER BY ticket_id DESC, tdate ASC";
	return get($sql, "_ticket_transfers_log");
}

function get_all_ticket_categories($deleted = "-1"){
	tickets_db();
	if($deleted	!= "-1") { $sql_deleted = "AND deleted = $deleted	"; }
	$sql = "SELECT * FROM ticket_categories WHERE	1 $sql_deleted	";
	return get($sql, "_ticket_categories",false,"id");
}



function get_ticket_categorie($id){
	tickets_db();
	$sql = "SELECT * FROM ticket_categories WHERE id = '$id'";

	return get($sql, "_ticket_categories", true);
}
function get_ticket_by_category_important($cat,$imp){
	tickets_db();
	$sql = "SELECT * FROM ticket WHERE ticket_category = '".$cat."' and important = '".$imp."'";

	return get($sql, "_ticket");
}


function get_tickets_to_update_department($dep,$cat){
	tickets_db();
	$sql = "update ticket set dep_id_live_chat = '".$cat."' where ticket_category = '".$dep."' and `open`= 1";
	return execute($sql);
}

function get_tickets_to_update_field_by_account($field,$value,$player){
	tickets_db();
	$sql = "update ticket set $field = '".$value."' where player_account LIKE '$player' ";
	return execute($sql);
}

//end tickets



//rec issues

function get_rec_issue_ticket($id){
	clerk_db();
	$sql = "SELECT * FROM rec_issues WHERE id = '$id'";
	
	return get($sql, "_rec_issues", true);
}


function get_rec_issues_tickets($clerk,$status="",$admin=false){
	clerk_db();
	if ($status != "") {
		$sql_status = " AND status = '".$status."'";
	}
	if (!$admin){
		$sql_assigned = "and (assigned = 0 OR assigned = '".$clerk."') ";
	}
	
	
	$sql = "SELECT * FROM rec_issues WHERE 1 $sql_status $sql_assigned   ORDER BY created_date DESC";
	return get($sql, "_rec_issues");
}

function search_rec_issues_tickets($from, $to, $status, $agent,$admin = false){
	clerk_db();
	if ($agent != "") {
		$sql_agent = " AND ri.by = $agent";
        if (!$agent) { $sql_agent = "";} // This is for the ALL Option   
    }
    if($from != ""){$sql_from = " AND DATE(created_date) >= DATE('$from') ";}
    if($to != ""){$sql_to = " AND DATE(created_date) <= DATE('$to') ";}
    if($status != ""){$sql_status = " AND status = '$status' ";}
    if (!$admin){
    	$sql_assigned = "and (assigned = 0 OR assigned = '".$clerk."') ";
    }

    $sql = "SELECT * FROM rec_issues ri WHERE 1 
    $sql_from $sql_to $sql_status $sql_agent $sql_assigned ORDER BY created_date DESC";

	//echo $sql;
    return get($sql, "_rec_issues");
}

//Programmers Issues


function get_programmers_issue_ticket($id){
	clerk_db();
	$sql = "SELECT * FROM programmer_issues WHERE id = '$id'";
	
	return get($sql, "_programmers_issues", true);
}


function get_programmers_issues_tickets($clerk,$status="",$admin=false){
	clerk_db();
	if ($status != "") {
		$sql_status = " AND status = '".$status."'";
	}
	if (!$admin){
		$sql_assigned = "and (assigned = 0 OR assigned = '".$clerk."') ";
	}
	
	
	$sql = "SELECT * FROM programmer_issues WHERE 1 $sql_status $sql_assigned   ORDER BY priority ASC, created_date DESC";
	//echo $sql;
	return get($sql, "_programmers_issues");
}

function search_programmers_issues_tickets($from, $to, $status, $agent,$admin = false){
	clerk_db();
	if ($agent != "") {
		$sql_agent = " AND ri.by = $agent";
        if (!$agent) { $sql_agent = "";} // This is for the ALL Option   
    }
    if($from != ""){$sql_from = " AND DATE(created_date) >= DATE('$from') ";}
    if($to != ""){$sql_to = " AND DATE(created_date) <= DATE('$to') ";}
    if($status != ""){$sql_status = " AND status = '$status' ";}
    if (!$admin){
    	$sql_assigned = "and (assigned = 0 OR assigned = '".$clerk."') ";
    }

    $sql = "SELECT * FROM programmer_issues ri WHERE 1 
    $sql_from $sql_to $sql_status $sql_agent $sql_assigned ORDER BY created_date DESC";

	//echo $sql;
    return get($sql, "_programmers_issues");
}


//picks
function get_inspin_manual_picks($gameid){
	inspinc_statsdb1();
	$sql = "SELECT * FROM simulation_new
	WHERE gameid = '$gameid' AND manual = 1";
	return get($sql, "_inspin_pick");
}
function get_all_ungraded_manual_picks(){
	inspinc_statsdb1();
	$sql = "SELECT * FROM simulation_new
	WHERE manual = 1 AND win = ''";
	return get($sql, "_inspin_pick");
}
function get_inspin_pick($gameid, $period = "Game"){
	inspinc_statsdb1();
	$sql = "SELECT *
	FROM simulation_new
	WHERE (period LIKE '$period%' OR period = '".get_alternative_period($period)."') AND gameid = '$gameid' ORDER BY id DESC";
	return get($sql, "_inspin_pick", true);
}
function get_inspin_pick_by_id($pid){
	inspinc_statsdb1();
	$sql = "SELECT simulation_new.*
	FROM simulation_new
	WHERE id = '$pid'";
	return get($sql, "_inspin_pick", true);
}
function has_pick($gameid, $period = "Game"){
	inspinc_statsdb1();
	$sql = "SELECT simulation_new.*
	FROM simulation_new
	WHERE period = '$period' AND gameid = '$gameid' 
	AND chosen_id != ''";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}
function search_inspin_picks($from, $to, $league, $period, $manual = ""){
	inspinc_statsdb1();
	if($manual!=""){$sql_manual = " AND manual = '$manual' ";}
	$sql = "SELECT s.* from schedule_feed as g, simulation_new as s WHERE g.gameid = s.gameid AND s.period = '$period' AND g.sportsubtype = '$league' 
	AND DATE(startdate) >= DATE('$from') AND DATE(startdate) <= DATE('$to') $sql_manual";
	return get($sql, "_inspin_pick", false, "gameid");
}
function search_inspin_games($sport, $from, $to){
	inspinc_statsdb1();
	$sql = "SELECT * FROM schedule_feed WHERE sportsubtype = '$sport'
	AND DATE(startdate) >= DATE('$from') AND DATE(startdate) <= DATE('$to') AND awayrotationnumber != ''
	ORDER BY  sportsubtype ASC, (awayrotationnumber * 1) ASC";	 		 
	return get($sql, "_inspin_game");
}
function get_premium_emails(){
	inspinc_insider();
	$sql = "SELECT firstname, lastname, email  FROM `customers` WHERE `premium` = 1";
	return get_str($sql);
}
//end picks


//special deposits
function get_special_method($mid){
	accounting_db();
	$sql = "SELECT * FROM special_method WHERE id = '$mid'";
	return get($sql, "_special_method", true);
}
function get_all_special_methods(){
	accounting_db();
	$sql = "SELECT * FROM special_method WHERE available = 1";
	return get($sql, "_special_method");
}
function get_special_deposit($did){
	accounting_db();
	$sql = "SELECT * FROM special_deposit WHERE id = '$did'";
	return get($sql, "_special_deposit", true);
}
function get_unaccepted_special_deposits(){
	accounting_db();
	$sql = "SELECT * FROM special_deposit WHERE status = 'pe' ORDER BY id DESC";
	return get($sql, "_special_deposit");
}
function search_special_deposits($from, $to, $player, $method, $status = ""){
	accounting_db();
	if($from != ""){$sql_from = " AND DATE(ddate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(ddate) <= DATE('$to') ";}
	if($method != ""){$sql_method = " AND method = '$method' ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	$sql = "SELECT * FROM special_deposit WHERE player LIKE '%$player%' $sql_from $sql_to $sql_method $sql_status  ORDER BY id DESC";
	return get($sql, "_special_deposit");
}
function update_money_order_status($tid, $status){
	processing_db();
	$sql = "UPDATE dmo_transaction SET status = '$status' WHERE id = '$tid' ";
	return get_str($sql);
}

function get_processing_transaction($tid){
	processing_db();
	$sql = "SELECT t.*, m.city FROM transaction as t, method as m WHERE t.id = '$tid' AND t.method = m.id";
	return get_str($sql, true);
}

function search_cash_transfer_payouts_for_process($from, $to){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(transaction.date) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(transaction.date) <= DATE('$to') ";}
	$sql = "SELECT * FROM transaction WHERE type = 'sm' AND id_customer = '1042'
	$sql_from $sql_to AND ((cmarked = 0 AND status != 'de') OR status = 'ape' OR status = 'pe') AND aps = 'ac'
	ORDER BY transaction.date DESC";
	return get($sql, "_cash_transfer_transaction");
}
function get_cash_transfer_transaction($id){
	processing_db();
	$sql = "SELECT * FROM transaction WHERE id = '$id'";
	return get($sql, "_cash_transfer_transaction", true);
}
function get_cash_transfer_processor($id){
	processing_db();
	$sql = "SELECT * FROM method WHERE id = '$id'";
	return get($sql, "_cash_transfer_processor", true);
}
function get_sbo_payouts_fees_by_processor($prs){
	sbo_book_db();
	$sql = "SELECT * FROM  payout_fees WHERE processor = '$prs'";
	return get_str($sql);
}

function search_moneyorder_payouts_for_process($from, $to){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	$sql = "SELECT * FROM dmo_transaction WHERE type = 'p' AND customer = '1042'
	$sql_from $sql_to AND ((cmarked = 0 AND status != 'de') OR status = 'pe') AND aps = 'ac'
	ORDER BY tdate DESC";
	return get($sql, "_moneyorder_payout");
}
function search_moneyorder_payouts($from, $to, $status, $aps, $cmarked){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($aps != ""){$sql_aps = " AND aps = '$aps' ";}
	if($cmarked != ""){$sql_cmarked = " AND cmarked = '$cmarked' ";}
	$sql = "SELECT * FROM dmo_transaction WHERE 1 AND type = 'p' AND customer = '1042'
	$sql_from $sql_to $sql_status $sql_aps $sql_cmarked
	ORDER BY tdate DESC";
	return get($sql, "_moneyorder_payout");
}
function get_moneyorder_payout($id){
	processing_db();
	$sql = "SELECT * FROM dmo_transaction WHERE id = '$id'";
	return get($sql, "_moneyorder_payout", true);
}


//local cash
function get_local_cash_payouts_for_process(){
	processing_db();
	$sql = "SELECT * FROM local_cash_transaction WHERE customer = '1042'
	AND status = 'ac' AND cmarked = 0
	ORDER BY tdate DESC";
	return get($sql, "_local_payout");
}
function search_local_payouts($from, $to, $status, $aps){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($aps != ""){$sql_aps = " AND aps = '$aps' ";}
	$sql = "SELECT * FROM local_cash_transaction WHERE customer = '1042'
	$sql_from $sql_to $sql_status $sql_aps
	ORDER BY tdate DESC";
	return get($sql, "_local_payout");
}
function get_local_payout($id){
	processing_db();
	$sql = "SELECT * FROM local_cash_transaction WHERE id = '$id'";
	return get($sql, "_local_payout", true);
}


//bankwire

function get_bankwire_payouts_for_process(){
	processing_db();
	$sql = "SELECT * FROM bank_wire WHERE
	status = 'ac' AND cmarked = 0
	ORDER BY tdate DESC";
	return get($sql, "_bank_wire");
}
function search_bankwire($from, $to, $status, $aps){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($aps != ""){$sql_aps = " AND aps = '$aps' ";}
	$sql = "SELECT * FROM bank_wire WHERE 1
	$sql_from $sql_to $sql_status $sql_aps
	ORDER BY tdate DESC";
	return get($sql, "_bank_wire");
}
function get_bankwire($id){
	processing_db();
	$sql = "SELECT * FROM bank_wire WHERE id = '$id'";
	return get($sql, "_bank_wire", true);
}




//special payouts
function search_special_payouts_for_process($from, $to, $status, $aps){
	accounting_db();
	if($from != ""){$sql_from = " AND DATE(ddate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(ddate) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($aps != ""){$sql_aps = " AND aps = '$aps' ";}
	$sql = "SELECT * FROM special_payouts WHERE
	$sql_from $sql_to $sql_status $sql_aps
	ORDER BY ddate DESC";
	return get($sql, "_special_payout");
}
function get_special_payout($did){
	accounting_db();
	$sql = "SELECT * FROM special_payouts WHERE id = '$did'";
	return get($sql, "_special_payout", true);
}
function search_special_payout($from, $to, $player, $method, $status = ""){
	accounting_db();
	if($from != ""){$sql_from = " AND DATE(ddate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(ddate) <= DATE('$to') ";}
	if($method != ""){$sql_method = " AND method = '$method' ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	$sql = "SELECT * FROM special_payouts WHERE player LIKE '%$player%' $sql_from $sql_to $sql_method $sql_status  ORDER BY id DESC";
	return get($sql, "_special_payout");
}


//affiliates leads
function get_lead_contact_history($lid){
	affiliate_db();
	$sql = "SELECT * FROM lead_contact WHERE `lead` = '$lid' ORDER BY cdate DESC";
	return get($sql,"_affiliate_lead_call");
}
function get_all_afleads_owners(){
	clerk_db();
	$sql = "SELECT u.id, u.name, u.name as label FROM permission_by_user as p, user as u WHERE p.permission = '78' AND p.user = u.id";
	return get_str($sql, false, "id");
}
function get_all_afleads_status(){
	affiliate_db();
	$sql = "SELECT id, name as label, name FROM lead_status";
	return get_str($sql, false, "id");
}
function get_all_afleads_dispositions(){
	affiliate_db();
	$sql = "SELECT id, name as label FROM  lead_disposition";
	return get_str($sql, false, "id");
}
function get_all_afleads_types(){
	affiliate_db();
	$sql = "SELECT id, name as label FROM lead_type order by name";
	return get_str($sql);
}
function get_all_afleads_plans(){
	affiliate_db();
	$sql = "SELECT id, name as label FROM lead_plan";
	return get_str($sql);
}
function get_all_afleads_countries(){
	affiliate_db();
	$sql = "SELECT DISTINCT country as id, country as label FROM `lead` WHERE country != ''";
	return get_str($sql);
}
function get_affiliate_lead($id){
	affiliate_db();
	$sql = "SELECT * FROM `lead` WHERE id = '$id' AND deleted = 0";
	return get($sql, "_affiliate_lead", true);
}
function get_latest_contacted_afleads($from = 0, $amount = 10){
	affiliate_db();
	$sql = "SELECT DISTINCT l.* FROM `lead_contact` as c, `lead` as l
	WHERE c.lead = l.id AND l.deleted = 0 ORDER BY cdate DESC LIMIT $from,$amount";
	return get($sql, "_affiliate_lead");
}
function get_callback_afleads($owner, $amount = 10){
	affiliate_db();
	$sql = "SELECT * FROM `lead` WHERE call_back_date <= DATE(NOW()) AND owner = '$owner' 
	AND call_back_date > '2013-01-01'  AND deleted = 0 ORDER BY call_back_date ASC, level ASC LIMIT 0,$amount";
	return get($sql, "_affiliate_lead");
}

function search_affiliate_leads($name = "", $web = "", $email = "", $phone = "", $country = "", $from_contact = "", $to_contact = "", $owner = "", $status = "", $disposition = "", $plan = "", $ww = "", $type = "", $level = "", $from_cb = "", $to_cb = "",$sbo = "",$p_method = ""){
	affiliate_db();
	if($name != ""){$sql_name = " AND (name LIKE '%$name%' || last_name LIKE '%$name%') ";}
	if($web != ""){$sql_web = " AND website LIKE '%$web%' ";}
	if($email != ""){$sql_email = " AND email LIKE '%$email%' ";}
	if($phone != ""){$sql_phone = " AND phone LIKE '%$phone%' ";}
	if($country != ""){$sql_country = " AND country = '$country' ";}
	
	if($from_contact != "" || $to_contact != ""){
		if($from_contact != ""){$sql_from_contact = " AND DATE(cdate) >= DATE('$from_contact') ";}
		if($to_contact != ""){$sql_to_contact = " AND DATE(cdate) <= DATE('$to_contact') ";}
		$sql_contact = " AND EXISTS (SELECT * FROM lead_contact WHERE lead = l.id $sql_from_contact $sql_to_contact)";
	}
	
	if($from_cb != ""){$sql_from_cb = " AND DATE(call_back_date) >= DATE('$from_cb') ";}
	if($to_cb != ""){$sql_to_cb = " AND DATE(call_back_date) <= DATE('$to_cb') ";}
	
	if($owner != ""){$sql_owner = " AND owner = '$owner' ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($disposition != ""){$sql_disposition = " AND disposition = '$disposition' ";}
	if($plan != ""){$sql_plan = " AND plan = '$plan' ";}
	if($ww != ""){$sql_ww = " AND ww_af LIKE '%$ww%' ";}
	if($sbo != ""){$sql_sbo = " AND aff_id LIKE '%$sbo%' ";}
	if($p_method != ""){$sql_p_method = " AND payment_method LIKE '%$p_method%' ";}
	if($type != ""){$sql_type = " AND site_type = '$type' ";}
	if($level != ""){$sql_level = " AND level = '$level' ";}
	$sql = "SELECT * FROM `lead` as l WHERE 1  AND deleted = 0 $sql_name $sql_web $sql_email $sql_phone $sql_country $sql_contact $sql_owner $sql_status $sql_disposition $sql_plan $sql_ww  $sql_sbo $sql_type $sql_level $sql_from_cb $sql_to_cb $sql_p_method ORDER BY level ASC, call_back_date ASC";

	return get($sql, "_affiliate_lead");
}

//affiliates

function get_all_affiliates_partners($dnc = true){
	affiliate_db();
	if (!$dnc) { $sql_dnc = "a.firstname not like '%(DNC)%' AND "; }
		
	$sql = "SELECT * FROM affiliates as a WHERE $sql_dnc CONCAT(a.firstname,' ',a.lastname) not like '%(closed)%' and CONCAT(a.firstname,' ',a.lastname) not like '%(DNU)%' and isadmin = 0 and id not in(1033,1035,1379,1372,1366,1471,1491,1480,1330,1357,1373) AND sub = 0 
	AND NOT EXISTS (SELECT * FROM affiliates_by_sportsbook WHERE idaffiliate = a.id AND idbook < 0) ORDER BY id DESC";	
	
	return get($sql, "_affiliate");
}

function get_affiliate_partner($id){
	affiliate_db();
	$sql = "SELECT * FROM affiliates WHERE id = $id";
	return get($sql, "_affiliate",true);
}

function get_all_affiliates_code(){
	affiliate_db();	
	$sql = "SELECT DISTINCT CONCAT_WS('_',idbook,idaffiliate) as book , affiliatecode FROM affiliates_by_sportsbook abs, affiliates a WHERE (a.id = abs.idaffiliate OR abs.idaffiliate = a.sub)"	;
	return get_str($sql, false,"book");
}

function get_affiliate_code_partner($aff_id, $book_id,$sub = ""){
	affiliate_db();
	// OR idaffiliate = ".$sub." WAS REMOVED
	$sql = "SELECT affiliatecode FROM affiliates_by_sportsbook WHERE idbook = $book_id AND (idaffiliate = $aff_id )"; 

	return get_str($sql, true);
}

function get_affiliate_password_partner($aff_id, $book_id,$sub =""){
	affiliate_db();
	// OR idaffiliate = ".$sub." WAS REMOVED
	$sql = "SELECT password FROM affiliates_by_sportsbook WHERE idbook = $book_id AND (idaffiliate = $aff_id )"; 
	return get_str($sql, true);
}


function get_affiliates_sub_websites($aff_id){
	affiliate_db();	
	$sql = "SELECT id, websitename FROM affiliates WHERE sub = '$aff_id'"; 
	return get_str($sql);
}

function get_affiliates_by_sportbook($aff_id,$idbook = ""){
	affiliate_db();	
	if ($idbook != "") { $sql_book = " AND  idbook = '".$idbook."'"; }
	$sql = "SELECT * FROM affiliates_by_sportsbook WHERE idaffiliate = '$aff_id' $sql_book"; 
	
	return get($sql,"_affiliates_by_sportsbook",true);
}

function update_affiliates_by_sportbook($aff_id,$idbook,$affcode,$password){
	affiliate_db();	
	$sql = "UPDATE affiliates_by_sportsbook SET `affiliatecode` = '".$affcode."', `password` = '".$password."' WHERE idbook = '".$idbook."' and idaffiliate = '".$aff_id."'"; 
	return execute($sql);
}

function delete_affiliates_by_sportbook($aff_id,$idbook){
	affiliate_db();	
	$sql = "DELETE FROM affiliates_by_sportsbook WHERE idaffiliate = '".$aff_id."' AND idbook = '".$idbook."' ";
	
	return execute($sql);
}

function get_sportsbooks_by_affiliate_partner($aff_id){
	affiliate_db();
	
	$sql = "SELECT b.id, b.name, b.url FROM sportsbooks as b, affiliates_by_sportsbook as abs 
	WHERE abs.idaffiliate = $aff_id	AND abs.idbook = b.id";

	return get_str($sql);
}

function get_all_sportsbooks_partner(){
	affiliate_db();
	$sql = "SELECT * FROM sportsbooks where id not in (7,10) ORDER BY id DESC";
	return get_str($sql);
}

function get_sportsbooks_partner($id){
	affiliate_db();
	$sql = "SELECT * FROM sportsbooks where id= '$id' ORDER BY id DESC";
	return get_str($sql,true);
}

function check_book_affiliate($aff_id, $book_id) {
	
	affiliate_db();
	$sql = "SELECT COUNT(*) AS cant FROM affiliates_by_sportsbook WHERE idaffiliate = $aff_id and idbook = $book_id";
	$total = get_str($sql,true);;
	if ($total["cant"] == 0) {
		return FALSE;
	}
	else {
		return TRUE;	
	}	
}

function check_email_affiliate($email,$id) {
	affiliate_db();
	$sql =  "SELECT count(*) as cant FROM affiliates WHERE email = '$email' and id <> '$id'";
	return get_str($sql,true);
}


function get_all_affiliates_brands($index = false){
	affiliate_db();
	$key = "";
	if ($index){  $key = "id"; }
	$sql = "SELECT * FROM sportsbooks where id not in(1,4,7,10,12)";
	return get($sql, "_affiliate_brand",false,$key);
}
function get_affiliates_brand($id){
	affiliate_db();
	$sql = "SELECT * FROM sportsbooks WHERE id = '$id'";
	return get($sql, "_affiliate_brand", true);
}
function get_all_affiliates_by_brand($bid, $light = true){
	affiliate_db();
	if($light){
		$sql = "SELECT a.id, a.firstname, a.lastname, ab.affiliatecode, ab.password FROM affiliates as a, affiliates_by_sportsbook as ab WHERE a.id = ab.idaffiliate AND idbook = '$bid'";
	}else{
		$sql = "SELECT * FROM affiliates as a, affiliates_by_sportsbook as ab WHERE a.id = ab.idaffiliate AND idbook = '$bid'";
	}	
	return get($sql, "_affiliate");
}


function delete_affiliate($aff_id){
	affiliate_db();
	$sql = "DELETE FROM affiliates_by_sportsbook WHERE idaffiliate = '".$aff_id."'";
	execute($sql);
	affiliate_db();
	$sql = "DELETE FROM clicks WHERE idaffiliate = '".$aff_id."'";
	execute($sql);
	affiliate_db();
	$sql = "DELETE FROM impressions WHERE idaffiliate = '".$aff_id."'";
	execute($sql);
	affiliate_db();
	$sql = "DELETE FROM affiliates WHERE id = '".$aff_id."'";
	return execute($sql);
}

function get_promotype_by_id($id){	
	affiliate_db();
	$sql = "SELECT * FROM promotypes WHERE id = $id";	
	return get($sql,"_promo_type",true);
}


function get_campaign_by_id($id){	
	affiliate_db();
	$sql = "SELECT * FROM campaignes WHERE id = '$id'";	
	return get($sql,"_affiliate_campaign",true);
}


function get_campaigne_category_by_id($id){
	affiliate_db();
	$sql = "SELECT * FROM category WHERE id = '$id' "; 
	
	return get_str($sql,true);
}

function get_all_campaigne_categories(){
	affiliate_db();
	$sql = "SELECT * FROM category"; 
	
	return get_str($sql);
}

function get_affiliate_code_lead($field,$email){
	affiliate_db();
	$sql = "SELECT $field FROM lead WHERE email = '".$email."'"; 
	
	return get($sql,"_affiliate_lead",true);
}
function get_affiliates_pending_approval(){
	affiliate_db();
	
	/*$sql = "SELECT a.*, idaffiliate, abs.password as abs_password, idbook FROM affiliates_by_sportsbook as abs , affiliates a WHERE a.id = abs.idaffiliate AND
	(abs.affiliatecode is null or abs.affiliatecode = '') ORDER BY abs.idaffiliate DESC;";*/
	
	$sql= "SELECT distinct(a.id), a.firstname, a.lastname, a.email, a.websiteurl, a.nepass FROM affiliates_by_sportsbook as abs , affiliates a WHERE a.id = abs.idaffiliate AND
	(abs.affiliatecode is null or abs.affiliatecode = '') ORDER BY abs.idaffiliate DESC;";

	return get($sql,"_affiliate");
}

function get_all_partners_campaigns($book = "" ){	
	affiliate_db();
	if ($book != "" ) {	$sqlbook = "WHERE id_sportsbook = ".$book." ";  	 }
	$sqlselect = ", (select p.name as img from promotypes  p 
	where p.type = 'b' and idcampaigne = c.id AND p.name LIKE '%125%' limit 0,1 ) as img";	
	$sql = "SELECT * $sqlselect FROM campaignes c $sqlbook ORDER BY id_sportsbook ASC";				
	return get($sql,"_affiliate_campaign");
}

function get_promos_by_campaigne_affiliate($camp_id){	
	affiliate_db();
	$sql = "SELECT * FROM promotypes WHERE idcampaigne = $camp_id ORDER BY type";	
	return get($sql,"_promo_type");
}

function get_promos_by_type($type){	
	affiliate_db();
	$sql = "SELECT * FROM promotypes WHERE  type = '".$type."' ORDER BY id DESC";	
	return get($sql,"_promo_type");
}

function delete_general_promo_affiliate($promo){
	affiliate_db();
	$sql = "DELETE FROM clicks WHERE idbanner = '$promo'";
	execute($sql);
	$sql = "DELETE FROM clicks_week WHERE idbanner = '$promo'";
	execute($sql);
	$sql = "DELETE FROM clicks_month WHERE idbanner = '$promo'";
	execute($sql);
	$sql = "DELETE FROM impressions WHERE idbanner = '$promo'";
	execute($sql);
	$sql = "DELETE FROM impressions_week WHERE idbanner = '$promo'";
	execute($sql);
	$sql = "DELETE FROM impressions_month WHERE idbanner = '$promo'";
	execute($sql);
	$sql = "DELETE FROM promotypes WHERE id = '$promo'";
	return execute($sql);
}

function get_promo_type_by_campaing_name($type,$camp_id,$name = "",$mailers =""){	
	affiliate_db();
	if ($name != "" ){
		$sql_where = " AND name LIKE '%". $name ."'";	
	}
	else { $sql_where = " LIMIT $mailers,1 "; }
	
	
	$sql = "SELECT * FROM promotypes WHERE type = '".$type."' AND idcampaigne = '" . $camp_id . "' $sql_where ";	
	return get($sql,"_promo_type");
}

function get_all_same_size_banners_affilaites($campaign, $size){
	affiliate_db();
	$sql = "SELECT * FROM `promotypes`  WHERE idcampaigne = '$campaign' AND name LIKE '%_$size.%' AND type = 'b'";
	return get($sql,"_promo_type");
}

function get_personal_promos_affiliate($aff_id,$type = ""){
	affiliate_db();
	if ($type != ""){ $sqltype = " and type = '".$type."' ";}
	$sql = "SELECT * FROM promotypes WHERE (name LIKE '%_-_".$aff_id."_-_%' OR name LIKE '%_-_all_-_%') AND idcampaigne = -1 $sqltype ORDER BY id DESC";
	return get($sql,"_promo_type");
}


function get_affiliate_news($id= ""){	
	affiliate_db();
	$sql_where = "";
	$rows = false;
	if ($id != "") { 
		$sql_where = " AND id = '$id'";
		$rows = true;
	}
	$sql = "SELECT * FROM news WHERE 1 $sql_where ";	
	return get($sql,"_affiliate_news",$rows);
}

function get_all_endorsement_default_affiliate(){
	affiliate_db();
	$sql = "SELECT * FROM endorsements_default where idbook <> 7";
	return get($sql,"_endorsements_default");
}

function get_endorsement_default_affiliate($id){
	affiliate_db();
	$sql = "SELECT * FROM endorsements_default where id = '".$id."'";
	return get($sql,"_endorsements_default",true);
}

function get_all_testimonials_affiliate(){
	affiliate_db();
	$sql = "SELECT * FROM testimonials";
	return get($sql,"_affiliate_testimonial");
}

function get_testimonials_affiliate($id){
	affiliate_db();
	$sql = "SELECT * FROM testimonials where id = '".$id."'";
	return get($sql,"_affiliate_testimonial",true);
}


function get_trends_league($league = ""){
	if($league == ""){$league = "-1";}
	if($league != "-1"){$sql_le = " AND sport = '$league' ";}
	inspinc_statsdb1();

	$sql = "SELECT juice, win FROM trends_feed WHERE juice != 0 AND juice != '' $sql_le ";
	return get_str($sql);
}

function get_trends_feeds_by_id($id){
	inspinc_statsdb1();

	$sql = "SELECT id, gameid, selected, juice, win FROM trends_feed WHERE id = '".$id."'";
	return get($sql,"_trends_feed", true);
}

function get_all_trends_feeds($perc_get,$games_get,$from_date = "" ,$to_date = "",$league_get = "",$show_selected = "", $limit = false,$start = "",$end = ""){
	inspinc_statsdb1();
	
	$sql_select = " b.id ";
	if($from_date != ""){$sql_from_date = " AND DATE(b.game_date) >= DATE('$from_date')";}
	if($to_date != ""){$sql_to_date = " AND DATE(b.game_date) <= DATE('$to_date')";}
	if($league_get != "" && $league_get != "all"){$sql_league = " AND a.sport = '$league_get' ";}
	if($show_selected){$sql_sel = " AND selected = 1 ";}
	
	if ($limit){
		$sql_limit = " LIMIT " . ($start-1)*$end .",".$end." "; 
		$sql_select = " b.id, b.description, a.win_percentage, b.team_away, b.team_home, a.total, b.game_date, b.selected, b.juice, b.win ";
	}

	$sql = "SELECT $sql_select  FROM trends_win_percentages as a, trends_feed as b
	WHERE a.id = b.id AND a.win_percentage > $perc_get AND a.total >= $games_get 
	$sql_from_date $sql_to_date $sql_sel $sql_league
	ORDER BY a.win_percentage DESC, a.total DESC $sql_limit";	
	
	return get($sql,"_trends_feed");
}


//balance sheet
function get_adjusted_balances($type, $system){
	accounting_db();
	$sql = "SELECT * FROM adjusted_balances WHERE type = '$type' AND `system` = '$system'";
	return get($sql, "_balace_adjust", false, "account");
}
function get_adjusted_balance($type, $system, $account){
	accounting_db();
	$sql = "SELECT * FROM adjusted_balances WHERE type = '$type' AND `system` = '$system' AND account = '$account'";
	return get($sql, "_balace_adjust", true);
}

//affiliate forgot pass
function get_affiliate_by_email($email){
	affiliate_db();
	$sql = "SELECT * FROM affiliates WHERE email = '$email'";
	return get($sql, "_affiliate", true);
}

//live help
function get_closed_chats_by_date($from, $to){
	livehelp_db();
	$sql = "SELECT u.name as clerk, d.name as dep, formatted, c.created as cdate, from_screen_name as customer
	FROM `chattranscripts` as c, chat_admin as u, chatdepartments as d 
	WHERE c.userID = u.userID AND d.deptID = c.deptID AND c.created >= '".strtotime($from)."' AND c.created <= '".strtotime($to)."'
	ORDER BY c.created DESC";
	return get_str($sql);
}
function get_live_chats_info(){
	livehelp_db();
	$sql = "SELECT c.sessionID as session, u.name as clerk, d.name as dep, c.created as cdate, from_screen_name as customer
	FROM `chatrequests` as c, chat_admin as u, chatdepartments as d 
	WHERE c.userID = u.userID AND d.deptID = c.deptID ORDER BY sessionID DESC";
	return get_str($sql);
}

function get_live_help_departments(){
	livehelp_db();
	$sql = "SELECT * FROM chatdepartments WHERE use_in_tickets = 1 ORDER BY sort_order ASC";
	return get($sql, "_live_help_department");
}

function get_live_help_department($id){
	livehelp_db();
	$sql = "SELECT * FROM chatdepartments WHERE deptID = '$id'";
	return get($sql, "_live_help_department", true);
}

//Emails
function get_accounts_hosts(){
	mail_db();
	$sql = "SELECT DISTINCT SUBSTRING(name,POSITION('@' IN name)+1) as id, 
	SUBSTRING(name,POSITION('@' IN name)+1) as label  FROM `account`";
	return get_str($sql);
}
function count_available_emails_accounts(){
	mail_db();
	$sql = "SELECT COUNT(*) as num FROM `account` WHERE enable = 1";
	return get_str($sql,true);
}
function get_available_emails_accounts($position, $block){
	mail_db();
	$sql = "SELECT * FROM `account` WHERE enable = 1 ORDER BY name ASC LIMIT $position , $block";
	return get($sql,"_email_account");
}
function get_account_pointer(){
	mail_db();
	$sql = "SELECT * FROM `pointer` LIMIT 0,1";
	return get($sql,"_email_pointer", true);
}
function get_emails_by_date($from, $to, $host){
	mail_db();
	$sql = "SELECT e.* FROM `email` as e, account as a WHERE DATE(edate) >= DATE('$from') && DATE(edate) <= DATE('$to') AND subject NOT LIKE '%RE:%'
	AND a.id = e.account AND a.name LIKE '%@$host%' ORDER BY edate DESC";
	return get($sql,"_email_message");
}
function get_email_replys($parent){
	mail_db();
	$tos = explode(",",$parent->vars["to_address"]);
	$sql_tos = "";
	foreach($tos as $to){
		$sql_tos .= " OR from_address LIKE '%".trim($to)."%' ";
	}
	$sql = "SELECT * FROM `email` WHERE ( account = '".$parent->vars["account"]."'  $sql_tos )
	AND subject LIKE '%RE:%' AND subject LIKE '%".$parent->vars["subject"]."%'
	AND DATE(edate) >= DATE('".$parent->vars["edate"]."') ORDER BY edate DESC";
	return get($sql,"_email_message");
}


// Baseball App

function get_baseball_schedule_app($date){
	baseball_db();
	$sql = "Select  g.id as gameid, g.startdate, 
	(select CONCAT_WS('_',espn_team,espn_small_name) from stadium  s where g.team_away = s.team_id) as away, 
	(select CONCAT_WS('_',espn_team,espn_small_name)  from stadium  s where g.team_home = s.team_id) as home, 
	(select CONCAT_WS('_',s.name,s.zip_code) from stadium  s where g.team_home = s.team_id) as stadium,
	(select CONCAT_WS('_',p.espn_nick,p.image) from player  p where g.pitcher_away = p.fangraphs_player) as pitcher_away,
	(select CONCAT_WS('_',p.espn_nick,p.image) from player  p where g.pitcher_home = p.fangraphs_player) as pitcher_home
	from  game g where DATE(g.startdate) = '".$date."'";
	return get_str($sql);	
	
}

function get_baseball_game_weather_app($str_game,$stardate){
	baseball_db();
	if (date("Y-m-d")> $stardate){
		$table = "weather";
	}
	else{
		$table = "temp_weather";
	}
	$sql = " select * from  ".$table."  where  game IN (".$str_game.")  group by game order by  added_date DESC";

	return get_str($sql, false,"game");
}


//Baseball

function get_baseball_stadium_custom_fields($fields,$index){
	baseball_db();
	$sql = "Select $fields from stadium";
	//echo $sql; exit;
	return get_str($sql,false,$index);	
	
}

function get_baseball_game_bet_by_date($date){
	baseball_db();
	$sql = "SELECT DISTINCT game  FROM bets WHERE date = '".$date."'";
  //echo $sql;
	return get_str($sql,false,'game');
}

function get_baseball_game_bet($date){
	baseball_db();
	$sql = "SELECT *  FROM bets WHERE game = '".$idgame."' AND line_type = '".$type."' AND source = '".$source."'";

	return get($sql,"_baseball_bet",true);
}

function get_baseball_game_bets($idgame){
	baseball_db();
	$sql = "SELECT *  FROM bets WHERE game = '".$idgame."'";
  return get($sql,"_baseball_bet");
}

function get_baseball_bets($date){
	baseball_db();
	$sql = "SELECT *  FROM bets WHERE date = '".$date."'";
	return get($sql,"_baseball_bet",false,"game");
}


function get_baseball_pitchers_vs_catchers($type,$date){
	baseball_db();
	if($type == "a"){
		$sql = "select CONCAT_WS('_',g.pitcher_away,g.catcher_home) as 'control' , count(*) as 'total' from game g where DATE(startdate) > '".$date."' and catcher_home != -1 GROUP BY pitcher_away,catcher_home order by pitcher_away";
	}
	if($type == "h"){
		$sql = "select CONCAT_WS('_',g.pitcher_home,g.catcher_away) as 'control' , count(*) as 'total' from game g where DATE(startdate) > '".$date."' and catcher_away != -1  GROUP BY pitcher_home,catcher_away order by pitcher_home";
	}

	return get_str($sql,false,"control");
	
}


function get_baseball_stats($date){
	baseball_db();
	$sql = "SELECT *  FROM baseball_stats WHERE date = '".$date."'";
	return get($sql,"_baseball_stats",true);
}

function get_all_baseball_stats($date1,$date2,$pk1 , $pk2,$ump1,$ump2){
	baseball_db();
	$sql = "SELECT *  FROM baseball_stats WHERE date >= '".$date1."' and  date <= '".$date2."' and (pk_avg >= '".$pk1."' and  pk_avg <= '".$pk2."') and (ump_weighted_avg >= '".$ump1."' and  ump_weighted_avg <= '".$ump2."') order by date";
	
	return get($sql,"_baseball_stats",false,"date");
}


function get_all_baseball_column_description(){
	baseball_db();
	$sql = "SELECT *  FROM columns_description";
	return get_str($sql,false,"column");
}

function get_baseball_column_description($column){
	baseball_db();
	$sql = "SELECT *  FROM columns_description cd where cd.column = '".$column."' ";
	//echo $sql;
	return get($sql, "_baseball_columns_description",true);
}

function get_baseball_season($year){
	baseball_db();
	$sql = "SELECT *  FROM `season` WHERE season = '$year'";
	return get_str($sql,true);
}

function get_all_baseball_seasons(){
	baseball_db();
	$sql = "SELECT *  FROM `season` Order by season DESC";
	return get_str($sql);
}


function get_baseball_games_by_date($today){
	baseball_db();
	$sql = "SELECT g.*,t.team_name as away,td.team_name as home FROM game g
	inner join  stadium t on g.team_away = t.team_id 
	inner join stadium td on g.team_home = td.team_id 
	WHERE DATE(startdate) = '$today' ORDER BY away_rotation ASC";
	return get($sql, "_baseball_game");
}

function get_all_baseball_games_by_team($team,$year="",$start="",$end=""){
	baseball_db();
	
	if($year != ""){
		
		$str_sql = " and g.startdate > '".$start."' and g.startdate < '".$end."' ";
	}
	
	$sql = "SELECT g.*,t.team_name as away,td.team_name as home FROM game g
	inner join  stadium t on g.team_away = t.team_id 
	inner join stadium td on g.team_home = td.team_id 
	WHERE g.team_home = '$team' and postponed = 0 $str_sql ORDER BY startdate ASC";
	return get($sql, "_baseball_game");
}

function get_all_baseball_games_by_player($player,$year="",$start="",$end=""){
	baseball_db();
	
	if($year != ""){
		
		$str_sql = " and g.startdate > '".$start."' and g.startdate < '".$end."' ";
	}
	
	$sql = "SELECT g.*,t.team_name as away,td.team_name as home FROM game g
	inner join  stadium t on g.team_away = t.team_id 
	inner join stadium td on g.team_home = td.team_id 
	WHERE (g.pitcher_away = '".$player."'  OR g.pitcher_home = '".$player."' )
	and postponed = 0 $str_sql ORDER BY startdate ASC";
	
	return get($sql, "_baseball_game");
}

function get_basic_baseball_games_by_date_fix(){
	baseball_db();
	$sql = "SELECT * FROM game 
	WHERE team_home = 50 AND DATE(startdate) > '2014-09-16' AND DATE(startdate) < '2014-12-12'  ORDER BY startdate ASC";
	return get($sql, "_baseball_game");
}

function get_basic_baseball_games_by_date($today,$post = false){
	baseball_db();
	if($post){ $sql_post  = ' AND postponed	= 0 ';}
	$sql = "SELECT * FROM game 
	WHERE DATE(startdate) = '$today' $sql_post ORDER BY startdate ASC";

	return get($sql, "_baseball_game");
}



function get_baseball_game($gid,$row = true){
	baseball_db();
	$sql = "SELECT * FROM game WHERE id = '$gid'";
	
	return get($sql, "_baseball_game", $row);
}

function get_count_baseball_games_by_date($today){
	baseball_db();
	$sql = "SELECT COUNT(*) as games FROM `game` WHERE DATE(startdate) = '$today'";
	return get_str($sql,true);
}


function get_baseball_games_without_pitcher($start,$date){
	baseball_db();	
	$sql="SELECT * FROM `game` WHERE (DATE(startdate) > '".$start."' && DATE(startdate) < '".$date."' ) and postponed = 0 and (CHARACTER_LENGTH(pitcher_away) =  1 OR CHARACTER_LENGTH(pitcher_home) = 1)";	
	echo $sql;
	return get($sql, "_baseball_game");	
}


function get_baseball_games_without_weather($date = '2022-04-01'){
	baseball_db();	
	$sql="SELECT * FROM game  WHERE (id in (SELECT game
	FROM `weather` WHERE `temp` = 0.00) || id NOT IN (select game from weather)) and DATE(startdate) > '".$date."' and DATE(startdate) < '".date("Y-m-d")."' and espn_game != 0 ORDER BY RAND() LIMIT 5 ";
	//echo $sql."<BR>";
	return get($sql, "_baseball_game");	
} 


function get_baseball_games_without_espn_game($date){
	baseball_db();	
	$sql="SELECT * FROM game  WHERE  DATE(startdate) >= '".$date."' and DATE(startdate) <= '".$date."' and espn_game = 0 ";
	return get($sql, "_baseball_game");	
}

/*function get_baseball_games_by_date($today){
	sbo_sports_db();
	$sql = "SELECT g.*,concat_ws(' ',t.name,t.nick) as away,concat_ws(' ',td.name,td.nick) as home FROM games g
			inner join teams t on g.team_away = t.id 
			inner join teams td on g.team_home = td.id 
			WHERE g.league = 'mlb' and DATE(startdate) = '$today'";
	return get($sql, "_baseball_game");
}

function get_count_baseball_games_by_date($today){
	sbo_sports_db();
	$sql = "SELECT COUNT(*) as games FROM `games` WHERE league = 'mlb' and DATE(startdate) = '$today'";
	return get_str($sql,true);
}

function get_baseball_team($idteam){
	sbo_sports_db();
    $sql = "SELECT id,name,first,nick FROM `teams` WHERE id = ".$idteam."";
	return get($sql, "_baseball_team", true);
}*/

function get_baseball_espn_player_stadium($player,$stadium){
	baseball_db();
	$sql = "SELECT *  FROM `espn_player_stadium` WHERE espn_player = ".$player." And id_stadium = ".$stadium."";
	return get($sql,"_baseball_espn_player_stadium",true);
}

function get_baseball_espn_player_year_data($player,$year){
	baseball_db();
	$sql = "SELECT *  FROM `espn_player_year_data` WHERE espn_player = ".$player." And year = ".$year."";
	return get($sql,"_baseball_espn_player_year_data",true);
}
function get_all_baseball_espn_player_year_data($player,$years){
	baseball_db();
	$year = date("Y")- $years;
	$sql = "SELECT *  FROM `espn_player_year_data` WHERE espn_player = ".$player." And year >= ".$year." and year != ".date("Y")." ";
	return get_str($sql);
}


function get_baseball_espn_pitcher_batter($player,$player2){
	baseball_db();
	$sql = "SELECT *  FROM `espn_pitcher_batter` WHERE espn_player1 = ".$player." And espn_player2 = ".$player2."";
	return get($sql,"_baseball_espn_pitcher_batter",true);
}

function get_baseball_espn_pitcher_batter_vs($player,$team){
	baseball_db();
	$sql = "SELECT p.player,p.image, ep.*  FROM `espn_pitcher_batter` ep, player  p WHERE espn_player1 = ".$player." And ep.espn_team = ".$team." and ep.espn_player2 = p.espn_player and ep.espn_team = p.espn_team";
	return get($sql,"_baseball_espn_pitcher_batter");
}


function get_baseball_stadium_by_team($idstadium){
	baseball_db();
	$sql = "SELECT * FROM `stadium` WHERE team_id = ".$idstadium."";
	return get($sql,"_baseball_stadium",true);
}

function get_baseball_stadium_parkfactor_season($idstadium,$season){
	baseball_db();
	$sql = "SELECT * FROM `stadium_parkfactor_season` WHERE stadium = ".$idstadium." AND season = ".$season."";
	return get($sql,"_baseball_stadium_parkfactor_season",true);
}

function get_baseball_stadium_parkfactor_season_data($season){
	baseball_db();
	$sql = "SELECT *, CONCAT_WS('_',stadium,season) as 'control' FROM `stadium_parkfactor_season` WHERE  season < ".$season." and season >= ".($season-3)."";

	return get($sql,"_baseball_stadium_parkfactor_season",false,'control');
}

function get_baseball_stadium_custom($data,$field){
	baseball_db();
	$sql = "SELECT * FROM `stadium` WHERE $field = '".$data."'";
	return get($sql,"_baseball_stadium",true);
}

function get_all_baseball_stadium_custom($index){
	baseball_db();
	$sql = "SELECT * FROM `stadium`";
	return get($sql,"_baseball_stadium",false,$index);
}

function get_all_baseball_team_speed($date,$index){
	baseball_db();
	$sql = "SELECT *, CONCAT_WS('_',date,team) as 'control'  FROM team_speed where date = '".$date."'";
	return get($sql,"_baseball_team_speed",false,$index);
}

function get_baseball_stadium_by_name($stadium,$fields = ""){
	baseball_db();
	$sql_field = " * ";
	if ( $field != ""){ $sql_field = $fields; } 
	$sql = "SELECT $sql_field  FROM `stadium` WHERE espn_name Like '%".$stadium."%'";
	return get($sql,"_baseball_stadium",true);
}

function get_baseball_stadium($sid){
	baseball_db();
	$sql = "SELECT * FROM `stadium` WHERE id = ".$sid."";
	return get($sql,"_baseball_stadium",true);
}

function get_all_baseball_stadiums($domed = false){
	baseball_db();
	if ($domed){ $sql_domed = " and has_roof > 0 "; }
	$sql = "SELECT * FROM `stadium` WHERE 1 $sql_domed";
	return get($sql,"_baseball_stadium");
}

function get_all_stadium_wind_avg(){
	baseball_db();
	$sql="select *,CONCAT_WS('_',stadium,wind) as 'wind_key' from stadium_wind_avg";
	return get($sql,"_stadium_wind_avg",false,"wind_key");
}



function get_all_stadium_dewpoint_avg(){
	baseball_db();
	$sql="select * from stadium_dewpoint_avg";
	return get($sql,"_stadium_dewpoint_avg",false,"stadium");
}

function get_stadium_wind_data($stadium){
	baseball_db();
	$sql="select * from stadium_wind_avg where stadium = '".$stadium."'";
	return get($sql,"_stadium_wind_avg");
}

function get_all_stadium_formula_data(){
	baseball_db();
	$sql="select * from stadium_formula_data";
	return get($sql,"_baseball_stadium_formula_data",false,"id_stadium");

}


function get_baseball_stadium_stadistics($stadium,$gameid){
	baseball_db();
	$sql = "SELECT  *  FROM stadium_stadistics_by_game WHERE  stadium = '".$stadium."' and game = '".$gameid."'";
	return get($sql,"_baseball_stadium_stadistics_by_game",true);
}

function get_baseball_stadium_position($wind,$stadium){
	baseball_db();	
	$sql = "SELECT sp.id,sp.position FROM stadium_wind_position st,stadium_position sp WHERE
	st.wind_direction in (Select id from wind_direction wd WHERE direction = '".$wind."' )and
	st.stadium_position = sp.id and stadium = ".$stadium."";

	return get_str($sql,true);		
}

function get_baseball_wind_direction(){
	baseball_db();	
	$sql = "SELECT * FROM wind_direction";
	return get_str($sql);		
}

function get_all_baseball_stadium_position(){
	baseball_db();
	$sql = "SELECT id,position FROM `stadium_position`";
	return get($sql,"_baseball_stadium_position",false,"id");
}



function get_baseball_team($team){
	baseball_db();
	$sql = "SELECT id, team_id,fangraphs_team,team_name,espn_id_name,espn_nick,mlb_nick,espn_small_name,espn_team,`rank`,wfb FROM `stadium` WHERE team_id = ".$team."";
	return get($sql,"_baseball_stadium",true);
}

function get_all_baseball_team(){
	baseball_db();
	$sql = "SELECT id, team_id, fangraphs_team, team_name,espn_nick,mlb_nick FROM `stadium`";
	return get_str($sql);
}

function get_baseball_player_by_id($field,$player){
	baseball_db();
	$sql = "SELECT * FROM `player` WHERE $field = '".$player."'";
	
	return get($sql,"_baseball_player",true);
}


function get_baseball_player_max_data($player){
	baseball_db();
	$sql = "select p.player , max(pg.total_last_game) as last_one, max(pg.sum_last_two_games) as last_two, max(pg.sum_last_games) as last_three, max(pg.sum_last_four_games) as last_four, max(pg.sum_last_five_games) as last_five from player p, player_stadistics_by_game pg 
	where p.fangraphs_player = pg.fangraphs_player and p.fangraphs_player = ".$player."";
	return get_str($sql,true);
}

function get_baseball_player_highest_pitches($player){
	baseball_db();
	$sql = "SELECT max(total_last_game) as pitch_count FROM `player_stadistics_by_game` WHERE  fangraphs_player = '".$player."'";
	return get_str($sql,true);
}



function get_baseball_player_by_team($field,$player,$team,$season, $type = ""){
	baseball_db();
	$sql_type ="";
	if($type != "" ){ $sql_type = " And p.type = '".$type."' "; }
	$sql = "SELECT * FROM player p, player_teams pt WHERE $field LIKE '%".$player."%' and 
	p.fangraphs_player = pt.player and pt.season = '".$season."' and pt.team = ".$team." $sql_type";
	//echo $sql."<BR>";
	return get($sql,"_baseball_player",true);
}

function get_baseball_player_by_type($type){
	baseball_db();
	$sql = "SELECT * FROM player p WHERE type = '".$type."' Order by player ASC"; 
	return get($sql,"_baseball_player");
}

function get_all_baseball_player_by_team($team,$season){
	baseball_db();
	$sql = "SELECT p.fangraphs_player, p.espn_nick FROM player_teams pt,player p WHERE p.fangraphs_player = pt.player and team = '".$team."' and season = '".$season."' order by p.espn_nick asc";
	return get($sql,"_baseball_player");
}

function get_baseball_player_by_espn_nick($nick){
	baseball_db();
	$sql = "SELECT * FROM  player p WHERE  p.espn_nick like '%".$nick."%'";
	return get($sql,"_baseball_player",true);
}

function get_baseball_player_espn_nick($espn_id){
	baseball_db();
	$sql = "SELECT espn_nick,fangraphs_player FROM  player p WHERE  p.espn_player = $espn_id";
	//echo $sql;
	return get_str($sql,true);
}


function get_baseball_player_by_name($player){
	baseball_db();
	$sql = "SELECT * FROM  player p WHERE  p.player like '%".$player."%' order by fangraphs_player DESC";
	return get($sql,"_baseball_player",false); // return all the  player with that name
}


function get_baseball_espn_player_data($player){
	baseball_db();
	$sql = "SELECT * FROM  espn_player_data p WHERE  p.espn_player = ".$player."";
	
	return get($sql,"_baseball_espn_player_data",true); 
}


function get_all_baseball_players($index){
	baseball_db();
	$sql = "SELECT *  FROM `player`";
	return get($sql,"_baseball_player",false,$index);
}

function get_all_baseball_players_espn(){
	baseball_db();
	$sql = "SELECT *  FROM `player` where image = 'no_image'  ORDER BY RAND() LIMIT 50  ";
	return get($sql,"_baseball_player");
}


function get_players_by_date($date,$field){
	baseball_db();
	$sql = "SELECT *  FROM player where espn_player != 0 and fangraphs_player IN (select pitcher_$field from game where DATE(startdate) = '".$date."' )";
	return get($sql,"_baseball_player");
}

function get_players_by_date_pending_update($date,$field,$type){
	baseball_db();
	/*$sql = "SELECT *,
	(select id from game where DATE(startdate) = '".$date."' and (pitcher_$field = fangraphs_player ) ) as game
	FROM player where espn_player != 0 and fangraphs_player IN (select pitcher_$field from game where DATE(startdate) = '".$date."' )
	And fangraphs_player NOT IN (Select player from player_updated where date = '".$date."' and type = '".$type."')  ORDER BY RAND() LIMIT 1; 	";
	echo $sql."<BR><BR>";
	*/
   $sql = "SELECT *,
	 (select id from game where DATE(startdate) = '".$date."' and (pitcher_$field = fangraphs_player ) ) as game
	  FROM player where espn_player != 0 and fangraphs_player IN (select pitcher_$field from game where DATE(startdate) = '".$date."' )
	  And fangraphs_player NOT IN (Select player from player_updated where date = '".$date."' and type = '".$type."')   LIMIT 20; 	"; 
	echo $sql."<BR><BR>";
	  return get($sql,"_baseball_player");
	}


	function update_baseball_player_data($gameid,$season,$restday,$t_lastgame,$avg_lastgames,$sum_lastgames,$avg_season,$avg_fourgames,$sum_lastfourgames,$avg_lastfivegames,$sum_lastfivegames){			   
		baseball_db();		   
		$sql =  "UPDATE player_stadistics_by_game SET `season` = '".$season."', `rest_time` = '".$restday."', `total_last_game` = '".$t_lastgame."', `avg_last_games` = '".$avg_lastgames."', `sum_last_games` = '".$sum_lastgames."', `avg_season` = '".$avg_season."', `avg_last_four_games` = '".$avg_fourgames."', `sum_last_four_games` = '".$sum_lastfourgames."', `avg_last_five_games` = '".$avg_lastfivegames."', `sum_last_five_games` = '".$sum_lastfivegames."' WHERE game = '".$gameid."'"; 
		execute($sql); 
	}

	function get_baseball_all_duplicated_players(){
		baseball_db();
		$sql = "SELECT id, p.fangraphs_player,p.player, count( player ) AS count FROM player p GROUP BY player
		HAVING count >1 ORDER BY player ASC";
		return get_str($sql);
	}


	function get_player_basic_stadistics($player,$year,$data=false,$gameid=""){
		baseball_db();

	 //if ($gameid!=""){
		$sql_game = " and game = '".$gameid."'"; 
	// } 

		if ($data){
			$avg_last_season = ",(Select max(avg_season) from `player_stadistics_by_game` WHERE fangraphs_player = '".$player."' and season = '".($year-1)."' and game = '0' ) as last_season";	
		}
		else{
			$avg_last_season ="";	
		}

		$sql = "SELECT  * $avg_last_season FROM player_stadistics_by_game  WHERE  fangraphs_player = '".$player."' and season = '".$year."' $sql_game ";

	//echo $sql."<BR>";
		return get($sql,"_baseball_player_stadistics_by_game",true);
	}



	function get_baseball_scores_ten($team,$field,$date){
		baseball_db();
		$date1 = date ('Y-m-d',strtotime ( '-2 day' , strtotime ($date))) ;	
		
		if ($field == "home"){
			$runs="away";
		}
		else{
			$runs="home";	
		}

		$sql = "select 'YES' as lose_ten from game where team_".$field." = ".$team."  and startdate < '".$date." 00:00:01' and startdate > '".$date1." 23:59:00' and ((runs_".$runs." - runs_".$field.")>=10)";
	//echo $sql."<BR>";
		return get_str($sql,true);
	}



	function get_baseball_firstbase($team_away,$team_home,$date){
		baseball_db();
		$sql = "select firstbase,runs_away,runs_home from game where team_away = ".$team_away." and team_home = ".$team_home." and startdate > '".$date." 00:00:01' and startdate < '".$date." 23:59:00'";
		return get_str($sql,true);
	}

	function get_pitcher_faceoff_team($team,$pitcher,$date){
		baseball_db();

		$sql = "SELECT espn_game from game g where  g.startdate > (DATE_SUB('".$date."', INTERVAL 10 day))
		AND g.startdate < '".$date."' AND team_away = '".$team."' and pitcher_home = '".$pitcher."'"
		;
		$home = get_str($sql);

		$sql = "SELECT espn_game from game g where  g.startdate > (DATE_SUB('".$date."', INTERVAL 10 day))
		AND g.startdate < '".$date."' AND team_home = '".$team."' and pitcher_away = '".$pitcher."'";

		$data = get_str($sql);

		if(!empty($home)){
			$data = array_merge($home,$data);
		}

		return $data;
	}

	function get_game_umpire_by_name($umpire,$field = "espn_name" ){
		baseball_db();
		$sql = "SELECT id  FROM `umpire` WHERE $field LIKE '%$umpire%'";
		return get($sql,"_baseball_umpire",true);
	}

	function get_umpire_year_stadistics(){
		baseball_db();
		$sql = "select DISTINCT year from umpire_stadistics order by year asc ";
		return get_str($sql);
	}


	function get_all_baseball_umpires($index="full_name"){
		baseball_db();
		$sql = "SELECT *  FROM `umpire`";
		return get($sql,"_baseball_umpire",false,$index);
	}
//

	function get_all_baseball_umpires_data_index(){
		baseball_db();
		$sql = "SELECT CONCAT_WS('_',umpire,year) as ump_year, (hw+rw)as starts , k_bb FROM  umpire_stadistics";
		return get_str($sql,false,"ump_year");
	}



	function get_umpire_name_by_id($umpire){
		if(!empty($umpire)){
		baseball_db();
		$sql = "SELECT full_name FROM `umpire` WHERE id = ".$umpire."";
		return get_str($sql,true);
	  }
	}

	function get_all_umpires(){
		baseball_db();
		$sql = "SELECT u.id,UPPER(u.full_name) as umpire, rating   FROM  umpire u order by umpire asc";
		return get($sql,"_baseball_umpire",false,'id');
	}

	function get_baseball_umpires_data($umpire){
		baseball_db();
		$sql = "SELECT * FROM  umpire_data where umpire = '".$umpire."'";
		return get($sql,"_baseball_umpire_data",true);
	}

	function get_all_umpire_data(){
		baseball_db();
		$sql = "SELECT * FROM  umpire_data ";
		return get_str($sql,false,"umpire");
	}




	function get_umpire_stadistics($umpire,$year){
		baseball_db();
		$sqlyear = " us.year IN ( ";
		for ($i=0;$i<6;$i++){
			$sqlyear .= ($year-$i).",";
		}
		$sqlyear = substr($sqlyear,0,-1);
		$sqlyear .= ") and ";
		$sql = "SELECT u.full_name , us.* FROM umpire_stadistics us, umpire u WHERE $sqlyear u.id =  us.umpire  and us.umpire = ".$umpire."";
		return get($sql,"_baseball_umpire",false,'year');
	}

	function get_umpire_basic_stadistics($umpire,$year){
		baseball_db();
		$sql = "SELECT  us.* FROM umpire_stadistics us  WHERE us.year = ".$year."  and us.umpire = ".$umpire."";
		return get($sql,"_baseball_umpire_stadistics",true);
	}

	function get_team_lastgames($team,$today,$field,$day){
		baseball_db();
		$pastdate = date ('Y-m-d',strtotime ( "-".$day." day" , strtotime ($today))) ;
		$sql = "SELECT espn_game FROM `game` WHERE team_".$field." = '".$team."' and startdate > '".$pastdate." 00:00:01' and startdate < '".$today." 00:00:01'";
	//echo $sql."<BR>";
		return get_str($sql);
	}

	function get_team_bullpen($team,$date,$days){
		baseball_db();
		$sql = "SELECT  * FROM team_bullpen  WHERE team = '".$team."'  and date = '".$date."' and days = ".$days."";
		return get($sql,"_baseball_team_bullpen",true);
	}

	function get_all_bullpen_team_by_dates($from,$to){
		baseball_db();
		$sql = "Select CONCAT_WS('_',date,team) as team_date, team,ip,pc from team_bullpen  tb  where date >= '".$from."' and date <='".$to."' and days = 3";
		return get_str($sql, false, "team_date");
	}

	function get_team_bullpen_season($team,$start_season,$today){
		baseball_db();
		$sql = "SELECT SUM(tp.ip) as IP , SUM(tp.pc) as PC FROM team_bullpen tp  WHERE tp.team = '".$team."' and    tp.days = 1 and ( tp.date >= '".$start_season."' && tp.date <= '".$today."')";
 //echo $sql."<BR>" ;
		return get_str($sql,true);
	}

	function delete_temp_weather($today){
		baseball_db();
		$table="temp_weather";
		$where= " DATE(date) < '$today'";
		return delete($table,"", $where);
	}

	function get_pivot_baseball_game(){
		baseball_db();
		$sql = "SELECT *  FROM `pivot_game` LIMIT 1";
		return get($sql, "_pivot_game", true);
	}

	function get_limited_baseball_games_by_date($today,$begin,$max){
		baseball_db();
	//sbo_sports_db();
	//$sql = "SELECT * FROM `games` WHERE league = 'mlb' and DATE(startdate) = '$today' LIMIT ".$begin.",".$max."";
		$sql = "SELECT * FROM `game` WHERE DATE(startdate) = '$today' LIMIT ".$begin.",".$max."";
		return get($sql, "_baseball_game");
	}

	function get_baseball_game_weather($game,$stardate){
		baseball_db();
		if (date("Y-m-d")> $stardate){
			$table = "weather";
		}
		else{
			$table = "temp_weather";
		}
		$sql = " select * from  ".$table."  where id in (SELECT MAX(id) FROM ".$table." WHERE game = ".$game.")";

	//echo $sql."<BR>";
		return get($sql, "_baseball_weather", true);
	}





	function get_adjustment_factors($position){
		if(!empty($position)){
		baseball_db();	
		$sql = "SELECT * FROM `adjustment_factors` WHERE position = ".$position."";
		return get_str($sql,true);
	 }
	}

	function get_baseball_constants(){
		baseball_db();	
		$sql = "SELECT * FROM `constants`";
		return get_str($sql);
	}

	function get_sbo_team_line($team,$date){
		sbo_liveodds_db();
		$sql = "select * from team_totals_line where team = '".$team."' and line_date = '".$date."'";
		return get_str($sql,true);
	}

//--baseball reports

	function get_baseball_games_weather_stadium($field,$team_home,$date_start,$date_end,$order="ASC",$indoors=""){
		baseball_db();	

		$sql_indoors ="";
		if ($indoors){
			$sql_indoors = " and real_roof_open = 1";	
		}

		$sql="SELECT s.team_name, g.id,g.startdate, g.team_away, g.".$field.", (g.homeruns_away + g.homeruns_home) as homeruns, (g.runs_away + g.runs_home) as runs FROM game g, stadium s WHERE g.team_home = s.team_id and g.team_home = '".$team_home."' and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0 $sql_indoors order by ".$field." $order LIMIT 10";
		return get($sql, "_baseball_game");	
	}

	function get_baseball_avg_data_stadium($field, $team_home,$date_start,$date_end,$indoors=""){
		baseball_db();

		$sql_indoors ="";
		if ($indoors){
			$sql_indoors = " and real_roof_open = 1";	
		}
		
		$sql="SELECT AVG(".$field.") as avg_".$field.", AVG((g.homeruns_away + g.homeruns_home)) as avg_homeruns, AVG((g.runs_away + g.runs_home)) as avg_runs FROM game g, stadium s WHERE g.team_home = s.team_id and g.team_home = '".$team_home."'
		and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0 $sql_indoors ";
		return get($sql, "_baseball_game");	
	}





	function get_baseball_games_temp_facts_stadium($field,$team_home,$date_start,$date_end,$order="ASC",$indoors="", $pk =""){
		baseball_db();




		$sql_indoors ="";
		if ($indoors){
			$sql_indoors = " and real_roof_open = 1";	
		}
		$sql_pk ="";
		if ($pk != ""){
			$sql_pk = " and pk >= ".$pk."";	
		}
		
		$sql="SELECT  s.team_name, g.id,g.startdate, g.team_away, g.team_home, g.away_rotation, w.".$field.", (g.homeruns_away + g.homeruns_home) as homeruns, (g.runs_away + g.runs_home) as runs, g.pk FROM game g, stadium s,weather w WHERE w.game = g.id and g.team_home = s.team_id and g.team_home = '".$team_home."' and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0  $sql_indoors $sql_pk  order by ".$field." $order LIMIT 10";

 //echo $sql;

		return get($sql, "_baseball_game");	
	}


	function get_baseball_games_dommed_stadium($team_home,$date_start,$date_end,$indoors=0){
		baseball_db();	

		$sql_indoors ="";
		if ($team_home == 37){$indoors=false;}
		if ($indoors){
			$sql_indoors = " and real_roof_open = 1";	
		}else { $sql_indoors = " and real_roof_open = 0";	 }

		$sql="SELECT s.team_name, g.id,g.startdate, g.team_away, (g.homeruns_away + g.homeruns_home) as homeruns, (g.runs_away + g.runs_home) as runs FROM game g, stadium s WHERE g.team_home = s.team_id and g.team_home = '".$team_home."' and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0 $sql_indoors";
		return get($sql, "_baseball_game");	
	}



	function get_baseball_stadium_by_dates($date_start,$date_end,$indoors="",$pk=""){
		baseball_db();

		$sql_indoors ="";
		if ($indoors){
			$sql_indoors = " and real_roof_open = 1";	
		}

		$sql_pk ="";
		if ($pk != ""){
			$sql_pk = " and pk >= ".$pk."";	
		}
		
		$sql="SELECT DISTINCT g.team_home, s.team_name, s.name FROM game g, stadium s WHERE g.team_home = s.team_id 
		and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0 $sql_indoors $sql_pk ORDER BY s.name ASC ";
		return get($sql, "_baseball_game");	
	}

	function get_baseball_avg_temp_facts_data_stadium($field, $team_home,$date_start,$date_end,$indoors=""){
		baseball_db();	

		$sql_indoors ="";
		if ($indoors){
			$sql_indoors = " and real_roof_open = 1";	
		}

		$sql="SELECT AVG(".$field.") as avg_".$field.", AVG((g.homeruns_away + g.homeruns_home)) as avg_homeruns, AVG((g.runs_away + g.runs_home)) as avg_runs FROM game g, stadium s,weather w WHERE w.game = g.id and g.team_home = s.team_id and g.team_home = '".$team_home."'
		and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0  $sql_indoors ";
		return get($sql, "_baseball_game");	
	}


	function get_baseball_games_by_pk($date_start,$date_end,$condition,$pk1,$pk2,$stadium){
		baseball_db();	
		$sql="SELECT id,startdate,away_rotation,home_rotation,team_away,team_home,(runs_away + runs_home) as score, pk FROM game  WHERE (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') 
		and postponed = 0 and pk >= $pk1 and pk <= $pk2 and real_roof_open = 1 and team_home IN (".$stadium.")
		Order by pk ASC";
		return get($sql, "_baseball_game");	
	}

	function get_baseball_games_by_dryair($date_start,$date_end,$condition,$dry1,$dry2,$stadium){
		baseball_db();	
		$sql="SELECT id,startdate,away_rotation,home_rotation,team_away,team_home,(runs_away + runs_home) as score, dry_air FROM game  WHERE (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') 
		and postponed = 0 and dry_air >= $dry1 and dry_air <= $dry2 and real_roof_open = 1 and team_home IN (".$stadium.")
		Order by pk ASC";
		return get($sql, "_baseball_game");	
	}

	function get_baseball_games_by_wheater_factor($date_start,$date_end,$stadium,$factor,$indoors,$range1,$range2){
		baseball_db();	
		if ($indoors){ $sql_indoors = " And real_roof_open = 1 "; }
		$sql="SELECT id,startdate,away_rotation,home_rotation,team_away,team_home,(runs_away + runs_home) as score, $factor , 
		(g.homeruns_away + g.homeruns_home) as homeruns 
		FROM game g  WHERE (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') 
		and postponed = 0 and $factor >= $range1 and $factor <= $range2 and real_roof_open = 1 and team_home = ".$stadium."
		Order by $factor ASC";
//echo $sql;
		return get($sql, "_baseball_game");	
	}


	function get_baseball_games_by_wind_stadium($date_start,$date_end,$stadium,$indoors,$wind = ""){
		baseball_db();	
		if ($wind != ""){ $sql_wind = " And wd.id  = '".$wind."' "; }
		if ($indoors){ $sql_indoors = " And real_roof_open = 1 "; }

		$sql="SELECT g.id,startdate,team_away,team_home,(runs_away + runs_home) as score, (g.homeruns_away + g.homeruns_home) as homeruns, s.id,
		w.wind_direction, wd.id as wid, (select position from stadium_position sp,stadium_wind_position sw where sw.stadium = s.id and sw.wind_direction = wd.id and sp.id = sw.stadium_position ) as position FROM game g, weather w, wind_direction wd, stadium s
		WHERE g.id = w.game and wd.direction = w.wind_direction  and s.team_id = g.team_home and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and postponed = 0  $sql_indoors and team_home = ".$stadium." $sql_wind Order by homeruns DESC";
//echo $sql;
		return get($sql, "_baseball_game");	
	}


	function get_baseball_games_dewpoint_stadium($date_start,$date_end,$stadium){
		baseball_db();	

		$sql="SELECT  w.dewpoint , (runs_away + runs_home) as score, (g.homeruns_away + g.homeruns_home) as homeruns 
		FROM game g, weather w
		WHERE g.id = w.game and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and postponed = 0  and team_home =".$stadium."  Order by homeruns DESC";
		return get($sql, "_baseball_game");	
	}

	function get_baseball_games_runs_by_date($date_start,$date_end,$pitcher = ""){
		baseball_db();	
		$sql_pitcher = "";
		if ($pitcher != "" ){
			$sql_pitcher = " and (pitcher_away = '".$pitcher."' || pitcher_home = '".$pitcher."') ";
		}
		$sql="SELECT id,startdate,away_rotation,home_rotation,team_away,team_home,(runs_away + runs_home) as score,pitcher_away,pitcher_home  FROM game  WHERE (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and postponed = 0 $sql_pitcher Order by startdate ASC";

		return get($sql, "_baseball_game");	
	}

	function get_player_pitches_by_game($game,$player,$team){
		baseball_db();	
		$sql="SELECT g.id,g.pitcher_".$team.", p.player, ps.* FROM game g, player p ,player_stadistics_by_game ps
		WHERE g.id = '".$game."' and p.fangraphs_player = (Select pitcher_".$team." from game where id = '".$game."' )
		and ps.game = '".$game."' and ps.fangraphs_player = g.pitcher_".$team."";
       //echo $sql."<BR><BR>";
		return get($sql, "_baseball_player_stadistics_by_game",true);	
	}

		function get_player_pitches_by_game_simple($game,$player,$team){
		baseball_db();	
		$sql="SELECT g.id,g.pitcher_".$team.", p.player FROM game g, player p 
		WHERE g.id = '".$game."' and p.fangraphs_player = (Select pitcher_".$team." from game where id = '".$game."' )
		";
       //echo $sql."<BR><BR>";
		return get($sql, "_baseball_player_stadistics_by_game",true);	
	}






	function get_last_games_by_pitcher($player,$limit,$game){
		baseball_db();	
		$sql="SELECT game FROM player_stadistics_by_game WHERE fangraphs_player = '".$player."' and game < '".$game."' order by game DESC limit $limit ";


  // echo $sql."<BR><BR>";
		return get_str($sql);	
	}


	function get_baseball_pitcher_team($team){
		baseball_db();	
		$sql="select p.fangraphs_player,p.player from player_teams pt, player p where p.fangraphs_player = pt.player and  pt.season = '".date("Y")."' and pt.team = ".$team." and p.type = 'pitcher'";

		return get_str($sql);	
	}



	function get_last_pitches_by_game_list($str_games,$player){
		baseball_db();	
		$sql="select SUM(total_last_game) as total  from player_stadistics_by_game where  fangraphs_player = $player and game in ($str_games)";

   //echo $sql."<BR><BR>";
		return get_str($sql,true);	
	}


	function get_baseball_games_kbb_by_date($date_start,$date_end,$range1,$range2,$years="",$pk1="",$pk2="",$moist1 ="",$moist2 ="",$temp1 ="",$temp2 ="",$hum1 ="",$hum2 ="",$vp1="",$vp2="",$dp1="",$dp2="",$stadium="",$pitcher = "", $airp1="", $airp2 ="",$aird1="",$aird2="",$t_adj1 = "",$t_adj2 = "" ){
		baseball_db();
		$sql_stadium = "";
		if ($stadium != ""){
			$sql_stadium = " and team_home IN (".$stadium.") " ;
		}

		$sql_pitcher = "";
		if ($pitcher != ""){
			$sql_pitcher = " and (pitcher_home = '".$pitcher."' || pitcher_away = '".$pitcher."') ";
		}

		$sql_pk ="";
		if ($pk1 != ""){
			$sql_pk = " and pk >= $pk1 and pk <= $pk2 and real_roof_open = 1 and team_home != '37' ";	
		}

		$sql_vp ="";
		if ($vp1 != ""){
			$sql_vp = " and vapour_pressure >= $vp1 and vapour_pressure <= $vp2 and real_roof_open = 1 and team_home != '37' ";	
		}

		if ($dp1 != ""){
			$sql_dp = " and w.dewpoint >= $dp1 and w.dewpoint <= $dp2 and real_roof_open = 1 and team_home != '37' ";	
		}


		$sql_moist ="";
		if ($moist1 != ""){
			$sql_moist = " and moist_air >= $moist1 and moist_air <= $moist2 and real_roof_open = 1 and team_home != '37' ";	
		}

		if ($temp1 != ""){
			$sql_temp = " and w.temp >= $temp1 and w.temp <= $temp2 and real_roof_open = 1 and team_home != '37' ";	
		}

		if ($hum1 != ""){
			$sql_hum = " and w.humidity >= $hum1 and w.humidity <= $hum2 and real_roof_open = 1 and team_home != '37' ";	
		}

		if ($airp1 != ""){
			$sql_airp = " and w.air_pressure >= $airp1 and w.air_pressure <= $airp2 and real_roof_open = 1 and team_home != '37' ";	
		}

		if ($aird1 != ""){
			$sql_aird = " and w.aird >= $aird1 and w.aird <= $aird2 and real_roof_open = 1 and team_home != '37' ";	
		}

		if ($t_adj1 != ""){
			$sql_total_adj = " and total_adj >= $t_adj1 and total_adj <= $t_adj2 and real_roof_open = 1 and team_home != '37' ";	
		}


	//$sql_year= "";

	/*foreach ($years as $year){
	   $sql_year .= " ,(select us.k_bb from umpire_stadistics us where us.year = '".$year."' and us.umpire = g.umpire ) as '".$year."' " ;	
	}
	$sql_year =   substr( $sql_year,0,-1);	*/
	
	$sql="SELECT g.id,g.startdate,g.away_rotation,g.home_rotation,g.team_away,g.team_home,(g.runs_away + g.runs_home) as score,g.umpire, (select full_name from umpire u where u.id = g.umpire ) as name, g.pk ,g.vapour_pressure,g.moist_air, g.total_adj, up.weighted_avg as actual, w.temp, w.humidity,w.dewpoint,w.air_pressure, w.aird  FROM game g , umpire_data up, weather w WHERE g.id = w.game and (DATE(g.startdate) >= '".$date_start."' && g.startdate <= '".$date_end."') and g.postponed = 0 and g.real_umpire = up.umpire and ( up.weighted_avg  >= ".$range1." && up.weighted_avg <= ".$range2.") $sql_pk  $sql_vp $sql_moist $sql_temp $sql_dp $sql_hum $sql_stadium $sql_pitcher $sql_aird $sql_airp $sql_total_adj Order by startdate ASC";
	//echo $sql;

	return get($sql, "_baseball_game");	
}

function get_baseball_pitchers_faceoff_by_date($pitcher1,$pitcher2,$date_start,$date_end){
	baseball_db();	
	$sql="SELECT *,(runs_away + runs_home) as score FROM `game` WHERE ((pitcher_away = '".$pitcher1."' and pitcher_home = '".$pitcher2."') || (pitcher_home = '".$pitcher1."' and pitcher_away = '".$pitcher2."')) AND (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and postponed = 0 Order by startdate ASC";
	return get($sql, "_baseball_game");	
}

function get_baseball_games_lose_by_runs($cant,$date_start,$date_end){
	baseball_db();	
	$sql="SELECT * FROM `game` WHERE (((runs_away - runs_home) >= ".$cant." ) || ((runs_home - runs_away) >= ".$cant." )) AND (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and postponed = 0 Order by startdate ASC";
	return get($sql, "_baseball_game");	
}

function get_baseball_next_game_by_team($date,$team){
	baseball_db();	
	$sql="SELECT *,(runs_away + runs_home) as score FROM `game` WHERE DATE(startdate) = '".$date."' and (team_away = '".$team."' || team_home = '".$team."') and postponed = 0 Order by startdate ASC";
	return get($sql,"_baseball_game",true);	
}

function get_baseball_highest_runs($date_start,$date_end,$runs,$stadium){
	baseball_db();	
	$sql="SELECT *,(runs_away + runs_home) as score, DATE(startdate) as 'line_date' FROM game  WHERE (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') 
	and postponed = 0 and ((runs_away + runs_home) >= '".$runs."')  and team_home IN (".$stadium.")
	Order by score DESC";
	return get($sql, "_baseball_game_line");	
}

function get_baseball_highest_runs_by_stadium($field,$team_home,$date_start,$date_end,$order="ASC"){
	baseball_db();	

	$sql="SELECT s.team_name,  g.*, (g.homeruns_away + g.homeruns_home) as homeruns, (g.runs_away + g.runs_home) as runs FROM game g, stadium s WHERE g.team_home = s.team_id and g.team_home = '".$team_home."' and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0 $sql_indoors order by ".$field." $order LIMIT 10";
	return get($sql, "_baseball_game");	
}

function get_baseball_highest_runs_weather_by_stadium($field,$team_home,$date_start,$date_end,$order="ASC"){
	baseball_db();	

	$sql="SELECT  w.*, s.team_name,  g.*, (g.homeruns_away + g.homeruns_home) as homeruns, (g.runs_away + g.runs_home) as runs FROM game g, stadium s, weather w WHERE w.game = g.id and g.team_home = s.team_id and g.team_home = '".$team_home."' and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and g.postponed = 0 $sql_indoors order by ".$field." $order LIMIT 10";
	return get($sql, "_baseball_game");	
}

function get_baseball_games_home_team($date_start,$date_end,$team_home,$indoors = ""){
	baseball_db();
	
	$sql_indoors ="";
	if ($indoors){
		$sql_indoors = " and real_roof_open = 1";	
	}	

	$sql="SELECT *, (runs_away + runs_home) as score FROM game WHERE team_home = '".$team_home."' and (DATE(startdate) >= '".$date_start."' && startdate <= '".$date_end."') and postponed = 0 $sql_indoors  order by  startdate ASC ";
	//echo $sql;
	return get($sql, "_baseball_game");	
}




function get_baseball_games_next_game_player($player,$startdate){
	baseball_db();	

	$sql="select g.id,g.startdate, g.away_rotation ,g.team_away,g.team_home,g.pitcher_away, g.pitcher_home, g.runs_away, g.runs_home, (runs_away + runs_home) as score, ps.rest_time , g.real_roof_open
	from game g, player_stadistics_by_game ps where g.id = ps.game and ps.fangraphs_player = ".$player." and (pitcher_away = ".$player." || pitcher_home = ".$player.") and startdate > '".$startdate."' and ps.rest_time not like '%months%' and ps.rest_time not like '%year%'  order by startdate asc limit 1	";
	//echo $sql."<BR><BR>";
	return get($sql, "_baseball_game",true);	
}


function get_baseball_games_last_game_player($player,$startdate,$field){
	baseball_db();	

	$sql="select g.id,g.startdate, pitcher_$field as pitcher, g.game_note , g.espn_game, '".$field."' as location, team_home as team
	from game g where pitcher_$field = '".$player."'  and startdate < '".$startdate."'  order by startdate desc limit 1";
	//echo $sql."<BR><BR>";
	return get_str($sql, true);	
}


function get_score($gameid, $period = "0"){
	inspinc_statsdb1();
	$sql = "SELECT * FROM scores WHERE gameid = '$gameid' AND of_period = '" .strtolower($period). "'";
	return get_str($sql, true);
}

function get_score_by_inings($gameid, $innings){
	inspinc_statsdb1();
	$str_inning = "";
	for ($i=1;$i<=$innings;$i++){
		$str_inning .= $i.",";
	}
	$str_inning = substr($str_inning,0,-1);
	$sql = "SELECT SUM(home_score) as home_score ,SUM(away_score) as away_score  FROM scores WHERE gameid = '$gameid' AND of_period IN ($str_inning)";
	//echo $sql; 
	return get_str($sql, true);
}



//alerts
function get_pending_baseball_alerts($clerk){
	baseball_db();
	$sql = "SELECT * FROM alert as r WHERE 
	NOT EXISTS(SELECT * FROM closed_alerts WHERE user = '$clerk' AND alert = r.id )
	ORDER BY id ASC";
	
	return get($sql, "_baseball_alert");
}

function new_signup_alerts_alerts($uid){
	clerk_db();
	$sql = "SELECT * FROM name as n WHERE list = 20 AND status = 1 AND clerk = 0 AND on_the_phone = 0
	AND DATE(added_date) = DATE(NOW())
	AND UNIX_TIMESTAMP(added_date) <= 
	UNIX_TIMESTAMP('".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " - 30 minutes "))."') 
	AND available = 1 AND NOT EXISTS (SELECT * FROM closed_alerts 			 
	WHERE type = 'nsup' AND alert = n.id AND user = '$uid')";
	return get_str($sql);
}
function cc_denied_alerts($uid){
	processing_db();
	$sql = "SELECT * FROM creditcard_transactions as t WHERE DATE(tdate) = DATE(NOW())
	AND approved = 'N' AND NOT EXISTS (SELECT * FROM closed_alerts 
	WHERE status = 'ccde' AND transaction = t.id AND user = '$uid')";
	return get_str($sql);
}

function tweets_alerts($uid){
	tweets_db();
	$sql = "SELECT a.id as alert,k.keyword , u.name, t.* FROM alerts a, tweets t, users u, keywords k WHERE k.id = a.keyword and t.user_id = u.id and t.id = a.tweet and  DATE(t.added_date) = DATE(NOW()) AND a.id NOT IN (SELECT alert FROM closed_alerts  WHERE user = '$uid')";
	return get_str($sql);
}

function denied_alerts($uid, $type = ""){
	clerk_db();
	if($type != ""){$sql_type = " AND message LIKE '%Type: $type%' ";}
	$sql = "SELECT * FROM `alert` as a WHERE type = 'denied_trans' $sql_type AND
	NOT EXISTS (SELECT * FROM closed_alerts WHERE type = 'detra' AND user = '$uid' AND alert = a.id)";
	return get_str($sql);
}

function mp_payouts_alerts($uid){
	processing_db();
	$sql = "SELECT * FROM moneypack_transaction as t WHERE DATE(tdate) >= DATE('2014-05-26') AND method != 'k'
	AND (cmarked = 1 OR status = 'de') AND NOT EXISTS (SELECT * FROM closed_alerts 
	WHERE status = 'mpp' AND transaction = t.id AND user = '$uid') AND type = 'pa'";
	return get_str($sql);
}

function mp_sell_alerts($uid){
	processing_db();
	$sql = "SELECT * FROM moneypak_sell as t WHERE t.status = 'ac' and t.delivered	 = 0					     AND NOT EXISTS (SELECT * FROM closed_alerts 
	WHERE status = 'mps' AND transaction = t.id AND user = '$uid')";
	return get_str($sql);
}

function affiliate_payouts_alerts($uid){
	processing_db();
	$sql = "SELECT *  FROM `all_transactions` as t WHERE `type` = 'pa' AND `player` LIKE 'AF%' AND `status` = 'ac'
	AND tdate >= '2014-02-04'
	AND NOT EXISTS (SELECT * FROM closed_alerts WHERE status = CONCAT('afp',t.method) 
	AND transaction = t.id AND user = '$uid')";
	return get_str($sql);
}



function other_payouts_alerts($uid){
	processing_db();
	$start_date = "2014-05-26";
	$alerts = array();
	$sql = "SELECT id, player, amount, 'BTP' as extra_id, 'btp' as short, 'Bitcoin' as ttype, status
	FROM bitcoin_payouts as t WHERE DATE(tdate) >= DATE('$start_date')
	AND (cmarked = 1 OR status = 'de') AND NOT EXISTS (SELECT * FROM closed_alerts 
	WHERE status = 'btp' AND transaction = t.id AND user = '$uid')";
	$alerts = array_merge(get_str($sql),$alerts);
	
	$sql = "SELECT id, player, amount, 'PTP' as extra_id, 'ptp' as short, 'Prepaid Gift Card' as ttype, status
	FROM prepaid_payout as t WHERE DATE(tdate) >= DATE('$start_date')
	AND (cmarked = 1 OR status = 'de') AND NOT EXISTS (SELECT * FROM closed_alerts 
	WHERE status = 'ptp' AND transaction = t.id AND user = '$uid')";
	$alerts = array_merge(get_str($sql),$alerts);
	
	$sql = "SELECT id, player, amount, 'PPP' as extra_id, 'ppp' as short, 'Paypal' as ttype, status
	FROM direct_paypal_transaction as t WHERE DATE(tdate) >= DATE('$start_date')  AND type = 'p'
	AND (cmarked = 1 OR status = 'de') AND NOT EXISTS (SELECT * FROM closed_alerts
	WHERE status = 'ppp' AND transaction = t.id AND user = '$uid')";
	$alerts = array_merge(get_str($sql),$alerts);
	
	$sql = "SELECT id, player, amount, 'MO' as extra_id, 'mop' as short, 'Money Order' as ttype, status
	FROM dmo_transaction as t WHERE DATE(tdate) >= DATE('$start_date')  AND type = 'p'
	AND (cmarked = 1 OR status = 'de') AND NOT EXISTS (SELECT * FROM closed_alerts
	WHERE status = 'mop' AND transaction = t.id AND user = '$uid')";
	$alerts = array_merge(get_str($sql),$alerts);
	
	$sql = "SELECT id, sender_account as player, amount, '' as extra_id, 'ctp' as short, 'Cash Transfer' as ttype, status
	FROM transaction as t WHERE DATE(t.date) >= DATE('$start_date')  AND type = 'sm' AND id_customer = '1042'
	AND status IN ('ac','de') AND NOT EXISTS (SELECT * FROM closed_alerts
	WHERE status = 'ctp' AND transaction = t.id AND user = '$uid')";
	$alerts = array_merge(get_str($sql),$alerts);
	
	return $alerts;
}

function delete_ezp_alert($trans, $user, $status){
	processing_db();
	$sql = "INSERT INTO closed_alerts (user, transaction, status, tdate) VALUES('$user','$trans','$status', NOW())";
	return execute($sql);
}

function delete_tweet_alert($alert,$user){
	tweets_db();
	$sql = "INSERT INTO closed_alerts (alert, user, closed_date) VALUES('$alert','$user', NOW())";
	return execute($sql);
}

function delete_vrb_alert($alert, $user, $type){
	clerk_db();
	$sql = "INSERT INTO closed_alerts (user, alert, type, tdate) VALUES('$user','$alert','$type', NOW())";
	return execute($sql);
}

function delete_baseball_alert($alert, $user, $type){
	baseball_db();
	$sql = "INSERT INTO closed_alerts (user, alert, type, tdate) VALUES('$user','$alert','$type', NOW())";
	return execute($sql);
}

//virtual CC
function get_all_virtualcc_amounts(){	
	processing_db();			
	$sql = "SELECT *, amount as label FROM virtualcc_amounts ORDER BY amount ASC";	
	return get_str($sql);
}
function get_virtualcc_amount($id){	
	processing_db();
	$sql = "SELECT * FROM virtualcc_amounts WHERE id = '$id'";	
	return get_str($sql, true);
}
function get_all_vcc_payouts_by_player($player){	
	processing_db();
	$sql = "SELECT * FROM virtualcc_transaction WHERE payout_player = '$player'";	
	return get($sql, "_virtual_cc");
}
function get_vcc($id){	
	processing_db();
	$sql = "SELECT * FROM virtualcc_transaction WHERE id = '$id'";	
	return get($sql, "_virtual_cc", true);
}

//cashier access
function get_cashier_method($id){	
	sbo_book_db();
	$sql = "SELECT * FROM cashier_access_methods WHERE id = '$id'";	
	return get($sql, "_cashier_method", true);
}
function get_all_cashier_methods(){	
	sbo_book_db();
	$sql = "SELECT * FROM cashier_access_methods";	
	return get($sql, "_cashier_method");
}
function get_cashier_access_list($method, $type){	
	sbo_book_db();
	$sql = "SELECT * FROM cashier_access_$type WHERE method = '$method'";	
	return get($sql, "_cashier_access");
}
function get_cashier_access_acount($type, $player, $method){	
	sbo_book_db();
	$sql = "SELECT * FROM cashier_access_$type WHERE player = '$player' AND method = '$method'";	
	return get($sql, "_cashier_access", true);
}
//
// cashier method description
function get_all_cashier_methods_description(){	
	sbo_book_db();
	$sql = "SELECT cm.* FROM cashier_methods_description cm Order by   cm.type ,cm.order ";	
	return get($sql, "_cashier_method_description");
}
function get_cashier_method_description($id){	
	sbo_book_db();
	$sql = "SELECT * FROM cashier_methods_description WHERE id = '$id'";	
	return get($sql, "_cashier_method_description", true);
}


function get_transaction_review($tid){
	tickets_db();
	$sql = "SELECT * FROM review WHERE transaction = '$tid'";	
	return get($sql, "_review", true);	
}

function get_review($rid){
	tickets_db();
	$sql = "SELECT * FROM review WHERE id = '$rid'";	
	return get($sql, "_review", true);	
}




function get_transaction_processed_date($tid, $type){
	sbo_book_db();
	$sql = "SELECT tdate FROM `dgs_transaction` WHERE `ezpay_id` = '".$type.$tid."'";
	return get_str($sql,true);
}


//programmers book
function get_programmers_entry($eid){
	clerk_db();
	$sql = "SELECT * FROM programmers_book WHERE id = '$eid'";
	return get($sql,"_programmer_entry",true);
}
function search_programmers_entry($word){
	clerk_db();
	if(trim($word) == ""){$word = "NOseArch!23";}
	$sql = "SELECT * FROM programmers_book WHERE title LIKE '%$word%' OR description 
	LIKE '%$word%' OR DATE('$word') = DATE(adate) ORDER BY adate DESC";
	return get($sql,"_programmer_entry");
}


//insertd DGS
function get_dgs_insertions_by_list($list){
	sbo_book_db();
	$sql = "SELECT * FROM dgs_transaction WHERE ezpay_id IN ($list)";
	return get_str($sql);
}

//bitcoins Address
function get_player_bitcoins_address($account){
	processing_db();
	$sql = "SELECT * FROM bitcoins_give_addresses WHERE account = '$account'";
	return get_str($sql);
}

//bitcoin payouts
function search_bitcoins_payouts($from, $to, $status, $aps){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($aps != ""){$sql_aps = " AND aps = '$aps' ";}
	$sql = "SELECT * FROM bitcoin_payouts as t WHERE 1 
	$sql_from $sql_to $sql_status $sql_aps
	ORDER BY tdate DESC";
	return get($sql, "_btc_payout");
}
function get_bitcoin_payout($id){
	processing_db();
	$sql = "SELECT * FROM bitcoin_payouts WHERE id = '$id'";
	return get($sql, "_btc_payout", true);
}

function get_bitcoin_deposit($id){
	processing_db();
	$sql = "SELECT * FROM bitcoin_deposit WHERE id = '$id'";
	return get($sql, "_btc_deposit", true);
}

function get_bitbetdeposits($from, $to){
	processing_db();
	$sql = "SELECT * FROM btc_casino_deposit WHERE DATE(tdate) >= DATE('$from') AND DATE(tdate) <= DATE('$to')";
	return get($sql, "_bitbet_deposit");
}



//prepaid payouts
function search_prepaid_payouts($from, $to, $status, $aps){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($aps != ""){$sql_aps = " AND aps = '$aps' ";}
	$sql = "SELECT * FROM prepaid_payout WHERE 1 
	$sql_from $sql_to $sql_status $sql_aps
	ORDER BY tdate DESC";
	return get($sql, "_prepaid_payout");
}
function get_prepaid_payout($id){
	processing_db();
	$sql = "SELECT * FROM prepaid_payout WHERE id = '$id'";
	return get($sql, "_prepaid_payout", true);
}


// credit card 
function get_creditcard_transaction($id){
	processing_db();
	$sql = "SELECT * FROM creditcard_transactions WHERE id = '$id'";
	return get($sql, "_creditcard_transaction", true);
}




//paypal transactions
function search_paypal_payouts($from, $to, $status, $aps){
	processing_db();
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($status != ""){$sql_status = " AND status = '$status' ";}
	if($aps != ""){$sql_aps = " AND aps = '$aps' ";}
	$sql = "SELECT * FROM direct_paypal_transaction WHERE type = 'p'
	$sql_from $sql_to $sql_status $sql_aps
	ORDER BY tdate DESC";
	return get($sql, "_paypal_transaction");
}
function get_paypal_transaction($id){
	processing_db();
	$sql = "SELECT * FROM direct_paypal_transaction WHERE id = '$id'";
	return get($sql, "_paypal_transaction", true);
}


//Email requests
function search_email_requests($from, $to, $status, $name, $email, $player){
	clerk_db();
	if($from == ""){$from = "2013-01-01";}
	if($status != ""){$sql_status = "AND complete = '$status'";}
	$sql = "SELECT * FROM email_requests WHERE DATE(rdate) >= DATE('$from') AND DATE(rdate) <= DATE('$to')
	$sql_status AND name LIKE '%$name%' AND email LIKE '%$email%' AND player LIKE '%$player%'
	ORDER BY rdate DESC";
	return get($sql, "_email_request");
}
function get_email_request($id){
	clerk_db();
	$sql = "SELECT * FROM email_requests WHERE id = '$id'";
	return get($sql, "_email_request", true);
}

function get_email_request_by_name($nid){
	clerk_db();
	$sql = "SELECT * FROM email_requests WHERE ckname = '$nid'";
	return get($sql, "_email_request", true);
}

//Tweets
function get_tweet_user($id){
	tweets_db();
	$sql = "SELECT * FROM users WHERE id = '$id'";
	return get($sql, "_tweet_user", true);
}

function get_all_tweet_user($available=""){
	tweets_db();
	
	if ($available != ""){
		$sql_available = "WHERE available = 1"; 
	}
	else {$sql_available =""; }
	
	
	$sql = "SELECT * FROM users $sql_available ";
	return get($sql, "_tweet_user");
}

function get_last_uset_tweet($id){
	tweets_db();
	$sql = "SELECT tweet_id FROM tweets where user_id = '".$id."' order by created_date desc limit 1 ";
	return get_str($sql,true);
}

function get_all_tweets($available="",$user=""){
	tweets_db();
	
	if ($available != ""){
		$sql_available = "WHERE available = 1"; 
	}
	else {$sql_available =""; }

	$sql_user = "";
	if ($user != ""){
		$sql_user = " AND user_id = ".$user." ";
	}
	
	$sql = "SELECT * FROM tweets $sql_available $sql_user  Order by created_date DESC ";
	return get($sql, "_tweet");
}

function get_tweet($id){
	tweets_db();

	$sql = "SELECT * FROM tweets where id = '".$id."'";
	return get($sql, "_tweet",true);
}


function get_tweet_keyword($id){
	tweets_db();
	$sql = "SELECT * FROM keywords WHERE id = '$id'";
	return get($sql, "_tweet_keyword", true);
}

function get_all_tweet_keyword($available=""){
	tweets_db();
	
	if ($available != ""){
		$sql_available = "WHERE available = 1"; 
	}
	else {$sql_available =""; }

	$sql = "SELECT * FROM keywords $sql_available ";
	return get($sql, "_tweet_keyword");
}

function get_all_tweets_alerts($keyword=""){
	tweets_db();
	$sql_keyword = "";
	if ($keyword != ""){
		$sql_keyword = "WHERE keyword = ".$keyword." ";
	}
	$sql = "SELECT * FROM alerts $sql_keyword Order by id DESC";
	return get($sql, "_tweet_alert");
}
function get_all_zip_address($params = ""){
	processing_db();
	if($params != ""){$params = "id, $params";}else{$params = "*";}
	$sql = "SELECT $params FROM `zip_address`";
	return get($sql, "_zip_address", false, "id");
}

// Reverse Transaction section
function get_global_transactions_by_date($from, $to,$table,$type,$playerField,$dgs_ID,$dateField,$status = "",$creditcard=false,$accounting=false,$cashTranfer=false){

	if (!$accounting){ processing_db(); }
	else {accounting_db();}
	
	$strstatus= "status";
	$sql_status = "";
	if ($status != "") { 
		$sql_status = " AND status = '".$status."'"; 
	}
	
	if ($creditcard) { 
		$strstatus= "approved"; 
		if ($status != "") { 
			if ($status == "ac") { $status = "Y" ;}
			if ($status == "de") { $status = "N" ;}
			$sql_status = " AND approved = '".$status."'"; 
		}

	}
	$sql_selection_cash ="";
	$sql_where_cash ="";
	if ($cashTranfer){ 
		$sql_selection_cash = " , type as cash"; 
		$sql_where_cash =" And type IN ('sm','rm') and id_customer = 1042";
	}
	else { $sql_selection_cash = " , 'NoCash' as cash";   } 

	$sql = "SELECT id, $dgs_ID as dgs_dID ,  $playerField as player, amount, $strstatus , $dateField as tdate , '".$type."' as type $sql_selection_cash, '$table' as method FROM $table  WHERE (DATE($dateField) >= DATE('".$from."') && DATE($dateField) <= DATE('".$to."')) $sql_status $sql_where_cash ORDER BY $dateField desc  ";
	
	$transactions = get($sql, "_global_transaction");
	
	return $transactions;
	
}


function get_global_all_transactions_by_date($from, $to,$table1,$table2,$status = ""){

	processing_db();
	
	$trans = array();
	$sql_status = "";
	if ($status != "") { 
		$sql_status = " AND status = '".$status."'"; 
	}
	$sql_selection_cash = " , 'NoCash' as cash";  
	
	$sql = "SELECT id, dgs_dID,  player, amount, status, tdate , 'Deposit' as type $sql_selection_cash, '$table1' as method FROM  $table1  WHERE (DATE(tdate) >= DATE('".$from."') && DATE(tdate) <= DATE('".$to."')) $sql_status ORDER BY tdate desc ";

	$deposits = get($sql, "_global_transaction");

	$sql = "SELECT id, dgs_dID,  player, amount, status, tdate , 'Payout' as type $sql_selection_cash, '$table2' as method FROM $table2 WHERE (DATE(tdate) >= DATE('".$from."') && DATE(tdate) <= DATE('".$to."')) $sql_status ORDER BY tdate desc ";
	
	$payouts = get($sql, "_global_transaction");
	$trans = array_merge($deposits,$payouts);

	return $trans;
	
}
function get_all_transactions($from,$to,$status){

	$tables_mixed= array();
	
	//Bitcoins
	$tables_mixed[0]["table1"] = "bitcoin_deposit";
	$tables_mixed[0]["table2"] = "bitcoin_payouts";
	
	//Prepaid
	$tables_mixed[1]["table1"] = "prepaid_transaction";
	$tables_mixed[1]["table2"] = "prepaid_payout";
	

	$tables = array();	
	
	//Creditcard
	$tables[0]["table"] = "creditcard_transactions";
	$tables[0]["type"] = "Deposit";
	$tables[0]["playerField"] = "player";
	$tables[0]["DgsField"] = "0";
	$tables[0]["DateField"] = "tdate";
	$tables[0]["creditcard"] = "true";
	$tables[0]["accounting"] = "false";
	$tables[0]["cashTransfer"] = "false";
	
	//Local Cash
	$tables[1]["table"] = "local_cash_transaction";
	$tables[1]["type"] = "Payout";
	$tables[1]["playerField"] = "account";
	$tables[1]["DgsField"] = "dgs_dID";
	$tables[1]["DateField"] = "tdate";
	$tables[1]["creditcard"] = "false";
	$tables[1]["accounting"] = "false";
	$tables[1]["cashTransfer"] = "false";
	
	
	//MoneyOrder Payout
	$tables[2]["table"] = "dmo_transaction";
	$tables[2]["type"] = "Payout";
	$tables[2]["playerField"] = "player";
	$tables[2]["DgsField"] = "dgs_dID";
	$tables[2]["DateField"] = "tdate";
	$tables[2]["creditcard"] = "false";
	$tables[2]["accounting"] = "false";
	$tables[2]["cashTransfer"] = "false";
	
	
	// MoneyPak
	$tables[3]["table"] = "moneypack_transaction";
	$tables[3]["type"] = "Payout";
	$tables[3]["playerField"] = "player";
	$tables[3]["DgsField"] = "dgs_dID";
	$tables[3]["DateField"] = "tdate";
	$tables[3]["creditcard"] = "false";
	$tables[3]["accounting"] = "false";
	$tables[3]["cashTransfer"] = "false";
	
	//Paypal
	$tables[4]["table"] = "direct_paypal_transaction";
	$tables[4]["type"] = "Payout";
	$tables[4]["playerField"] = "player";
	$tables[4]["DgsField"] = "dgs_dID";
	$tables[4]["DateField"] = "tdate";
	$tables[4]["creditcard"] = "false";
	$tables[4]["accounting"] = "false";
	$tables[4]["cashTransfer"] = "false";
	
	//Cash Transfer
	$tables[5]["table"] = "transaction";
	$tables[5]["type"] = "Cash";
	$tables[5]["playerField"] = "sender_account";
	$tables[5]["DgsField"] = "dgs_dID";
	$tables[5]["DateField"] = "date";
	$tables[5]["creditcard"] = "false";
	$tables[5]["accounting"] = "false";
	$tables[5]["cashTransfer"] = "true";
	
	
	//Special Deposit
	$tables[6]["table"] = "special_deposit";
	$tables[6]["type"] = "Deposit";
	$tables[6]["playerField"] = "player";
	$tables[6]["DgsField"] = "dgs_dID";
	$tables[6]["DateField"] = "ddate";
	$tables[6]["creditcard"] = "false";
	$tables[6]["accounting"] = "true";
	$tables[6]["cashTransfer"] = "false";
	
	
	//Special Payout
	$tables[7]["table"] = "special_payouts";
	$tables[7]["type"] = "Payout";
	$tables[7]["playerField"] = "player";
	$tables[7]["DgsField"] = "dgs_dID";
	$tables[7]["DateField"] = "ddate";
	$tables[7]["creditcard"] = "false";
	$tables[7]["accounting"] = "true";
	$tables[7]["cashTransfer"] = "false";
	
	
	
	$trans = array();
	
	foreach ($tables as $table){
		
		$transactions =  get_global_transactions_by_date($from, $to,$table["table"],$table["type"],$table[ "playerField"],$table["DgsField"],$table["DateField"],$status,$table["creditcard"],$table["accounting"],		$table["cashTransfer"]);	

		$trans = array_merge($transactions,$trans);

	}
	
	foreach ($tables_mixed as $table_mixed) {
		
		$transactions = get_global_all_transactions_by_date($from,$to,$table_mixed["table1"],$table_mixed["table2"],$status);

		$trans = array_merge($transactions,$trans);

		
	}
	

	return($trans);	

}

function is_alert_exist($id_trans,$method){
	clerk_db();
	$sql = "SELECT * FROM alert WHERE (message LIKE '%".$method."%' && message LIKE '%Id: ".$id_trans."%')";
	$res = get_str($sql, true);
	if(!is_null($res)){return true;}else{return false;} 
	
}

function get_name_denied_date($player,$date){
	clerk_db();
	$sql = "SELECT * FROM name WHERE acc_number = '$player' AND DATE(added_date) = DATE('$date') AND list = '66'";
	return get($sql, "ck_name", true);
}


function get_denied_resolutions($from, $to){
	clerk_db();
	$sql = "SELECT DISTINCT n.*  FROM name as n, `call` as c WHERE
	c.name = n.id AND n.available = 0 AND n.list = 66 AND 
	DATE(call_start) >= '$from' AND DATE(call_start) <= '$to'";
	return get($sql, "ck_name");
}

function search_cashback_refund($from ="",$to="",$account="",$type="") {
	processing_db();
	if($from != ""){$sql_from = " AND DATE(week) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(week) < DATE('$to') ";}
	if($account != ""){$sql_account = "AND account Like '%$account%' ";}
	if($type != ""){$sql_type = "AND type = '$type' ";}
	$sql = "SELECT type,account,amount,transaction_id,pp.name as method, notes, week, added_date, cc.descriptor FROM cc_cashback_refund cc, creditcard_processors pp  WHERE pp.code = cc.method $sql_from $sql_to $sql_account $sql_type  ";
	return get($sql, "_cashback");
}


//help calls
function get_pending_help_calls(){
	clerk_db();
	$sql = "SELECT * FROM help_call_request WHERE status = 'pe' ORDER BY id ASC";
	return get($sql, "_help_call");
}
function get_pending_help_calls_alerts($clerk){
	clerk_db();
	$sql = "SELECT * FROM help_call_request as r WHERE status = 'pe'
	AND NOT EXISTS(SELECT * FROM closed_alerts WHERE user = '$clerk' AND alert = r.id AND type = 'heca')
	ORDER BY id ASC";
	return get($sql, "_help_call");
}
function get_help_call($id){
	clerk_db();
	$sql = "SELECT * FROM help_call_request WHERE id = '$id'";
	return get($sql, "_help_call", true);
}


function get_global_transaction_by_method($tid, $method){
	processing_db();
	$sql = "SELECT *  FROM `all_transactions` WHERE `id_trans` = '$tid' AND method = '$method'";
	return get_str($sql,true);
}

function search_global_transactions($from = "",$to = "" ,$method = "",$type = "",$player = "",$idtrans = "",$status = "",$cmarked = "", $payment_method = ""){
	processing_db();
	
	if($from != ""){$sql_from = " AND DATE(tdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(tdate) <= DATE('$to') ";}
	if($method != ""){$sql_method = "AND method Like '%$method%' ";}
	if($type != ""){$sql_type = "AND type = '$type' ";}
	if($player != ""){$sql_player = "AND player LIKE '%$player%' ";}
	if($idtrans != ""){$sql_trans = "AND id_trans = '$idtrans' ";}
	if($status != ""){$sql_status = "AND status = '$status' ";}
	if($cmarked != ""){$sql_dgs = "AND cmarked = '$cmarked' ";}
	if($payment_method != ""){$sql_payment = "AND payment_method = '$payment_method' ";}
	
	
	$sql = "SELECT *  FROM `all_transactions` WHERE 1 $sql_from $sql_to $sql_method $sql_type $sql_player $sql_trans $sql_status $sql_dgs $sql_payment ORDER BY tdate DESC";
	
	
	return get($sql,"_global_transaction");
}

function search_global_denied_transactions($from = "",$to = "" ,$method = "",$type = "",$player = "",$clerk = "",$newstatus = ""){
	processing_db();
	
	if($from != ""){$sql_from = " AND DATE(pdate) >= DATE('$from') ";}
	if($to != ""){$sql_to = " AND DATE(pdate) <= DATE('$to') ";}
	if($method != ""){$sql_method = "AND method Like '%$method%' ";}
	if($type != ""){$sql_type = "AND type = '$type' ";}
	if($player != ""){$sql_player = "AND player LIKE '%$player%' ";}
	if($newstatus != ""){$sql_new_status = "AND new_status = '$newstatus' ";}
	if($clerk != ""){$sql_clerk = "AND clerk = '$clerk' ";}
	
	
	$sql = "SELECT *  FROM `process_log` WHERE 1 $sql_from $sql_to $sql_method $sql_type $sql_player $sql_new_status $sql_status $sql_clerk ";
	
	return get($sql,"_process_log");
}

function get_global_denied_transactions($id){
	processing_db();
	
	$sql = "SELECT *  FROM `process_log` WHERE id = '".$id."'";
	
	return get($sql,"_process_log",true);
}

// Player allowed ips
function get_player_ips($player){	
	sbo_book_db();
	$sql = "SELECT * FROM player_ip WHERE player LIKE '%".$player."%'";	
	return get($sql, "_player_ip", true);
}

//Casino access
function get_all_casino_websites(){	
	sbo_book_db();
	$sql = "SELECT * FROM website WHERE full_casino = 1";	
	return get_str($sql);
}
function get_all_websites(){	
	sbo_book_db();
	$sql = "SELECT * FROM website";	
	return get_str($sql);
}
function get_all_casinos(){	
	sbo_book_db();
	$sql = "SELECT * FROM casino";	
	return get_str($sql);
}
function get_all_casino_web_relations(){	
	sbo_book_db();
	$sql = "SELECT CONCAT(website,'-',casino) as tkey, casino, website FROM casino_by_website";	
	return get_str($sql, false, "tkey");
}
function delete_all_casino_web_relation(){	
	sbo_book_db();
	$sql = "DELETE FROM casino_by_website";	
	return execute($sql);
}
function delete_casino_web_relation($casino, $web){	
	sbo_book_db();
	$sql = "DELETE FROM casino_by_website WHERE casino = '$casino' AND website = '$web'";	
	return execute($sql);
}
function insert_casino_web_relation($casino, $web){	
	sbo_book_db();
	$sql = "INSERT INTO casino_by_website (casino, website) VALUES ($casino, $web)";	
	return execute($sql);
}
function get_inactive_affiliates_banners($date){	
	affiliate_db();
	$sql = "select * from promotypes as b WHERE type = 'b' AND b.id NOT IN(
	select DISTINCT idbanner from impressions WHERE impdate >= '$date') ORDER BY idcampaigne";	
	return get($sql,"_promo_type");
}
function get_all_affiliates_campaigns(){	
	affiliate_db();
	$sql = "select * from campaignes";	
	return get($sql,"_affiliate_campaign", false, "id");
}
function get_affiliates_campaigns_report(){
	affiliate_db();		
	$sql = "SELECT * FROM campaignes WHERE id IN (52,83,86,144,169)";
	return get($sql, "_affiliate_campaign", false);
}

//contests
function get_contest($cid){
	inspinc_insider();
	$sql = "SELECT * FROM contest WHERE id = '$cid'";
	return get($sql,"_contest",true);
}
function get_all_checked_contests($limit = 30){
	inspinc_insider();
	$sql = "SELECT * FROM contest WHERE is_checked = 1 ORDER BY id DESC LIMIT 0,$limit";
	return get($sql,"_contest");
}
function get_contest_players_results($cid, $just_winners = false){
	inspinc_insider();
	if($just_winners){$sql_win = " HAVING total = 5 ";}
	$sql = "select player, count(*) as total from answer_by_player as ap, answer as a, question as q
	WHERE q.id_contest = '$cid' AND a.id_question = q.id AND a.is_correct = 1 AND 
	a.id = ap.answer GROUP BY player $sql_win ORDER BY total DESC";
	return get_str($sql);
}
function get_open_contest($cid){
	inspinc_insider();
	$sql = "SELECT * FROM contest WHERE id = '$cid' AND open_date < NOW() AND close_date > NOW() AND visible = 1";
	return get($sql,"_contest",true);
}
function get_contests_by_league($league){
	inspinc_insider();
	$sql = "SELECT * FROM contest WHERE league = '$league' AND open_date < NOW() AND close_date > NOW() AND visible = 1";
	return get($sql,"_contest");
}
function get_contest_question($cid){
	inspinc_insider();
	$sql = "SELECT * FROM question WHERE id = '$cid'";
	return get($sql,"_contest_question",true);
}
function get_questions_by_contest($cid){
	inspinc_insider();
	$sql = "SELECT * FROM question WHERE id_contest = '$cid'";
	return get($sql,"_contest_question");
}
function get_contest_answer($cid){
	inspinc_insider();
	$sql = "SELECT * FROM answer WHERE id = '$cid'";
	return get($sql,"_contest_answer",true);
}
function get_contest_answers_by_question($cid){
	inspinc_insider();
	$sql = "SELECT * FROM answer WHERE id_question = '$cid'";
	return get($sql,"_contest_answer");
}
function get_contest_player_answers($cid, $player){
	inspinc_insider();
	$sql = "SELECT b.*, q.id as akey FROM answer_by_player as b, question as q, answer as a
	WHERE player = '$player' AND b.answer = a.id AND a.id_question = q.id AND q.id_contest = '$cid'";
	return get($sql,"_contest_answer_by_player", false, "akey");
}

//leagues order
function get_leagues_order_by_day($day){
	sbo_book_db();	
	$sql = "SELECT * FROM `leagues_order` WHERE sdate = '$day'";
	return get($sql,"_league_order", true);
}


function is_moneypack($player, $type){
	sbo_book_db();
	$sql = "SELECT * FROM moneypack_players WHERE account = '$player' AND $type = 1";
	$res = get_str($sql, true);
	if(is_null($res)){return false;}else{return true;}
}

/*Metatags*/

function get_all_metatags($pageLimit = 0,$num_results_x_page = ""){
	sbo_seo_db();
	
	if ($num_results_x_page != "") {	  	
		$limit = " LIMIT $pageLimit,$num_results_x_page";
	}	
	else {
		$limit = "";	
	}
	
	$sql = "SELECT * FROM metatags ORDER BY id DESC $limit";

	return get($sql, "_metatags");
}

function get_metatag($id){
	sbo_seo_db();
	$sql = "SELECT * FROM metatags WHERE id = '$id'";
	return get($sql, "_metatags", true);
}

function search_metatag($url){
	sbo_seo_db();
	$sql = "SELECT * FROM metatags WHERE url LIKE '%$url%'";
	return get($sql, "_metatags");
}

/* Posting */
function get_posting_types(){
	sbo_posting();
	$sql = "SELECT * FROM posting_type";
	return get_str($sql);
}

function get_posting_type_by_id($id){
	sbo_posting();
	$sql = "SELECT * FROM posting_type where id = '$id'";
	return get_str($sql,true);
}

function get_posting($id){
	sbo_posting();
	$sql = "SELECT * FROM posting_data WHERE id = '$id'";
	return get($sql,'_posting',true);
}

function search_postings($type,$brand="",$date="",$pageLimit = 0,$num_results_x_page = ""){
	sbo_posting();

	if ($brand != "") {	  	
		$brand_sql = " AND post_brand = '$brand' ";
	}	
	else {
		$brand_sql = "";	
	}
	
	if ($date != "") {	  	
		$date_sql = " AND post_date = '$date' ";
	}	
	else {
		$date_sql = "";	
	}
	
	if ($num_results_x_page != "") {	  	
		$limit = " LIMIT $pageLimit,$num_results_x_page";
	}	
	else {
		$limit = "";	
	}

	$sql = "SELECT * FROM posting_data WHERE post_type = '$type' $brand_sql $date_sql ORDER BY post_brand DESC, id DESC $limit";

	return get_str($sql);
}

// Widget System

function get_all_event_leagues(){
	sbolines_db();
	$sql = "Select * from events_leagues order by position asc ";

	return get($sql,"_event_leagues",false,"id");	
}

function get_event_league_details($league){
	sbolines_db();
	$sql = "SELECT  * FROM events_leagues_details WHERE league = '".$league."'";
	return get($sql,"_event_leagues_details",true);
	
}

function get_all_events_books($opener,$all = true){
	sbolines_db();
	if ($opener != "") { $sql_opener = " AND small_name != 'OP' "; }
	if ($all) { $sql_available = " AND available = 1"; }
	$sql = "SELECT * FROM events_books WHERE 1 $sql_available $sql_opener Order by ranked_order ASC ";
	return get($sql,"_events_books",false,"id");
	
}

function update_book_order($id,$order){
   sbolines_db();
    $sql = "Update events_books	 set ranked_order = $order Where id = $id";
  execute($sql);	
}


function update_book_status($id,$status){
   sbolines_db();
    $sql = "Update events_books	 set available = $status Where id = $id";
    execute($sql);	
}



function get_events_book($field,$data){
	sbolines_db();
	$sql = "SELECT * FROM events_books WHERE $field = '".$data."'";
	return get($sql,"_events_books",true);
	
}


function get_event_books_history($league,$old = false){
	sbolines_db();
	if ($old) { $condition = " < ";
    $date2 =  date( "Y-m-d", strtotime( "-15 day", strtotime(date( "Y-m-d")))); // Using 15 days as reference;
    $slq_date2 = " and line_date > '".$date2."' ";

} else { $condition = " >= ";}
$sql = "select book, count(book), MAX(line_date)  as line_date   from events_leagues_line where line_date $condition '".date("Y-m-d")."' $slq_date2 and league = '".$league."' GROUP BY book order by line_date Desc";	
 // echo $sql."<BR>";
return get_str($sql,false,"book");	

}
function get_event_period_history($league,$old = false){
	sbolines_db();
	$slq_date2 = "";
	if ($old) { $condition = " < ";
      $date2 =  date( "Y-m-d", strtotime( "-15 day", strtotime(date( "Y-m-d")))); // Using 15 days as reference;
      $slq_date2 = " and line_date > '".$date2."' ";
  } else { $condition = " >= ";}
  $sql = "select period, count(period), MAX(line_date)  as line_date   from events_leagues_line where line_date $condition '".date("Y-m-d")."' $slq_date2 and league = '".$league."' GROUP BY period";	
  //echo $sql."<BR>";
  return get_str($sql,false,"period");	

}

function get_all_event_periods($id = ""){
	sbolines_db();
	if ($id != "" ) { $sql_id = " AND id <= '".$id."'  ";} 
	$sql = "select *  from period where 1  $sql_id";	
	return get_str($sql,false,"id");	

}
function get_event_line_type_total($league,$type,$old = false){
	sbolines_db();
	if ($old) { $condition = " < ";} else { $condition = " >= ";}
	$sql = 'select 1 as "total", "'.$type.'" as type, line_date from events_leagues_line where line_date '.$condition.' "'.date("Y-m-d").'" and league = "'.$league.'" and away_'.$type.' != "" ORDER BY line_date desc LIMIT 1';	
  //echo $sql;
	return get_str($sql,false);	

}

function get_all_event_sites(){
	sbolines_db();
	$sql = "Select * from sites order by site asc ";

	return get($sql,"_event_sites",false);	
}
function get_event_site($id){
	sbolines_db();
	$sql = "Select * from sites where id = '".$id."' ";

	return get($sql,"_event_sites",true);	
}

function get_event_site_details($id){
	sbolines_db();
	$sql = "Select * from sites_details where site_id = '".$id."' ";

	return get($sql,"_event_sites_details",true);	
}



function get_sites_target_books($site){
	sbolines_db();
	$sql = "Select * from sites_target_books where site = '".$site."' ";

	return get($sql,"_sites_target_books",false,"book");	
}

function get_site_target_books($site,$book){
	sbolines_db();
	$sql = "Select * from sites_target_books where site = '".$site."' and book = '".$book."' ";

	return get($sql,"_sites_target_books",true);	
}

function get_all_event_banners(){
	sbolines_db();
	$sql = "Select * from events_banners order by id asc ";

	return get($sql,"_events_banners",false);	
}
function get_event_banner($id){
	sbolines_db();
	$sql = "Select * from events_banners where id = '".$id."' ";

	return get($sql,"_events_banners",true);	
}

function get_user_order_books($user,$site){
	sbolines_db();
	$sql = "SELECT * FROM user_order_books WHERE user = '".$user."' AND site = '".$site."' ";
	return get($sql,"_user_order_books",true);
	
}

function get_events_opener(){
	sbolines_db();
	$sql = "SELECT * FROM events_opener";
	return get($sql,"_events_opener",true);
	
}


function get_history_lines_new_opener($book){
	sbolines_db();
	$sql = "SELECT * FROM events_leagues_history_line WHERE book = '".$book."' AND line_date >= '".date("Y-m-d")."'
	GROUP BY away_rotation,period ORDER BY modification_date ";	
	return get_str($sql);		  
	
}

function delete_old_opener_lines(){
	sbolines_db();
	$sql = "DELETE FROM events_leagues_line WHERE  book = 0 AND line_date >= '".date("Y-m-d")."' ";
	
	return execute($sql);
}

function get_reg_devices_app($app){
	sbolines_db();
	$sql = "SELECT device_key FROM devices_key WHERE app = '".$app."' AND device_key != 'none' AND device_key != 'undefined'";	

	return get_str($sql);		  
	
}


//BRAKET
function get_braket_player($player){
	sbo_breaket_db();
	$sql = "SELECT * FROM brakets_count WHERE player = '$player'";	
	return get($sql, "_braket_player", true);
}
function get_all_brakets_players(){
	sbo_breaket_db();
	$sql = "SELECT * FROM brakets_count ORDER BY player ASC";	
	return get($sql, "_braket_player");
}

function get_all_seo_entries($paid = ""){
	clerk_db();
	if($paid != ""){$paid = " WHERE paid = '$paid' ";}	
	else{$paid = "";}	
	$sql = "SELECT * FROM seo_system $paid ORDER BY paid_date ASC";
	return get($sql, "_seo_entry");
}
function get_seo_entries_report($paid = "", $brand = "", $keyword = "", $email = ""){
	clerk_db();
	if($paid != ""){$paid = " AND paid = '$paid' ";}	
	else{$paid = "";}	
	$sql = "SELECT * FROM seo_system WHERE brand LIKE '%$brand%' AND keywords LIKE '%$keyword%' AND email LIKE '%$email%' $paid ORDER BY paid_date ASC";
	return get($sql, "_seo_entry");
}
function get_seo_info_entry(){
	clerk_db();
	$sql = "SELECT * from seo_website WHERE status = 'u' ORDER BY RAND() LIMIT 0,1";
	return get($sql, "_seo_website", true);
}

function get_seo_lead($clerk){
	clerk_db();
	$sql = "SELECT * from seo_website as w WHERE status = 'r' AND 
	(clerk = '$clerk' OR (clerk IS NULL OR clerk = 0) AND EXISTS(SELECT * FROM seo_list_by_clerk WHERE list = w.list AND clerk = '$clerk')) 	
	ORDER BY pr desc LIMIT 0,1";
	return get($sql, "_seo_website", true);
}
function get_clerk_leads($clerk, $status){
	clerk_db();
	$sql = "SELECT * from seo_website WHERE status = '$status' AND clerk = '$clerk' ORDER BY website ASC";
	return get($sql, "_seo_website");
}
function get_clerk_paid_leads($clerk){
	clerk_db();
	$sql = "SELECT e.* from seo_system as e, seo_website as w WHERE e.paid = 1 AND e.paid_status = 'un' AND e.website = w.id AND w.clerk = '$clerk' ";
	return get($sql, "_seo_entry");
}
function get_ready_paid_links($clerk){
	clerk_db();
	$sql = "SELECT * from seo_system WHERE paid = 1 AND paid_status = 're' ";
	return get($sql, "_seo_entry");
}
function get_seo_website_report($website, $status, $clerk){
	clerk_db();
	$sql = "SELECT * from seo_website WHERE status LIKE '%$status%' AND (clerk = '$clerk' OR '$clerk' = '') AND website LIKE '%$website%' ORDER BY website ASC";
	return get($sql, "_seo_website");
}
function get_seo_clerk_stats($clerk, $from, $to){
	clerk_db();
	$sql = "select count(*) as total, action FROM seo_website_log WHERE clerk = '$clerk' AND
	DATE(ldate) >= '$from' AND DATE(ldate) <= '$to'
	GROUP BY action";
	return get_str($sql,false,"action");
}
function get_seo_stat_websites($from, $to, $clerk, $action){
	clerk_db();
	$sql = "select w.website, w.id, l.ldate FROM seo_website_log as l, seo_website as w WHERE l.clerk = '$clerk' AND l.website = w.id AND
	DATE(ldate) >= '$from' AND DATE(ldate) <= '$to' AND action = '$action' ORDER BY w.name ASC";
	return get_str($sql);
}
function get_website_logs($wid){
	clerk_db();
	$sql = "select * FROM seo_website_log where website = '$wid' ORDER BY id DESC";
	return get($sql,"_seo_log");
}

function get_seo_list($id){
	clerk_db();
	$sql = "SELECT * from seo_list WHERE id = ' $id'";
	return get($sql, "_seo_list", true);
}
function get_seo_brand($id){
	clerk_db();
	$sql = "SELECT * from seo_brand WHERE id = ' $id'";
	return get($sql, "_seo_brand", true);
}
function get_seo_article($id){
	clerk_db();
	$sql = "SELECT * from seo_article WHERE id = ' $id'";
	return get($sql, "_seo_article", true);
}
function get_seo_ranking($id){
	clerk_db();
	$sql = "SELECT * from seo_ranking WHERE id = ' $id'";
	return get($sql, "_seo_ranking", true);
}
function seo_delete_list_clerks($lid){
	clerk_db();
	$sql = "DELETE FROM seo_list_by_clerk WHERE list = '$lid'";
	execute($sql);
}
function seo_insert_clerk_in_list($lid, $cid){
	clerk_db();
	$sql = "INSERT INTO seo_list_by_clerk VALUES('$lid','$cid')";
	execute($sql);
}
function get_all_clerks_by_seo_list($lid){
	clerk_db();
	$sql = "SELECT * from seo_list_by_clerk WHERE list = '$lid'";
	return get_str($sql, false, "clerk");
}
function count_seo_websites_by_list($lid, $status = ""){
	clerk_db();
	$sql = "SELECT count(*) as total from seo_website WHERE list = '$lid' AND status LIKE '%$status%'";
	return get_str($sql, true);
}
function get_all_seo_list(){
	clerk_db();
	$sql = "SELECT * from seo_list ORDER BY name ASC";
	return get($sql, "_seo_list");
}
function get_all_seo_brands(){
	clerk_db();
	$sql = "SELECT * from seo_brand ORDER BY name ASC";
	return get($sql, "_seo_brand", false, "id");
}
function get_all_hidden_agents_cashier(){
	sbo_book_db();
	$sql = "SELECT * from hidden_cashier ORDER BY account ASC";
	return get($sql, "_hidden_agents_cashier", false, "id");
}
function get_hidden_agent_cashier($id){
	sbo_book_db();
	$sql = "SELECT * from hidden_cashier WHERE id = '$id'";
	return get($sql, "_hidden_agents_cashier", true);
}
function get_all_seo_articles(){
	clerk_db();
	$sql = "SELECT *, concat(name , ' (' , keyword , ')') as fullname from seo_article ORDER BY name ASC";
	return get($sql, "_seo_article");
}
function get_all_seo_rankings($brand = ""){
	clerk_db();
	$sql = "SELECT * from seo_ranking WHERE brand = '$brand' OR '$brand' = '' ORDER BY brand ASC";
	return get($sql, "_seo_ranking");
}
function seo_cound_paid_links($brand, $keyword){
	clerk_db();	
	$keyword = clean_get($keyword);
	$sql = "select COUNT(*) as total from seo_system where brand = '$brand' AND keywords 
	LIKE '%$keyword%' AND paid = 1 ";	
	return get_str($sql,true);
}
function get_all_seo_rankings_brands(){
	clerk_db();
	$sql = "SELECT * from seo_brand";
	return get($sql,"_seo_brand");
}
function get_all_seo_rankings_keywords(){
	clerk_db();
	$sql = "SELECT DISTINCT keyword from seo_ranking";
	return get($sql,"_seo_ranking");
}
function get_keyword_by_brand_url($brand, $url){
	clerk_db();
	$sql = "SELECT keyword from seo_ranking WHERE url = '$url' AND brand = '$brand'";
	return get($sql,"_seo_ranking", true);
}
function get_all_seo_rankings_urls($brand){
	clerk_db();
	$sql = "SELECT DISTINCT url from seo_ranking WHERE brand = '$brand'";
	return get($sql,"_seo_ranking");
}
function get_seo_website($id){
	clerk_db();
	$sql = "SELECT * from seo_website WHERE id = ' $id'";
	return get($sql, "_seo_website", true);
}



function get_seo_entry($id){
	clerk_db();
	$sql = "SELECT * FROM  seo_system WHERE id = '$id'";
	return get($sql, "_seo_entry", true);
}
function get_seo_black_list(){
	clerk_db();
	$sql = "SELECT * FROM  seo_website WHERE status = 'i' AND black_list = 1";
	return get($sql, "_seo_website");
}

function get_all_players_interests(){
	sbo_book_db();
	$sql = "SELECT * FROM  interest ORDER BY player ASC";
	return get($sql, "_interest");
}
function get_player_interest($id){
	sbo_book_db();
	$sql = "SELECT * FROM  interest WHERE id = '$id'";
	return get($sql, "_interest", true);
}

/*Email Websites*/
function check_email_website($email,$website){
	clerk_db();
	$sql = "SELECT * FROM email_websites where email = '$email' and website = '$website'";
	return get_str($sql);
}
/*End Email Websites*/

//TWEETER WIDGET
function get_wid_tweet_user($id){
	inspinc_tweetdb1();
	$sql = "SELECT * FROM wid_users WHERE id = '$id'";
	return get($sql, "_wid_tweet_user", true);
}

function get_wid_all_tweet_user($available=""){
	inspinc_tweetdb1();
	
	if ($available != ""){
		$sql_available = "WHERE available = 1"; 
	}
	else {$sql_available =""; }
	
	
	$sql = "SELECT * FROM wid_users $sql_available ";
	return get($sql, "_wid_tweet_user");
}

function get_wid_last_uset_tweet($id){
	inspinc_tweetdb1();
	$sql = "SELECT tweet_id, created_date FROM wid_tweets where user_id = '".$id."' order by created_date desc limit 1 ";
	return get_str($sql,true);
}

function get_wid_all_tweets($available="",$user=""){
	inspinc_tweetdb1();
	
	if ($available != ""){
		$sql_available = "WHERE available = 1"; 
	}
	else {$sql_available =""; }

	$sql_user = "";
	if ($user != ""){
		$sql_user = " AND user_id = ".$user." ";
	}
	
	$sql = "SELECT * FROM wid_tweets $sql_available $sql_user  Order by created_date DESC ";
	return get($sql, "_wid_tweet");
}

function get_wid_tweet($id){
	inspinc_tweetdb1();

	$sql = "SELECT * FROM wid_tweets where id = '".$id."'";
	return get($sql, "_wid_tweet",true);
}

//Twitter members

function get_twitter_member($id){
	inspinc_tweetdb1();

	$sql = "SELECT * FROM twitter_members where id = '".$id."'";		
	
	return get($sql, "_twitter_member", true);
}

function get_all_twitter_members($name="",$sport="",$teamid="",$limit=0, $num_results_x_page=""){
	inspinc_tweetdb1();
	
	if ($name != ""){
		$sql_name = " AND name like '%".$name."%' "; 
	}else{
	    $sql_name = "";
    }
	
	if ($sport != ""){
		$sql_sport = " AND sport = '".$sport."' "; 
	}else{
	    $sql_sport = "";
    }
	
	if ($teamid != ""){
		$sql_team = " AND teamid = '".$teamid."' ";
	}else{
	    $sql_team = "";
    }
	
	if ($num_results_x_page != "") {	  	
	    $limit = " LIMIT $limit,$num_results_x_page";
	}	
	else {
	    $limit = "";	
	}
	
	$sql = "SELECT * FROM twitter_members WHERE 1 AND sport NOT IN('TEAM-ACCOUNTS','TV-Analysts') $sql_name $sql_sport $sql_team ORDER BY id ASC $limit";
	
	//echo $sql;
	
	return get($sql, "_twitter_member");
}

//Twitter Teams per League

function get_all_twitter_teams($league){
	inspinc_tweetdb1();
	$sql =  "SELECT * FROM twitter_teams WHERE sport = '" . $league . "' ORDER BY id ASC";
	return get_str($sql);
}

function get_twitter_team($id){
	inspinc_tweetdb1();
	$sql =  "SELECT * FROM twitter_teams WHERE teamid = '". $id."'";
	return get_str($sql,true);
}

//New Feature Notes

function get_all_new_feature_notes($type){

	sbo_book_db();;

	$sql = "SELECT * FROM new_feature WHERE type = '$type' ORDER BY date DESC $limit";

	return get($sql,"_new_feature");
}

function get_new_feature($id){

	sbo_book_db();
	$sql = "SELECT * FROM new_feature WHERE id = '".$id."'";

	return get($sql,"_new_feature",true);
}

// Job Manager
// Espn Games
function get_espn_games_pending($league){
	sbo_sports_db();
	$sql = "SELECT espn.*, (select t.name from teams t where t.id = g.team_away ) as away,(select t.name from teams t where t.id = g.team_home ) as home, g.startdate FROM espn_games espn, games g WHERE 
	espn.gameid = g.id and espn.league = '".$league."'and  espn.espn_id = '-1' and espn.game_date <= '".date("Y-m-d")."' order by game_date ASC";
	return get($sql, "_espn_games");
}

function get_espn_games_for_log($league,$date,$field1,$value1){
	sbo_sports_db();
	//$sql = "SELECT  * from espn_games where league = '".$league."'and  espn_id <> '-1' and  game_date = '".$date."' and $field1 = $value1 and $field2 = $value2  order by game_date ASC";
	$sql = "SELECT  * from espn_games where league = '".$league."'and  espn_id <> '-1' and  game_date >= '".$date."' and $field1 = $value1  order by game_date ASC";	


	return get($sql, "_espn_games");
}


function get_espn_games_custom($league,$date,$field1,$value1,$field2,$value2){
	sbo_sports_db();
	
	//$sql = "SELECT  * from espn_games where  league = '".$league."'and  espn_id <> '-1' and  game_date >= '".$date."' and $field1 = $value1 and $field2 = $value2  ORDER BY RAND() LIMIT 0,5";

	$sql = "SELECT  * from espn_games where  league = '".$league."'and  espn_id <> '-1' and  game_date >= '".$date."' and $field1 = $value1 and $field2 = $value2  ORDER BY ID LIMIT 5";

 //   echo $sql;
	return get($sql, "_espn_games");
}


function get_espn_game($gameid){
	sbo_sports_db();
	$sql = "Select * from espn_games where id = '".$gameid."'" ;
	
	return get($sql, "_espn_games",true);

}

function get_espn_game_espnid($gameid){
	sbo_sports_db();
	$sql = "Select * from espn_games where espn_id = '".$gameid."'" ;
	
	return get($sql, "_espn_games",true);

}


function get_sbo_game($gameid){
	sbo_sports_db();
	$sql = "Select * from games where id = '".$gameid."'" ;
	
	return get($sql, "_sbo_games",true);

}


function get_sbo_schedule($league,$date){
	sbo_sports_db();
	$sql = "select g.id, g.startdate ,
(select name from teams where g.team_away = teams.id ) as 'away', 
 (select short from teams where g.team_away = teams.id ) as 'short_away',
(select name from teams where g.team_home = teams.id ) as 'home' ,
(select short from teams where g.team_home = teams.id ) as 'short_home' 
from games g where league = '".$league."' and date(startdate) = '".$date."' " ;
//echo $sql;
	
	return get_str($sql);

}



function get_team_espn_short($league,$short){
	sbo_sports_db();
	$sql = "select * from teams where espn_short = '".$short."' and league = '".$league."'";
	//echo $sql;
	return get_str($sql,true);
}




function get_game_by_rotation_date($date,$awayrotation){
	sbo_sports_db();
	$sql = "SELECT * FROM games WHERE  DATE(startdate) = DATE('".$date."') AND awayrotationnumber = '".$awayrotation."'";	
	return get($sql, "_sbo_games", true);
}

function get_pph_sports_headline($id){
	tabs_db();
	$sql = "Select * from pph_sports where id = '".$id."'" ;
	
	return get($sql, "_pph_sports",true);

}

function get_all_pph_sports_headline($type = 'n'){
	tabs_db();
	$sql = "Select * from pph_sports where type = '".$type."' " ;
	
	return get($sql, "_pph_sports");

}


function get_main_brands_sports_headline($id){
	tabs_db();
	$sql = "Select * from main_brands_sports where id = '".$id."'" ;
	
	return get($sql, "_main_brands_sports",true);

}

function get_all_main_brands_sports_headline($brand,$type){
	tabs_db();
	$sql = "Select * from main_brands_sports where brand = '".$brand."' and type = '".$type."'" ;
	return get($sql, "_main_brands_sports");

}


//PPH Videos

function get_all_pph_videos($id){
	tabs_db();
	
	if ($id != "") {
		$sql_field = " AND id_site = $id ";
	}else {
		$sql_field = "";	
	}
	
	$sql = "Select * from pph_videos where 1 $sql_field";	
	return get($sql, "_pph_videos");		
}

function get_pph_video($id){
	tabs_db();
	$sql = "Select * from pph_videos where id = '".$id."'" ;	
	return get($sql, "_pph_videos", true);		
}

function get_pph_site($id){
	tabs_db();
	$sql = "Select * from pph_sites where id = '".$id."'" ;	
	return get_str($sql, true);		
}

function get_all_pph_sites($video){
	tabs_db();
	
	if ($video != "") {$sql_field = " AND video = $video ";}

	$sql = "Select * from pph_sites where 1 $sql_field"; 
	return get_str($sql, false);		
}

//END PPH Videos

// Manual Sites Paymets
function get_pre_player_by_brand($brand){
	sbo_book_db();	
	$sql = "SELECT account,name, last FROM `preusers` WHERE account LIKE '%".$brand."%'";
	return get_str($sql);
}

function get_manual_sites_payments($date,$site){
	sbo_book_db();	
	$sql = "select CONCAT_WS('_',site,player,date) as control from manual_sites_payments Where site = $site And date = '".$date."'";
	return get_str($sql,false,'control');
}


//NBA File

function get_nba_teams($index = "id"){
	nba_db();
	$sql = "Select	* from teams order by team Asc";
	return get($sql,"_nba_teams",false,$index);

}

function get_nba_team($id){
	nba_db();
	$sql = "Select	* from teams where id = $id";
	return get($sql,"_nba_teams",true);

}

function get_nba_teams_distance($home){
	nba_db();
	$sql = "Select	*, CONCAT_WS('_',team_home,team_away) as 'control' from teams_distance where team_home = $home";
	return get($sql,"_nba_teams_distance",false,"control");

}


function get_nba_all_teams_distance(){
	nba_db();
	$sql = "Select	*, CONCAT_WS('_',team_home,team_away) as 'control' from teams_distance order by team_home";
	return get($sql,"_nba_teams_distance",false,"control");

}


function get_nba_schedule_by_team($team,$season){
	nba_db();
	$sql = "Select	* from games where (team_home = $team OR team_away = $team) and season = '".$season."'";

	return get($sql,"_nba_games");
}

function get_nba_schedule_team($team,$season,$date){
	nba_db();
	$sql = "Select	* from games where (team_home = $team OR team_away = $team) and season = '".$season."' and date= '".$date."'";
	return get($sql,"_nba_games",true);
} 

function get_nba_schedule_pending_scores($season,$date){
	nba_db();
	$sql = "select * from games where season = '".$season."' and away_points = '' and espn_id != '' and espn_id > 0 and date < '".$date."'";
	return get($sql,"_nba_games");
}
/*
function get_awayrotations_between_dates($league,$date1,$date2){
 sbo_sports_db();
 $date1 = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($date1))) ;	
 $date2 = date ('Y-m-d',strtotime ( '1 day' , strtotime ($date2))) ;	
 $sql="select CONCAT_WS('_',DATE(startdate),team_away) as control,awayrotationnumber from games where league = '".$league."' and DATE(startdate) BETWEEN '".$date1."' AND '".$date2."'";

return get_str($sql,false,"control");
}
function get_league_lines_between_dates($league,$date1,$date2){
  sbo_liveodds_db();
  $date1 = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($date1))) ;	
  $date2 = date ('Y-m-d',strtotime ( '1 day' , strtotime ($date2))) ;	
  $sql = "select *,CONCAT_WS('_',line_date,period,away_rotation) as 'control' from line where league = '".$league."' and line_date BETWEEN '".$date1."' AND '".$date2."'"; 
return get_str($sql,false,"control");
}
*/
function get_all_nba_espn_id($season){
	nba_db();
	$sql = "select espn_id from games where season = '".$season."' and espn_id > 0 ";	
	return get_str($sql,false,"espn_id");	
}

function get_nba_last_team_game($id,$date,$field){
	nba_db();
	$sql = "Select	* from games where team_$field = ".$id." and date < '".$date."' Order by date Desc Limit 1";
  //echo $sql."<BR>";
	return get_str($sql,true);

}

//MLB File

function get_mlb_teams($index = "id"){
	mlb_db();
	$sql = "Select	* from teams order by team Asc";
	return get($sql,"_mlb_teams",false,$index);

}

function get_mlb_team($id){
	mlb_db();
	$sql = "Select	* from teams where id = $id";
	return get($sql,"_mlb_teams",true);

}

function get_mlb_teams_distance($home){
	mlb_db();
	$sql = "Select	*, CONCAT_WS('_',team_home,team_away) as 'control' from teams_distance where team_home = $home";
	return get($sql,"_mlb_teams_distance",false,"control");

}


function get_mlb_all_teams_distance(){
	mlb_db();
	$sql = "Select	*, CONCAT_WS('_',team_home,team_away) as 'control' from teams_distance order by team_home";
	return get($sql,"_mlb_teams_distance",false,"control");

}


function get_mlb_schedule_by_team($team,$season){
	mlb_db();
	$sql = "Select	* from games where (team_home = $team OR team_away = $team) and season = '".$season."'";

	return get($sql,"_mlb_games");
}

function get_mlb_schedule_team($team,$season,$date){
	mlb_db();
	$sql = "Select	* from games where (team_home = $team OR team_away = $team) and season = '".$season."' and date= '".$date."'";
	return get($sql,"_mlb_games",true);
}

function get_mlb_schedule_pending_scores($season,$date){
	mlb_db();
// $sql = "select * from games where season = '".$season."' and away_points = '' and espn_id != '' and date < '".$date."'";
	$sql = "select * from games where season = '".$season."' and five_home_points = '' and espn_id != '' and date < '".$date."'";
 //echo $sql;
	return get($sql,"_mlb_games");
}

function get_awayrotations_between_dates($league,$date1,$date2){
	sbo_sports_db();
	$date1 = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($date1))) ;	
	$date2 = date ('Y-m-d',strtotime ( '1 day' , strtotime ($date2))) ;	
	$sql="select CONCAT_WS('_',DATE(startdate),team_away) as control,awayrotationnumber from games where league = '".$league."' and DATE(startdate) BETWEEN '".$date1."' AND '".$date2."'";

	return get_str($sql,false,"control");
}
function get_league_lines_between_dates($league,$date1,$date2){
	sbo_liveodds_db();
	$date1 = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($date1))) ;	
	$date2 = date ('Y-m-d',strtotime ( '1 day' , strtotime ($date2))) ;	
	$sql = "select *,CONCAT_WS('_',line_date,period,away_rotation) as 'control' from line where league = '".$league."' and line_date BETWEEN '".$date1."' AND '".$date2."'"; 

	return get_str($sql,false,"control");
}

function get_lines_by_date_rotations($date,$rot){
	sbo_liveodds_db();
	$sql = "select * from line where away_rotation	 = '".$rot."' and line_date = '".$date."'"; 
	return get_str($sql,true);
}



function get_all_mlb_espn_id($season){
	mlb_db();
	$sql = "select espn_id from games where season = '".$season."' and espn_id > 0 ";	
	return get_str($sql,false,"espn_id");	
}




//NHL FILE

function get_nhl_teams($index = "id"){
	nhl_db();
	$sql = "Select	* from teams order by team Asc";
	return get($sql,"_nhl_teams",false,$index);

}

function get_nhl_team($id){
	nhl_db();
	$sql = "Select	* from teams where id = $id";
	return get($sql,"_nhl_teams",true);

}

function get_nhl_teams_distance($home){
	nhl_db();
	$sql = "Select	*, CONCAT_WS('_',team_home,team_away) as 'control' from teams_distance where team_home = $home";
	return get($sql,"_nhl_teams_distance",false,"control");

}


function get_nhl_all_teams_distance(){
	nhl_db();
	$sql = "Select	*, CONCAT_WS('_',team_home,team_away) as 'control' from teams_distance order by team_home";
	return get($sql,"_nhl_teams_distance",false,"control");

}


function get_nhl_schedule_by_team($team,$season){
	nhl_db();
	$sql = "Select	* from games where (team_home = $team OR team_away = $team) and season = '".$season."'";

	return get($sql,"_nhl_games");
}

function get_nhl_schedule_team($team,$season,$date){
	nhl_db();
	$sql = "Select	* from games where (team_home = $team OR team_away = $team) and season = '".$season."' and date= '".$date."'";
	return get($sql,"_nhl_games",true);
}

function get_nhl_schedule_pending_scores($season,$date){
	nhl_db();
	$sql = "select * from games where season = '".$season."' and away_points = '' and espn_id != '' and espn_id > 0  and date < '".$date."'";
	return get($sql,"_nhl_games");
}

/*
function get_awayrotations_between_dates($league,$date1,$date2){
 sbo_sports_db();
 $date1 = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($date1))) ;	
 $date2 = date ('Y-m-d',strtotime ( '1 day' , strtotime ($date2))) ;	
 $sql="select CONCAT_WS('_',DATE(startdate),team_away) as control,awayrotationnumber from games where league = '".$league."' and DATE(startdate) BETWEEN '".$date1."' AND '".$date2."'";

return get_str($sql,false,"control");
}
function get_league_lines_between_dates($league,$date1,$date2){
  sbo_liveodds_db();
  $date1 = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($date1))) ;	
  $date2 = date ('Y-m-d',strtotime ( '1 day' , strtotime ($date2))) ;	
  $sql = "select *,CONCAT_WS('_',line_date,period,away_rotation) as 'control' from line where league = '".$league."' and line_date BETWEEN '".$date1."' AND '".$date2."'"; 
return get_str($sql,false,"control");
}
*/

function get_all_nhl_espn_id($season){
	nhl_db();
	$sql = "select espn_id from games where season = '".$season."' and espn_id > 0 ";	
	return get_str($sql,false,"espn_id");	
}

function get_nhl_last_team_game($id,$date,$field){
	nhl_db();
	$sql = "Select * from games where team_$field = ".$id." and date < '".$date."' Order by date Desc Limit 1";
	return get_str($sql,true);

}


//NFL File

function get_nfl_teams($index = "id"){
	nfl_db();
	$sql = "Select	* from teams order by team Asc";
	return get($sql,"_nfl_teams",false,$index);

}

function get_nfl_team($id){
	nfl_db();
	$sql = "Select	* from teams where id = $id";
	return get($sql,"_nfl_teams",true);

}


// PROPS FILE


function get_all_props_players_league($league, $index = "espn_id"){
	props_db();
	$sql = "SELECT *, CONCAT_WS('_',league,espn_id)as 'control' FROM players";
	return get($sql,"_props_players",false,$index);

}

function get_props_alert($id){
	props_db();
	$sql = "Select * from alerts where id = $id " ;
	return get($sql,"_alerts",true);

}

function get_pending_props_alerts(){
	props_db();
	$sql = "Select a.* from alerts a where a.reviewed = '0'" ;
	return get($sql,"_alerts");

}

function get_props_alerts($from,$to,$league,$type){
	props_db();
	if($league){ $sqlleague = " AND league = '".$league."' "; }
	if($type){ $sqltype = " AND type = '".$type."' "; }   
	$sql = "Select * from alerts a where (DATE(date) >= '".$from."' && DATE(date) <= '".$to."') $sqlleague $sqltype  " ;
	return get($sql,"_alerts");

}

function get_props_alerts_types(){
	props_db();
	$sql = "Select DISTINCT(type) from alerts" ;
	return get($sql,"_alerts");

}

function get_players_props_added($league,$espn_id){
	props_db();
	//$sql = "Select player_espn_id From game_log Where espn_game	 = '".$espn_id."' AND league = '".$league."' " ;
	$sql = "Select  player_espn_id, max(type) as type From game_log g Where espn_game =  '".$espn_id."' AND league = '".$league."'   GROUP BY player_espn_id order by type DESC";
	//echo $sql; exit;
	return get_str($sql,false,'player_espn_id');

}


function get_game_players($league,$espn_id){
	props_db();
	$sql = "Select gp.espn_player_id,optional_id,bench from game_players gp,players p WHERE p.espn_id = gp.espn_player_id AND  gp.espn_game_id =  '".$espn_id."' AND gp.league ='".$league."'  AND p.league ='".$league."' ORDER BY RAND()";
	//echo $sql;
	return get_str($sql,false,"espn_player_id");

}



function get_player_by_name($league,$name,$team){
    
    props_db();
	$sql = "Select * from players WHERE nick LIKE  '%".$name."%' AND league ='".$league."' AND team = '".$team."' ";
	//echo $sql."<BR>";
	return get($sql,"_props_players",true) ;
}

function get_optional_ids($league){
    
    props_db();
	$sql = "Select optional_id from players WHERE league ='".$league."' ";
	//echo $sql."<BR>";
	return get($sql,"_props_players",false,'optional_id') ;
}



//Ticker Message Agents-players

function get_ticker_message($id){
	sbo_book_db();
	$sql = "SELECT * FROM  ticker_message WHERE id = $id";
	return get($sql, "_ticker_message",true);
}

function get_ticker_message_by_player($ticket,$player){
	sbo_book_db();
	$sql = "SELECT * FROM  ticker_message_by_player WHERE id = $id";
	return get($sql, "_ticker_message");
}

// telegram
function get_telegram_user_by_email($email){
	clerk_db();
	$sql = "SELECT * FROM telegram WHERE email = '$email' ";
	return get($sql, "telegram", true);
}

function get_telegram_users(){
	clerk_db();
	$sql = "SELECT * FROM telegram";
	return get($sql, "telegram");
}

//Leagues

function get_leagues(){
	sbo_sports_db();
	$sql = "SELECT * FROM leagues ORDER BY pos ASC";
	return get($sql, "_league");
}

function get_league($id){
	sbo_sports_db();
	$sql = "SELECT * FROM leagues WHERE id = $id";
	return get($sql, "_league", true);
}


// graded legues time

function get_leagues_graded_time(){
	 props_db();
	$sql = "SELECT * FROM graded_time_leagues ORDER BY league ASC";
	return get($sql, "_graded_time_leagues");

}

function get_league_graded_time($id){
	 props_db();
	$sql = "SELECT * FROM graded_time_leagues WHERE id = $id  ORDER BY league ASC";
	return get($sql, "_graded_time_leagues" , true);

}

// headlines



///special

function search_pph_bill_special($from, $to, $account = ""){
	accounting_db();
	if($account != ""){$sql_acc = " AND account = '$account' ";}
	$sql = "SELECT * FROM special_billing WHERE DATE(mdate) >= '$from' AND DATE(mdate) <= '$to' $sql_acc
	ORDER BY id DESC";
	
	return get($sql, "_special_bill");
}


function get_pph_account_test($id){
	accounting_db();
	$sql = "SELECT * FROM  pph_account_test WHERE id = '$id'";
	return get($sql, "_pph_account_test", true);
}

function get_all_pph_accounts_for_billing_test($date){
	accounting_db();
	$sql = "SELECT * FROM  pph_account_test WHERE deleted = 0 AND last_billing < '$date' ORDER BY NAME ASC";
	return get($sql, "_pph_account_test");
}


function search_pph_accounts_test($house = "", $deleted = "", $commission = ""){
	accounting_db();
	if($house != ""){$sql_house = " AND house = '$house'";}
	if($deleted != ""){$sql_deleted = " AND deleted = '$deleted'";}
	if($commission != ""){$sql_commission = " AND is_commission = '$commission'";}
	$sql = "SELECT * FROM  pph_account_test WHERE 1 $sql_deleted $sql_house $sql_commission ORDER BY NAME ASC";
	return get($sql, "_pph_account_test", false, "id");
}

function get_pph_account_by_name_test($name){
	accounting_db();
	$sql = "SELECT * FROM  pph_account_test WHERE name = '$name'";
	return get($sql, "_pph_account_test", true);

}
//


function get_player_headline_image($league,$team){
	 props_db();
	
	$sql = "SELECT espn_id,team,name,type FROM players WHERE league = '".$league."' and team = '".$team."' and headline = 1  ORDER BY name ASC";
	//echo $sql;
	return get_str($sql);

}