<?
require_once('C:/websites/jobs.inspin.com/includes/classes.php');
class contest {
	var $id;
	var $name;
	var $league;
	var $open_date;
	var $close_date;
	var $check;
	var $visible;
	var $points;
	var $questions;
	function contest($pid, $pname, $pleague, $popen_date, $pclose_date, $pcheck, $pvisible, $ppoints, $pquestions = array()) {
       $this->id = $pid;
	   $this->name = $pname;
	   $this->league = $pleague;
	   $this->open_date = $popen_date;
	   $this->close_date = $pclose_date;
	   $this->check = $pcheck;
	   $this->visible = $pvisible;
	   $this->points = $ppoints;
	   $this->questions = $pquestions;
   }
}
class question {
	var $id;
	var $text;
	var $answers;
	function question($pid, $ptext, $panswers) {
       $this->id = $pid;
	   $this->text = $ptext;
	   $this->answers = $panswers;
   }
}
class answer {
	var $id;
	var $text;
	var $is_correct;
	function answer($pid, $ptext, $pis_correct) {
       $this->id = $pid;
	   $this->text = $ptext;
	   $this->is_correct = $pis_correct;
   }
}
?>