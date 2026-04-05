<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
 require_once(ROOT_PATH . '/ck/affiliates/contests/functions.php'); 
if($current_clerk->im_allow("affiliates_system")){

 if (isset($_POST["grade"])){ $_GET["action"] = "graded"; }
 
 $action = $_GET["action"];
 
 if (!isset($_GET["action"])) { $action = "add_edit"; }
 
 
   switch ($action) {
	
	case "graded" :
		 
		  $contest_id = $_POST["contest_id"];
		  $questions = get_questions($contest_id);
	     
		foreach($questions as $question){
		  clean_correct($question->vars["id"]);
		  $ans_id = $_POST["radio_" . $question->vars["id"]];
		  if($ans_id != ""){
			
			$answer = get_answer($ans_id); 
			
			if (!is_null($answer)){
			
			  $answer->vars["is_correct"]	= 1;
			
			  $answer->update(array("is_correct"));
			 }
			
			
		   }
		 }
         break;
	   
   case "cancel" :
	  
	 $contest_id = $_GET["id"];
	 $contest = get_contest_by_id($contest_id);
      if (!is_null($contest)) {
		 $contest->vars["is_checked"] = 3;
		 $contest->vars["visible"] = 1;
		 $contest->update(array("is_checked","visible"));
	  }
	  $msg = "Contest Canceled";
    break;
	
	case "delete":
		
	 $contest_id = $_GET["id"];
	 $contest = get_contest_by_id($contest_id);
      if (!is_null($contest)) {
        $questions = get_questions($contest_id);
		 foreach($questions as $question){
	          
			  $answers = get_answers($question->vars["id"]); 
			   foreach($answers as $answer){
		          delete_player_answer($answer->vars["id"]);
		          delete_customer_answer($answer->vars["id"]);
				  $answer->delete();
	           }
	           $question->delete();
         }
         $contest->delete();
		
	  }
		$msg = "Contest Deleted";
  break;
	
  case "add_edit":
	     
			
			
			if ($_POST["start_hour"] == ""){ $start_hour = 00;} else { $start_hour = $_POST["start_hour"]; }
			if ($_POST["start_minute"] == ""){ $start_minute = 00;}else { $start_minute = $_POST["start_minute"]; }
			if ($_POST["end_hour"] == ""){ $end_hour = 00;} else { $end_hour = $_POST["end_hour"]; }
			if ($_POST["end_minute"] == ""){ $end_minute = 00;}	 else { $end_minute = $_POST["end_minute"]; }				
			
			
			
			$name = $_POST["name"];
			$start_date = $_POST["start_date"]." ".$start_hour.":".$start_minute.":00";
			$end_date = $_POST["end_date"]." ".$end_hour.":".$end_minute.":00";
			$points = $_POST["points"];
			$visible = $_POST["visible"];
			$league = $_POST["league_list"];
			
			$deleted_answers = $_POST["deleted_answers"];
			$arr_d_a = explode("-",$deleted_answers);
			 foreach($arr_d_a as $id_ans_del){
			   
			   $delete_answer = get_answer($id_ans_del);
			   if (!is_null($delete_answer)){ 
			     delete_player_answer($delete_answer->vars["id"]);
				 delete_customer_answer($delete_answer->vars["id"]);
				 $delete_answer->delete();
				 }	 
			 }
			$deleted_questions = $_POST["deleted_questions"];
			$arr_d_q = explode("-",$deleted_questions);
			foreach($arr_d_q as $id_que_del){
			 $delete_question = get_question($id_que_del);
			   if (!is_null($delete_question)){
				   $answers = get_answers($delete_question->vars["id"]); 
			       foreach($answers as $answer){
		              delete_player_answer($answer->vars["id"]);
					  delete_customer_answer($answer->vars["id"]);
				      $answer->delete();
	               }
				    $delete_question->delete();
				 }	
			}
			
			if(isset($_POST["action"])){$edit = true;}else{$edit = false;}
			
			if($edit){
				 $contest = get_contest_by_id($_POST["cont_id"]);
				 $contest->vars["name"] = $_POST["name"];
				 $contest->vars["league"] = $_POST["league_list"];
				 $contest->vars["open_date"] = $_POST["start_date"]." ".$start_hour.":".$start_minute.":00";
				 $contest->vars["close_date"] = $_POST["end_date"]." ".$end_hour.":".$end_minute.":00";	
				 $contest->vars["is_checked"] = 0;
				 $contest->vars["visible"] = $_POST["visible"];
				 $contest->vars["points"] = $_POST["points"];	
				 $contest->update();
				 $contest_id = $contest->vars["id"];
				
			}else{
				
				$contest = new _contest();
				$contest->vars["name"] = $_POST["name"];
				$contest->vars["league"] = $_POST["league_list"];
				$contest->vars["open_date"] = $_POST["start_date"]." ".$start_hour.":".$start_minute.":00";
				$contest->vars["close_date"] = $_POST["end_date"]." ".$end_hour.":".$end_minute.":00";		
				$contest->vars["is_checked"] = 0;
				$contest->vars["visible"] = $_POST["visible"];
				$contest->vars["points"] = $_POST["points"];	
				$contest->insert();
				
				$contest_id = $contest->vars["id"];
			
			}
			
			$question_count = $_POST["questions_count"];
			
			for($i=0;$i<$question_count;$i++){
				$answer_count = $_POST["answer_count" . ($i + 1)];
				if(isset($answer_count)){
					$question_text = $_POST["question" . ($i + 1)];
					if($edit){
						
						$question =  get_question($_POST["question_id" . ($i + 1)]);
						if (!is_null($question)){
						$question->vars["text"] = $question_text;
						$question->update(array("text"));
						$id_question = $question->vars["id"];	
						}
						else {
							if ($question_text != ""){	
							$question = new _contest_question();
							$question->vars["text"] = $question_text;
							$question->vars["id_contest"] =	$contest_id;	
							$question->insert();
							$id_question = $question->vars["id"];
						  }
						
						}
						
					}else{
						
					 if ($question_text != ""){	
						$question = new _contest_question();
						$question->vars["text"] = $question_text;
						$question->vars["id_contest"] =	$contest_id;	
						$question->insert();
						$id_question = $question->vars["id"];
					
						
					 }
					}
					for($e=0;$e<$answer_count;$e++){
						$answer_text = $_POST["answer" . ($e + 1) . "_" . ($i + 1)];
						if(isset($answer_text)){
							if($edit){
								
								$answer =  get_answer($_POST["answer_id" . ($e + 1) . "_" . ($i + 1)]);
								if (!is_null($answer)){
									$answer->vars["text"] = $answer_text;
									$answer->update(array("text"));	
								 }
								 else {
									if ($answer_text != ""){	
									$answer = new _contest_answer();
									$answer->vars["text"] = $answer_text;
									$answer->vars["id_question"] = 	$id_question;				
									$answer->vars["is_correct"] = 0;					
									$answer->insert();
									}
						
								 }
							
							}else{
								
								if ($answer_text != ""){
									$answer = new _contest_answer();
									$answer->vars["text"] = $answer_text;
									$answer->vars["id_question"] = 	$id_question;				
									$answer->vars["is_correct"] = 0;					
									$answer->insert();
								}
								
							}				
						}
					}
				}	
			}
			
			if($edit){ $msg = "Contest Edited" ;} else { $msg = "Contest Added"; }

	break;
	
   }
  	

header("Location: http://localhost:8080/ck/affiliates/contest.php?message=".$msg);
	
?>
<? } else { echo "ACCESS DENIED"; }?>