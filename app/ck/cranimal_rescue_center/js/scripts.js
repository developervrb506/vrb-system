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