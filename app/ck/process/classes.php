<?
class system_settings{
	var $settings;
	function __construct($pset){
		$this->settings = $pset;
	}
	function get($name){
		return $this->settings[$name];
	}
}
class system_setting{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "settings", $specific);
	}
}

class _menu{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "menu", $specific);
	}
}

class buymoneypaks_system_setting{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "moneypak_sell_settings", $specific);
	}
}
class permission{
	
	var $vars = array();
	
	function initial(){}
}

class period {
 	var $vars = array();
   	function initial(){}
}

class durango{
    var $vars = array();
    function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "durango_control", $specific);
	}
	function insert($tablename){
	   clerk_db();
	   $this->vars["id"] = insert($this, $tablename);
	}
	function update_name($specific = NULL){
	   clerk_db();
	   return update($this, "durango_name", $specific);
	}
	
}
class _affiliate_by_clerk{
    function __construct($pvars = array()){$this->vars = $pvars;}
	var $vars = array();
	function initial(){}
	function update($specific = NULL){
	    clerk_db();
	   return update($this, "affiliate_by_clerk", $specific);
	}
	function insert(){
	    clerk_db();
		$this->vars["id"] = insert($this, "affiliate_by_clerk");
	}
	function delete(){
	   clerk_db();
	   delete("affiliate_by_clerk", $this->vars["id"]);
	}
	
	
}



class _phone_login{
	var $vars = array();
    function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	    clerk_db();
	   return update($this, "login_by_user", $specific);
	}
	function insert(){
	    clerk_db();
		$this->vars["id"] = insert($this, "login_by_user");
	}
	function delete(){
	   clerk_db();
	   delete("login_by_user", $this->vars["id"]);
	}
}


class clerk{
	var $vars = array();
	var $calls_per_hour = 0;
	var $permissions = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	//function clerk($pvars = array()){$this->vars = $pvars;}
	function initial(){
		
		$this->vars["level"] = get_ck_level($this->vars["level"]);
		$this->vars["user_group"] = get_user_group($this->vars["user_group"]);
		//$this->calls_per_hour = $this->calculate_calls_per_hour(date("Y-m-d"));
		$this->permissions = get_clerk_permissions($this->vars["id"], $this->vars["user_group"]->vars["id"]);
	}

	
	
	function get_estiamation_hours_by_week($week, $schedule = NULL){
		$hours = 0;
		$today_time = strtotime(date("Y-m-d"));
		if(is_null($schedule)){$schedule = get_all_schedule_by_clerk($this->vars["id"],$week);}
		$working_logs = get_week_logins($this->vars["id"], $week);
		for($i=0;$i<7;$i++){
			$day = date("Y-m-d", strtotime($week." + $i days"));
			$day_time = strtotime($day);
			$sday = strtolower(date("D",$day_time));
			if(!is_null($schedule[$sday])){	
				if($day_time < $today_time){
					//real hours
					if(!is_null($working_logs[$day."-0"]) && !is_null($working_logs[$day."-1"])){
						$start = strtotime($working_logs[$day."-0"]->vars["date"]);
						$end = strtotime($working_logs[$day."-1"]->vars["date"]);	
					}else{
						$start = 0;
						$end = 0;	
					}
					
				}else{
					//schedule hours				
					$start = strtotime($schedule[$sday]->vars["open_hour"]);
					$end = strtotime($schedule[$sday]->vars["close_hour"]);					
				}
				$hours += ($end - $start);
			}
		}
		return round($hours/60/60,1);
	}
	function get_schedule_hours_by_week($week, $schedule = NULL){
		$hours = 0;
		$today_time = strtotime(date("Y-m-d"));
		if(is_null($schedule)){$schedule = get_all_schedule_by_clerk($this->vars["id"],$week);}
		for($i=0;$i<7;$i++){
			$day = date("Y-m-d", strtotime($week." + $i days"));
			$day_time = strtotime($day);
			$sday = strtolower(date("D",$day_time));
			if(!is_null($schedule[$sday])){	
				//schedule hours				
				$start = strtotime($schedule[$sday]->vars["open_hour"]);
				$end = strtotime($schedule[$sday]->vars["close_hour"]);					
				$hours += ($end - $start);
			}
		}
		return round($hours/60/60,1);
	}
	function get_worked_hours_by_week($week){
		$hours = 0;
		$today_time = strtotime(date("Y-m-d"));
		$working_logs = get_week_logins($this->vars["id"], $week);
		for($i=0;$i<7;$i++){
			$day = date("Y-m-d", strtotime($week." + $i days"));
			$day_time = strtotime($day);
			if($day_time <= $today_time){
				//real hours
				if(!is_null($working_logs[$day."-0"]) && !is_null($working_logs[$day."-1"])){
					$start = strtotime($working_logs[$day."-0"]->vars["date"]);
					$end = strtotime($working_logs[$day."-1"]->vars["date"]);
					$hours += ($end - $start);	
				}				
			}				
		}
		return round($hours/60/60,1);
	}
	
	
	function break_action($end = ""){
		if($end != ""){
			$break = get_break($end);
			$break->vars["end_time"] = gmdate("Y-m-d H:i:s",time()-(6*60*60));
			$break->update(array("end_time"));
		}else{
			$break = new ck_break();
			$break->vars["user"] = $this->vars["id"];
			$break->vars["start_time"] = gmdate("Y-m-d H:i:s",time()-(6*60*60));
			$break->insert();
		}
	}
	
	function get_tickets_category()
	{
	  $category=strtolower($this->vars["name"]); 
	   return $category;
	}
	
	function im_allow($permission_name){
		$allow = false;
		foreach($this->permissions as $per){
			if($per->vars["name"] == $permission_name){$allow = true; }
		}
		return $allow;
	}
	
	function is_manager(){
		$allow = false;
		$manager = get_clerk_manager_group($this->vars["id"]);
//		print_r($manager); exit;
		 if (!empty($manager)) { $allow = true;}
		return $allow;
	}
	
	function has_login_extension(){
		$allow = false;
		$login = get_all_clerk_phone_logins($this->vars["id"]);
		 if (!empty($login) > 0) { $allow = true;}
		return $allow;
	}
	
	
	function time_logs_period($from, $to){
		$time = 0;
		if($from == $to){$time = $this->time_log_per_day($from);}
		else{
			$time += $this->time_log_per_day($from);
			$current = $from;
			while($current != $to){
				$current = date("Y-m-d",strtotime($current . " +1 day"));
				$time += $this->time_log_per_day($current);
			}
		}
		return $time;
	}
	function break_time($from, $to, $detail = false){
		$time = 0;
		$breaks = search_breaks($this->vars["id"], $from, $to);
		foreach($breaks as $break){
			$time += $break->get_time();
		}
		if($time>0){$time = $time / 60 / 60;}
		if($detail){return array("start"=>$break->vars["start_time"],"end"=>$break->vars["end_time"],"time"=>$time);}
		else{return $time;}	
	}
	function time_log_per_day($date, $detail = false){
		$logs = search_log_ins($this->vars["id"], $date);
		$time = 0;
		if(!$logs[0]->vars["out"] && $logs[1]->vars["out"]){
			$diff = strtotime($logs[1]->vars["date"]) - strtotime($logs[0]->vars["date"]);
			$time = $diff / 60 / 60;
		}
		//if($detail){return array("start"=>$logs[0]->vars["date"],"end"=>$logs[1]->vars["date"],time=>$time);}
		if($detail){return array("start"=>$logs[0]->vars["date"],"end"=>$logs[1]->vars["date"],"time"=>$time);}
		else{return $time;}		
	}
	
	function my_balance(){
		$transactions = get_transactions_by_clerk($this->vars["id"]);
		$balance = 0;
		foreach($transactions as $trs){
			if($trs->vars["substract"]){$balance -= $trs->vars["amount"];}
			else{$balance += $trs->vars["amount"];}
		}
		return round($balance,2);
	}
	function calculate_comision($amount, $method){
		$comision = $amount * ($method["percentage"]/100);
		if($comision > $method["cap"]){$comision = $method["cap"];}
		return $comision;
	}
	function transfer_sender($relation){
		if($relation->vars["from"] == $this->vars["id"]){
			$is = true;
		}else{
			$is = false;
		}
		return $is;
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "user", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "user");
	}	
	
	function insert_permission(){
	  clerk_db();
	  insert($this, "permission_by_user");
	}
	
	function print_status(){
		$status = "Disabled";
		if($this->vars["available"]){$status = "Enabled";}	
		return $status;
	}
	function admin(){
		$admin = false;
		if($this->vars["level"]->vars["id"] == 1){
			$admin = true;
		}
		return $admin;
	}
	function logged_time($from, $to){
		$current = $from;
		$run = true;
		$hours = 0;
		while($run){
			$hl = $this->hours_logged($current);
			if($hl > 0){
				$hours += $hl;
			}
			if($current == $to){$run = false;}
			else{$current = date("Y-m-d",strtotime($current)+86400);}
		}
		return $hours;
	}
	function hours_logged($date){
		$log = get_today_first_log($this->vars["id"],$date);
		if(date("Y-m-d") == date("Y-m-d",strtotime($date))){$current_time = time();}
		else{
			$last_call = get_last_call_of_day($this->vars["id"],$date);
			if($last_call->vars["final_status"] != 0 && date("y-m-d",strtotime($last_call->vars["call_start"])) == date("y-m-d",strtotime($last_call->vars["call_end"]))){
				$current_time = strtotime($last_call->vars["call_end"]);
			}else{
				$current_time = strtotime($last_call->vars["call_start"]);
			}
		}
		$hours = 0;
		if(!is_null($log)){
			$dif = $current_time-strtotime($log["date"]);
			$hours = round($dif/60/60,2);
		}
		return $hours;
	}
	function calculate_calls_per_hour($date){
		$hours = $this->hours_logged($date);
		$calls_count = count(get_today_calls($this->vars["id"],$date));
		$cph = 0;
		if($hours>0){
			$cph = 	round($calls_count / $hours,2);
		}
		return $cph;
	}
	static function sort_by_cph($a, $b){
		return sort_object($a->calls_per_hour, $b->calls_per_hour,"DESC");
   }
   function count_calls_by_status($status,$date=""){
	   $count = get_calls_count_by_status($this->vars["id"],$status,$date);
	   return $count["number"];
   }
}
class clerk_schedule{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	//function clerk_schedule($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "user_schedule", $specific);
	}
	function insert(){
	   clerk_db();
	    $this->vars["id"] = insert($this, "user_schedule");
	}
	
	function delete(){
	   clerk_db();
	   delete("user_schedule", $this->vars["id"]);
	}	
}

class user_backup_day{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "user_backup_day", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "user_backup_day");
	}
	function delete(){
	   clerk_db();
	   delete("user_backup_day", $this->vars["id"]);
	}	
	
}

class _user_vacation{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "user_vacation", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "user_vacation");
	}
	function delete(){
	   clerk_db();
	   delete("user_vacation", $this->vars["id"]);
	}	
	
}



class ck_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "log", $specific);
	}
	function insert(){
	   clerk_db();
	    $this->vars["id"] = insert($this, "log");
	}
}
class time_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "user_times", $specific);
	}
	function insert(){
	   clerk_db();
	    $this->vars["id"] = insert($this, "user_times");
	}
	function already_in(){
		if(is_null(get_log_in($this->vars["user"], $this->vars["date"]))){$in = false;}else{$in = true;}
		return $in;
	}
}
class ck_list_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "list_log", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "list_log");
	}
}

class ck_break{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "breaks", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "breaks");
	}
	function get_time(){
		if(is_null($this->vars["end_time"])){$end = gmdate("Y-m-d H:i:s",time()-(6*60*60));}else{$end = $this->vars["end_time"];}
		$time =  strtotime($end) - strtotime($this->vars["start_time"]);
		return $time;
	}
}

class names_list{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["admin"] = get_clerk($this->vars["admin"]);
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "list", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "list");
	}
	function print_status(){
		$status = "Disabled";
		if($this->vars["available"]){$status = "Enabled";}	
		return $status;
	}
	function load_names_from_CSV($file, $first = false, $save = false){
		$fp = fopen ($file, "r");
		$names = array();
		$index = 0;
		while(($data = fgetcsv($fp, 2000, ",")) !== FALSE) {
			if(($first && $index >0) || !$first){
				$vars = array();
				$vars["list"] = $this->vars["id"];
				$vars["name"] = clean_chars($data[0]);
				$vars["last_name"] = clean_chars($data[1]);
				$vars["street"] = clean_chars($data[2]);
				$vars["city"] = clean_chars($data[3]);
				$vars["state"] = get_state_code(clean_chars($data[4]));
				$vars["zip"] = clean_chars($data[5]);
				$vars["email"] = clean_chars($data[6]);
				$vars["phone"] = preg_replace("/[^0-9]/", "", clean_chars($data[7]));
				$vars["phone2"] = preg_replace("/[^0-9]/", "", clean_chars($data[8]));
				$vars["acc_number"] = clean_chars($data[9]);
				$vars["aff_id"] = clean_chars($data[10]);
				$vars["added_date"] = date("Y-m-d H:i:s");
				
				$new = 	new ck_name($vars);
				if($save){
					
					//$dup_name = get_dup_in_available_lists($new->vars["phone"]);
					$not_enable_statuses = array(2,3,12);
					
					if(is_null($dup_name)){
						//phone not exist in the list
						$new->insert();	
						$names[] = $new;
					}else if(!$dup_name->vars["available"] && !in_array($dup_name->vars["status"]->vars["id"],$not_enable_statuses) && $new->vars["list"] == $dup_name->vars["list"]->vars["id"]){
						//phone exist in the list and is disable
						$dup_name->vars["available"] = "1";
						$dup_name->vars["status"] = "1";
						$dup_name->vars["clerk"] = "0";
						$dup_name->vars["on_the_phone"] = "0";
						$dup_name->vars["current_call"] = "0";
						$dup_name->update();
					}else{
						//phone exist in the available lists
					}
					
				}else{
					$names[] = $new;
				}
				
			}
			$index++;
		} 
		fclose ( $fp );
		return $names;
	}
	function load_websites_from_CSV($file, $first = false, $save = false){
		$fp = fopen ($file, "r");
		$webs = array();
		$index = 0;
		while(($data = fgetcsv($fp, 2000, ",")) !== FALSE) {
			if(($first && $index >0) || !$first){
				$vars = array();
				$vars["affiliate"] = clean_chars($data[0]);
				$vars["name"] = clean_chars($data[1]);
				$new = 	new ck_website($vars);
				if($save){$new->insert();}
				$webs[] = $new;
			}
			$index++;
		} 
		fclose ( $fp );
		return $webs;
	}
	function insert_list_log($clerk, $file){
		$vars["list"] = $this->vars["id"];
		$vars["upload_date"] = date("Y-m-d H:i:s");
		$vars["admin"] = $clerk;
		$vars["file_name"] = $file;
		$log = new ck_list_log($vars);
		$log->insert();
	}
}
class ck_name{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["clerk"] = get_clerk($this->vars["clerk"]);
		$this->vars["list"] = get_names_list($this->vars["list"]);
		$this->vars["status"] = get_name_status($this->vars["status"]);
	}
	function insert_lead_transfer(){
		$this->vars["closer_attended"] = "1";
		$lv["name"] = $this->vars["id"];
		$lv["clerk"] = $this->vars["clerk"]->vars["id"];
		$lv["tdate"] = date("Y-m-d H:i:s");
		$ltrans = new lead_transfer($lv);
		$ltrans->insert();
	}
	function call_back_str(){
		if(date("Y-m-d") == date("Y-m-d",strtotime($this->vars["next_date"]))){
			if(date("H:i",strtotime($this->vars["next_date"])) == "00:00"){$result = "Today";}	
			else{$result = "at ". date("h:i A",strtotime($this->vars["next_date"]));}
		}
		return $result;
	}
	function insert_transaction($amount, $method, $comment, $clerk = NULL){
		if(is_null($clerk)){$vars["clerk"] = $this->vars["clerk"]->vars["id"];}
		else{$vars["clerk"] = $clerk;}		
		$vars["name"] = $this->vars["id"];
		$vars["substract"] = "0";
		$vars["transaction_date"] = date("Y-m-d H:i:s");
		$vars["amount"] = $amount;
		$vars["current_percentage"] = $method["percentage"];
		$vars["current_cap"] = $method["cap"];
		$vars["comment"] = $comment;
		$transaction = new clerk_transaction($vars);
		$transaction->insert();
	}
	function call_back_color(){
		$time = str_replace("00:00:00","23:59:59",$this->vars["next_date"]);
		if(strtotime($time)-3600>time()){
			$color = "06F";
		}else if(strtotime($time)<time() && time()<strtotime($time)+3600){
			$color = "060";
		}else if(strtotime($time)+3600<time()+3600){
			$color = "900";
		}
		return $color;
	}
	function update($specific = NULL, $secure = false){
	   clerk_db();
	   if(!$secure || !$this->vars["on_the_phone"]){
	   	  return update($this, "name", $specific);
	   }
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "name");
	}
	function full_name(){
		return $this->vars["name"] . " " . $this->vars["last_name"];	
	}
	function print_status(){
		$status = "Disabled";
		if($this->vars["available"]){$status = "Enabled";}	
		return $status;
	}
	function open_call($clerk_id, $view = false, $start = "", $new = "0"){
		if($start == ""){$start = date("Y-m-d H:i:s");}
		//call
		$vars = array();
		$vars["clerk"] = $clerk_id;
		$vars["name"] = $this->vars["id"];
		$vars["call_start"] = $start;
		$vars["is_new"] = $new;
		$call = new call($vars);
		$call->insert();
		//name
		$this->vars["on_the_phone"] = 1;
		if(!$view || $this->vars["clerk"] == 0){$this->vars["clerk"] = $clerk_id;}
		$this->vars["current_call"] = $call->vars["id"];
		$this->update(array("on_the_phone","clerk","current_call","closer_attended"));
		
	}
	function close_call($reset_status = "", $new_lead = "0", $conversation_status = "", $conversation_status_time = ""){
		//call
		$call = get_call($this->vars["current_call"]);
		$call->vars["call_end"] = date("Y-m-d H:i:s");
		$call->vars["final_status"] = $this->vars["status"];
		$call->vars["new_lead"] = $new_lead;
		$call->vars["conversation_status"] = $conversation_status;
		$call->vars["conversation_status_time"] = $conversation_status_time;
		$call->update();
		
		if($reset_status != ""){$this->vars["status"] = $reset_status;}
		
		$this->vars["on_the_phone"] = "0";
		$this->vars["current_call"] = "0";
		
		$this->vars["clerk"] = $this->vars["clerk"]->vars["id"];
		
		$this->update();
	}
	function back_status(){
		switch($this->vars["status"]->vars["id"]){
			case "6":
				$str = "Called on ";
			break;
			case "9":
				$str = "Called on ";
			break;
			case "7":
				$str = "Message Sent on ";
			break;
			case "8":
				$str = "Email Sent on ";
			break;
		}
		return $str;
	}
	function get_clerck_name(){
		if(is_null($this->vars["clerk"])){
			$name = "Free";
		}else{
			$name = $this->vars["clerk"]->vars["name"];
		}	
		return $name;
	}
}
class status{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "status", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "status");
	}
}
class call{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["final_status"]	= get_name_status($this->vars["final_status"]);
		$this->vars["conversation_status"]	= get_conversation_status($this->vars["conversation_status"]);
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "call", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "call");
	}
	function is_open(){
		$open = false;
		if(is_null($this->vars["final_status"]) || $this->vars["final_status"] == 0){
			$open = true;
		}
		return $open;
	}
	function get_status($id = false){
		if($id){$var = "id";$def = 0;}else{$var = "name";$def = "Open Call";}
		if($this->is_open()){$result = $def;}
		else{$result = $this->vars["final_status"]->vars[$var];}
		return $result;
	}
	function call_time(){
		if($this->is_open()){$compare = time();}
		else{$compare = strtotime($this->vars["call_end"]);}
		return time_diff($compare-strtotime($this->vars["call_start"]));
	}
}
class rule{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "rule", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "rule");
	}
	function delete(){
	   $this->delete_reads();
	   clerk_db();
	   delete("rule", $this->vars["id"]);
	}
	function delete_reads(){
	   clerk_db();
	   delete("rule_by_reads", "","rule = '". $this->vars["id"] ."'");
	}
	function insert_no_reads($clerk_id){
		$read = array();
		$read["clerk"] = $clerk_id;
		$read["rule"] = $this->vars["id"];
		insert($read, "rule_by_reads");
	}
	/*
	function insert_no_reads($clerk_level){
		$clerks = get_all_clerks("",$clerk_level);
		foreach($clerks as $clerk){
			$read = array();
			$read["clerk"] = $clerk->vars["id"];
			$read["rule"] = $this->vars["id"];
			insert($read, "rule_by_reads");
		}
	}
	
	*/
}
class _affiliate_description{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "affiliate_descriptions", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "affiliate_descriptions");
	}
}
class ck_message{
	var $vars = array();
	var $attachments = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["from"] = get_clerk($this->vars["from"]);
		$this->vars["to"] = get_clerk($this->vars["to"]);
		$this->attachments = get_attachments_by_message($this->vars["id"]);
	}
	function have_attachments(){
		$have = false;
		if(!empty($this->attachments)){$have = true;}	
		return $have;
	}
	function send(){
		$this->insert();
		foreach($this->attachments as $att){
			$att->vars["message"] = $this->vars["id"];
			$att->insert();
		}
		$this->send_alert_email();
	}
	function resend($clerk){
		if($this->vars["from"]->vars["id"] == $clerk->vars["id"]){
			$type = "read_to";
		}else{
			$type = "read_from";
		}
		$this->vars[$type] = 0;
		$this->vars["last_date"] = date("Y-m-d H:i:s");
		$this->update(array($type,"last_date","content"));
	}
	function attach($input, $path, $up_file = ""){
		$base = basename($_FILES[$input]['name']);
		$parts = explode(".",$base);
		$att_vars["name"] = $base;
		
		if($up_file == ""){
			$att_vars["file"] = upload_file($input, $path,mt_rand(100,999)."_".$parts[0]);
		}else{
			if(file_exists($path.$up_file)){
				$new = mt_rand(100,999)."_".$base;				
				copy($path.$up_file,$path.$new);
				$att_vars["file"] = $new;
			}else{$att_vars["name"] = "";}
		}
		
		if($att_vars["name"] != ""){
			$this->attachments[] = new attachment($att_vars);
		}
		return $att_vars["file"];
	}
	function copy_attach($path, $up_file){
		if(file_exists($path.$up_file)){
			$new = mt_rand(100,999)."_".$up_file;				
			copy($path.$up_file,$path.$new);
			$att_vars["file"] = $new;
			$att_vars["name"] = $up_file;
			$this->attachments[] = new attachment($att_vars);
		}
	}
	function send_alert_email(){
		$content = "Hello " . $this->vars["to"]->vars["name"];
		$content .= "<br /><br />You received a New Private Message on VRB Marketing From: " . $this->vars["from"]->vars["name"];
		$content .= '<br /><br />"'.$this->vars["title"].'"';
		$content .= '<br /><br />'.str_replace("rnrn","<br />",nl2br($this->vars["content"]));
		$content .= '<br /><br /><a href="http://localhost:8080">vrbmarketing.com</a>';
		send_email_ck($this->vars["to"]->vars["email"], "You have a new Private Message on VRB", $content, true);
	}
	function change_important(){
		if($this->vars["important"]){$this->vars["important"] = "0";}
		else{$this->vars["important"] = "1";}		
		$this->update(array("important"));
	}
	function change_complete(){
		if($this->vars["complete"]){
			$this->vars["complete"] = "0";
		}else{
			$this->vars["complete"] = "1";
			$this->vars["complete_date"] = date("Y-m-d H:i:s");
		}		
		$this->update(array("complete","complete_date"));
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "message", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "message");
	}
	function delete(){
		$this->vars["deleted"] = 1;
		$this->update(array("deleted"));
	}
	function restore(){
		$this->vars["deleted"] = 0;
		$this->update(array("deleted"));
	}
	function _empty(){
	   clerk_db();
	   foreach(get_message_replys($this->vars["id"]) as $reply){
		   $reply->delete();
	   }
	   
	   foreach($this->attachments as $att){$att->delete();}
	   
	   delete("message", $this->vars["id"]);
	}
	function is_read($clerk){
		$read = true;
		if($this->vars["from"]->vars["id"] == $clerk->vars["id"]){
			$type = "read_from";
		}else{
			$type = "read_to";
		}
		if(!$msg->vars[$type]){$read = false;}
		return $read;
	}
	function is_message_read($clerk){
		$read = true;
		if($this->vars["from"]->vars["id"] == $clerk->vars["id"]){
			$type = "read_from";
		}else{
			$type = "read_to";
		}
		if(!$this->vars[$type]){$read = false;}
		return $read;
	}
}
class list_pointer{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["list"] = get_names_list($this->vars["list"]);
	}
	function move($signups = false){
		if(
			$this->vars["remaining"]<1 || !$this->vars["list"]->vars["available"] || is_null(_get_random_name($this->vars["list"]->vars["id"]))
			|| ($this->vars["list"]->vars["id"]=="20" && !$signups)
		){
			$this->vars["list"] = get_next_available_list($this->vars["list"]);
			$this->vars["remaining"] = $this->vars["list"]->vars["allow"];
		}
		$this->vars["remaining"]--;
		if(!is_null($this->vars["list"])){$this->update();}
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "list_pointer", $specific);
	}
}
class ck_website{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "website", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "website");
	}	
}
class ck_level{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "levels", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "levels");
	}	
}
class user_group{
	var $vars = array();
//	function user_group($pvars = array()){$this->vars = $pvars;}
	function __construct($pvars = array()) {$this->vars = $pvars; }
	
