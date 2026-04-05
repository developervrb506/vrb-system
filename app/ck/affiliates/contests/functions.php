<?
require_once(ROOT_PATH . '/ck/process/functions.php');
require_once(ROOT_PATH . '/ck/db/manager.php');


function get_all_contests(){
	inspinc_insider();
	$sql = "SELECT * FROM contest ORDER BY id DESC";
	return get($sql,"_contest");
}
function get_all_contests_graded($graded){
	
	inspinc_insider();
	$sql = "SELECT * FROM contest WHERE is_checked = $graded ORDER BY id DESC";
	return get($sql,"_contest");
}


function get_all_contests_by_league($league){
	inspinc_insider();
	$sql = "SELECT * FROM contest WHERE league = '$league' AND visible = 1 ORDER BY id DESC";
	return get($sql,"_contest");
}

function get_contest_by_id($id_contest){
	inspinc_insider();
	$sql = "SELECT * FROM contest WHERE id = $id_contest";
	return get($sql,"_contest",true);
}

function get_questions($contest_id){
	inspinc_insider();
	$sql = "SELECT * FROM question WHERE id_contest = $contest_id ORDER BY id ASC";
	
	return get($sql,"_contest_question");
	
}
function get_answers($question_id){
	inspinc_insider();
	$sql = "SELECT * FROM answer WHERE id_question = $question_id ORDER BY id ASC";
	return get($sql, "_contest_answer");
}

function get_question($id){
	inspinc_insider();
	$sql = "SELECT * FROM question WHERE id = ".$id."";
	return get($sql,"_contest_question",true);
}
function get_answer($id){
	inspinc_insider();
	$sql = "SELECT * FROM answer WHERE id = ".$id."";
	echo $sql;
	return get($sql, "_contest_answer",true);
}


function delete_player_answer($answer_id){
	inspinc_insider();
	$sql = "DELETE FROM answer_by_player  WHERE answer = " . $answer_id . "";
	 return execute($sql);
}

function delete_customer_answer($answer_id){
	inspinc_insider();
	$sql = "DELETE FROM answer_by_customer  WHERE id_answer = " . $answer_id . "";
	 return execute($sql);
}

function clean_correct($question_id){
	if($id == ""){$id = 0;}
	inspinc_insider();
	$sql = "UPDATE answer  SET is_correct = '0' WHERE id_question = " . $question_id . "";
    return execute($sql);
}

function get_contest_entries($id_cont){
	inspinc_insider();
	$sql = "SELECT COUNT(distinct abc.id_customer) as number FROM answer as ans, question as que, answer_by_customer as abc 
	WHERE abc.id_answer = ans.id AND ans.id_question = que.id AND que.id_contest = '$id_cont'";
	$total = get_str($sql,true);
	return $total["number"];
}

function is_answer_correct($id){
	if($id == ""){$id = 0;}
	$sql = "SELECT text FROM answer WHERE id = $id and is_correct = 1";
	$answer = get($sql,"_contest_answer",true);
	
	if(!is_null($answer)) {
		$correct = true;
	}else{
		$correct = false;
	}
	return $correct;
}

function is_on_air($start, $end, $diff = 0){
	$current_date = date("Y-m-d H:i",time()-$diff);
	$on_time = false;
	if($start < $current_date && $current_date < $end){$on_time = true;}
	return $on_time;
}
/*
function answer_correct($id){
	if($id == ""){$id = 0;}
	$update = "UPDATE answer 
				  SET is_correct = '1' WHERE id = " . $id . "";
	 $res = mysql_query($update)
				  or die(mysql_error());
}

*/

/*
function answer_custmer($id_ans, $id_cus){
	$insert = "INSERT INTO answer_by_customer (id_customer, id_answer)
						VALUES ($id_cus,$id_ans)";
	$res = mysql_query($insert)
	             or die(mysql_error());
}

function is_answer_select_by_customer($id_ans, $id_cus){
	if($id_ans == ""){$id_ans = 0;}
	$selections_sql = "SELECT * FROM answer_by_customer WHERE id_answer = $id_ans and id_customer = $id_cus";
	$selections_sql_res = mysql_query($selections_sql);
	if($selections_info = mysql_fetch_array($selections_sql_res)) {
		$correct = true;
	}else{
		$correct = false;
	}
	return $correct;
}
function correct_by_customer($id_cont, $id_cus){
	$correct = 0;
	$selections_sql = "SELECT COUNT(distinct ans.id) as correct FROM answer as ans, question as que, answer_by_customer as abc 
	WHERE abc.id_customer = '$id_cus' AND abc.id_answer = ans.id AND ans.is_correct = 1 AND ans.id_question = que.id AND que.id_contest = '$id_cont'";
	$selections_sql_res = mysql_query($selections_sql);
	if($selections_info = mysql_fetch_array($selections_sql_res)) {
		$correct = $selections_info['correct'];
	}
	return $correct;
}
*/

