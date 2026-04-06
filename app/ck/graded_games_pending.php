<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/ajax.js"></script>
<? if($current_clerk->im_allow("graded_games_checker")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../process/js/jquery.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.9.1.js"></script>
<script type="text/javascript">
	


    $(document).on("change",".minute",function(){

		id =  $(this).data('id');
		min = $(this).val();
		updateTime(id,min);
    });	

    

    $(document).on("change","#sel_league",function(){

		
		min =  $(this).find(':selected').data('min');
			
	    $('#min_league').data('id' ,$(this).val());
		$('#min_league').val(min);
        $('#games_data').html('');
    });	


    
    $(document).on("click","#a_league",function(){
             
         if(  $('#a_league').html() == 'See all Leagues'){
             $('#leagues_time').show();
             getleagues();
             $('#leagues_filter').hide();
			 $('#a_league').html('Hide all Leagues');
         }   else {
            
 			 $('#leagues_time').hide();
             $('#leagues_filter').show();
             getFilters();
			 $('#a_league').html('See all Leagues');

         }
		     
		});	


        $(document).on("click","#btn_report",function(){
             
          getGames();
		     
		});	


	function getGames(){

	  var league = $('#sel_league option:selected').text();
	  var min = $('#min_league').val();

	  //console.log('<?= BASE_URL ?>/ck/process/actions/graded_games_pending_action.php?action=data&league='+league+'&min='+min);
	fetch('<?= BASE_URL ?>/ck/process/actions/graded_games_pending_action.php?action=data&league='+league+'&min='+min)
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		//console.log(data);
		$("#games_data").html(data.html);
		
	}).catch(function(error){
		console.log('error 4');
	});
  }
         

  function getleagues(){

	fetch('<?= BASE_URL ?>/ck/process/actions/graded_games_pending_action.php?action=leagues')
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		//console.log(data);
		$("#leagues_time").html(data.html);
		
	}).catch(function(error){
		console.log('error 3');
	});
  }

    function getFilters(){

	fetch('<?= BASE_URL ?>/ck/process/actions/graded_games_pending_action.php?action=filters')
	.then(function(response) {
	  return response.json();//json
	}).then(function(data){
		//console.log(data);
		$("#leagues_filter").html(data.html);
		
	}).catch(function(error){
		console.log('error 3');
	});

}



    function updateTime(id,min){
  
   // console.log('<?= BASE_URL ?>/ck/process/actions/graded_games_pending_action.php?action=league&id='+id+'&min='+min);
	fetch('<?= BASE_URL ?>/ck/process/actions/graded_games_pending_action.php?action=league&id='+id+'&min='+min)
	 .then(function(response) {
		return response.json();
	}).then(function(data){
		
		if(data.control == 1){
			console.log('Time Updated');
		} else {
			console.log('Error 1');
		}

	}).catch(function(error){
		console.log('Error 2');
	}); 

    }


</script>
<title>Pending Graded Games  </title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Pending Graded Games (Under Construction)</span><br /><br />
<? include "includes/print_error.php" ?> 
	

<?
$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d");}
$search = $_GET["search"];
$t = $_GET["t"];
$l = explode("_",$_GET["l"]);
$l = $l[0];


 // echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_pending.php?from=$from&search=$search&user=".urlencode($current_clerk ->vars["name"])."&l=".$l."&t=".$t); 


$leagues = get_leagues_graded_time();

?>
<a style="color:#393; font-size: 20px" href="javascript:void(0)" id="a_league"> See all Leagues</a><BR><BR>

<div id="leagues_time" style="display: none">
   <?/*
   <table  width="700" border="0" cellspacing="0" cellpadding="0">
   	<thead style="margin-bottom: 10px">
   	 <tr>
   	 	<td><strong> LEAGUE</strong> </td>	
   	 	<td><strong> MINUTES</strong> </td>	
   	 
   	</tr>	
   	<tr style="height: 10px !important; ">
      <td colspan="2"></td>
    </tr>
   	</thead>
    <?	 foreach($leagues	as $l){ ?>
   	  <tr>
   	  	 <td><? echo $l->vars['league']?></td>
   	  	 <td> <input class="minute" style="font-size: 22; width: 70px;" data-id ="<? echo $l->vars['id'] ?>" id="minute" type="number" value="<? echo $l->vars['time']?>"/></td>

   	  <tr>	
   	 <? } ?> 	

   </table> */?>
</div>


<div id="leagues_filter">	
   
<strong>  League:</strong>  <select id='sel_league' style="font-size: 22;">
 	     <? foreach($leagues as $l) { ?>
 	     <option data-min="<? echo $l->vars['time']?>" value="<? echo $l->vars['id']?>"><? echo $l->vars['league']?></option>
 	     <? } ?>
 	     </select>
 	     &nbsp;&nbsp;&nbsp;
 	     <strong>  Min:</strong> 
 	     <input class="minute" style="font-size: 22; width: 70px;" data-id="<? echo $leagues[0]->vars['id'] ?>" id="min_league" type="number" value="<? echo $leagues[0]->vars['time']?>"/>
 	     &nbsp;&nbsp;&nbsp;<input type="button" name="btn_report" id="btn_report" value="SEARCH" style="font-size: 22;">

  <div  id="games_data"></div>

</div>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>