	function initial(){ }
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "user_group", $specific);
	}
	function insert(){
	   clerk_db();
	   //$this->vars["id"] = insert_test($this, "user_group");
	   $this->vars["id"] = insert($this, "user_group");
	}	
}
class user_group_per_chat{
	var $vars = array();	
	function initial(){}		
}
class attachment{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "attachment", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "attachment");
	}
	function delete(){
	   clerk_db();
	   $path = "./ck/attachments/";
	   if(file_exists($path.$this->vars["file"]) && $this->vars["file"] != ""){unlink($path.$this->vars["file"]);}
	   delete("attachment", $this->vars["id"]);
	}	
}
class transfer_relation{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["call"] = get_call($this->vars["call"]);
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "call_transfer", $specific);
	}
	function insert(){
	   clerk_db();	   
	   $this->vars["id"] = insert($this, "call_transfer");
	   $this->insert_log("se");
	}
	function delete(){
	   clerk_db();
	   delete("call_transfer", $this->vars["id"]);
	}
	function insert_log($result){
		$log["from"] = $this->vars["from"];
		$log["to"] = $this->vars["to"];
		$log["date"] = date("Y-m-d H:i:s");
		$log["call"] = $this->vars["call"];
		$log["result"] = $result;
		insert($log,"call_transfer_log");
	}
}

class _global_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}

    function str_type(){
		if($this->vars["type"] == "de" ){$str = "Deposit";}
		else{$str = "Payout";}	
		return $str;
	}
	
	
	function color_status(){
		switch($this->vars["status"]){
			case "de":
				$status = '<span style="color:#C00">Denied</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
			case "ape":
				$status = '<span style="color:#FC3">Pre-Pending</span>';
			break;	
		}
		return $status;
	}



}



class clerk_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["clerk"] = get_clerk($this->vars["clerk"]);	
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "clerk_transaction", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "clerk_transaction");
	}	
	function str_type(){
		if($this->vars["substract"]){$str = "Withdrawal";}
		else{$str = "Deposit";}	
		return $str;
	}
}



