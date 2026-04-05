
	
$( document ).ready(function() {
  document.getElementById('date').valueAsDate = new Date();


  //$(".upload-label").addClass("progress-bar");

 //  setTimeout(function(){
    //  $(".upload-label").removeClass("progress-bar");
   //   $(".upload-label").addClass("upload-complete");


  /// }, 10000);



});


//$(".upload-file-label").on('click', function(){
    // var filename = e.target.files[0].name;
    // $(".filename").text(filename);
  	

   function preupload(){

   uploadImage();

 



     fetch('http://localhost:8080/ck/process/actions/run_sports_headlines.php')
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		console.log('data');
		$("#div_games").html(data.html);
		
	}).catch(function(error){
		console.log('data 3');
	});

   $(".upload-label").addClass("progress-bar");

   setTimeout(function(){
      $(".upload-label").removeClass("progress-bar");
      $(".upload-label").addClass("upload-complete");


   }, 10000);

}




function loadGames(){

var league = $('#league').val();
var date = $('#date').val();

console.log(league+date);

    console.log('http://localhost:8080/ck/headlines/action/action.php?action=data&l='+league+'&date='+date);
   
	fetch('http://localhost:8080/ck/headlines/action/action.php?action=data&l='+league+'&date='+date)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		//console.log(data);
		$("#div_games").html(data.html);
		
	}).catch(function(error){
		alert("Ha sucedido un error 1.");
	});

}

function NoPlayers(){

	var isChecked = document.getElementById('noplayers').checked;
    if(isChecked){
        console.log('checkbox esta seleccionado');
        $("#div_players").html('');
         LoadPlayers();
	} else { 
   		console.log('checkbox NO esta seleccionado');
   		$("#div_players").html('');
   		LoadNoPlayers();
    }


}


function loadNames(){

  name =	$( "#games option:selected" ).text();
  const myArray = name.split("VS");
   console.log(myArray);
   $('#away_name').val(myArray[0]);
   	$('#home_name').val(myArray[1]);
  console.log(name);
}

function LoadPlayers(){
	var params = $("#games").val();
    $(".B").html('');
	console.log('PLAYERS  / '+params+ ' VS ');

	console.log('http://localhost:8080/ck/headlines/action/action.php?action=players&params='+params);
   
	fetch('http://localhost:8080/ck/headlines/action/action.php?action=players&params='+params)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		//console.log(data);
		$("#div_players").html(data.html);
		
	}).catch(function(error){
		console.log(data);
		alert("Ha sucedido un error 1.");
	});

}

function LoadNoPlayers(){
	var params = $("#games").val();
    
	console.log('http://localhost:8080/ck/headlines/action/action.php?action=noplayers&params='+params);
   
	fetch('http://localhost:8080/ck/headlines/action/action.php?action=noplayers&params='+params)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		//console.log(data);
		$("#div_players").html(data.html);
		
	}).catch(function(error){
		console.log(data);
		alert("Ha sucedido un error 1.");
	});

}



function generateImage(){
	
	createImagePlayers();
	createImageMobile();
	var html = '<div  class="container_loader"><div></div><div></div><div></div><div></div></div>';

	$("#div_image").html(html);
	showImage();
	

}




function generateImageNoPlayers(){
	
    createImageNoPlayers();
	//createImageMobile();
	var html = '<div  class="container_loader"><div></div><div></div><div></div><div></div></div>';
	$("#div_image").html(html);
	showImage();
	console.log('No players');

}



function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function showImage() {
    for (let i = 0; i < 3; i++) {
        console.log(`Waiting ${i} seconds...`);
        await sleep(i * 1000);
    }
     var version = new Date().getTime();
    var html='<BR><h3 style="text-align: center;"> WEBSITE </h3><BR><img class="img_demo" src=http://localhost:8080/ck/headlines/temp/base.png?v='+version+'><BR><BR>';
    $("#div_image").html(html);
  /*  var html2='<h3 style="text-align: center;"> MOBILE </h3><BR><img class="img_demo" src=http://localhost:8080/ck/headlines/images/sbo/mobile.jpg?v='+version+'><BR>'+
     '<div class="div_upload"><label class="upload-label"><span onclick="preupload()" class="upload-file-label">UPLOAD HEADLINE</span> </label></div>';
   /*'<input onclick="uploadImage();" style="font-size: 25px" type="button" value="UPLOAD"/>';*/
   // $("#div_image_mobile").html(html2);
  //  $("#div_mob").html(html2);*/

}




