$(document).ready(function(){
	
   var league = $('#leagues_dd').val();
   var team   = $('#choosen_team').val();
              
   $.ajax({
		 url: '/ck/process/api/get-teams.php',
		 type: 'post',
		 data: {league:league},
		 dataType: 'json',	 
		 success:function(response){
			 			 
		 var len = response.length;
				 
			$("#teams_dd").empty();
		 
			for(var i = 0; i<len; i++){
			  var team_id   = response[i]['team_id'];	
			  var team_name = response[i]['team_name'];
			 	  
			  if(team == team_id){				 
				  $("#teams_dd").append("<option value='"+team_id+"' selected>"+team_name+"</option>");			  
			  }else{
				  $("#teams_dd").append("<option value='"+team_id+"'>"+team_name+"</option>");	
			  }			  			  
			  
			}
			
		 }
		 
   });		    
   	 
   $("#leagues_dd").change(function(){
	   
   var league = $(this).val();   
          
	   $.ajax({
		 url: '/ck/process/api/get-teams.php',
		 type: 'post',
		 data: {league:league},
		 dataType: 'json',	 
		 success:function(response){
			 			 
			var len = response.length;
				 
			$("#teams_dd").empty();
		 
			for(var i = 0; i<len; i++){
			  var team_id   = response[i]['team_id'];	
			  var team_name = response[i]['team_name'];			  
			  $("#teams_dd").append("<option value='"+team_id+"'>"+team_name+"</option>");
			}
			
		 }
		 
	   });
	   
   });
   
	
});