class lead_transfer{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["name"] = get_ckname($this->vars["name"]);
		$this->vars["clerk"] =	get_clerk($this->vars["clerk"]);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "lead_transfer");
	}
}
class reporter{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function run($name){
		switch($name){
			case "team_home":
				$content = array();
				$deposits = get_deposits_number($this->vars["from"],$this->vars["to"]);
				$leads = get_leads_number($this->vars["from"],$this->vars["to"]);
				if($leads > 0){$rate = round(($deposits/$leads)*100,1);}else{$rate = "0";}
				$content[] = array("name"=>"# Deposits", "number"=>$deposits);
				$content[] = array("name"=>"# Leads", "number"=>$leads);
				$content[] = array("name"=>"Conversion Rate", "number"=>"%$rate");
			break;
			
			case "fronters_home":
				$content = array();
				$clerks = get_all_clerks("1","2");
				$this->vars["explain"] = "<strong>#C:</strong> Number of Calls(daily), <strong>CPH:</strong> Calls per hour, <strong>#S:</strong> Number of Signups(daily), <strong>SPH:</strong> Signups per hour, <strong>#CON:</strong> Number of Conversions(daily), <strong>CONPH:</strong> Conversions per hour ";
				$content[] = array(99999999,"","#C","CPH","#S","SPH","#CON","CONPH");
				foreach($clerks as $ck){
                     if($ck->vars["user_group"]->vars["id"] != 15){
						$from_time = strtotime($this->vars["from"]);
						$to_time = strtotime($this->vars["to"]);
						$days = (($to_time - $from_time) / 60 / 60 / 24) + 1;
						//#calls
						$calls = get_calls_count($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
						if($calls > 0){
							//CPH					
							$ck->calls_per_hour = 0;	
							for($i=0;$i<$days;$i++){
								$day = date("Y-m-d",$from_time + ($i * 60 * 60 * 24));
								$ck->calls_per_hour += $ck->calculate_calls_per_hour($day);
							}
							$ck->calls_per_hour = round($ck->calls_per_hour / $days,2);
							$cph = $ck->calls_per_hour;
							//$sigups
							$signups = 0;
							$conversions = 0;
							
							$sign_calls = get_player_in_calls_count_by_status($ck->vars["id"],"9",$this->vars["from"],$this->vars["to"]);
							foreach($sign_calls as $sc){
								$signups++;
								$isconversion = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/deposit_checker.php?pl=".str_replace(" ","",$sc["acc"]));
								if($isconversion){$conversions++;}
							}
							$sign_calls = get_player_in_calls_count_by_status($ck->vars["id"],"11",$this->vars["from"],$this->vars["to"]);
							foreach($sign_calls as $sc){
								$signups++;
								$isconversion = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/deposit_checker.php?pl=".str_replace(" ","",$sc["acc"]));
								if($isconversion){$conversions++;}
							}
							
							//signups / hour
							$hours =  $ck->logged_time($this->vars["from"],$this->vars["to"]);
							if($hours > 0){
								$sph = round($signups/$hours,1);
								$conph = round($conversions/$hours,1);						
							}else{
								$sph = 0;
								$conph = 0;
							}
							
							$content[] = array($cph,$ck->vars["name"],$calls,$cph,$signups,$sph,$conversions,$conph);
						}
					}
				}
				rsort($content);
			break;
			case "agent_fronters_home":
				$content = array();
				$clerks = get_all_clerks_by_group(15);
				$this->vars["explain"] = "<strong>#C:</strong> Number of Calls(daily), <strong>CPH:</strong> Calls per hour, <strong>#S:</strong> Number of Signups(daily), <strong>AL:</strong> Active Players last week, <strong>AT:</strong> Active Players this week, <strong>PS:</strong> Total amount in payouts, <strong>DS: </strong>Total amount in deposits, <strong>N:</strong> Net";
				$content[] = array(99999999,"","#C","CPH","ALW","ATW","PS","DS","N","");
				$from_time = strtotime($this->vars["from"]);
				$to_time = strtotime($this->vars["to"]);
				$days = (($to_time - $from_time) / 60 / 60 / 24) + 1;
				foreach($clerks as $ck){	
					//#calls
					$calls = get_calls_count($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
					if($calls > 0){
						//CPH					
						$ck->calls_per_hour = 0;	
						for($i=0;$i<$days;$i++){
							$day = date("Y-m-d",$from_time + ($i * 60 * 60 * 24));
							$ck->calls_per_hour += $ck->calculate_calls_per_hour($day);
						}
						$ck->calls_per_hour = round($ck->calls_per_hour / $days,2);
						$cph = $ck->calls_per_hour;
						
						$af_list = array();
						$affs = get_all_affiliates_by_clerk($ck->vars["id"]);
						foreach($affs as $af){$af_list[] = $af->vars["aff"];}
						$data_box = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/agent_stats_box.php?agent=".implode(",",$af_list)));
							
						$net = $data_box->deposits + $data_box->payouts;
						
						//$in_link = "<a href = '#' class='normal_link'>Inactive</a>";
                     $in_link = '<a href="http://localhost:8080/ck/sbo_inactive_player_by_agent.php?id='.$ck->vars["id"].'" class="normal_link" target="_blank" >Inactive</a>';
					
						$content[] = array($cph,$ck->vars["name"],$calls,$cph,$data_box->actives_last,$data_box->actives_this,$data_box->payouts,$data_box->deposits,$net,$in_link);
					}else{
						$cph = 0;
					}
					
				}
				rsort($content);
			break;
			case "closers_home":
				$content = array();
				$clerks = get_all_clerks("","4,5");
				$this->vars["explain"] = "<strong>#C:</strong> Number of Calls(daily), <strong>CPH:</strong> Calls per hour, <strong>#NC:</strong> Number of New Calls, <strong>#S:</strong> Number of Signups, <strong>CRLD:</strong> conversion rate leads to deposits(weekly), <strong>CRND:</strong> conversion new names to deposits(weekly), <strong>#DP:</strong> Number of Depoits(weekly)";
				$content[] = array(99999999,"","CPH","#C","#NC","#S","CRLD","CRND","#DP");
				foreach($clerks as $ck){
					$from_time = strtotime($this->vars["from"]);
					$to_time = strtotime($this->vars["to"]);
					$days = (($to_time - $from_time) / 60 / 60 / 24) + 1;
					//#calls
					$calls = get_calls_count($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
					if($calls > 0){
						//CPH					
						$ck->calls_per_hour = 0;	
						for($i=0;$i<$days;$i++){
							$day = date("Y-m-d",$from_time + ($i * 60 * 60 * 24));
							$ck->calls_per_hour += $ck->calculate_calls_per_hour($day);
						}
						$ck->calls_per_hour = round($ck->calls_per_hour / $days,2);
						$cph = $ck->calls_per_hour;
						//$sigups
						$signups = 0;
						for($i=0;$i<$days;$i++){
							$day = date("Y-m-d",$from_time + ($i * 60 * 60 * 24));
							$signups += $ck->count_calls_by_status("9",$day);
						}
						//process
						$leads_day = get_closers_leads_number($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
						$deposits_day = get_deposits_number($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
						$new_calls_day = get_new_calls_count($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
						$rf = $this->vars["from"];
						$rt = $this->vars["to"];
						$this->set_date_to_this_week();
						$leads_week = get_closers_leads_number($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
						$deposits_week = get_deposits_number($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
						$new_calls_week = get_new_calls_count($this->vars["from"],$this->vars["to"],$ck->vars["id"]);
						$this->vars["from"] = $rf;
						$this->vars["to"] = $rt;
						//CRND						
						if($new_calls_week>0){$crnd = round(($deposits_week/$new_calls_week)*100,1);}else{$crnd = 0;}
						//CRLD
						if($leads_week > 0){$crld = round(($deposits_week/$leads_week)*100,1);}else{$crld = "0";}
						//#NC
						$nc = $new_calls_day + $leads_day;
						
						$content[] = array($cph,$ck->vars["name"],$cph,$calls,$nc,$signups,"%".$crld,"%".$crnd,$deposits_week);
					}
				}
				rsort($content);
			break;
		}		
		return $content;
	}
	function set_date_to_this_week(){
		$weekday = get_week_day(date("d/m/Y"));
		$this->vars["from"] = date("Y-m-d", time()-($weekday * 24 * 60 * 60));
  		$this->vars["to"] = date("Y-m-d");
	}
	function restart(){
		$this->vars = array();	
	}
}


//betting
class _inspin_game{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$away = new _inspin_team();
		$away->system_setting(array("id"=>string_to_ascii($this->vars["away_team"]),"name"=>$this->vars["away_team"]));
		$this->vars["away_team"] = $away;
		$home = new _inspin_team();
		$home->system_setting(array("id"=>string_to_ascii($this->vars["home_team"]),"name"=>$this->vars["home_team"]));
		$this->vars["home_team"] = $home;
	}
	function insert_other(){
		betting_db();
		return insert($this, "other_event");
	}
	//function system_setting($pvars = array()){$this->vars = $pvars;}
	function get_bet_total_money($period, $team, $type, $idef = ""){
		$bets = search_bet($this->vars["id"], $period, $team, $type, $idef);
		$total = 0;
		foreach($bets as $bet){
			$bline = $bet->vars["line"];
			if(contains_ck($bet->vars["line"],"-")&&contains_ck($bet->vars["line"],"+")){$bline = substr($bet->vars["line"],1);}
			if(contains_ck($bline,"-")){
				$total += $bet->vars["win"] * ($bet->vars["account_percentage"]/100);
			}else{
				$total += $bet->vars["risk"] * ($bet->vars["account_percentage"]/100);
			}
		}
		return round($total,2);
	}
	function get_bet_total_details($period, $team, $type, $idef = ""){
		$bets = search_bet($this->vars["id"], $period, $team, $type, $idef);
		$lines = array();
		foreach($bets as $bet){
			$key = biencript($bet->vars["line"]);
			$bline = $bet->vars["line"];
			if(contains_ck($bet->vars["line"],"-")&&contains_ck($bet->vars["line"],"+")){$bline = substr($bet->vars["line"],1);}
			if(contains_ck($bline,"-")){
				$value = $bet->vars["win"] * ($bet->vars["account_percentage"]/100);
			}else{
				$value = $bet->vars["risk"] * ($bet->vars["account_percentage"]/100);
			}
			if(is_null($lines[$key])){$lines[$key] = 0;}
			$lines[$key] += round($value,2);
		}
		return $lines;
	}
}
class _inspin_team{
	var $vars = array();
	function initial(){}
	function __construct($pvars = array()){$this->vars = $pvars;}
	//function system_setting($pvars = array()){$this->vars = $pvars;}
}
class _odds_line{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "line", $specific);
	}
	
	
	function insert(){
		sbo_liveodds_db();
		//db_connect("live_odds");
		return insert($this, "line");
	}
	function clean_total($total){	
		$total = str_replace(" ","",$total);
		if($total == "o"){$total = "";}
		if($total == "u"){$total = "";}
		$total = preg_replace('/\+(\d+)/i', "", $total);
		$total = preg_replace('/\-(\d+)/i', "", $total);
		return $total;
	}
	function get_main($league, $team, $percentage = false){
		$team = strtolower($team);
		$league = strtoupper($league);
		if($percentage){$addon = "_percentage";}
		$main_line = "";
		switch($league){
			case "NFL":
				$main_line = $this->vars[$team . "_spread" . $addon];
			break;	
			case "NCAAF":
				$main_line = $this->vars[$team . "_spread" . $addon];
			break;
			case "NBA":
				$main_line = $this->vars[$team . "_spread" . $addon];
			break;
			case "NCAAB":
				$main_line = $this->vars[$team . "_spread" . $addon];
			break;
			case "NHL":
				$main_line = $this->vars[$team . "_money" . $addon];
			break;
			case "MLB":
				$main_line = $this->vars[$team . "_money" . $addon];
			break;
		}
		return $main_line;
	}
	function sort_favorite_odds_lines($line_away, $line_home, $total_away, $total_home){
		$line_away = str_replace(" ","",$line_away);
		$line_home = str_replace(" ","",$line_home);
		$first_away = substr($line_away,0,1);
		$first_home = substr($line_home,0,1);
		
		if(contains_str($total_away,"-")){
			$total = $this->clean_total($total_away);
		}else if(contains_str($total_home,"-")){
			$total = $this->clean_total($total_home);
		}else{
			$total = $this->clean_total($total_home);
		}
		
		if($first_away == "-"){
			$result = $line_away . "<br />" . $total;
		}else if($first_home == "-"){
			$result = $total . "<br />" . $line_home;
		}else{
			$result = $total . "<br />" . $line_home;
		}
		return $result;
	}
}
class _betting_account{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["agent"] = get_betting_agent($this->vars["agent"]);
		$this->vars["bank"] = get_betting_bank($this->vars["bank"]);
	}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "account", $specific);
	}	
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "account");
	}
	function current_bet_balance($from="",$to=""){
		$wins = get_betstype_amount_balance_by_account($this->vars["id"], "w",$from,$to);
		$lose = get_betstype_amount_balance_by_account($this->vars["id"], "l",$from,$to);
		$amount = $wins["amount"] - $lose["amount"];
		return $amount;
	}
	function current_trans_balance($from = "", $to = ""){
		$trans = get_trans_amount_balance_by_account($this->vars["id"],$from,$to);
		$amount = $trans[0]["amount"] - $trans[1]["amount"];
		return $amount;
	}
	function current_balance(){
		$bets = $this->current_bet_balance();
		$trans = $this->current_trans_balance();
		return $bets + $trans;
	}
	function get_balance($from, $to){
		$bets = $this->current_bet_balance($from, $to);
		$trans = $this->current_trans_balance($from, $to);
		return $bets + $trans;
	}
	function get_weekly_bet_balances($from, $to){
		$balance = array();
		
       	$balance["pmts"] = $this->current_trans_balance($from,$to);
       	$last_sunday = date("Y-m-d",strtotime($from."-1 days"));
		$balance["bow"] = $this->current_bet_balance("",$last_sunday) + $this->current_trans_balance("",$last_sunday);
		$balance["week"] = 0;
		$days = array("mon","tue","wed","thu","fri","sat","sun");
		$more_days["Monday"] = "mon";
		$more_days["Tuesday"] = "tue";
		$more_days["Wednesday"] = "wed";
		$more_days["Thursday"] = "thu";
		$more_days["Friday"] = "fri";
		$more_days["Saturday"] = "sat";
		//$more_days["l"] = "Sunday";
		$more_days["Sunday"] = "sun";
		$win = get_betstype_amount_balance_by_account_by_date($this->vars["id"], "w", $from, $to);
		$loss = get_betstype_amount_balance_by_account_by_date($this->vars["id"], "l", $from, $to);
	   
		$datediff =  strtotime($to) -  strtotime($from);
        $t_days = round($datediff / (60 * 60 * 24)) + 1;
        

		for($i=0;$i<$t_days;$i++){
			 $key_date = date("Y-m-d",strtotime($from)+$i*24*60*60);
		     $weekday = date('l', strtotime($key_date));
             $amount = $win[$key_date]["amount"] - $loss[$key_date]["amount"];
			 $balance["week"] += $amount;
             $balance[$more_days[$weekday]] +=  $amount;
			//$balance[$days[$i]] = $amount;  // Comented on 17/08/2021 , this method was updated by Alexis.
		}
		
		$balance["bal"] = $balance["bow"] + $balance["week"] + $balance["pmts"];
	
		return $balance;
	}
}
class _betting_identifier{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "identifier", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "identifier");
	}
	function get_bet_balance($from = "",$to = ""){
		$wins = get_betstype_amount_balance_by_identifier($this->vars["id"], "w",$from,$to);
		$lose = get_betstype_amount_balance_by_identifier($this->vars["id"], "l",$from,$to);
		$amount = $wins["amount"] - $lose["amount"];
		return $amount;
	}	
}
class _betting_proxy{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "proxy", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "proxy");
	}
}
class _betting_agent{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "agent", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "agent");
	}
	function get_balance($from, $to){
		$accs = get_all_betting_accounts_by_agent($this->vars["id"]);
		$balance = 0;
		foreach($accs as $acc){
			$balance += $acc->get_balance($from, $to);
		}
		return $balance;
	}
	function get_bet_balance($from, $to){
		$accs = get_all_betting_accounts_by_agent($this->vars["id"], "1");
		$balance = 0;
		foreach($accs as $acc){
			$balance += $acc->current_bet_balance($from, $to);
		}
		return $balance;
	}
}
class _betting_bank{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "bank_account", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "bank_account");
	}
}
class _betting_software{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "software", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "software");
	}
}
class _betting_group{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "betting_group", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "betting_group");
	}
}
class _betting_auto_settings{
	var $vars = array();
	var $groups = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->groups = get_account_betting_groups($this->vars["account"]);	
	}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "auto_settings", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "auto_settings");
	}
	function update_groups($groups){
		clean_account_betting_groups($this->vars["account"]);	
		if(!is_null($groups)){
			foreach($groups as $grp){
				insert_account_betting_groups($this->vars["account"], $grp);	
			}
		}
	}
}
class _account_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["account"] = get_betting_account($this->vars["account"]);
	}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "account_transaction", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "account_transaction");
	}
	function delete_all(){
	   betting_db();
	   delete("account_transaction", "", "transaction_id = '".$this->vars["transaction_id"]."'");
	}
}
class _bet{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["user"]	= get_clerk($this->vars["user"]);
		$this->vars["account"]	= get_betting_account($this->vars["account"]);
		$this->vars["identifier"]	= get_betting_identifier($this->vars["identifier"]);
	}
	function get_money(){
		$bline = $this->vars["line"];
		if(contains_ck($this->vars["line"],"-")&&contains_ck($this->vars["line"],"+")){$bline = substr($this->vars["line"],1);}
		if(contains_ck($bline,"-")){
			$money += $this->vars["win"] * ($this->vars["account_percentage"]/100);
		}else{
			$money += $this->vars["risk"] * ($this->vars["account_percentage"]/100);
		}
		return round($money,2);	
	}
	function get_result_amount(){
		if($this->vars["status"]=="w"){
			$ammount = $this->vars["win"];
		}else if($this->vars["status"]=="l"){
			$ammount = "-".$this->vars["risk"];
		}
		else if($this->vars["status"]=="p"){
			$ammount = 0;
		}
		return $ammount;
	}
	function get_report_comment(){
		$content = "";
		if($this->is_adjustment()){
			$content .= "Adjustment<br />";
			$content .= nl2br($this->vars["comment"]);
		}else{
			$content .= "Identifier: ".$this->vars["identifier"]->vars["name"] . "<br />";
			$content .= $this->vars["team"] . " ".$this->vars["line"] . "<br />";
			$content .= ucwords($this->vars["type"]) . ", ".$this->vars["period"] . "<br />";
		}
		return $content;
	}
	function str_status(){
		if($this->vars["status"] == "w"){
			$str = "Win";
		}else if($this->vars["status"] == "l"){
			$str = "Lose";
		}else if($this->vars["status"] == "p"){
			$str = "Push";
		}
		else{
			$str = "Not Graded";
		}
		return $str;
	}
	function is_adjustment(){
		if($this->vars["type"] == "adjustment"){$is = true;}else{$is = false;}
		return $is;
	}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "bet", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "bet");
	}
	function delete(){
	   betting_db();
	   delete("bet", $this->vars["id"]);
	}
	function delete_previous_adjustments($from){
	   betting_db();
	   delete("bet", $this->vars["id"], "account = '".$this->vars["account"]->vars["id"]."' AND gameid = '".$this->vars["gameid"]."' AND period = '".$this->vars["period"]."' AND type = 'adjustment' AND line = '".$this->vars["line"]."' AND comment LIKE '%$from%' AND adjustment_key != '".$this->vars["adjustment_key"]."'");
	}
	function insert_record($action, $by){
	   betting_db();
	   $this->vars["action"] = $action;
	   $this->vars["by"] = $by;
	   $this->vars["bet"] = $this->vars["id"];
	   unset($this->vars["id"]);
	   $rid = insert($this, "record_bet");
	   $this->vars["id"] = $this->vars["bet"];
	   unset($this->vars["bet"]);
	   unset($this->vars["action"]);
	   unset($this->vars["by"]);
	   return $rid;
	}
	function get_commission_amount($percentage){
		if($this->vars["status"] == "w"){
			$base = $this->vars["win"];
		}else if($this->vars["status"] == "l"){
			$base = $this->vars["risk"];
		}else if($this->vars["status"] == "p"){
			$base = 0;
		}
		return $base * ($percentage/100);
	}
	function get_commission_status(){
		if($this->vars["status"] == "w"){
			$cstatus = "l";
		}else if($this->vars["status"] == "l"){
			$cstatus = "w";
		}else if($this->vars["status"] == "p"){
			$cstatus = "p";
		}
		return $cstatus;
	}
	function grade($game, $scoreA, $scoreH){
		switch($this->vars["type"]){
			case "money":
				if($game->vars["away_team"]->vars["name"] == $this->vars["team"]){
					if($scoreA > $scoreH){
						//win
						$this->vars["status"] = "w";
					}else if($scoreA < $scoreH){
						//loss
						$this->vars["status"] = "l";
					}else{
						//push
						$this->vars["status"] = "p";
					}	
				}else if($game->vars["home_team"]->vars["name"] == $this->vars["team"]){
					if($scoreA < $scoreH){
						//win 
						$this->vars["status"] = "w";
					}else if($scoreA > $scoreH){
						//loss
						$this->vars["status"] = "l";
					}else{
						//push
						$this->vars["status"] = "p";
					}		
				}
			break;
			case "spread":
				$first = substr($this->vars["line"],0,1);
				$spread = substr(trim($this->vars["line"]),1);
				if(contains_ck($spread,"+")){$spliter = "+";}else if(contains_ck($spread,"-")){$spliter = "-";}
				$parts = explode($spliter,$spread);
				$spread = $first.$parts[0];
								
				if($game->vars["away_team"]->vars["name"] == $this->vars["team"]){
					$result = $scoreA + $spread;
					if($result > $scoreH){
						//win
						$this->vars["status"] = "w";
					}else if($result < $scoreH){
						//loss
						$this->vars["status"] = "l";
					}else{
						//push
						$this->vars["status"] = "p";
					}
				}else if($game->vars["home_team"]->vars["name"] == $this->vars["team"]){
					$result = $scoreH + $spread;
					if($result > $scoreA){
						//win
						$this->vars["status"] = "w";
					}else if($result < $scoreA){
						//loss
						$this->vars["status"] = "l";
					}else{
						//push
						$this->vars["status"] = "p";
					}
				}
			break;
			case "total":
				if(contains_ck($this->vars["line"],"+")){$spliter = "+";}else if(contains_ck($this->vars["line"],"-")){$spliter = "-";}
				$parts = explode($spliter,$this->vars["line"]);
				$total = $parts[0];
				$total = str_replace("o","",$total);
				$total = str_replace("u","",$total);
				$total = str_replace(" ","",$total);
				if(is_numeric($total)){
					$total_score = $scoreA + $scoreH;
					if($game->vars["away_team"]->vars["name"] == $this->vars["team"]){
						if($total_score > $total){
							//win
							$this->vars["status"] = "w";
						}else if($total_score < $total){
							//loss
							$this->vars["status"] = "l";
						}else{
							//push
							$this->vars["status"] = "p";
						}						
					}else if($game->vars["home_team"]->vars["name"] == $this->vars["team"]){
						if($total_score < $total){
							//win
							$this->vars["status"] = "w";
						}else if($total_score > $total){
							//loss
							$this->vars["status"] = "l";
						}else{
							//push
							$this->vars["status"] = "p";
						}
					}
				}
			break;
			case "over_team_totals":
				if(contains_ck($this->vars["line"],"+")){$spliter = "+";}else if(contains_ck($this->vars["line"],"-")){$spliter = "-";}
				$parts = explode($spliter,$this->vars["line"]);
				$total = $parts[0];
				$total = str_replace("o","",$total);
				$total = str_replace(" ","",$total);
				if(is_numeric($total)){
					if($game->vars["away_team"]->vars["name"] == $this->vars["team"]){
						$score = $scoreA;
					}elseif($game->vars["home_team"]->vars["name"] == $this->vars["team"]){
						$score = $scoreH;
					}
					
					if($score > $total){
						//win
						$this->vars["status"] = "w";
					}else if($score < $total){
						//loss
						$this->vars["status"] = "l";
					}else{
						//push
						$this->vars["status"] = "p";
					}					
				}
			break;
			case "under_team_totals":
				if(contains_ck($this->vars["line"],"+")){$spliter = "+";}else if(contains_ck($this->vars["line"],"-")){$spliter = "-";}
				$parts = explode($spliter,$this->vars["line"]);
				$total = $parts[0];
				$total = str_replace("u","",$total);
				$total = str_replace(" ","",$total);
				if(is_numeric($total)){
					if($game->vars["away_team"]->vars["name"] == $this->vars["team"]){
						$score = $scoreA;
					}elseif($game->vars["home_team"]->vars["name"] == $this->vars["team"]){
						$score = $scoreH;
					}
					
					if($score < $total){
						//win
						$this->vars["status"] = "w";
					}else if($score > $total){
						//loss
						$this->vars["status"] = "l";
					}else{
						//push
						$this->vars["status"] = "p";
					}					
				}
			break;
		}
		$this->update(array("status"));
	}
}
class _result{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "results", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "results");
	}
	function delete_previous(){
	   betting_db();
	   delete("results", $this->vars["id"], "game_id = '".$this->vars["game_id"]."' AND period = '".$this->vars["period"]."'");
	}
}
class _betting_period{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "periods", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "periods");
	}
	function is_team_totals(){
		if($this->vars["name"] == "Team Totals"){
			$is = true;
		}else{$is = false;}
		
		return $is;
	}
}
class _betting_commission{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["account"]  = get_betting_account($this->vars["account"]);
		$this->vars["caccount"] = get_betting_account($this->vars["caccount"]);
	}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "commissions", $specific);
	}
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "commissions");
	}
	function delete(){
	   betting_db();
	   delete("commissions", $this->vars["id"]);
	}
}
class _sbo_line{
	var $vars = array();
	function initial(){}
}

class _gambling_checklist{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){	
	}
	
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "checklist");
	}
	function delete(){
	   betting_db();
	   delete("checklist", $this->vars["id"]);
	}
}

class _gambling_checklist_by_day{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){	
	   $this->vars["clerk"] = get_clerk($this->vars["clerk"]);
	}
	
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "checklist_by_day");
	}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "checklist_by_day", $specific);
	}
	
}

class _external_bets{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){	
	}
	
	function insert(){
	   betting_db();
	   $this->vars["id"] = insert($this, "external_bets");
	}
	function delete(){
	   betting_db();
	   delete("external_bets", $this->vars["id"]);
	}
	function update($specific = NULL){
	   betting_db();
	   return update($this, "external_bets", $specific);
	}
}

//End betting

//expenses

class _expense_category{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "category", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "category");
	}
}
class _expense{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["category"] = get_expense_category($this->vars["category"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "expense", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "expense");
	}
	function is_posted(){
		if($this->vars["status"] == "po"){
			$is = true;
		}else{
			$is = false;
		}
		return $is;
	}
	function str_status(){
		switch($this->vars["status"]){
			case "un":
				$str = "Unposted";
			break;
			case "po":
				$str = "Posted";
			break;	
		}
		return $str;
	}
	function is_payment(){
		if($this->vars["amount"]<0){
			$is = true;
		}else{
			$is = false;	
		}
		return $is;
	}
	function has_error(){
		if($this->vars["intersystem"] && $this->vars["system_id"] < 1){
			$error = true;
		}else{$error = false;}
		return $error;
	}
	function get_error(){
		$error = "";
		if($this->vars["intersystem"] && $this->vars["system_id"] < 1){
			$error = "There was a problem inserting the transaction in ".$this->vars["system"];
		}
		return $error;
	}
	function is_intersystem(){
		if(contains_ck($this->vars["note"],"Intersystem Transaction #") || contains_ck($this->vars["note"],"Intersystem Expense #")){
			$is = true;	
		}
		else{$is = false;}	
		return $is;
	}
}



//End Expenses



//Michael's Expenses

class _dj_expense_category{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "dj_category", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "dj_category");
	}
}

class _dj_expense{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["category"] = get_dj_expense_category($this->vars["category"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "dj_expense", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "dj_expense");
	}
	function str_status(){
		if($this->vars["paid"]){
			$str = "Paid";
		}else{
			$str = "Pending";
		}
		return $str;
	}
	function is_payment(){
		if($this->vars["amount"]<0){
			$is = true;
		}else{
			$is = false;	
		}
		return $is;
	}
	function str_date(){
		$month = date("F",strtotime("2012-".$this->vars["month"]."-01"));
		return $month.", ".$this->vars["year"];
	}
}

//End Michael's Expenses

//Office Expense

class _office_expense{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["category"] = get_expense_category($this->vars["category"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "office_expense", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "office_expense");
	}
	function str_status(){
		if($this->vars["paid"]){
			$str = "Paid";
		}else{
			$str = "Pending";
		}
		return $str;
	}
	function is_payment(){
		if($this->vars["amount"]<0){
			$is = true;
		}else{
			$is = false;	
		}
		return $is;
	}
	function str_date(){
		$month = date("F",strtotime("2012-".$this->vars["month"]."-01"));
		return $month.", ".$this->vars["year"];
	}
}

// Predefined Office
class _predefined_office_expense{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["category"] = get_expense_category($this->vars["category"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "predefined_office_expense", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "predefined_office_expense");
	}
	function is_payment(){
		if($this->vars["amount"]<0){
			$is = true;
		}else{
			$is = false;	
		}
		return $is;
	}
	
}





//credit accounting

class _credit_account{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "credit_account", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "credit_account");
	}
	function move_balance($amount){
		accounting_db();
		$this->vars["balance"] += $amount;
		$this->update(array("balance"));
	}
}
class _credit_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["from_account"] = get_credit_account($this->vars["from_account"]);
		$this->vars["to_account"] = get_credit_account($this->vars["to_account"]);	
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "credit_transaction", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "credit_transaction");
	}
}
class _credit_adjustment{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["account"] = get_credit_account($this->vars["account"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "credit_adjustment", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "credit_adjustment");
	}
}

//end credit accounting

//pph accounting

class _pph_account{
	function __construct($pvars = array()){$this->vars = $pvars;}
	var $vars = array();
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "pph_account", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "pph_account");
	}
	function move_balance($amount){
		$this->vars["balance"] += $amount;
		$this->update(array("balance"));
	}
}


class _pph_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["from_account"] = get_pph_account($this->vars["from_account"]);
		$this->vars["to_account"] = get_pph_account($this->vars["to_account"]);	
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "pph_transaction", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "pph_transaction");
	}
}
class _pph_expense{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "pph_expense", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "pph_expense");
	}
}

class _pph_bill{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["account"] = get_pph_account($this->vars["account"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "pph_billing", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "pph_billing");
	}
	function get_phone_total(){
		return $this->vars["phone_count"] * $this->vars["phone_price"];
	}
	function get_base_total(){
		if($this->vars["base_count"] > $this->vars["max_players"]){
			return 0;
		}else{
			return /*$this->vars["base_count"] **/ $this->vars["base_price"];
		}	
	}
	function get_internet_total(){
		return $this->vars["internet_count"] * $this->vars["internet_price"];
	}
	function get_liveplus_total(){
		return $this->vars["liveplus_count"] * $this->vars["liveplus_price"];
	}
	
