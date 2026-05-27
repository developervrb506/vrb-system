<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets_categories")){ ?>
<?
if (isset($_POST['process'])){
	$categorie = get_ticket_categorie($_POST['process']);
	$categorie->vars["instructions"] = clean_str_ck($_POST['instructions']);
	$categorie->vars["notes"] = clean_str_ck($_POST['notes']);
	$categorie->update(array("instructions","notes"));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Customers Feedback Tickets</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
function enable(table){
   if (document.getElementById("btn_remove"+table)){	
  document.getElementById("btn_remove"+table).disabled = false;
   }
   if(document.getElementById("btn_delete"+table)){
    document.getElementById("btn_delete"+table).disabled = false;	
   }
}

function action_checkbox(action,total,table){

  var tickets ;
  var check = false;
  var  action_string = action;
  var important = 0;
  
  if(action_string == 'rm'){ action_string = 'QUIT'; important = 3;} 
  else if(action_string == 'add') { action_string = "ADD"; important = 1;}
  else{ action_string = 'DELETE'; important = 0; }
  
  if(confirm("Are you sure you want to "+action_string+" this ticket from the system?")){
	   for (var i=1;i <= total;i++){
		 
		 
		  if (document.getElementById("ck_"+table+i)) {
			 if (document.getElementById("ck_"+table+i).checked){
				 tickets = document.getElementById("ck_"+table+i).value+","+tickets;
				 check = true;
				 //document.getElementById("tr_"+document.getElementById("ck_"+i).value).style.display = "none";
				 
			 }
		  }
	   }
	  if (check){
		var tks = tickets.substring(0, tickets.length - 10);
		//document.getElementById("idel").src = BASE_URL . "/ck/process/actions/action_feedback.php?important="+important+"&tks="+tks;
	   window.location = BASE_URL . "/ck/process/actions/action_feedback.php?important="+important+"&tks="+tks;
	  }
  }
}




function mark_desmark(total,table){
	 enable(table);
	 for (var i=1;i <= total;i++){
	   if (document.getElementById("ck_"+table+i)) {
		 if (document.getElementById("mark_ck"+table).checked){
			 document.getElementById("ck_"+table+i).checked = true;
		 } else {
		    document.getElementById("ck_"+table+i).checked = false;
		 }
	   }
	 }
	
}


</script>
</head>

<div align="right">
     <iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<br /><br />
<? include "includes/print_error.php" ?>    
<?
  $feedback = get_ticket_feedback();
?>
<span class="page_title">Customers Feedback Tickets</span><br /><br />



<strong>ALL FEEDBACKS</strong>
 <div style='width: 100%; min-height:53px; max-height:400px; overflow:scroll;'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">
     <div style="float: left; ">
      <input type="checkbox" id="mark_ck1" onchange="mark_desmark('<? echo count($feedback) ?>',1)" style="width:30px; height:30px" />
     </div>
     <div  style="float: right;">
     <input  onclick="action_checkbox('rm','<? echo count($feedback) ?>',1)" disabled="disabled" id="btn_remove1" type="button" value="REMOVE" style="width: 45px;font-size: 8px; margin-bottom:3px"><BR>
    <input  onclick="action_checkbox('add','<? echo count($feedback) ?>',1)" disabled="disabled" id="btn_delete1" type="button" value="ADD" style="width: 45px;font-size: 8px;">
     </div></td>
    <td class="table_header" align="center">Account</td>
    <td class="table_header" align="center">Message</td>

  </tr>
  <?
  $i=0;
 
   foreach( $feedback as $fb){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
    <tr  id="tr_<? echo $fb->vars["id"]; ?>">

    <td class="table_td<? echo $style ?>" align="center">
     <input onchange="enable(1);" type="checkbox" style="width:20px; height:20px" id="ck_1<? echo $i; ?>" name="ck_<? echo $fb->vars["id"]; ?>" value="<? echo $fb->vars["id"]; ?>">
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $fb->vars["player_account"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $fb->vars["message"]; ?></td>
    
    
  </td>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>

   
  </tr>

</table>



</div>
<BR><BR>
<strong>SELECTED FEEDACKS</strong>

<?
  $feedback = get_ticket_by_category_important(6,1);
?>
 <div style='width: 100%; min-height:53px; max-height:400px; overflow:scroll;'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">
     <div style="float: left; ">
      <input type="checkbox" id="mark_ck2" onchange="mark_desmark('<? echo count($feedback) ?>',2)" style="width:30px; height:30px" />
     </div>
     <div  style="float: right;">
     <input  onclick="action_checkbox('del','<? echo count($feedback) ?>',2)" disabled="disabled" id="btn_remove2" type="button" value="DELETE" style="width: 45px;font-size: 8px; margin-bottom:3px"><BR>
     </div></td>
    <td class="table_header" align="center">Account</td>
    <td class="table_header" align="center">Message</td>

  </tr>
  <?
  $i=0;
 
   foreach( $feedback as $fb){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
    <tr  id="tsr_<? echo $fb->vars["id"]; ?>">

    <td class="table_td<? echo $style ?>" align="center">
     <input onchange="enable(2);" type="checkbox" style="width:20px; height:20px" id="ck_2<? echo $i; ?>" name="ck2_<? echo $fb->vars["id"]; ?>" value="<? echo $fb->vars["id"]; ?>">
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $fb->vars["player_account"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $fb->vars["message"]; ?></td>
    
    
  </td>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>

   
  </tr>

</table>



</div>
</div>


<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>