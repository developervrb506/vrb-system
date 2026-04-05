function change_roof_status(id, opened){
	// if  the rooft  is Closed
	if (opened == "0"){
	
		var style2 = contains(document.getElementById('t'+id).className,2);
		if (style2){ color = "table_td2_gray"; }
		else { color = "table_td1_gray"; }
		
		document.getElementById('t'+id).className = color;
		document.getElementById('i'+id).className = color;
		document.getElementById('h'+id).className = color;
		document.getElementById('ws'+id).className = color;
		document.getElementById('wd'+id).className = color;
		document.getElementById('wp'+id).className = color;
		document.getElementById('wg'+id).className = color;
		document.getElementById('ai'+id).className = color;
		document.getElementById('dw'+id).className = color;
		document.getElementById('pk'+id).className = color;
		document.getElementById('air_d'+id).className = color;
		document.getElementById('wat_v'+id).className = color;
		document.getElementById('air_m'+id).className = color;
	}else {	
		color = document.getElementById('r'+id).align;
		document.getElementById('t'+id).className = color;
		document.getElementById('i'+id).className = color;
		document.getElementById('h'+id).className = color;
		document.getElementById('ws'+id).className = color;
		document.getElementById('wd'+id).className = color;
		document.getElementById('wp'+id).className = color;
		document.getElementById('wg'+id).className = color;
		document.getElementById('ai'+id).className = color;
		document.getElementById('dw'+id).className = color;
		document.getElementById('pk'+id).className = color;
		document.getElementById('air_d'+id).className = color;
    	document.getElementById('wat_v'+id).className = color;
		document.getElementById('air_m'+id).className = color;
	}
	document.getElementById("changer").src = "process/actions/change_roof_action.php?gid="+id+"&status="+opened;
}



function change_manual_umpire(idgame, idumpire){
	location.href = "process/actions/manual_umpire_action.php?gid="+idgame+"&umpire="+idumpire;
}


function change_manual_pitcher(idgame, idpitcher,state){

	location.href = "process/actions/manual_pitcher_action.php?gid="+idgame+"&pitcher="+idpitcher+"&state="+state;

}



function change_wind_position(idgame, idposition){
	location.href = "process/actions/manual_wind_position_action.php?gid="+idgame+"&position="+idposition;
}


function change_hrw(idgame, hrw){
	location.href = "process/actions/manual_hrw_action.php?gid="+idgame+"&hrw="+hrw;
}

function change_seal(idgame, seal){
	location.href = "process/actions/manual_seal_action.php?gid="+idgame+"&seal="+seal;
}

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
  
  function display_filter(id,message,href,clean1,clean2){
	
	if(document.getElementById(id).style.display == "none"){
	   document.getElementById(id).style.display = "block";
       document.getElementById(href).innerHTML= "Hide "+ message;
	   if (clean1 == clean2){	   
	   	 document.getElementById(clean1).value = "X";
		
	   }
  	 } else if(document.getElementById(id).style.display == "block"){
	   document.getElementById(id).style.display = "none";
	   document.getElementById(href).innerHTML= "Show "+ message;
	   document.getElementById(clean1).value = "";
       document.getElementById(clean2).value = "";
	   
	 }
	
 }
 
 function change_active_years(year,cant){

 var id=year.substr(5,1);
 var season=year.substr(0,4);
 var max_years = parseInt(id)+parseInt(5);
 for (x=1;x<id;x++){ 
   document.getElementById("season_"+x).checked = false;
   document.getElementById("season_"+x).disabled = true;
   document.getElementById("td_season_"+x).style.display = "none";
 }
 for (x=cant;x >=id;x--){
 
    if (x < max_years) { 
	  document.getElementById("season_"+x).disabled = false;
      document.getElementById("season_"+x).checked = false;
	  document.getElementById("td_season_"+x).style.display = "block";
	 
	  if (document.getElementById("season_"+x).value == season ){
	     document.getElementById("season_"+x).disabled = true;   
	     document.getElementById("season_"+x).checked = true;
	   }
	  if (document.getElementById("season_"+x).value == "2007" ){ //There are not data earlier 2008
	     document.getElementById("season_"+x).disabled = true;   
	     document.getElementById("season_"+x).checked = false; 
	   }
     }
     else {
	  document.getElementById("td_season_"+x).style.display = "none"; 
	  document.getElementById("season_"+x).disabled = true; 
	  document.getElementById("season_"+x).checked = false;  
    }
 
 }
 
}