	function get_horsesplus_total(){
		return $this->vars["horsesplus_count"] * $this->vars["horsesplus_price"];
	}
	function get_propsplus_total(){
		return $this->vars["propsplus_count"] * $this->vars["propsplus_price"];
	}
	
	function get_livecasino_total(){
		return $this->vars["livecasino_count"] * $this->vars["livecasino_price"];
	}
	
}

class _pph_account_external{
	function __construct($pvars = array()){$this->vars = $pvars;}
	var $vars = array();
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "pph_account_external", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "pph_account_external");
	}
	function move_balance($amount){
		$this->vars["balance"] += $amount;
		$this->update(array("balance"));
	}
}

class _pph_bill_external{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["account"] = get_pph_account_external($this->vars["account"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "pph_billing_external", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "pph_billing_external");
	}
	function get_phone_total(){
		return $this->vars["phone_count"] * $this->vars["phone_price"];
	}
	function get_base_total(){
		if($this->vars["base_count"] > $this->vars["max_players"]){
			return 0;
		}else{
			return /*$this->vars["base_count"] **/ $this->vars["base_price"];
		}	
	}
	function get_internet_total(){
		return $this->vars["internet_count"] * $this->vars["internet_price"];
	}
	function get_liveplus_total(){
		return $this->vars["liveplus_count"] * $this->vars["liveplus_price"];
	}
	
	function get_horsesplus_total(){
		return $this->vars["horsesplus_count"] * $this->vars["horsesplus_price"];
	}
	function get_propsplus_total(){
		return $this->vars["propsplus_count"] * $this->vars["propsplus_price"];
	}
	
	function get_livecasino_total(){
		return $this->vars["livecasino_count"] * $this->vars["livecasino_price"];
	}
	
}

//end pph accounting

//intersystem
class _intersystem_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "intersystem_transaction", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "intersystem_transaction");
	}
	function str_status(){
		switch($this->vars["status"]){
			case "ac":
				$str = "Accepted";
			break;
			case "ca":
				$str = "Canceled";
			break;
			case "pe":
				$str = "Pending";
			break;
		}
		return $str;
	}
	function get_accounts(){
		global $current_clerk;
		$accs = array();
		$accs["from_system"] = get_system($this->vars["from_system"]);
		$accs["to_system"] = get_system($this->vars["to_system"]);
		$system = $accs["from_system"]["id"]; $account = $this->vars["from_account"]; 
		include(ROOT_PATH . "/ck/balances/api/get_account.php"); $accs["from_account"] = $saccount;
		$system = $accs["to_system"]["id"]; $account = $this->vars["to_account"]; 
		include(ROOT_PATH . "/ck/balances/api/get_account.php"); $accs["to_account"] = $saccount;	
		return $accs;
	}
	function has_error(){
		if($this->vars["status"] == "ac"){
			if($this->vars["from_transaction"] < 1 || $this->vars["to_transaction"] < 1){
				$error = true;
			}else{$error = false;}
		}else{$error = false;}
		return $error;
	}
	function get_error($accs){
		$error = "";
		if($this->vars["from_transaction"] < 1){
			$error .= "There was a problem inserting the transaction in ".$accs["from_account"]["name"] . "(". $accs["from_system"]["name"].")<br />";
		}
		if($this->vars["to_transaction"] < 1){
			$error .= "There was a problem inserting the transaction in ".$accs["to_account"]["name"] . "(". $accs["to_system"]["name"].")";
		}
		return $error;
	}
}
//end intersystem

//agent freeplay

class _agent_freeplay_amount{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "agent_freeplay_amounts", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "agent_freeplay_amounts");
	}
}


//end agent freeplay


class _sbo_player_file{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "player_file", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "player_file");
	}
	function delete(){
	   sbo_book_db();
	   //delete file
	   delete("player_file", $this->vars["id"]);
	}
}


//goals

class _goal{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["ugroup"] = get_user_group($this->vars["ugroup"]);	
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "goals", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "goals");
	}
	function get_percentage(){
		return round(($this->vars["current"] * 100) / $this->vars["goal"]);
	}
}

//end goals


class _bronto_filter{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "bronto_filter", $specific);
	}
	function insert($table="bronto_filter"){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "bronto_filter");
	}
}

//prepaid
class _prepaid_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["processor"] = get_prepaids_processor($this->vars["processor"]);	
	    $this->vars["card_number"] = num_two_way($this->vars["card_number"], true);	
  	    $this->vars["expiration"] = num_two_way($this->vars["expiration"], true);	
 	    $this->vars["cvv"] = num_two_way($this->vars["cvv"], true);	
	}
	function update($specific = NULL){
	   processing_db();
	    $this->vars["enumber"] = super_encript($this->vars["card_number"]);
	    $this->vars["card_number"] = num_two_way($this->vars["card_number"], false);
  	    $this->vars["expiration"] = num_two_way($this->vars["expiration"], false);
	    $this->vars["cvv"] = num_two_way($this->vars["cvv"], false);
	    $res = update($this, "prepaid_transaction", $specific);
	    $this->vars["card_number"] = num_two_way($this->vars["card_number"], true);
  	    $this->vars["expiration"] = num_two_way($this->vars["expiration"], true);
	    $this->vars["cvv"] = num_two_way($this->vars["cvv"], true);
		return $res;
	}
	function set_auto_processor(){
		if($this->vars["payment_method"] == 91){
			$this->vars["processor"] = "1";
		}else{
			$this->vars["processor"] = "2";
		}
	}
	function color_status(){
		$status = $this->vars["processor_status"];
		switch($this->vars["processor_status"]){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
	function get_color(){
		switch($this->vars["processor_status"]){
			case "de":
				$color = '#770808';
			break;
			case "ac":
				$color = '#1c4f06';
			break;
			case "pe":
				$color = '#000';
			break;	
		}
		return $color;
	}
}
class _prepaid_proc{
	var $vars = array();
	function initial(){}
}
//end prepaid


//moneypak
class _moneypak_transaction{
	function __construct($pvars = array()){$this->vars = $pvars;}
	var $vars = array();
	function initial(){
		//$this->vars["number"] = num_two_way($this->vars["number"], true);
	}
	function update($specific = NULL){
	   processing_db();
	   //$this->vars["enumber"] = super_encript(num_two_way($this->vars["number"],true));
	   //$this->vars["number"] = num_two_way($this->vars["number"], false);
	   $res = update($this, "moneypack_transaction", $specific);
   	   //$this->vars["number"] = num_two_way($this->vars["number"], true);
	   return $res; 
	}
	function str_method(){
		if($this->vars["method"] == "m"){
			$str = "Moneypak";
		}else if ($this->vars["method"] == "r"){
			$str = "Reloadit";
		}else if ($this->vars["method"] == "v"){
			$str = "Vanilla Reloadit";
		}else if ($this->vars["method"] == "p"){
			$str = "Paypal Cash Card";
		}
		return $str;
	}
	function insert(){
	   processing_db();
	   $this->vars["enumber"] = super_encript($this->vars["number"]);
	   $this->vars["number"] = num_two_way($this->vars["number"], false);
	   if($this->vars["zip"]>0){$zad = new _zip_address(); $zad->store_data($this->vars["zip"]);}
	   $this->vars["id"] = insert($this, "moneypack_transaction");
	}
	function color_status(){
		$status = $this->vars["status"];
		switch($this->vars["status"]){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
	function get_color(){
		switch($this->vars["processor_status"]){
			case "de":
				$color = '#770808';
			break;
			case "ac":
				$color = '#1c4f06';
			break;
			case "pe":
				$color = '#000';
			break;	
		}
		return $color;
	}
	function str_active(){
		if($this->vars["active"]){
			$str = "Active";
		}else{
			$str = "Inactive";
		}
		return $str;
	}
	function get_destination(){
		switch($this->vars["destination"]){
			case "p":
				$destination = 'Paypal';
			break;
			case "c":
				$destination = 'CreditCard';
			break;
			
		}
		return $destination;
	}
	
	
}

class _moneypak_sell{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["moneypak"] = get_moneypak_transaction($this->vars["moneypak"]);
	}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "moneypak_sell", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "moneypak_sell");
	}
	function color_status(){
		$status = $this->vars["status"];
		switch($this->vars["status"]){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
	function get_color(){
		switch($this->vars["processor_status"]){
			case "de":
				$color = '#770808';
			break;
			case "ac":
				$color = '#1c4f06';
			break;
			case "pe":
				$color = '#000';
			break;	
		}
		return $color;
	}
	function str_delivered(){
		if($this->vars["delivered"]){
			$str = "True";
		}else{
			$str = "False";
		}
		return $str;
	}
}




class _cashback{
	var $vars = array();
	function initial(){}
	function str_type(){
		if($this->vars["type"] == "c"){
			$str = "Cashback";
		}else{
			$str = "Refund";
		}
		return $str;
	}
}



class _zip_address{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   processing_db();
	   insert($this, "zip_address");
	}
	function store_data($zip){
		$data = get_zip_adrress($zip);
		$this->vars["id"] = $zip;
		$this->vars["city"] = $data["city"];
		$this->vars["state"] = $data["state"];
		$this->vars["state_short"] = $data["state_short"];
		$this->vars["country"] = $data["country"];
		$this->vars["country_short"] = $data["country_short"];
		$this->insert();
	}
}

class _mp_expense_item{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "moneypak_expense_item", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "moneypak_expense_item");
	}
}
//end moneypak

//reloadit
class _reloadit_transaction{
	function __construct($pvars = array()){$this->vars = $pvars;}
	var $vars = array();
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "reloadit_transaction", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "reloadit_transaction");
	}
	function color_status(){
		$status = $this->vars["status"];
		switch($this->vars["status"]){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
	function get_color(){
		switch($this->vars["processor_status"]){
			case "de":
				$color = '#770808';
			break;
			case "ac":
				$color = '#1c4f06';
			break;
			case "pe":
				$color = '#000';
			break;	
		}
		return $color;
	}
}

//end reloadit

//checks
class _check_transaction{
	   
	  var $vars = array();
	  function __construct($pvars = array()){$this->vars = $pvars;}
	  function initial(){}
	  function update($specific = NULL){
	    processing_db();
	    return update($this, "check_transactions", $specific);
	  }
	  function insert(){
	    processing_db();
	    $this->vars["id"] = insert($this, "check_transactions");
	  }
	  function delete(){
		processing_db();
		return delete("check_transactions",$this->vars["id"] );
	  }	
	  
	  function color_status(){
		$status = $this->vars["status"];
		switch($this->vars["status"]){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
	  
 }

//tickets

class _master_ticket{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   tickets_db();
	   $this->vars["id"] = insert($this, "master_ticket");
	}
	function update($specific = NULL){
	   tickets_db();
	   return update($this, "master_ticket", $specific);
	}


	function get_password(){
		$key1 = mt_rand()."O";
		$key2 = "O".mt_rand();
		return biencript($key1.$this->vars["id"].$key2);
	}
	
	function str_status(){
		if($this->vars["open"]){
			$str = "Open";
		}else{
			$str = "Closed";
		}
		return $str;
	}
	
}

class _master_players_tickets{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   tickets_db();
	   $this->vars["id"] = insert($this, "master_players_tickets");
	}
}

class _ticket{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   tickets_db();
	   $this->vars["id"] = insert($this, "ticket");
	}
	function update($specific = NULL){
	   tickets_db();
	   return update($this, "ticket", $specific);
	}
	function insert_response($message, $from, $clerk = ""){
		$res = new _ticket_response();
		$res->vars["rdate"] = date("Y-m-d H:i:s");
		$res->vars["by"] = $from;
		$res->vars["message"] = $message;
		$res->vars["ticket"] = $this->vars["id"];
		if($clerk!=""){$res->vars["clerk"] = $clerk;}
		$res->insert();
		$this->vars["pread"] = 0;
		$this->vars["removed"] = 0;
		$this->update(array("pread","removed"));
		return $res;
	}

	function insert_response_api($response){
		$res = new _ticket_response();
		$res->vars["rdate"] = $response['rdate'];
		$res->vars["by"] =$response['_by'];
		$res->vars["message"] = $response['message'];
		$res->vars["ticket"] = $response['ticket'];
		$res->vars["clerk"] =$response['clerk'];
		$res->insert();
		return $res;
	}


	static function sort_by_date($a, $b){
		return sort_object($a->vars["tdate"], $b->vars["tdate"],"DESC");
   }
	function is_me($name){
		if($this->vars["name"] == $name){
			$is = true;
		}else{$is = false;}
		return $is;
	}
	function get_password(){
		$key1 = mt_rand()."O";
		$key2 = "O".mt_rand();
		return biencript($key1.$this->vars["id"].$key2);
	}
	function str_status(){
		if($this->vars["open"]){
			$str = "Open";
		}else{
			$str = "Closed";
		}
		return $str;
	}
}

class _ticket_categories{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	
	function update($specific = NULL){
	   tickets_db();
	   return update($this, "ticket_categories", $specific);
	}
}

class _ticket_response{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   tickets_db();
	   $this->vars["id"] = insert($this, "response");
	}
	function update($specific = NULL){
	   tickets_db();
	   return update($this, "response", $specific);
	}
}

class _pph_ticket{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function load_clerks($close = true){
		$this->vars["open_clerk"] = get_clerk($this->vars["open_clerk"]);
		if($close){$this->vars["close_clerk"] = get_clerk($this->vars["close_clerk"]);}	
	}
	function insert(){
	   tickets_db();
	   $this->vars["id"] = insert($this, "pph_ticket");
	}
	function update($specific = NULL){
	   tickets_db();
	   return update($this, "pph_ticket", $specific);
	}
	function str_status(){
		if($this->vars["resolved"]){
			$str = "Resolved";
		}else{
			$str = "Pending";
		}
		return $str;
	}
	function status_color(){
		if($this->vars["resolved"]){
			$col = "#060";
		}else{
			$col = "#C00";
		}
		return $col;
	}
}

class _department_ticket{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function load_clerks($close = true){
		$this->vars["open_clerk"] = get_clerk($this->vars["open_clerk"]);
		if($close){$this->vars["close_clerk"] = get_clerk($this->vars["close_clerk"]);}	
	}
	function insert(){
	   tickets_db();
	   $this->vars["id"] = insert($this, "department_ticket");
	}
	function update($specific = NULL){
	   tickets_db();
	   return update($this, "department_ticket", $specific);
	}
	function str_status(){
		if($this->vars["resolved"]){
			$str = "Resolved";
		}else{
			$str = "Pending";
		}
		return $str;
	}
	function status_color(){
		if($this->vars["resolved"]){
			$col = "#060";
		}else{
			$col = "#C00";
		}
		return $col;
	}
}

class _ticket_transfers_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   tickets_db();
	   $this->vars["id"] = insert($this, "transfers_log");
	}
}

//rec issues

class _rec_issues{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
         if (!is_null($this->vars["solutioned_by"])){
		 $this->vars["solutioned_by"] = get_clerk($this->vars["solutioned_by"]);
		 }
		 $this->vars["by"] = get_clerk($this->vars["by"]);	
		 if ($this->vars["assigned"] != 0){ 
		   $this->vars["assigned"] = get_clerk($this->vars["assigned"]);	
		 } 
	}
	
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "rec_issues");
	}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "rec_issues", $specific);
	}
	function str_status(){
		switch($this->vars["status"]){
			case "pe":
				$str = "Pending";
			break;
			case "so":
				$str = "Solved";
			break;
			case "cl":
				$str = "Closed";
			break;
		}
		return $str;
	}
	
	
	function status_color(){
    		switch($this->vars["status"]){
			case "pe":
				$col = "#C00";
			break;
			case "so":
				$col = "#060";
			break;
			case "cl":
				$col = "#060";
			break;
		}
   	    return $col;
	}
	
}

// programmers issues

class _programmers_issues{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
         if (!is_null($this->vars["solutioned_by"])){
		    $this->vars["solutioned_by"] = get_clerk($this->vars["solutioned_by"]);		
		 }
		 $this->vars["by"] =  get_clerk($this->vars["by"]);				
		 if ($this->vars["assigned"] != 0){ 
		    $this->vars["assigned"] = get_clerk($this->vars["assigned"]);	
		 } 
	}
	
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "programmer_issues");
	}
	function update($specific = NULL){
	  clerk_db();
	  return update($this, "programmer_issues", $specific);
	}
	function str_status(){
		switch($this->vars["status"]){
			case "pe":
				$str = "Pending";
			break;
			case "so":
				$str = "Solved";
			break;
			case "cl":
				$str = "Closed";
			break;
		}
		return $str;
	}
	
	
	function status_color(){
    		switch($this->vars["status"]){
			case "pe":
				$col = "#C00";
			break;
			case "so":
				$col = "#060";
			break;
			case "cl":
				$col = "#060";
			break;
		}
   	    return $col;
	}
	
}

// trends_feeds
class _trends_feed{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   inspinc_statsdb1();
	   return update($this, "trends_feed", $specific);
	}
	function insert(){
	   inspinc_statsdb1();
	   $this->vars["id"] = insert($this, "trends_feed");
	}
	function delete(){
	   inspinc_statsdb1();
	   delete("trends_feed", $this->vars["id"]);
	}	
}


//picks