async function showImageMobile() {
    for (let i = 0; i < 3; i++) {
        console.log(`Waiting ${i} seconds...`);
        await sleep(i * 1000);
    }
     var version = new Date().getTime();
    var html2='<BR><BR><img class="img_demo" src=http://localhost:8080/ck/headlines/images/sbo/mobile.jpg?v='+version+'><BR><BR><input onclick="uploadImage();" style="font-size: 25px" type="button" value="UPLOAD"/>';
    $("#div_image_mobile").html(html2);

   

}

function createImagePlayers(){
	
	var league = $('#league').val();
	var away = $('#away').val();
	var home = $('#home').val();
	var day = $('#game_date').val();
	var hour = $('#hour').val();
	var tv = $('#tv').val();
	var a_player = $('#player_away').val();
	var h_player = $('#player_home').val();

    day = replaceAllstr(day," ","$");
    hour = replaceAllstr(hour," ","$");


console.log('http://localhost:8080/ck/headlines/action/action.php?action=generate&l='+league+'&a='+away+'&h='+home+'&ap='+a_player+'&hp='+h_player+'&tv='+tv+'&day='+day+'&hour='+hour);
   
	fetch('http://localhost:8080/ck/headlines/action/action.php?action=generate&l='+league+'&a='+away+'&h='+home+'&ap='+a_player+'&hp='+h_player+'&tv='+tv+'&day='+day+'&hour='+hour)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		console.log(data);
	//	$("#div_players").html(data.html);
		
	}).catch(function(error){
		//alert("Ha sucedido un error 1.");
		console.log('done');
	});
}



function createImageNoPlayers(){
	
	var league = $('#league').val();
	var away = $('#away').val();
	var away_name = $('#away_name').val();
	var home_name = $('#home_name').val();
	var home = $('#home').val();
	var day = $('#game_date').val();
	var hour = $('#hour').val();
	var tv = $('#tv').val();
	
    day = replaceAllstr(day," ","$");
    hour = replaceAllstr(hour," ","$");
    away_name = replaceAllstr(away_name," ","$");
    home_name = replaceAllstr(home_name," ","$");


    console.log('http://localhost:8080/ck/headlines/action/action.php?action=generateNoPlayer&l='+league+'&a='+away+'&h='+home+'&tv='+tv+'&day='+day+'&hour='+hour+'&an='+away_name+'&hn='+home_name);
   
	
	fetch('http://localhost:8080/ck/headlines/action/action.php?action=generateNoPlayer&l='+league+'&a='+away+'&h='+home+'&tv='+tv+'&day='+day+'&hour='+hour+'&an='+away_name+'&hn='+home_name)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		console.log(data);
	//	$("#div_players").html(data.html);
		
	}).catch(function(error){
		//alert("Ha sucedido un error 1.");
		console.log('done');
	})
	;
}



function createImageMobile(){
	
	var league = $('#league').val();
	var away = $('#away').val();
	var home = $('#home').val();
	var day = $('#game_date').val();
	var hour = $('#hour').val();
	var tv = $('#tv').val();
	var a_player = $('#player_away').val();
	var h_player = $('#player_home').val();

    day = replaceAllstr(day," ","$");
    hour = replaceAllstr(hour," ","$");


console.log('http://localhost:8080/ck/headlines/action/action.php?action=generateMobile&l='+league+'&a='+away+'&h='+home+'&ap='+a_player+'&hp='+h_player+'&tv='+tv+'&day='+day+'&hour='+hour);
   
	fetch('http://localhost:8080/ck/headlines/action/action.php?action=generateMobile&l='+league+'&a='+away+'&h='+home+'&ap='+a_player+'&hp='+h_player+'&tv='+tv+'&day='+day+'&hour='+hour)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		console.log(data);
	//	$("#div_players").html(data.html);
		
	}).catch(function(error){
		//alert("Ha sucedido un error 1.");
		console.log('done');
	});
}

 

function uploadImage(){

    var params = $("#games").val();
   
	console.log('Upload Pending');
	console.log('http://localhost:8080/ck/headlines/action/action.php?action=upload&&params='+params);
   	fetch('http://localhost:8080/ck/headlines/action/action.php?action=upload&params='+params)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		console.log(data);

	//	$("#div_players").html(data.html);
		
	}).catch(function(error){
		//alert("Ha sucedido un error 1.");
		console.log('error done');
	});

}


function replaceAllstr(string, search, replace) {
  return string.split(search).join(replace);
}

