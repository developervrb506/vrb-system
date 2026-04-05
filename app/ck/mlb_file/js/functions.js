
function showtooltip(element_id , message )  
{  
    var elem = document.getElementById(element_id) ;  
    elem.title = message ;  
     
} 

function unckeck_all(id,cant){

for(var i =1; i<=cant; i++){
		var check_box = document.getElementById(id+i);
		if(check_box != null){
			check_box.checked = false;
		}
		//else{alert("stadium_"+i); }
	}	
 document.getElementById("check").style.display = "block";
 document.getElementById("uncheck").style.display = "none";  
}

function ckeck_all(id,cant){
	
for(var i =1; i<=cant; i++){
		var check_box = document.getElementById(id+i);
		 if(check_box != null){
			check_box.checked = true;
		}
		//else{alert("stadium_"+i); }
	}	
 document.getElementById("check").style.display = "none";
 document.getElementById("uncheck").style.display = "block";  
}

 function show_hide_table_column(table,id, do_show,columns) {
  var stl;
  var new_width;
    
	if 	(do_show) {
	  stl = ''  
	}
    else {
		 stl = 'none' ;
	}
	
	var tbl = document.getElementsByName(id);
	for (x=0;x<tbl.length;x++){
    	tbl[x].style.display=stl;
	}

  }
  