class _inspin_pick{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   inspinc_statsdb1();
	   return update($this, "simulation_new", $specific);
	}
	function insert(){
	   inspinc_statsdb1();
	   $this->vars["id"] = insert($this, "simulation_new");
	}
	function delete(){
	   inspinc_statsdb1();
	   delete("simulation_new", $this->vars["id"]);
	}	
	function get_stars(){
		if($this->vars["2and3star"] == "Y"){$stars = 2;}else if($this->vars["4and5star"] == "Y"){$stars = 3;}else{$stars = 1;}	
		return $stars;
	}
	function is_graded(){
		if($this->vars["win"] != ""){
			$is = true;
		}else{$is = false;}
		return $is;
	}
	function comment_period(){
		if(strtolower($this->vars["period"]) != "game"){
			$str = $this->vars["period"];
		}
		return $str;
	}
	function str_result($res){
		switch($res){
			case "Y":
				$str = "Win";
			break;
			case "N":
				$str = "Loss";
			break;
			case "P":
				$str = "Push";
			break;
		}
		return $str;
	}
	function get_result($line, $team, $game, $scoreA, $scoreH){
		if($line != "" && $team != ""){
			$line = strtolower($line);
			$marks = substr_count($line,"-");
			$marks += substr_count($line,"+");
			if(contains_ck($line,"o") || contains_ck($line,"u")){$type = "total";}
			else if($marks > 1){$type = "spread";}
			else if($marks <= 1){$type = "money";}
			switch($type){
				case "money":
					$prejuice = str_replace("pk","",str_replace(" ","",strtolower($line)));				
					if($game->vars["away_team"]->vars["id"] == $team){
						if($scoreA > $scoreH){
							//win
							$pick_result = "Y";							
						}else if($scoreA < $scoreH){
							//loss
							$pick_result = "N";							
						}else{
							//push
							$pick_result = "P";							
						}	
					}else if($game->vars["home_team"]->vars["id"] == $team){
						if($scoreA < $scoreH){
							//win 
							$pick_result = "Y";
						}else if($scoreA > $scoreH){
							//loss
							$pick_result = "N";
						}else{
							//push
							$pick_result = "P";
						}		
					}
				break;
				case "spread":
					$first = substr($line,0,1);
					$spread = substr(trim($line),1);
					if(contains_ck($spread,"+")){$spliter = "+";}else if(contains_ck($spread,"-")){$spliter = "-";}
					$parts = explode($spliter,$spread);
					$spread = $first.$parts[0];
					$prejuice = $spliter.$parts[1];
									
					if($game->vars["away_team"]->vars["id"] == $team){
						$result = $scoreA + $spread;
						if($result > $scoreH){
							//win
							$pick_result = "Y";
						}else if($result < $scoreH){
							//loss
							$pick_result = "N";
						}else{
							//push
							$pick_result = "P";
						}
					}else if($game->vars["home_team"]->vars["id"] == $team){
						$result = $scoreH + $spread;
						if($result > $scoreA){
							//win
							$pick_result = "Y";
						}else if($result < $scoreA){
							//loss
							$pick_result = "N";
						}else{
							//push
							$pick_result = "P";
						}
					}
				break;
				case "total":
					if(contains_ck($line,"+")){$spliter = "+";}else if(contains_ck($line,"-")){$spliter = "-";}
					$parts = explode($spliter,$line);
					$total = $parts[0];
					$total = str_replace("o","",$total);
					$total = str_replace("u","",$total);
					$total = str_replace(" ","",$total);
					$prejuice = $spliter.$parts[1];
					
					if($this->vars["period"] != "Team Totals"){
						if(is_numeric($total)){
							$total_score = $scoreA + $scoreH;
							if($team == "Over"){
								if($total_score > $total){
									//win
									$pick_result = "Y";
								}else if($total_score < $total){
									//loss
									$pick_result = "N";
								}else{
									//push
									$pick_result = "P";
								}						
							}else if($team == "Under"){
								if($total_score < $total){
									//win
									$pick_result = "Y";
								}else if($total_score > $total){
									//loss
									$pick_result = "N";
								}else{
									//push
									$pick_result = "P";
								}
							}
						}
					}else{
						if($game->vars["away_team"]->vars["id"] == $team){
							$score = $scoreA;
						}else if($game->vars["home_team"]->vars["id"] == $team){
							$score = $scoreH;
						}
						if(is_numeric($total)){
							if(contains_ck($line,"o")){
								if($score > $total){
									//win
									$pick_result = "Y";
								}else if($score < $total){
									//loss
									$pick_result = "N";
								}else{
									//push
									$pick_result = "P";
								}						
							}else if(contains_ck($line,"u")){
								if($score < $total){
									//win
									$pick_result = "Y";
								}else if($score > $total){
									//loss
									$pick_result = "N";
								}else{
									//push
									$pick_result = "P";
								}
							}
						}
					}
				break;			
			}
			
			if($pick_result == "Y"){
				if($prejuice > 0){$pick_juice = $prejuice;}else{$pick_juice = "100";}
			}else if($pick_result == "N"){
				if($prejuice > 0){$pick_juice = "100";}else{$pick_juice = $prejuice;}
			}else{$pick_juice = "100";}
			
		}
		return array("result"=>$pick_result,"juice"=>str_replace("+","",str_replace("-","",$pick_juice)));
	}
}

//tickets

//special deposits

class _special_method{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "special_method", $specific);
	}
	function insert($table="special_method"){
	   accounting_db();
	   $this->vars["id"] = insert($this, "special_method");
	}
}
class _special_deposit{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["method"] = get_special_method($this->vars["method"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "special_deposit", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "special_deposit");
	}
	function str_inserted(){
		if($this->vars["inserted"]){
			$str = '<span style="color:#393">Yes</span>';
		}else{
			$str = '<span style="color:#FC3">No</span>';
		}
		return $str;
	}
	function str_status(){
		switch($this->vars["status"]){
			case "de":
				$str = '<span style="color:#C00">Denied</span>';
			break;
			case "ac":
				$str = '<span style="color:#393">Accepted</span>';
			break;
			case "pe":
				$str = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $str;
	}
}

class _special_payout{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["method"] = get_special_method($this->vars["method"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "special_payouts", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "special_payouts");
	}
	function str_inserted(){
		if($this->vars["inserted"]){
			$str = '<span style="color:#393">Yes</span>';
		}else{
			$str = '<span style="color:#FC3">No</span>';
		}
		return $str;
	}
	function str_status(){
		switch($this->vars["status"]){
			case "de":
				$str = '<span style="color:#C00">Denied</span>';
			break;
			case "ac":
				$str = '<span style="color:#393">Accepted</span>';
			break;
			case "pe":
				$str = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $str;
	}
}

class _moneyorder_payout{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "dmo_transaction", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "dmo_transaction");
	}
	function get_fee($fees){
		$fee = 0;
		for($i=0;$i<count($fees);$i++){
			$base = $fees[$i]["base"];
			$top = $fees[$i]["top"];
			if($base <= $this->vars["amount"] && $top >= $this->vars["amount"]){
				$fee = $fees[$i]["amount"];
				break;
			}
		}
		return $fee;
	}
	function str_status(){
		switch($this->vars["status"]){
			case "de":
				$str = '<span style="color:#C00">Denied</span>';
			break;
			case "ac":
				$str = '<span style="color:#393">Accepted</span>';
			break;
			case "pe":
				$str = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $str;
	}
}

class _local_payout{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "local_cash_transaction", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "local_cash_transaction");
	}
	function str_status(){
		switch($this->vars["status"]){
			case "de":
				$str = '<span style="color:#C00">Denied</span>';
			break;
			case "ac":
				$str = '<span style="color:#393">Accepted</span>';
			break;
			case "pe":
				$str = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $str;
	}
}

class _bank_wire{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "bank_wire", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "bank_wire");
	}
	function str_status(){
		switch($this->vars["status"]){
			case "de":
				$str = '<span style="color:#C00">Denied</span>';
			break;
			case "ac":
				$str = '<span style="color:#393">Accepted</span>';
			break;
			case "pe":
				$str = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $str;
	}
}

class _cash_transfer_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "transaction", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "transaction");
	}
	function get_fee($fees){
		$fee = 0;
		for($i=0;$i<count($fees);$i++){
			$base = $fees[$i]["base"];
			$top = $fees[$i]["top"];
			if($base <= $this->vars["amount"] && $top >= $this->vars["amount"]){
				$fee = $fees[$i]["amount"];
				break;
			}
		}
		return $fee;
	}
	function str_status(){
		switch($this->vars["status"]){
			case "de":
				$str = '<span style="color:#C00">Denied</span>';
			break;
			case "ac":
				$str = '<span style="color:#393">Accepted</span>';
			break;
			case "pe":
				$str = '<span style="color:#FC3">Pending</span>';
			break;
			case "ape":
				$str = 'On Review';
			break;	
		}
		return $str;
	}
}

class _cash_transfer_processor{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "method", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "method");
	}
}


//BRONTO

class _bronto{
	var $vars = array();
	function send_sms($keyword, $content, $message_id = '0bbd03eb00000000000000000000000a1892' ){
		$client = new SoapClient('https://api.bronto.com/v4?wsdl', array('trace' => 1,'features' => SOAP_SINGLE_ELEMENT_ARRAYS));
		setlocale(LC_ALL, 'en_US');
		$error = "";
		try {
			$token = "9449A993-AD3E-4A6D-A5F0-507DBB1A5310";
		 
			//print "logging in\n";
			$sessionId = $client->login(array('apiToken' => $token))->return;
		 
			$session_header = new SoapHeader("http://api.bronto.com/v4",
											 'sessionHeader',
											 array('sessionId' => $sessionId));
			$client->__setSoapHeaders(array($session_header));
		 
			$now = date('c');
			$smsMessageFieldObject = array('name' => 'promotions',
										   'content' => $content );
		 
			$delivery = array('start' => $now,
							  'messageId' => $message_id,
							  'deliveryType' => 'triggered',
							  'keywords' => $keyword, //   TEST keyword: '9b817fdc-5251-43f0-895d-f06d4bd4159c',
							  'fields' => $smsMessageFieldObject
							  );
		 
			$write_result = $client->addSMSDeliveries(array($delivery))->return;
			print_r($write_result);
			if ($write_result->errors) {
				$error .= "There was a problem adding the SMS delivery:\n";
				$error .= " /Error: ".print_r($write_result->errors,true);
				$error .= " /Request: ".$client->__getLastRequest();
				$error .= " /Response: ".$client->__getLastResponse();
			  } else {
				$error .= "The SMS delivery has been successfully created.\n";
			  }
		 
		} catch (Exception $e) {
			$error .= "uncaught exception\n";
			//print_r($e);
		}
		
		return $error; 
	}
}



//affiliates
class _affiliate_brand{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "sportsbooks", $specific);
	}
	function insert($table="sportsbooks"){
	   affiliate_db();
	   $this->vars["id"] = insert($this, "sportsbooks");
	}
}
class _affiliate{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
			
  	    $this->vars["password"] = aff_two_way_encript($this->vars["nepass"], true);	
		
		}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "affiliates", $specific);
	}
	function insert($table){
	   affiliate_db();
	   $this->vars["id"] = insert($this, "affiliates");
	}
	function full_name(){
		return $this->vars["firstname"]	." ".$this->vars["lastname"];
	}
}
class _affiliate_lead{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "lead", $specific);
	}
	function insert(){
	   affiliate_db();
	   $this->vars["id"] = insert($this, "lead");
	}
	function full_name(){
		return $this->vars["name"]	." ".$this->vars["last_name"];
	}
	function get_last_contact_date(){
		if($this->vars["last_contact"] == "0000-00-00 00:00:00"){$date = "Never";}	
		else{$date = date("Y-m-d H:i",strtotime($this->vars["last_contact"]));}
		return $date;
	}
	function get_call_back_date(){
		if(date("Y",strtotime($this->vars["call_back_date"]))>1999){
			$date = date("Y-m-d",strtotime($this->vars["call_back_date"]));
		}
		return $date;
	}
	function str_owner_name($obj){
		if(!is_null($obj)){
			$name = $obj["name"];
		}else{
			$name = "Free";
		}
		return $name;
	}
}
class _affiliate_lead_call{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "lead_contact", $specific);
	}
	function insert(){
	   affiliate_db();
	   $this->vars["id"] = insert($this, "lead_contact");
	}
}

class _affiliates_by_sportsbook{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){	}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "affiliates_by_sportsbook", $specific);
	}
	
	function insert($table="affiliates_by_sportsbook"){
	   affiliate_db();
	   $this->vars["id"] = insert($this, "affiliates_by_sportsbook");
	}
	
	 function delete(){
	   affiliate_db();
	   delete("affiliates_by_sportsbook", $this->vars["id"]);
	}
	
}

class _affiliate_news{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "news", $specific);
	}
	function insert(){
	   affiliate_db();;
	   $this->vars["id"] = insert($this, "news");
	}
	function delete(){
	   affiliate_db();
	   delete("news", $this->vars["id"]);
	}
}

class _endorsements_default{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["idbook"] = get_affiliates_brand($this->vars["idbook"]);
		
		}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "endorsements_default", $specific);
	}
	function insert(){
	   affiliate_db();;
	   $this->vars["id"] = insert($this, "endorsements_default");
	}
	function delete(){
	   affiliate_db();
	   delete("endorsements_default", $this->vars["id"]);
	}
}

class _affiliate_testimonial{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){	}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "testimonials", $specific);
	}
	function insert(){
	   affiliate_db();;
	   $this->vars["id"] = insert($this, "testimonials");
	}
	function delete(){
	   affiliate_db();
	   delete("testimonials", $this->vars["id"]);
	}
}

class _metatags{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_seo_db();
	   return update($this, "metatags", $specific);
	}
	function insert(){
		sbo_seo_db();
		return insert($this, "metatags");
	}
	function delete(){
		sbo_seo_db();
		return delete("metatags",$this->vars["id"] );
	}	
}

//balance
class _balace_adjust{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "adjusted_balances", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "adjusted_balances");
	}
	function delete(){
	   accounting_db();
	   delete("adjusted_balances", $this->vars["id"]);
	}
}


//Email System
class _email_message{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   mail_db();
	   $this->vars["id"] = insert($this, "email");
	}
	function get_hash(){
		return md5($this->vars["account"].$this->vars["edate"].$this->vars["subject"].$this->vars["body"]);
	}
	function create_hash(){
		$this->vars["hash"]	 = $this->get_hash();
	}
}
class _email_account{
	var $vars = array();
	function initial(){}
}
class _email_pointer{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   mail_db();
	   return update($this, "pointer", $specific);
	}
}

//$email = new _email("rarce@inspin.com","sbomike160412");
//$email->connect("Sent Items");
class _imap{
	var $user, $pass, $mbox;
	function _imap($puser, $ppass){
		$this->user = $puser;
		$this->pass = $ppass;
	}
	function connect($mailbox = "INBOX" /*Sent Items*/){
		$authhost="{190.241.11.135:143/novalidate-cert}$mailbox";
		$this->mbox = @imap_open( $authhost, $this->user, $this->pass );
	}
	function inbox(){
		$check = imap_check($this->mbox);
		$overviews = imap_fetch_overview($this->mbox,"1:{$check->Nmsgs}");
		return $overviews;
	}
	function messages_by_date($date){
		$messages = imap_search($this->mbox, 'ON "'.$date.'"');
		return $messages;
	}
	function get_message($uid){
		$data = array();
		$overview = imap_fetch_overview($this->mbox, $uid, 0);
		$data["overview"] = $overview[0];
		//$data["body"] = imap_body($this->mbox, $uid, FT_UID);
		$body = imap_fetchbody($this->mbox,$uid,1.2,FT_PEEK );
		if(!strlen($body)>0){
			$body = imap_fetchbody($this->mbox,$uid,1,FT_PEEK );
		}
		$data["body"] = $body;
		return $data;
	}
	function get_body($uid){
		$body = imap_fetchbody($this->mbox,$uid,1.2,FT_PEEK );
		if(!strlen($body)>0){
			$body = imap_fetchbody($this->mbox,$uid,1,FT_PEEK );
		}
		return $body;
	}
	function get_message_header($uid){
		return imap_header($this->mbox, $uid);
	}
	function close_connection(){
		imap_close($this->mbox);
	}
}


// Baseball_File
class _baseball_alert{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   baseball_db();	
	   $this->vars["id"] = insert($this, "alert");
	}
}

class _baseball_bet{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   baseball_db();	
	   $this->vars["id"] = insert($this, "bets");
	}
	function update($specific = NULL){
	   baseball_db();	
	   return update($this, "bets", $specific);
	}
	 function delete(){
		baseball_db();
		return delete("bets",$this->vars["id"] );
	  }	
}

class _player_updated{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   baseball_db();	
	   $this->vars["id"] = insert($this, "player_updated");
	}
}

/*

class _wheather_parser{
	var $code = array();
	function _wheather_parser(){
		$this->code["api"]= "a7bf9b320c55aee1";
	}
	function get_current_weather($location,$now=false){
		$current = array();
		$json_string = file_get_contents("http://api.wunderground.com/api/".$this->code["api"]."/conditions/q/".$location.".json");
		$parsed_json = json_decode($json_string);
		$current["wind_gust"] = $parsed_json->{'current_observation'}->{'wind_gust_mph'};
		$current["air_pressure"] = $parsed_json->{'current_observation'}->{'pressure_in'};
		
		 if($now){
		   $current["temp"] = $parsed_json->{'current_observation'}->{'temp_f'};   
		   $current["condition"] = $parsed_json->{'current_observation'}->{'weather'};
		   $current["img_url"] = $parsed_json->{'current_observation'}->{'icon_url'};
		   $current["wind_speed"] = $parsed_json->{'current_observation'}->{'wind_mph'};
		   $current["wind_degrees"] = $parsed_json->{'current_observation'}->{'wind_degrees'};
		   $current["wind_direction"] = $parsed_json->{'current_observation'}->{'wind_dir'};
		   $current["humidity"] = $parsed_json->{'current_observation'}->{'relative_humidity'};
		   $current["dewpoint"] = $parsed_json->{'current_observation'}->{'dewpoint_f'};
		}
		
		return $current;
	}
	function get_history_weather($location,$Historical_date,$hour){
		// EDT time
		$history = array();
		$json_string = file_get_contents("http://api.wunderground.com/api/".$this->code["api"]."/history_".$Historical_date."/q/".  $location.".json");
		//echo "http://api.wunderground.com/api/".$this->code["api"]."/history_".$Historical_date."/q/".  $location.".json";
		echo "<pre>";
		//print_r($json_string);
 	   echo "</pre>";
		$parsed_json = json_decode($json_string);
	
		foreach ($parsed_json->{'history'}->{'observations'} as $item ){
		
			echo "<pre>";
		   // print_r($item);
 	      echo "</pre>";
	     // echo $item->{'date'}->{'hour'}." IGUAL A".$hour."<BR>";  
		  if ($item->{'date'}->{'hour'} == $hour){
				 
				 $history["temp"]= $item->{'tempi'};
				 $history["condition"]= $item->{'conds'}; 
				 $history["img_url"]= $item->{'icon'};  // NO URL
				 $history["wind_speed"]= $item->{'wspdi'}; 
				 $history["wind_degrees"]= $item->{'wdird'}; 
				 $history["wind_direction"]= $item->{'wdire'}; 
				 $history["wind_gust"]= $item->{'wgusti'}; 
				 $history["humidity"]= $item->{'hum'}; 
				 $history["air_pressure"]= $item->{'pressurei'}; 
				 $history["dewpoint"]= $item->{'dewpti'}; 
				 break;
		 } else if($item->{'date'}->{'hour'} < $hour ){
			    
				 $history["temp"]= $item->{'tempi'};
				 $history["condition"]= $item->{'conds'}; 
				 $history["img_url"]= $item->{'icon'};  // NO URL
				 $history["wind_speed"]= $item->{'wspdi'}; 
				 $history["wind_degrees"]= $item->{'wdird'}; 
				 $history["wind_direction"]= $item->{'wdire'}; 
				 $history["wind_gust"]= $item->{'wgusti'}; 
				 $history["humidity"]= $item->{'hum'}; 
				 $history["air_pressure"]= $item->{'pressurei'}; 
				 $history["dewpoint"]= $item->{'dewpti'}; 
			     
			 
			 
			 
			     }
		  
		  
		 
		 
		}
		// Note that values will = -9999 or -999 for Null or Non applicable (NA) variables.
		return $history;
	}
	function get_hourly_weather($location,$hour,$day){
		// EDT time
	   $hourly = array();
	   $json_string = file_get_contents("http://api.wunderground.com/api/".$this->code["api"]."/hourly/q/".$location.".json");
	   echo $json_string; exit;
	   $parsed_json = json_decode($json_string);
	
	   foreach ($parsed_json->{'hourly_forecast'} as $item ){
	
		  if ($item->{'FCTTIME'}->{'hour'} == $hour && $item->{'FCTTIME'}->{'mday'} == $day){
			  $hourly["temp"]= $item->{'temp'}->{'english'};
			  $hourly["condition"]= $item->{'condition'}; 
			  $hourly["img_url"]= $item->{'icon_url'};  
			  $hourly["wind_speed"]= $item->{'wspd'}->{'english'}; 
			  $hourly["wind_degrees"]= $item->{'wdir'}->{'degrees'}; 
			  $hourly["wind_direction"]= $item->{'wdir'}->{'dir'}; 
			  $hourly["humidity"]= $item->{'humidity'}; 
			  $hourly["dewpoint"]= $item->{'dewpoint'}->{'english'}; 
		  }
	   }
		// Note that values will = -9999 or -999 for Null or Non applicable (NA) variables.
	  return $hourly;
	}
}
*/

class _wheather_parser{
	var $code = array();
	//function _wheather_parser(){
		function __construct(){
	//	$this->code["api"]= "fe8f60555770606cddaeae8ab553e101"; //inspin.com
		$this->code["api"]= "bc0369f637e1059fece9f30f6b038c35"; //gmail
	}
	
