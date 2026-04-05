function prevalidate(validations){
	var good = true;
	if(validate(validations)){
		account = document.getElementById("account").value.replace(" ","");
		idf = document.getElementById("identifier").value.replace(" ","");
		if(!inArray(accounts,account)){
			alert("The Account Number doesn't Exist on the System");
			document.getElementById("account").focus();
			good = false;
		}
		else if(!inArray(identifiers,idf)){
			alert("The Identifier doesn't Exist on the System");
			document.getElementById("identifier").focus();
			good = false;	
		}
		
	}else{
		good = false;
	}
	return good;
}
function prevalidate_transaction(validations){
	var good = true;
	if(validate(validations)){
		faccount = document.getElementById("faccount").value.replace(" ","");
		taccount = document.getElementById("taccount").value.replace(" ","");
		if(faccount == "" && taccount == ""){
			alert("You need to insert at least 1 Account");
			good = false;
		}else if(!inArray(accounts,faccount) && faccount != ""){
			alert("The Account Number doesn't Exist on the System");
			document.getElementById("faccount").focus();
			good = false;
		}else if(!inArray(accounts,taccount) && taccount != ""){
			alert("The Account Number doesn't Exist on the System");
			document.getElementById("taccount").focus();
			good = false;
		}
		
	}else{
		good = false;
	}
	return good;
}
function prevalidate_commission(validations){
	var good = true;
	if(validate(validations)){
		account = document.getElementById("account").value.replace(" ","");
		caccount = document.getElementById("caccount").value.replace(" ","");
		if(!inArray(accounts,account)){
			alert("The Account Number doesn't Exist on the System");
			document.getElementById("account").focus();
			good = false;
		}else if(!inArray(accounts,caccount)){
			alert("The Account Number doesn't Exist on the System");
			document.getElementById("caccount").focus();
			good = false;
		}
		
	}else{
		good = false;
	}
	return good;
}
function make_upper(field){
	field.value = (field.value + '').toUpperCase();
}
function prevalidate_manual_bet(validations){
	var good = true;
	if(validate(validations)){
		account = document.getElementById("account").value.replace(" ","");
		idf = document.getElementById("identifier").value.replace(" ","");
		if(!inArray(accounts,account)){
			alert("The Account Number doesn't Exist on the System");
			document.getElementById("account").focus();
			good = false;
		}
		else if(!inArray(identifiers,idf)){
			alert("The Identifier doesn't Exist on the System");
			document.getElementById("identifier").focus();
			good = false;	
		}
		
	}else{
		good = false;
	}
	return good;
}
function focus_amount(){
	line = document.getElementById("line").value;
	if(contains(line,"-")){
		document.getElementById("win").focus();
		calc_amount('risk')
	}else if(contains(line,"+")){
		document.getElementById("risk").focus();
		calc_amount('win')
	}
}
function calc_amount(type){
	line = document.getElementById("line").value;
	if(type == "win"){
		if(contains(line,"-")){
			ra = document.getElementById("risk").value;
			line = line.replace("-","");
			win = ra / (line/100);
		}else if(contains(line,"+")){
			ra = document.getElementById("risk").value;
			line = line.replace("+","");
			win = ra * (line/100);
		}
		document.getElementById("win").value = Math.round((win));
	}else if(type == "risk"){
		if(contains(line,"-")){
			wa = document.getElementById("win").value;
			line = line.replace("-","");
			risk = wa * (line/100);
		}else if(contains(line,"+")){
			wa = document.getElementById("win").value;
			line = line.replace("+","");
			risk = wa / (line/100);
		}
		document.getElementById("risk").value = Math.round((risk));
	}
}
function delete_bet(bid){
   if(confirm("Are you sure you want to DELETE this Bet?")){
	   document.getElementById("del_frm_"+bid).submit();
   }
}
function show_hide(did, type){
	if(type === undefined){type = 'block'}
	var div = document.getElementById(did);
	var cstatus = div.style.display;
	if(cstatus == "none"){
		div.style.display = type;
	}else{
		div.style.display = "none";
	}
}
function switch_max_amounts(){
	show_hide("basic_max", "table");
	show_hide("detail_max", "table");
	btn = document.getElementById("max_btn");
	if(btn.innerHTML == "+ Detailed"){
		btn.innerHTML = "- Basic";
		document.getElementById("detailed_max").value = "1";
	}else{
		btn.innerHTML = "+ Detailed";
		document.getElementById("detailed_max").value = "0";
	}
}

function change_period_drop(){
	var sport = document.getElementById("sport").value;
	if(sport == "NFL" || sport == "NCAAF" || sport == "NBA"){
		dd ='<select name="period" id="period" class="ab_input">';
        dd +='    <option value="GAME">Game</option>';
        dd +='    <option value="1H">1st Half</option>';
        dd +='    <option value="2H">2nd Half</option>';
        dd +='    <option value="1Q">1st Quarter</option>';
        dd +='    <option value="2Q">2nd Quarter</option>';
        dd +='    <option value="3Q">3rd Quarter</option>';
        dd +='    <option value="4Q">4th Quarter</option>';
        dd +='  </select>';
	}else if(sport == "NCAAB"){
		dd ='<select name="period" id="period" class="ab_input">';
        dd +='    <option value="GAME">Game</option>';
        dd +='    <option value="1H">1st Half</option>';
        dd +='    <option value="2H">2nd Half</option>';
        dd +='  </select>';
	}else if(sport == "MLB"){
		dd ='<select name="period" id="period" class="ab_input">';
        dd +='    <option value="GAME">Game</option>';
		dd +='    <option value="1H">1st Half</option>';
        dd +='    <option value="2H">2nd Half</option>';
        dd +='  </select>';
	}else if(sport == "NHL"){
		dd ='<select name="period" id="period" class="ab_input">';
        dd +='    <option value="GAME">Game</option>';
		dd +='    <option value="1P">1st Period</option>';
        dd +='    <option value="2P">2nd Period</option>';
        dd +='    <option value="3P">3rd Period</option>';
        dd +='  </select>';
	}
	document.getElementById("periods_box").innerHTML = dd;
}