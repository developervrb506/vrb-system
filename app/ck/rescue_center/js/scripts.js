function add_remove_records(id){
	var container = document.getElementById("delete_records_form");
	var input = document.createElement("input");
		
	if(document.getElementById('record_'+id).checked){		
        input.type  = "checkbox";
        input.name  = 'record['+id+']';
		input.id    = 'record['+id+']';
	    input.value = id;
		input.style.display = "none";
		input.checked = true;        			
        container.insertBefore(input, document.getElementById('delete_records'));		
	}else{
		var record = document.getElementById('record['+id+']');
            record.parentNode.removeChild(record);
	}
}

function update_as_paid_records(id,page){
	var container = document.getElementById("update_as_paid_records_form");
	var input = document.createElement("input");
		
	if(document.getElementById('record_'+id+'_'+page).checked){		
        input.type  = "checkbox";
        input.name  = 'record['+id+'_'+page+']';
		input.id    = 'record['+id+'_'+page+']';
	    input.value = id+'_'+page;
		input.style.display = "none";
		input.checked = true;        			
        container.insertBefore(input, document.getElementById('update_as_paid_records'));		
	}else{
		var record = document.getElementById('record['+id+'_'+page+']');
            record.parentNode.removeChild(record);
	}
}

function f_check_all_checkboxes(){
	
	var inputs = document.getElementsByClassName("checks_unpaid");
	
	for (var i = 0; i < inputs.length; i++) {
		
		if (inputs[i].type == "checkbox") {  //Check only the checked checkboxes	   		   
		  			 
			myarr = inputs[i].name.split("_");
			id   = myarr[1];
			page = myarr[2];		
			
			if (document.getElementById('record_'+id+'_'+page).checked == false){
				document.getElementById('record_'+id+'_'+page).checked = true;			   
			    update_as_paid_records(id,page);
			}			
		
		}
	}
}

function f_uncheck_all_checkboxes(){
	
	var inputs = document.getElementsByClassName("checks_unpaid");
	
	for (var i = 0; i < inputs.length; i++) {
		
		if (inputs[i].type == "checkbox") {  //Check only the checked checkboxes	   		   
		  			 
			myarr = inputs[i].name.split("_");
			id   = myarr[1];
			page = myarr[2];		
			
			if (document.getElementById('record_'+id+'_'+page).checked == true){
				document.getElementById('record_'+id+'_'+page).checked = false;			   
			    update_as_paid_records(id,page);
			}			
		
		}
	}
}

function send_emails_manual_contacts(id){
	var container = document.getElementById("send_emails_form");
	var input = document.createElement("input");
		
	if(document.getElementById('send_record_'+id).checked){		
        input.type  = "checkbox";
        input.name  = 'send_record['+id+']';
		input.id    = 'send_record['+id+']';
	    input.value = id;
		input.style.display = "none";
		input.checked = true;        			
        container.insertBefore(input, document.getElementById('send_emails_records'));		
	}else{
		var record = document.getElementById('send_record['+id+']');
            record.parentNode.removeChild(record);
	}
}