	function get_time_zone($time) 
   {  
		$tz_from = 'GMT';
		$tz_to = 'America/New_York';
		$format = 'Y-m-d H';
		
		//$dt = new DateTime($datetime, new DateTimeZone($tz_from));
		$dt = new DateTime('@'.$time, new DateTimeZone('America/New_York'));
		$dt->setTimeZone(new DateTimeZone($tz_to));
		return $dt->format($format);
   } 
   
   function get_milibars_to_in($bars) 
   {  
		$inHg = round(($bars * 0.029530),2);
		return $inHg;
   } 
   
   function wind_cardinals($deg) {
	$cardinalDirections = array(
		'N' => array(348.75, 361),
		'N2' => array(0, 11.25),
		'NNE' => array(11.25, 33.75),
		'NE' => array(33.75, 56.25),
		'ENE' => array(56.25, 78.75),
		'E' => array(78.75, 101.25),
		'ESE' => array(101.25, 123.75),
		'SE' => array(123.75, 146.25),
		'SSE' => array(146.25, 168.75),
		'S' => array(168.75, 191.25),
		'SSW' => array(191.25, 213.75),
		'SW' => array(213.75, 236.25),
		'WSW' => array(236.25, 258.75),
		'W' => array(258.75, 281.25),
		'WNW' => array(281.25, 303.75),
		'NW' => array(303.75, 326.25),
		'NNW' => array(326.25, 348.75)
	);
	foreach ($cardinalDirections as $dir => $angles) {
			if ($deg >= $angles[0] && $deg < $angles[1]) {
				$cardinal = str_replace("2", "", $dir);
			}
		}
		return $cardinal;
}
   
	function get_current_weather($latitud,$longitud,$hour_game){
		$current = array();
		
		echo "https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud."<BR>";
		$json_string = file_get_contents("https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud);
		$parsed_json = json_decode($json_string);
	    //print_r()
	     exit;
		$now =  $this->get_time_zone($parsed_json->{'currently'}->{'time'});
		//echo $now." -- ".$hour_game;
       
		
		
		if($now == $hour_game){
		   $current["wind_gust"] = $parsed_json->{'currently'}->{'windGust'};
		    $current["air_pressure"] = $this->get_milibars_to_in($parsed_json->{'currently'}->{'pressure'});
		   $current["temp"] = $parsed_json->{'currently'}->{'temperature'};   
		   $current["condition"] = $parsed_json->{'currently'}->{'icon'};
		   //$current["img_url"] = $parsed_json->{'currently'}->{'icon_url'};
		   $current["wind_speed"] = $parsed_json->{'currently'}->{'windSpeed'};
		   $current["wind_degrees"] = $parsed_json->{'currently'}->{'windBearing'};
		   $current["wind_direction"] = $this->wind_cardinals($parsed_json->{'currently'}->{'windBearing'});
		   $current["humidity"] = ($parsed_json->{'currently'}->{'humidity'} * 100);
		   $current["dewpoint"] = $parsed_json->{'currently'}->{'dewPoint'};
		} else {
			
			
			foreach ($parsed_json->{'hourly'}->{'data'} as $item ){
				
				$tt = $this->get_time_zone($item->{'time'});
				//echo $tt."<BR>";
				if($tt == $hour_game){
					 $current["wind_gust"] = $item->{'windGust'};
					$current["air_pressure"] = $this->get_milibars_to_in($item->{'pressure'});
				   $current["temp"] = $item->{'temperature'};   
				   $current["condition"] = $item->{'icon'};
				   //$current["img_url"] = $item->{'icon_url'};
				   $current["wind_speed"] = $item->{'windSpeed'};
				   $current["wind_degrees"] = $item->{'windBearing'};
				   $current["wind_direction"] = $this->wind_cardinals($item->{'windBearing'});
				   $current["humidity"] = ($item->{'humidity'} * 100);
				   $current["dewpoint"] = $item->{'dewPoint'};
					break;
					}
				
			}
			
	    }
	
	
		
		return $current;
	}
	
	function get_history_weather($latitud,$longitud,$time){
		$current = array();
		
		//echo "https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud.",".$time."<BR>";
		$json_string = file_get_contents("https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud.','.$time);
		$parsed_json = json_decode($json_string);
	  
		//$now =  $this->get_time_zone($parsed_json->{'currently'}->{'time'});
		//echo strtotime($hour_game)." -- ".$parsed_json->{'currently'}->{'time'};
		//echo "<BR>";
		//echo $now." -- ".$hour_game;
        // exit;
		
		
		//if($now == $hour_game){
		   $current["wind_gust"] = $parsed_json->{'currently'}->{'windGust'};
		    $current["air_pressure"] = $this->get_milibars_to_in($parsed_json->{'currently'}->{'pressure'});
		   $current["temp"] = $parsed_json->{'currently'}->{'temperature'};   
		   $current["condition"] = $parsed_json->{'currently'}->{'icon'};
		   //$current["img_url"] = $parsed_json->{'currently'}->{'icon_url'};
		   $current["wind_speed"] = $parsed_json->{'currently'}->{'windSpeed'};
		   $current["wind_degrees"] = $parsed_json->{'currently'}->{'windBearing'};
		   $current["wind_direction"] = $this->wind_cardinals($parsed_json->{'currently'}->{'windBearing'});
		   $current["humidity"] = ($parsed_json->{'currently'}->{'humidity'} * 100);
		   $current["dewpoint"] = $parsed_json->{'currently'}->{'dewPoint'};
		
	
	
		
		return $current;
	}
	

}


///OpenWeather

class _Openweather_parser{
	var $code = array();
	function __construct(){
	//function _Openweather_parser(){
	
		$this->code["api"]= "JN2WPKLFG2MGQ6GM48825TDUM"; //gmail
	}
	
	function get_time_zone($time) 
   {  
		$tz_from = 'GMT';
		$tz_to = 'America/New_York';
		$format = 'Y-m-d H';
		
		//$dt = new DateTime($datetime, new DateTimeZone($tz_from));
		$dt = new DateTime('@'.$time, new DateTimeZone('America/New_York'));
		$dt->setTimeZone(new DateTimeZone($tz_to));
		return $dt->format($format);
   } 


   function convertirFecha($fecha_unix) {
    $fecha = new DateTime();
    $fecha->setTimestamp($fecha_unix);
    return $fecha->format('Y-m-d H');
}
   
   function get_milibars_to_in($bars) 
   {  
		$inHg = round(($bars * 0.029530),2);
		return $inHg;
   } 
   
   function wind_cardinals_OLD($deg) {
	$cardinalDirections = array(
		'N' => array(348.75, 361),
		'N2' => array(0, 11.25),
		'NNE' => array(11.25, 33.75),
		'NE' => array(33.75, 56.25),
		'ENE' => array(56.25, 78.75),
		'E' => array(78.75, 101.25),
		'ESE' => array(101.25, 123.75),
		'SE' => array(123.75, 146.25),
		'SSE' => array(146.25, 168.75),
		'S' => array(168.75, 191.25),
		'SSW' => array(191.25, 213.75),
		'SW' => array(213.75, 236.25),
		'WSW' => array(236.25, 258.75),
		'W' => array(258.75, 281.25),
		'WNW' => array(281.25, 303.75),
		'NW' => array(303.75, 326.25),
		'NNW' => array(326.25, 348.75)
	);
	foreach ($cardinalDirections as $dir => $angles) {
			if ($deg >= $angles[0] && $deg < $angles[1]) {
				$cardinal = str_replace("2", "", $dir);
			}
		}
		return $cardinal;
}


function wind_cardinals($degrees) {
 
  $cardinalDirections = array(
    'N' => array(337.5, 22.5),
    'NE' => array(22.5, 67.5),
    'E' => array(67.5, 112.5),
    'SE' => array(112.5, 157.5),
    'S' => array(157.5, 202.5),
    'SW' => array(202.5, 247.5),
    'W' => array(247.5, 292.5),
    'NW' => array(292.5, 337.5)
  );

  
  foreach ($cardinalDirections as $dir => $angles) {
     //echo $dir." ".$angles[0]." ".$angles[1]."<BR>";

    if ((double)$degrees >= $angles[0] && (double)$degrees < $angles[1]) {
    	
      return $dir;
    }
  }

  return 'WW'; // Default to North if no cardinal direction is found
}
   
	function get_current_weather($latitud,$longitud,$hour_game){
		$current = array();
		
		$link = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/".$latitud.",".$longitud."?key=".$this->code["api"];
		//$link = "https://api.openweathermap.org/data/2.5/weather?lat=".$latitud."&lon=".$longitud."&appid=".$this->code["api"];
		echo $link."<BR>";
		$json_string = file_get_contents($link);
		$parsed_json = json_decode($json_string);
	    echo "<pre>";
	   //print_r($parsed_json);
	   // echo "<BR><BR>";
	   // echo $parsed_json->{'currentConditions'}->{'datetimeEpoch'};
	    
		$now =  $this->convertirFecha($parsed_json->{'currentConditions'}->{'datetimeEpoch'});
		//echo $now." -- ".$hour_game;
       
		// exit; 
		
		if($now == $hour_game){
		   $current["wind_gust"] = $parsed_json->{'currentConditions'}->{'windGust'};
		    $current["air_pressure"] = $this->get_milibars_to_in($parsed_json->{'currentConditions'}->{'pressure'});
		   $current["temp"] = $parsed_json->{'currentConditions'}->{'temp'};   
		   $current["condition"] = $parsed_json->{'currentConditions'}->{'icon'};
		   //$current["img_url"] = $parsed_json->{'currently'}->{'icon_url'};
		   $current["wind_speed"] = $parsed_json->{'currentConditions'}->{'windspeed'};
		   $current["wind_degrees"] = $parsed_json->{'currentConditions'}->{'winddir'};
		   $current["wind_direction"] = $this->wind_cardinals($parsed_json->{'currentConditions'}->{'winddir'});
		   $current["humidity"] = $parsed_json->{'currentConditions'}->{'humidity'} ;
		   $current["dewpoint"] = $parsed_json->{'currentConditions'}->{'dew'};
		} else {
			
			
			foreach ($parsed_json->{'days'}[0]->{'hours'} as $item ){
				
				$tt = $this->get_time_zone($item->{'datetimeEpoch'});
				//echo $tt."<BR>";
				
				if($tt == $hour_game){	
				
					$current["wind_gust"] = $item->{'windGust'};
					 $current["air_pressure"] = $this->get_milibars_to_in($item->{'pressure'});
				    $current["temp"] = $item->{'temp'};   
		  			 $current["condition"] = $item->{'icon'};
				   //$current["img_url"] = $item->{'icon_url'};
				    $current["wind_speed"] = $item->{'windspeed'};
		   		    $current["wind_degrees"] = $item->{'winddir'};
		   		    $current["wind_direction"] = $this->wind_cardinals($item->{'winddir'});
		   		  	$current["humidity"] = $item->{'humidity'} ;
		   			$current["dewpoint"] = $item->{'dew'};
					break;
					}
				
			}
			
	    }
	
	  //print_r($current);
	   //exit;
		
		return $current;
	}
	
	function get_history_weather($latitud,$longitud,$time){
		$current = array();
		
		//echo "https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud.",".$time."<BR>";
		$json_string = file_get_contents("https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud.','.$time);
		$parsed_json = json_decode($json_string);
	  
		//$now =  $this->get_time_zone($parsed_json->{'currently'}->{'time'});
		//echo strtotime($hour_game)." -- ".$parsed_json->{'currently'}->{'time'};
		//echo "<BR>";
		//echo $now." -- ".$hour_game;
        // exit;
		
		
		//if($now == $hour_game){
		   $current["wind_gust"] = $parsed_json->{'currently'}->{'windGust'};
		    $current["air_pressure"] = $this->get_milibars_to_in($parsed_json->{'currently'}->{'pressure'});
		   $current["temp"] = $parsed_json->{'currently'}->{'temperature'};   
		   $current["condition"] = $parsed_json->{'currently'}->{'icon'};
		   //$current["img_url"] = $parsed_json->{'currently'}->{'icon_url'};
		   $current["wind_speed"] = $parsed_json->{'currently'}->{'windSpeed'};
		   $current["wind_degrees"] = $parsed_json->{'currently'}->{'windBearing'};
		   $current["wind_direction"] = $this->wind_cardinals($parsed_json->{'currently'}->{'windBearing'});
		   $current["humidity"] = ($parsed_json->{'currently'}->{'humidity'} * 100);
		   $current["dewpoint"] = $parsed_json->{'currently'}->{'dewPoint'};
		
	
	
		
		return $current;
	}
	

}


class _baseball_game_line{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars['line'] = get_lines_by_date_rotations($this->vars['line_date'],$this->vars['away_rotation']);
	}
}


class _baseball_game{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   baseball_db();	
	   return update($this, "game", $specific);
	}
	function started(){
		$now = time();
		$game = strtotime($this->vars["startdate"]);	
		if($now > $game){$start = true;}
		else{$start = false;}
		return $start;
	}
	function get_roof_comparison(){
		if($this->vars["roof_open"]){$manual = "Open";}else{$manual = "Close";}
		if($this->vars["real_roof_open"]){$real = "Open";}else{$real = "Close";}
		
		$str = "<strong>".$manual."</strong>";
		if($manual != $real && $this->vars["real_roof_open"] != -1){
			$str = "<strong>Selected: $manual <br />";
			$str .= "Real: $real <br />";
			$str .= "<span class='error'>Didn't match</span></strong>";
		}
		return $str;
	}
	
	function get_firstbase_comparison($first){
		$firstbase = get_umpire_name_by_id($first);
		$umpire = get_umpire_name_by_id($this->vars["umpire"]);		
		$str = "<strong>".$umpire["full_name"]."</strong>";
		if($firstbase["full_name"] != $umpire["full_name"]){
			$str = "<strong>First Base:<br />".$firstbase['full_name']."<br />";
			$str .= "Assigned:<br />".$umpire['full_name']." <br />";
			$str .= "<span class='error'>Didn't match</span></strong>";
		}
		return $str;
	}
	
	
	
	function get_umpire_comparison(){
		$umpire = get_umpire_name_by_id($this->vars["umpire"]);
		$umpire_real = get_umpire_name_by_id($this->vars["real_umpire"]);		
		
		$str = "<strong>".$umpire["full_name"]."</strong>";
		if($umpire["full_name"] != $umpire_real["full_name"] && $this->vars["real_umpire"] != 0){
			$str = "<strong>Selected:<br />".$umpire['full_name']."<br />";
			$str .= "Real:<br />".$umpire_real['full_name']." <br />";
			$str .= "<span class='error'>Didn't match</span></strong>";
		}
		return $str;
	}


	
	function get_pk($weather,$stadium,$adjustment_factors,$constants){
		
	  $weather->vars["wind_speed"] = check_999_null($weather->vars["wind_speed"]);
	  $weather->vars["humidity"] = check_999_null($weather->vars["humidity"]);
	  $weather->vars["temp"] = check_999_null($weather->vars["temp"]);
	  $weather->vars["wind_gust"] = check_999_null($weather->vars["wind_gust"]);
	  $weather->vars["air_pressure"] = check_999_null($weather->vars["air_pressure"]);
	  $weather->vars["dewpoint"] = check_999_null($weather->vars["dewpoint"]);
	
	  $factor=array();
	  $factor[0]["name"]= "LF";
	  $factor[1]["name"]="LCF";
	  $factor[2]["name"]="CF";
	  $factor[3]["name"]="RCF";
	  $factor[4]["name"]="RF"; 
	  
	  $const_temp_factor = $constants[0]["value"];
	  $const_rf  = $constants[1]["value"];
	  $const_rcf = $constants[2]["value"];
	  $const_cf  = $constants[3]["value"];
	  $const_lcf = $constants[4]["value"];
	  $const_lf = $constants[5]["value"];
	  $const_variant=$constants[6]["value"];
	  
	    
	  $temperature = round(($weather->vars["temp"] - $stadium->vars["avg_temp"]) * $const_temp_factor);
	  
	  for ($i=0;$i<5;$i++){
		  $factor[$i]["wind"] = ($adjustment_factors[$factor[$i]["name"]] * $weather->vars["wind_speed"]);
		  $factor[$i]["adjusted"] = round(($stadium->vars[$factor[$i]["name"]] + $temperature + $factor[$i]["wind"])) ;
	   }
	    
	  $pre_pk = ((
				 ($factor[0]["adjusted"] * $const_lf )+
				 ($factor[1]["adjusted"] * $const_lcf )+
				 ($factor[2]["adjusted"] * $const_cf )+
				 ($factor[3]["adjusted"] * $const_rcf )+
				 ($factor[4]["adjusted"] * $const_rf )
				 ) * $const_variant );
	  
	  $pre_pk= number_format($pre_pk);
	  $pk = number_format($pre_pk - $stadium->vars["overall"]);
	  return $pk;
	}  
	
    //reference: https://www.brisbanehotairballooning.com.au/faqs/education/116-calculate-air-density.html
	function get_kelvin_temp($temp){
	// °K = ((°F - 32 )/1.8000) +273.15
	 $kelvin =  (($temp-32)/1.8000)+ 273.15;
	 return number_format($kelvin,2); 
	}	
	
	function get_celsius_temp($temp){
	// °C = ((°F - 32 )/1.8000)
	 $celsius =  (($temp-32)/1.8000);
	 return number_format($celsius,2); 
	}
	
	function get_pascals_from_inches($air_pressure){
	//1 Inches Of Water to Pascals = 249.082	 
	 $pascals = 249.082;
	 $pascals = $pascals *$air_pressure;
	 return $pascals;
	
	}
	
	
	function get_pascals_from_inch_merc($air_pressure){
	// http://www.endmemo.com/sconvert/painhg.php	
	// 1 inHg = 33.86 hpa  
	 $hecto_pascals = 33.86;
	 $hecto_pascals = $hecto_pascals * $air_pressure;
	 return $hecto_pascals;
	
	}
	
	function get_aird($temp,$air_pressure,$vapour){
	// http://www.gribble.org/cycling/air_density.html
	  $pv = $vapour;
	  $pd =  ($this->get_pascals_from_inch_merc($air_pressure)) - $pv;
	  // echo $pv." -- ".$pd."<BR>";
	  $rv = 461.9664;
	  $rd = 287.0531;  
	 
	   $aird =  ($pd/($rd * $temp)) + ($pv/($rv * $temp));
	   //$aird .= " ".$pv." ".$pd; 
	 return number_format($aird*100,4);
	
	}
	
	
	function get_air_density($air_pressure,$temp){
	// Pdry air = p /R.T
	// p = air pressure, R= 287.05 J(kg.K) , T= temp °K
      $gas_constant= 287.05;
	  $air_density =  ($air_pressure/($gas_constant * $temp))*100;
	 // return $air_density;
	  return number_format($air_density,4); 
	}
	
    function get_water_vapour($dwp){
	// Es = Eso / p8  , T = Dew Point °C
	// Eso = 6.1078  , p = (co+T(c1+T(c2+T(c3+T(c4+T(c5+T(c6+T(c7+T(c8+T(c9))))))))))
	
	$Eso = 6.1078;
	$c = array();
	$c[0] = 0.99999683;
	$c[1] = -0.0090826951;
	$c[2] = 0.000078736169;
	$c[3] = -0.00000061117958;
	$c[4] = 0.0000000043884187;
	$c[5] = -0.000000000029883885;
	$c[6] = 0.00000000000021874425;
	$c[7] = -0.0000000000000017892321;
	$c[8] = 0.000000000000000011112018;
	$c[9] = -0.000000000000000000030994571;
	
	 $water_vapour = ($c[0]+$dwp*($c[1]+$dwp*($c[2]+$dwp*($c[3]+$dwp*($c[4]+$dwp*($c[5]+$dwp*($c[6]+$dwp*($c[7]+$dwp*($c[8]+$dwp*($c[9])))))))))) ;
	
	$water_vapour  = pow($water_vapour,8);
	$water_vapour = $Eso / $water_vapour;
	  return  number_format($water_vapour,4); 
 }
	
  function get_moist_air_density ($air_pressure,$water_vapour, $temp_kelvin){
      
	  $pd = ($air_pressure - $water_vapour) * 100   ;
	  $pd = $pd / (287.0531 * $temp_kelvin );
	   $pv = $water_vapour *100;
	  $pv = ($pv/(461.495 * $temp_kelvin));
	  $density = (($pd + $pv));
	
	return number_format($density,4);
  }

}

class _baseball_stats{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"baseball_stats", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "baseball_stats");
	}
	
}