/*
function get_customers_by_contest($cont_id){
	inspinc_insider();
	$customers = array();
	$selections_sql = "SELECT distinct abc.id_customer as id_cus FROM answer as ans, question as que, answer_by_customer as abc 
	WHERE que.id_contest = '$cont_id' AND que.id = ans.id_question AND ans.id = abc.id_answer";
	$selections_sql_res = mysql_query($selections_sql);
	while($selections_info = mysql_fetch_array($selections_sql_res)) {
		$id_cus = $selections_info['id_cus'];
		$customers[] = get_customer($id_cus);
	}
	return $customers;
}
function is_fill($id_cont, $id_cus){
	if($id_cont == ""){$id_cont = 0;}
	$selections_sql = "SELECT que.text FROM answer as ans, question as que, answer_by_customer as abc 
	WHERE abc.id_customer = $id_cus AND abc.id_answer = ans.id AND ans.id_question = que.id AND que.id_contest = $id_cont";
	$selections_sql_res = mysql_query($selections_sql);
	if($selections_info = mysql_fetch_array($selections_sql_res)) {
		$correct = true;
	}else{
		$correct = false;
	}
	return $correct;
}
function is_answer_select_by_customer_vrb($id_ans, $id_cus){
	inspinc_partners();
	if($id_ans == ""){$id_ans = 0;}
	$selections_sql = "SELECT * FROM contest_by_affiliate WHERE id_answer = $id_ans and affiliate_code  = '$id_cus'";
	$selections_sql_res = mysql_query($selections_sql);
	if($selections_info = mysql_fetch_array($selections_sql_res)) {
		$correct = true;
	}else{
		$correct = false;
	}
	return $correct;
}
function correct_by_customer_vrb($id_cont, $aff){
	$correct = 0;
	inspinc_partners();
	$selections_sql = "SELECT id_answer FROM contest_by_affiliate WHERE affiliate_code = '$aff'";
	$selections_sql_res = mysql_query($selections_sql);
	while($selections_info = mysql_fetch_array($selections_sql_res)) {
		$id_ans = $selections_info['id_answer'];
		inspinc_insider();
		$selections_sql2 = "SELECT que.text FROM answer as ans, question as que
			WHERE ans.id = $id_ans AND ans.is_correct = 1 AND ans.id_question = que.id AND que.id_contest = $id_cont";
		$selections_sql_res2 = mysql_query($selections_sql2);
		if($selections_info2 = mysql_fetch_array($selections_sql_res2)) {
			$correct ++;
		}
	}
	return $correct;
}
function get_customers_by_contest_vrb($id_cont){
	$affiliates = array();	
	inspinc_insider();
	$selections_sql2 = "SELECT ans.id as ans_id FROM answer as ans, question as que
		WHERE ans.id_question = que.id AND que.id_contest = $id_cont";
	$selections_sql_res2 = mysql_query($selections_sql2);
	while($selections_info2 = mysql_fetch_array($selections_sql_res2)) {
		$id_ans = $selections_info2['ans_id'];
		inspinc_partners();
		$selections_sql = "SELECT affiliate_code FROM contest_by_affiliate WHERE id_answer = $id_ans";
		$selections_sql_res = mysql_query($selections_sql);
		while($selections_info = mysql_fetch_array($selections_sql_res)) {
			$aff = $selections_info['affiliate_code'];
			if(!in_array($aff,$affiliates)){$affiliates[] = $aff;}
		}
	}
	return $affiliates;
}
function is_fill_vrb($id_cont, $id_cus){
	inspinc_partners();
	$correct = false;
	$selections_sql = "SELECT id_answer FROM contest_by_affiliate WHERE affiliate_code = '$id_cus'";
	$selections_sql_res = mysql_query($selections_sql);
	while($selections_info = mysql_fetch_array($selections_sql_res)) {
		$id_ans = $selections_info['id_answer'];
		inspinc_insider();
		$selections_sql2 = "SELECT que.text FROM answer as ans, question as que
			WHERE ans.id = $id_ans AND ans.id_question = que.id AND que.id_contest = $id_cont";
		$selections_sql_res2 = mysql_query($selections_sql2);
			if(!$correct){
				if($selections_info2 = mysql_fetch_array($selections_sql_res2)) {
					$correct = true;
				}else{
					$correct = false;
				}
			}
	}
	return $correct;
}
function answer_custmer_vrb($id_ans, $id_cus){
	inspinc_partners();
	$insert = "INSERT INTO contest_by_affiliate (affiliate_code , id_answer)
						VALUES ('$id_cus',$id_ans)";
	$res = mysql_query($insert)
	             or die(mysql_error());
}
*/


/*
function set_as_graded($contest_id){
	if($contest_id == ""){$contest_id = 0;}
	$update = "UPDATE contest  SET is_checked = '1' WHERE id = " . $contest_id . "";
	 $res = mysql_query($update)
				  or die(mysql_error());
}
function delete_contest($contest_id){
	$update = "DELETE FROM contest  WHERE id = " . $contest_id . "";
	 $res = mysql_query($update)
				  or die(mysql_error());
}

*/

/*
function cancel_contest($contest_id){
	if($contest_id == ""){$contest_id = 0;}
	$update = "UPDATE contest  SET is_checked = 3, visible = 0 WHERE id = " . $contest_id . "";
	 $res = mysql_query($update)
				  or die(mysql_error());
}*/
?>