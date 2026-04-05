var questions_display = 5;
var answer_display = 5;
function add_answer(question_num, set_focus){
	answer_count =  parseInt(document.getElementById("answer_count" + question_num).value) + 1;	
	
	new_answer_div = document.createElement("div");
	new_answer_div.id = 'answer_div_'+ answer_count +'_'+ question_num;
	new_answer_div.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Answer: <input name="answer'+ answer_count +'_'+ question_num +'" type="text" id="answer'+ answer_count +'_'+ question_num +'" size="100"> <a href="javascript:;" onClick="remove_answer('+ question_num +','+ answer_count +')">-Remove Answer</a><br><br></div>';
	document.getElementById("question_div_" + question_num).appendChild(new_answer_div);
	
	if(set_focus){document.getElementById('answer'+ answer_count +'_'+ question_num).focus();}
	
	document.getElementById("answer_count" + question_num).value = answer_count;
}
function remove_answer(question_num, answer_num, id){
	var parent = document.getElementById("question_div_" + question_num);
	var child = document.getElementById("answer_div_" + answer_num + "_" + question_num);
	parent.removeChild(child);
	if(id != "" && document.getElementById("deleted_answers") != null){document.getElementById("deleted_answers").value += "-" + id;}
}
function remove_question(question_number, id){
	var parent = document.getElementById("questions_div");
	var child = document.getElementById("question_div_" + question_number);
	parent.removeChild(child);
	if(id != "" && document.getElementById("deleted_questions") != null){document.getElementById("deleted_questions").value += "-" + id;}
}
function add_question(make_scroll){
	questions_count = parseInt(document.getElementById("questions_count").value) + 1;
	
	new_question_div = document.createElement("div");
	new_question_div.id = 'question_div_'+ questions_count;
	
	question = '<br><hr /><br><strong>Question:</strong> <a href="javascript:;" onClick="remove_question('+ questions_count +')">-Remove Question</a>';
	question += '<input name="answer_count'+ questions_count +'" type="hidden" id="answer_count'+ questions_count +'" size="5" value="0"><br><br>';
	question += 'Text: <input name="question'+ questions_count +'" type="text" id="question'+ questions_count +'" size="100"><br><br>';
	question += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:;"  onClick="add_answer('+ questions_count +', true)">+Add Answer</a><br><br>';
	
	new_question_div.innerHTML = question;
	
	
	document.getElementById("questions_div").appendChild(new_question_div);
	
	for(var i=0; i < answer_display; i++) {
		add_answer(questions_count, false);
	}		
	document.getElementById("questions_count").value = questions_count;
	if(make_scroll){
		document.getElementById("question_div_" + questions_count).scrollIntoView(true);
		document.getElementById('question'+ questions_count).focus();
	}
	
}
function validate_form(){
	var correct = true;
	
	if(document.getElementById("questions_count").value <= 0){
		correct = false;
		alert("You Need to add Questions to the contest");
	}else if(document.getElementById("name").value == ""){
		correct = false;
		alert("You Need to write a name");
	}else if(document.getElementById("start_date").value == ""){
		correct = false;
		alert("You Need to select a start date");
	}else if(document.getElementById("end_date").value == ""){
		correct = false;
		alert("You Need to select a end date");
	}else if(document.getElementById("points").value == ""){
		correct = false;
		alert("You Need to write points");
	}else if(document.getElementById("start_hour").value == ""){
		correct = false;
		alert("You Need to write a Hour");
	}else if(document.getElementById("start_minute").value == ""){
		correct = false;
		alert("You Need to write  Minutes");
	}else if(document.getElementById("end_hour").value == ""){
		correct = false;
		alert("You Need to write a Hour");
	}else if(document.getElementById("end_minute").value == ""){
		correct = false;
		alert("You Need to write  Minutes");
	}
	return correct;
}
//change the selected value from a drop down list
function change_dropdown(ddlID, value, change){
	var ddl = document.getElementById(ddlID);
	for (var i = 0; i < ddl.options.length; i++) {
		if (ddl.options[i].value == value) {
			if (ddl.selectedIndex != i) {
				ddl.selectedIndex = i;
				if (change){ddl.onchange();}
			}
		   break;
	   }
   }
}