class _baseball_team{
	var $vars = array();
	function initial(){}
}

class _baseball_team_speed{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"team_speed", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "team_speed");
	}
}


class _baseball_team_bullpen{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   baseball_db();
	   return update($this,"team_bullpen", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "team_bullpen");
    }
}

class _baseball_player_teams{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   baseball_db();
	   return update($this,"player_teams", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "player_teams");
     }
}
	

class _baseball_espn_player_data{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   baseball_db();
	   return update($this,"espn_player_data", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "espn_player_data");
     }
}
	
class _baseball_espn_player_year_data{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   baseball_db();
	   return update($this,"espn_player_year_data", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "espn_player_year_data");
     }
}


class _baseball_espn_pitcher_batter{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   baseball_db();
	   return update($this,"espn_pitcher_batter", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "espn_pitcher_batter");
     }
}

class _baseball_umpire{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "umpire");
	   
	}
}

class _baseball_umpire_data{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "umpire_data");
	}
	function update($specific = NULL){
	   baseball_db();
	   return update($this,"umpire_data", $specific);
	}
}

class _baseball_columns_description{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "columns_description");
	}
	function update($specific = NULL){
	   baseball_db();
	   return update($this,"columns_description", $specific);
	}
}

class _baseball_umpire_stadistics{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"umpire_stadistics", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "umpire_stadistics");
	}
}

class _baseball_player{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"player", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "player");
	}
	function delete(){
	   baseball_db();
	   delete("player", $this->vars["id"]);
	}
}

class _baseball_player_stadistics_by_game{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"player_stadistics_by_game", $specific);

	}
	
	
	
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "player_stadistics_by_game");
	}
}

class _baseball_stadium_stadistics_by_game{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"stadium_stadistics_by_game", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "stadium_stadistics_by_game");
	}
}

class _baseball_stadium_parkfactor_season{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"stadium_parkfactor_season", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "stadium_parkfactor_season");
	}
}

class _baseball_espn_player_stadium{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   baseball_db();
	   return update($this,"espn_player_stadium", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "espn_player_stadium");
	}
}



class _baseball_stadium{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	
	function initial(){}
	function update($specific = NULL){
	  baseball_db();	
	   return update($this, "stadium", $specific);
	}
		
	function get_baseball_stadium_wind_position($wind){
        $position = get_baseball_stadium_position($wind,$this->vars['id']);  
    return $position;		
   }

}


class _baseball_stadium_formula_data{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	
	function initial(){}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "stadium_formula_data");
	}
	
	function update($specific = NULL){
	  baseball_db();	
	   return update($this, "stadium_formula_data", $specific);
	}
		
	

}

class _stadium_wind_avg{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	
	function initial(){}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "stadium_wind_avg");
	}
	function update($specific = NULL){
	  baseball_db();	
	   return update($this, "stadium_wind_avg", $specific);
	}

}

class _stadium_dewpoint_avg{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "stadium_dewpoint_avg");
	}
	function update($specific = NULL){
	  baseball_db();	
	   return update($this, "stadium_dewpoint_avg", $specific);
	}

}



class _baseball_stadium_position{
	var $vars = array();
	function initial(){}
}

class _baseball_weather{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	//function _baseball_weather($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($table="temp_weather",$specific = NULL){
	   baseball_db();
	   return update($this, $table, $specific);
	}
	function insert($table="temp_weather"){
  	   baseball_db();
  	   ;
	   $this->vars["id"] = insert($this, $table);
	}
}

class _pivot_game{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
//	function _pivot_game($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	   function update($specific = NULL){
	   baseball_db();
	   return update($this, "pivot_game", $specific);
	}
	function insert(){
  	   baseball_db();
	   $this->vars["id"] = insert($this, "pivot_game");
	}
}

// creditcard transactions

class _creditcard_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "creditcard_transactions", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "creditcard_transactions");
	}
	function color_status(){
		$status = $this->vars["approved"];
		switch($status){
			case "N":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "Y":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "P":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
			case "E":
				$status = '<span style="color:#C00">Expired</span>';
			break;		}
		return $status;
	}
}



// bitcoin deposit

class _btc_deposit{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "bitcoin_deposit", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "bitcoin_deposit");
	}
	function color_status(){
		$status = $this->vars["status"];
		switch($status){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
}

class _bitbet_deposit{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "btc_casino_deposit", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "btc_casino_deposit");
	}
}



//bitcoin payout

class _btc_payout{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "bitcoin_payouts", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "bitcoin_payouts");
	}
	function color_status(){
		$status = $this->vars["status"];
		switch($status){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
}

//payout question

class _payout_question{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	//function _payout_question($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "payout_question", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "payout_question");
	}
	function delete(){
	   clerk_db();
	   delete("payout_question", $this->vars["id"]);
	}
	
}

class _payout_answer{
	var $vars = array();
	//function _payout_answer($pvars = array()){$this->vars = $pvars;}
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "payout_answer", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "payout_answer");
	}
	function delete(){
	   clerk_db();
	   delete("payout_answer", $this->vars["id"]);
	}
	
}

//prepaid payout
class _prepaid_payout{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "prepaid_payout", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "prepaid_payout");
	}
	function color_status(){
		$status = $this->vars["status"];
		switch($status){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
}


//paypal payout
class _paypal_transaction{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "direct_paypal_transaction", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "direct_paypal_transaction");
	}
	function color_status(){
		$status = $this->vars["status"];
		switch($status){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
}




//virtual CCs

class _virtual_cc{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "virtualcc_transaction", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "virtualcc_transaction");
	}
	function color_status($type){
		$status = $this->vars["status"];
		switch($this->vars[$type."_status"]){
			case "de":
				$status = '<span style="color:#C00">Rejected</span>';
			break;
			case "ac":
				$status = '<span style="color:#393">Approved</span>';
			break;
			case "pe":
				$status = '<span style="color:#FC3">Pending</span>';
			break;	
		}
		return $status;
	}
	function is_rejected($type){
		if($this->vars[$type."_status"] == "de"){$is = true;}else{$is = false;}
		return $is;
	}
}

//Cashier Access

class _cashier_method{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "cashier_access_methods", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "cashier_access_methods");
	}
	function clean_list(){
		sbo_book_db();
		
		if($this->vars["type"] == "b"){$type = "black";}
		else if($this->vars["type"] == "w"){$type = "white";}
		
		delete("cashier_access_".$type, "", "method = '".$this->vars["id"]."'");
	}
	function delete_account($player){
		sbo_book_db();
		
		if($this->vars["type"] == "b"){$type = "black";}
		else if($this->vars["type"] == "w"){$type = "white";}
		
		delete("cashier_access_".$type, "", "method = '".$this->vars["id"]."' AND player = '$player'");
	}
	function str_type(){
		if($this->vars["type"] == "b"){$type = "black";}
		else if($this->vars["type"] == "w"){$type = "white";}
		return $type;
	}
	function get_list(){
		if($this->vars["type"] == "b"){$type = "black";}
		else if($this->vars["type"] == "w"){$type = "white";}
		return 	get_cashier_access_list($this->vars["id"], $type);
	}
	function get_by_str(){
		if($this->vars["type"] == "b"){$str = "Black List";}
		else if($this->vars["type"] == "w"){$str = "Allow List";}
		return $str;
	}
}

//Cashier Method Description

class _cashier_method_description{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		  $this->vars["cashier_method"] = get_cashier_method($this->vars["cashier_method"]);
	}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "cashier_methods_description", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "cashier_methods_description");
	}
	
	
	
}



//

class _cashier_access{
	var $vars = array();
	var $type;
	function __construct($pvars = array()){$this->vars = $pvars;}
	function set_type($ptype){
		if($ptype == "b"){
			$this->type = "black";
		}else if($ptype == "w"){
			$this->type = "white";
		}
	}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "cashier_access_".$this->type, $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "cashier_access_".$this->type);
	}
	function delete(){
	   clerk_db();
	   delete("cashier_access_".$this->type, $this->vars["id"]);
	}
}

//expense emails
class _expense_email{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "expense_email".$this->type, $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "expense_email".$this->type);
	}
	function delete(){
	   accounting_db();
	   delete("expense_email".$this->type, $this->vars["id"]);
	}
}


//emails lists
class _list_email{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "email_list".$this->type, $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "email_list".$this->type);
	}
	function delete(){
	   clerk_db();
	   delete("email_list".$this->type, $this->vars["id"]);
	}
}


//programmers book
class _programmer_entry{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "programmers_book", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "programmers_book");
	}
}


//Email requests
class _email_request{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "email_requests", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "email_requests");
	}
	function color_status(){
		if($this->vars["complete"]){
			$status = '<span style="color:#393">Completed</span>';
		}else{
			$status = '<span style="color:#FC3">Pending</span>';
		}
		return $status;
	}
}

// Tweets

class _tweet{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["user_id"] = get_tweet_user($this->vars["user_id"]);
	   
	}
    function update($specific = NULL){
	   tweets_db();
	   return update($this, "tweets", $specific);
	}
	function insert(){
	   tweets_db();
	   $this->vars["id"] = insert($this, "tweets");
	}
}

class _tweet_user{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   tweets_db();
	   return update($this, "users", $specific);
	}
	function insert(){
	   tweets_db();
	   $this->vars["id"] = insert($this, "users");
	}
	
    function getConnectionWithAccessToken() {
	  $cons_key = "Xk5Sju50DrJoYGYpYZaHw";
	  $cons_secret = "zSjKYbRma9DXmB2BsCai1eAoaZDHNE4b8ONghyso";
	  $oauth_token = "47371649-oPRieHGpa9aebFrop8LeQMrXlaazeh1Eq1g0UDI64";
	  $oauth_token_secret = "55BnfSxeyJ5ucOhdn4sZ1EKJZvP0GIAaR8yKCCKRNSo";
	  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
    return $connection;
    }
	
	function get_tweets_user($tweet_id = "", $first = false){
	  $connection = $this->getConnectionWithAccessToken();
	   if ($first) {
	    $param = "count=1";	   
	   }
	   else{
	    $param = "since_id=".$tweet_id."";	   
	   }
	  
	  $response = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$this->vars["user"]."&".$param."");
	
	  $tweets = json_encode($response);
	  $parsed_json = json_decode($tweets,true);
	  
	  $tweets_data = array();
	  $tweet = new _tweet();
	   
	  foreach ($parsed_json as $item ){
	    $tweet->vars["created_date"] = date("Y-m-d H:i:s",strtotime($item['created_at']));
	    $tweet->vars["tweet_id"] =  $item['id'];
	    $tweet->vars["tweet"] = clean_chars($item['text']);
	    $tweet->vars["added_date"] = date ("Y-m-d H:i:s");
	    $tweet->vars["twitter_user"] = $item['user']['id'];
	    $tweets_data[] = $tweet;
	  }
	  return $tweets_data;
	  
    }
}

class _tweet_keyword{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   tweets_db();
	   return update($this, "keywords", $specific);
	}
	function insert(){
	   tweets_db();
	   $this->vars["id"] = insert($this, "keywords");
	}
}

class _tweet_alert{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["tweet"] = get_tweet($this->vars["tweet"]);
		$this->vars["keyword"] = get_tweet_keyword($this->vars["keyword"]);
		}
    function update($specific = NULL){
	   tweets_db();
	   return update($this, "alerts", $specific);
	}
	function insert(){
	   tweets_db();
	   $this->vars["id"] = insert($this, "alerts");
	}
}
class _alert{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "alert");
	}
}

// Phone System
class _phone_record{
	var $vars = array();
	function initial(){}
}

//token
class _token{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   clerk_db();
	   return update($this, "user_token", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "user_token");
	}
	function delete($user){
	   clerk_db();
	   delete("user_token", $this->vars["id"], " user = '$user' ");
	}
}

//salary
class _salary{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   clerk_db();
	   return update($this, "clerk_salary", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "clerk_salary");
	}
}
class _late_result{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   clerk_db();
	   return update($this, "user_late_result", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "user_late_result");
	}
	function get_str(){
		$str = "";
		$by = get_clerk($this->vars["by"]);
		switch($this->vars["result"]){
			case "ap":
				$str = "Approved and Paid by " . $by->vars["name"];
			break;
			case "ad":
				$str = "Approved without being paid by " . $by->vars["name"];
			break;
			case "un":
				$str = "Unjustified by " . $by->vars["name"];
			break;
		}
		return $str;
	}
}


class _login_token{
	function generate(){
		session_start();
		$letters = array("A","B","C","D","E","F","G","H","I","J");
		$numbers = array("1","2","3","4","5");
		$code = array();
		
		$code[] = $letters[array_rand($letters)].$numbers[array_rand($numbers)];
		$code[] = $letters[array_rand($letters)].$numbers[array_rand($numbers)];
		$code[] = $letters[array_rand($letters)].$numbers[array_rand($numbers)];
			
		$_SESSION['token'] = $code;	
	}
	function clean(){
		session_start();
		$_SESSION['token'] = NULL;	
	}
	function check($user, $val1, $val2, $val3){
		
		session_start();
		$c1 = $_SESSION['token'][0];
		$c2 = $_SESSION['token'][1];
		$c3 = $_SESSION['token'][2];
		
		$this->clean();		
		return check_user_token($user, $a,$b,$c,$val1, $val2, $val3);
		
	}
	
	function check_test($user, $val1, $val2, $val3,$a,$b,$c){
		
		$this->clean();		
		return check_user_token($user, $a,$b,$c,$val1, $val2, $val3);
		//return true;
	}
		
	
}


//help calls

class _help_call{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "help_call_request", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "help_call_request");
	}
}

// Live Help Department
class _live_help_department{
	var $vars = array();
	function initial(){}
}


class _process_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   processing_db();
	   return update($this, "process_log", $specific);
	}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "process_log");
	}
	
	 function str_type(){
		if($this->vars["type"] == "de" ){$str = "Deposit";}
		else{$str = "Payout";}	
		return $str;
	}
}

class _buy_moneypaks_promo{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	    clerk_db();
	   return update($this, "buy_moneypaks_promo", $specific);
	}
	function insert(){
	    clerk_db();
	   $this->vars["id"] = insert($this, "buy_moneypaks_promo");
	}
}

class _player_ip{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "player_ip", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "player_ip");
	}
}

class _security_player_answers{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "security_player_answers", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "security_player_answers");
	}
}

class _promo_type{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "promotypes", $specific);
	}
	function insert(){
	   affiliate_db();
	   $this->vars["id"] = insert($this, "promotypes");
	}
	
   function get_size(){
	  $size = explode("_",$this->vars["name"]);
	  $value = str_replace(".gif","",$size[1]);
	  $value = str_replace(".GIF","",$value);
	  $value = str_replace(".jpg","",$value);
	  $value = str_replace(".JPG","",$value);
	  $value = str_replace(".png","",$value);
	  $value = str_replace(".PNG","",$value);
	  
   return $value;	
  }
  	function delete(){
	   affiliate_db();
	   delete("promotypes", $this->vars["id"]);
	}
	
}

class _affiliate_campaign{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		 $this->vars["id_sportsbook"] = get_affiliates_brand($this->vars["id_sportsbook"]);
		 $this->vars["category"] = get_campaigne_category_by_id($this->vars["category"]);
	}
	function update($specific = NULL){
	   affiliate_db();
	   return update($this, "campaignes", $specific);
	}
	function insert(){
	   affiliate_db();
	   $this->vars["id"] = insert($this, "campaignes");
	}
}


//contest
class _contest{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   inspinc_insider();
	   return update($this, "contest", $specific);
	}
	function insert(){
	   inspinc_insider();
	   $this->vars["id"] = insert($this, "contest");
	}
	
	function delete(){
	   inspinc_insider();
	   delete("contest", $this->vars["id"]);
	}
}
class _contest_question{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   inspinc_insider();
	   return update($this, "question", $specific);
	}
	function insert(){
	   inspinc_insider();
	   $this->vars["id"] = insert($this, "question");
	}
	function delete(){
	   inspinc_insider();
	   delete("question", $this->vars["id"]);
	}
}
class _contest_answer{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   inspinc_insider();
	   return update($this, "answer", $specific);
	}
	function insert(){
	   inspinc_insider();
	   $this->vars["id"] = insert($this, "answer");
	}
	
	function delete(){
	   inspinc_insider();
	   delete("answer", $this->vars["id"]);
	}
	
	
}
class _contest_answer_by_player{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   inspinc_insider();
	   return update($this, "answer_by_player", $specific);
	}
	function insert(){
	   inspinc_insider();
	   $this->vars["id"] = insert($this, "answer_by_player");
	}
}


//leagues order
class _league_order{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "leagues_order", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "leagues_order");
	}
}

//cashier log
class _cashier_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   processing_db();
	   $this->vars["id"] = insert($this, "cashier_log");
	}
}

//email web_sites
class _email_web_sites{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	    clerk_db();
	   $this->vars["id"] = insert($this, "email_websites");
	}
}

//Posting
class _posting{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_posting();
	   return update($this, "posting_data", $specific);
	}
	function insert(){
		sbo_posting();
		$this->vars["id"] = insert($this, "posting_data");
	}
	function delete(){
		sbo_posting();
		return delete("posting_data",$this->vars["id"] );
	}	
}

// Widget Manager

class _event_leagues_details{
     var $vars = array();
	 function __construct($pvars = array()){$this->vars = $pvars;}
	 function initial(){}
	 function update($specific = NULL){
	   sbolines_db();
	   return update($this, "events_leagues_details", $specific);
	}
	 function insert(){
	   sbolines_db();
	  $this->vars["id"] = insert($this, "events_leagues_details");
	}
	
}

class _event_leagues{
     var $vars = array();
	 function __construct($pvars = array()){$this->vars = $pvars;}
	 function initial(){}
	 function update($specific = NULL){
	  sbolines_db();
	   return update($this, "events_leagues", $specific);
	}
	
}

class _events_books{
     var $vars = array();
	 function __construct($pvars = array()){$this->vars = $pvars;}
	 function initial(){}
	 function update($specific = NULL){
	   sbolines_db();
	   return update($this, "events_books", $specific);
	}
	function print_status(){
		$status = "Disabled";
		if($this->vars["available"]){$status = "Active";}	
		return $status;
	}
}

class _event_sites{
     var $vars = array();
	 function __construct($pvars = array()){$this->vars = $pvars;}
	 function initial(){}
	 function insert(){
		sbolines_db();
		$this->vars["id"] = insert($this, "sites");
	}
	function delete(){
	   sbolines_db();
	   delete("sites", $this->vars["id"]);
	}
}

class _event_sites_details{
     var $vars = array();
	 function __construct($pvars = array()){$this->vars = $pvars;}
	 function initial(){}
	 function insert(){
		sbolines_db();
		$this->vars["id"] = insert($this, "sites_details");
	}
	 function update($specific = NULL){
	   sbolines_db();
	   return update($this, "sites_details", $specific);
	}
}


class _user_order_books{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	sbolines_db();
		return insert($this, "user_order_books");
	}
	
	function update($specific = NULL){
	sbolines_db();
    return update($this, "user_order_books", $specific);
    }


}



class _events_opener{
     var $vars = array();
	 function __construct($pvars = array()){$this->vars = $pvars;}
	 function initial(){}
	 function update($specific = NULL){
	   sbolines_db();
	   return update($this, "events_opener", $specific);
	}
	
}


class _events_leagues_line{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	  sbolines_db();
		return insert($this, "events_leagues_line");
      }
	
}

class _events_banners{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	sbolines_db();
		return insert($this, "events_banners");
	}
	
	function update($specific = NULL){
	sbolines_db();
    return update($this, "events_banners", $specific);
    }

   function delete(){
	   sbolines_db();
	   delete("events_banners", $this->vars["id"]);
	}
}

class _sites_target_books{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	sbolines_db();
		return insert($this, "sites_target_books");
	}
	
	function update($specific = NULL){
	sbolines_db();
    return update($this, "sites_target_books", $specific);
    }

   function delete(){
	   sbolines_db();
	   delete("sites_target_books", $this->vars["id"]);
	}
}

class _league{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_sports_db();
	   return update($this, "leagues", $specific);
	}
	
}

//braket
class _braket_player{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   sbo_breaket_db();
	   $this->vars["id"] = insert($this, "brakets_count");
	}	
	function update($specific = NULL){
	   sbo_breaket_db();
	   return update($this, "brakets_count", $specific);
	} 
	function delete(){
	   sbo_breaket_db();
	   delete("brakets_count", $this->vars["id"]);
	}
}

class _seo_entry{
	var $vars = array();
	//function _seo_entry($pvars = array()){$this->vars = $pvars;}
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "seo_system", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "seo_system");
	}
	function delete(){
		clerk_db();
		return delete("seo_system",$this->vars["id"] );
	}	
}
class _seo_list{
	var $vars = array();
	//function _seo_entry($pvars = array()){$this->vars = $pvars;}
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "seo_list", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "seo_list");
	}
}
class _seo_brand{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "seo_brand", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "seo_brand");
	}
}
class _hidden_agents_cashier{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}	
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "hidden_cashier");
	}
	function delete(){
	   sbo_book_db();
	   delete("hidden_cashier", $this->vars["id"]);
	}
}
class _seo_article{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "seo_article", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "seo_article");
	}
}
class _seo_ranking{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "seo_ranking", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "seo_ranking");
	}
}
class _seo_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "seo_website_log");
	}
	function str_action(){
		switch($this->vars["action"]){
			case "if":
				$str = "Info Filled";
			break;
			case "sa":
				$str = "Set Active";
			break;
			case "mo":
				$str = "Mark as Open";
			break;
			case "mi":
				$str = "Mark as Inactive";
			break;
			case "re":
				$str = "Released";
			break;
			case "va":
				$str = "Moved to Affiliates";
			break;
			case "vl":
				$str = "Moved to SEO Likes";
			break;
			case "vd":
				$str = "Moved to Betting Odds";
			break;
		}
		return $str;
	}
}
class _seo_website{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "seo_website", $specific);
	}
	function delete(){
	   clerk_db();
	   delete("seo_website", $this->vars["id"]);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert($this, "seo_website");
	}
	function str_type(){
		switch($this->vars["type"]){
			case "s":
				$str = "Sports";
			break;
			case "h":
				$str = "Horses";
			break;
			case "c":
				$str = "Casino";
			break;
			case "o":
				$str = "Other";
			break;
		}
		return $str;
	}
	function str_status(){
		switch($this->vars["status"]){
			case "u":
				$str = "Uploaded";
			break;
			case "r":
				$str = "Ready";
			break;
			case "a":
				$str = "Active";
			break;
			case "o":
				$str = "Open";
			break;
			case "i":
				$str = "Inactive";
			break;
			case "m":
				$str = "Moved";
			break;
		}
		return $str;
	}
}
class _seo_csv{
	function load($file, $list, $first = false, $save = false){
		$fp = fopen ($file, "r");
		$webs = array();
		$index = 0;
		while(($data = fgetcsv($fp, 2000, ",")) !== FALSE) {
			if(($first && $index >0) || !$first){
				$new = new _seo_website();
				$new->vars["website"] = clean_chars($data[0]);
				$new->vars["list"] = $list;
				if($save){$new->insert();}
				$webs[] = $new;
			}
			$index++;
		} 
		fclose ( $fp );
		return $webs;
	}
}



class _interest{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
		sbo_book_db();
		return insert($this, "interest");
	}	
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "interest", $specific);
	}
}


// Tweets Widget

class _wid_tweet{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["user_id"] = get_wid_tweet_user($this->vars["user_id"]);
	   
	}
    function update($specific = NULL){
	   inspinc_tweetdb1();
	   return update($this, "wid_tweets", $specific);
	}
	function insert(){
	   inspinc_tweetdb1();
	   $this->vars["id"] = insert($this, "wid_tweets");
	}
}

class _wid_tweet_user{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	  inspinc_tweetdb1();
	   return update($this, "wid_users", $specific);
	}
	function insert(){
	   inspinc_tweetdb1();
	   $this->vars["id"] = insert($this, "wid_users");
	}
	
    function getConnectionWithAccessToken() {
	  $cons_key = "Xk5Sju50DrJoYGYpYZaHw";
	  $cons_secret = "zSjKYbRma9DXmB2BsCai1eAoaZDHNE4b8ONghyso";
	  $oauth_token = "47371649-oPRieHGpa9aebFrop8LeQMrXlaazeh1Eq1g0UDI64";
	  $oauth_token_secret = "55BnfSxeyJ5ucOhdn4sZ1EKJZvP0GIAaR8yKCCKRNSo";
	  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
    return $connection;
    }
	
	function get_wid_tweets_user($tweet_id = "", $first = false){
	  $connection = $this->getConnectionWithAccessToken();
	   if ($first) {
	    $param = "count=1";	   
	   }
	   else{
	     $param = "since_id=".$tweet_id."&exclude_replies=1&count=2";	
		//$param = "count=10";	   
	   }
	  
	  $response = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$this->vars["user"]."&".$param."");
	
	  $tweets = json_encode($response);
	
	
	  $parsed_json = json_decode($tweets,true);
	  
	  $tweets_data = array();
	  $tweet = new _wid_tweet();
	   
	  foreach ($parsed_json as $item ){
	    $tweet->vars["created_date"] = date("Y-m-d H:i:s",strtotime($item['created_at']));
	    $tweet->vars["tweet_id"] =  $item['id'];
	    $tweet->vars["tweet"] = clean_chars($item['text']);
	    $tweet->vars["added_date"] = date ("Y-m-d H:i:s");
	    $tweet->vars["twitter_user"] = $item['user']['id'];
	    $tweets_data[] = $tweet;
	  }
	  return $tweets_data;
	  
    }
}

// New Feature Note


class _new_feature{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "new_feature", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "new_feature");
	}
	function delete(){
	   sbo_book_db();
	   delete("new_feature", $this->vars["id"]);
	}
	
	function print_status(){
		$status = "Disabled";
		if($this->vars["active"]){$status = "Active";}	
		return $status;
	}
	
	function print_type(){
		
		if($this->vars["type"] == 'a'){$type = "Agent";}	
		if($this->vars["type"] == 'p'){$type = "Player";}
		return $type;
	}
	
}

class _pph_ticker{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		 $this->vars["by"] = get_clerk($this->vars["by"]);
		}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "pph_ticker_message", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "pph_ticker_message");
	}
	function delete(){
	   sbo_book_db();
	   delete("pph_ticker_message", $this->vars["id"]);
	}
	
}

class _agent_messages{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "agents_messages", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "agents_messages");
	}
	function delete(){
	   sbo_book_db();
	   delete("agents_messages", $this->vars["id"]);
	}	
}


class _ticker_response{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "ticker_response");
	}
	function update($specific = NULL){
	    sbo_book_db();
	   return update($this, "ticker_response", $specific);
	}
}

class _ticker_message{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "ticker_message");
	}
	function update($specific = NULL){
	    sbo_book_db();
	   return update($this, "ticker_message", $specific);
	}
}

class _ticker_message_by_player{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	    sbo_book_db();
	   return update($this, "ticker_message_by_player", $specific);
	}
}

class _ticker_message_by_agent{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	    sbo_book_db();
	   return update($this, "ticker_message_by_agent", $specific);
	}
}

// Job Manager
// Espn Games

class _espn_games{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_sports_db();
	   return update($this, "espn_games", $specific);
	}
	
}

class _sbo_games{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_sports_db();
	   return update($this, "games", $specific);
	}
	
}

class _pph_sports{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	  tabs_db();
	   return update($this, "pph_sports", $specific);
	}
	function insert(){
	  tabs_db();
	   $this->vars["id"] = insert($this, "pph_sports");
	}
	function delete(){
	   tabs_db();
	   delete("pph_sports", $this->vars["id"]);
	}	
}



class _main_brands_sports{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	  tabs_db();
	   return update($this, "main_brands_sports", $specific);
	}
	function insert(){
	  tabs_db();
	   $this->vars["id"] = insert($this, "main_brands_sports");
	}
	function delete(){
	   tabs_db();
	   delete("main_brands_sports", $this->vars["id"]);
	}	
}

class _grade_check{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "grading_check", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "grading_check");
	}
}

class _pph_videos{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	  tabs_db();
	  return update($this, "pph_videos", $specific);
	}
	function insert(){
	  tabs_db();
	  $this->vars["id"] = insert($this, "pph_videos");
	}
	function delete(){
	   tabs_db();
	   delete("pph_videos", $this->vars["id"]);
	}	
}

// Manual Payments
class _manual_sites_payments{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   sbo_book_db();
	   return update($this, "manual_sites_payments", $specific);
	}
	function insert(){
	   sbo_book_db();
	   $this->vars["id"] = insert($this, "manual_sites_payments");
	}
}

//Nba File
// Baseball_File


class _nba_teams{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   nba_db();	
	   $this->vars["id"] = insert($this, "teams");
	}
	function update($specific = NULL){
	   nba_db();	
	   return update($this, "teams" , $specific);
	}
	 function delete(){
		nba_db();
		return delete("teams",$this->vars["id"] );
	  }	
}
class _nba_games{
	var $vars = array();
	function initial(){}
	function insert(){
	   nba_db();	
	   $this->vars["id"] = insert($this, "games");
	}
	function update($specific = NULL){
	   nba_db();	
	   return update($this, "games" , $specific);
	}
	 function delete(){
		nba_db();
		return delete("games",$this->vars["id"] );
	  }	
}

class _nba_teams_distance{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   nba_db();	
	   $this->vars["id"] = insert($this, "teams_distance");
	}
	function update($specific = NULL){
	   nba_db();	
	   return update($this, "teams_distance" , $specific);
	}
	 function delete(){
		nba_db();
		return delete("teams_distance",$this->vars["id"] );
	  }	
}


//MLB File
// Baseball_File


class _mlb_teams{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   mlb_db();	
	   $this->vars["id"] = insert($this, "teams");
	}
	function update($specific = NULL){
	   mlb_db();	
	   return update($this, "teams" , $specific);
	}
	 function delete(){
		mlb_db();
		return delete("teams",$this->vars["id"] );
	  }	
}
class _mlb_games{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   mlb_db();	
	   $this->vars["id"] = insert($this, "games");
	}
	function update($specific = NULL){
	   mlb_db();	
	   return update($this, "games" , $specific);
	}
	 function delete(){
		mlb_db();
		return delete("games",$this->vars["id"] );
	  }	
}

class _mlb_teams_distance{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   mlb_db();	
	   $this->vars["id"] = insert($this, "teams_distance");
	}
	function update($specific = NULL){
	   mlb_db();	
	   return update($this, "teams_distance" , $specific);
	}
	 function delete(){
		mlb_db();
		return delete("teams_distance",$this->vars["id"] );
	  }	
}





// nhl System

class _nhl_teams{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   nhl_db();	
	   $this->vars["id"] = insert($this, "teams");
	}
	function update($specific = NULL){
	   nhl_db();	
	   return update($this, "teams" , $specific);
	}
	 function delete(){
		nhl_db();
		return delete("teams",$this->vars["id"] );
	  }	
}
class _nhl_games{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   nhl_db();	
	   $this->vars["id"] = insert($this, "games");
	}
	function update($specific = NULL){
	   nhl_db();	
	   return update($this, "games" , $specific);
	}
	 function delete(){
		nhl_db();
		return delete("games",$this->vars["id"] );
	  }	
}

class _nhl_teams_distance{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   nhl_db();	
	   $this->vars["id"] = insert($this, "teams_distance");
	}
	function update($specific = NULL){
	   nhl_db();	
	   return update($this, "teams_distance" , $specific);
	}
	 function delete(){
		nhl_db();
		return delete("teams_distance",$this->vars["id"] );
	  }	
}

// NFL system

class _nfl_teams{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   nfl_db();	
	   $this->vars["id"] = insert($this, "teams");
	}
	function update($specific = NULL){
	   nfl_db();	
	   return update($this, "teams" , $specific);
	}
	 function delete(){
		nfl_db();
		return delete("teams",$this->vars["id"] );
	  }	
}


// Props System
class _props_players{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   props_db();	
	   $this->vars["id"] = insert($this, "players");
	}
	function update($specific = NULL){
	   props_db();	
	   return update($this, "players" , $specific);
	}
	
	 function delete(){
		props_db();
		return delete("players",$this->vars["id"] );
	  }	
}

class _game_log{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   props_db();	
	   $this->vars["id"] = insert($this, "game_log");
	}
	function update($specific = NULL){
	   props_db();	
	   return update($this, "game_log" , $specific);
	}
	 function delete(){
		props_db();
		return delete("game_log",$this->vars["id"] );
	  }	
}

class _game_players{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   props_db();	
	   $this->vars["id"] = insert($this, "game_players");
	}
	function update($specific = NULL){
	   props_db();	
	   return update($this, "game_players" , $specific);
	}
	 function delete(){
		props_db();
		return delete("game_players",$this->vars["id"] );
	  }	
}

class _alerts{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   props_db();	
	   $this->vars["id"] = insert($this, "alerts");
	}
	function update($specific = NULL){
	   props_db();	
	   return update($this, "alerts" , $specific);
	}
	 function delete(){
		props_db();
		return delete("alerts",$this->vars["id"] );
	  }	
}

class _review{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function insert(){
	   tickets_db();	
	   $this->vars["id"] = insert($this, "review");
	}
	function update($specific = NULL){
	   tickets_db();	
	   return update($this, "review" , $specific);
	}
}

// TELEGRAM
class _Bot{
	private $btoken;private $website;
	private $data;private $update;
	private $nombre;private $apellido;
	private $chatID;private $chatType;
	private $message;

	function __construct($data){

		switch ($data){
		 
          case "Grading":  
		  $this->btoken="6245470304:AAGDQlxmgVo6VF3W_BAW-ZjwiOTIZ3vyNCU";
		  break;

		  case "Blacklist":
		  $this->btoken="916312856:AAEXDaJMPVoGd8I87mW3GY_Zfzf4Oem8Rc0";
		  break;

		  default: 
		    $this->btoken="916312856:AAEXDaJMPVoGd8I87mW3GY_Zfzf4Oem8Rc0";
		    break;
 


	    }
		
		$this->website="https://api.telegram.org/bot".$this->btoken;
	}


//////////////////////////////////////////////////
//
//////////////////////////////////////////////////

public function explodeMensaje($msg){
	$dato=explode(" ", $msg);
	return $dato;
}


	public function checkUser($entrada){
		$mensaje=$this->fileGetContents($entrada);
		$dato=$this->explodeMensaje($mensaje["message"]);
		
		$correo=$dato[1];
		$comando=strtolower($dato[0]);

		return array("correo"=>$correo,"identificador"=>$mensaje["chatID"]);

		
	}

//////////////////////////////////////////////////
//
//////////////////////////////////////////////////

	public function envioMensaje($response,$fgc){
		$resultado=$this->fileGetContents($fgc);
		$params=['chat_id'=>$resultado["chatID"],'text'=>$response,];
		$ch = curl_init($this->website . '/sendMessage');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		return $result = curl_exec($ch);
		curl_close($ch);
	}
	
	
	public function envioMensajeProcesos($chatid,$response){

		$params=['chat_id'=>$chatid,'text'=>$response,];
		$ch = curl_init($this->website . '/sendMessage');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		return $result = curl_exec($ch);
		curl_close($ch);
	}

	
//////////////////////////////////////////////////
//
//////////////////////////////////////////////////

	public function fileGetContents($fgc){
		$var=file_get_contents($fgc);
		$var=json_decode($var, TRUE);

		$nombre=$var['message']['chat']['first_name'];
		$apellidos=$var['message']['chat']['last_name'];
		$chatID=$var['message']['chat']['id'];
		$chatType=$var['message']['chat']['type'];
		$message=$var['message']['text'];
		return array("chatID"=>$chatID,"chatType"=>$chatType,"message"=>$message);
	}
}

class telegram{
    var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
   // function telegram($pvars = array()){$this->vars = $pvars;}
	function initial(){}
	function update($specific = NULL){
	   clerk_db();
	   return update($this, "telegram", $specific);
	}
	function insert(){
	   clerk_db();
	   $this->vars["id"] = insert_test($this, "telegram");
	   return $this->vars["id"];
	}
	function delete(){
	   clerk_db();
	   delete("telegram", $this->vars["id"]);
	}
	
}

//Twitter Members

class _twitter_member{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	   inspinc_tweetdb1();
	   return update($this, "twitter_members", $specific);
	}
	function insert(){
	   inspinc_tweetdb1();
	   $this->vars["id"] = insert($this, "twitter_members");
	}
	function delete(){
	   inspinc_tweetdb1();
	   delete("twitter_members", $this->vars["id"]);
	}
}

// special

class _special_bill{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){
		$this->vars["account"] = get_pph_account($this->vars["account"]);
	}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "special_billing", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "special_billing");
	}
	function get_phone_total(){
		return $this->vars["phone_count"] * $this->vars["phone_price"];
	}
	function get_base_total(){
		if($this->vars["base_count"] > $this->vars["max_players"]){
			return 0;
		}else{
			return /*$this->vars["base_count"] **/ $this->vars["base_price"];
		}	
	}
	function get_internet_total(){
		return $this->vars["internet_count"] * $this->vars["internet_price"];
	}
	function get_liveplus_total(){
		return $this->vars["liveplus_count"] * $this->vars["liveplus_price"];
	}
	
	function get_horsesplus_total(){
		return $this->vars["horsesplus_count"] * $this->vars["horsesplus_price"];
	}
	function get_propsplus_total(){
		return $this->vars["propsplus_count"] * $this->vars["propsplus_price"];
	}
	
	function get_livecasino_total(){
		return $this->vars["livecasino_count"] * $this->vars["livecasino_price"];
	}
	
}


class _pph_account_test{
	function __construct($pvars = array()){$this->vars = $pvars;}
	var $vars = array();
	function initial(){}
	function update($specific = NULL){
	   accounting_db();
	   return update($this, "pph_account_test", $specific);
	}
	function insert(){
	   accounting_db();
	   $this->vars["id"] = insert($this, "pph_account_test");
	}
	function move_balance($amount){
		$this->vars["balance"] += $amount;
		$this->update(array("balance"));
	}
}


// Graded Time

class _graded_time_leagues{
	var $vars = array();
	function __construct($pvars = array()){$this->vars = $pvars;}
	function initial(){}
    function update($specific = NULL){
	    props_db();
	   return update($this, "graded_time_leagues", $specific);
	}
	function insert(){
	    props_db();
	   $this->vars["id"] = insert($this, "graded_time_leagues");
	}
	function delete(){
	    props_db();
	   delete("graded_time_leagues", $this->vars["id"]);
	}
}


?>