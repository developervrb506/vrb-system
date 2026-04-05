<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets_categories")){ ?>
<?
if (isset($_POST['process'])){
	$ticket = get_master_ticket($_POST['process']);	
	$ticket->vars["subject"] = clean_str_ck($_POST['subject']);
	$ticket->vars["message"] = clean_str_ck($_POST['message']);
	$ticket->vars["open"] = $_POST['status'];
	$ticket->vars["exp_date"] = $_POST['exp_date'];	
	$ticket->update(array("subject","message","open","exp_date"));
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tickets Broadcast</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<br /><br />
<? include "includes/print_error.php" ?>   
<?
if(isset($_GET["detail"])){
	//details
	$tk = get_master_ticket($_GET["idf"]);

	
     ?>	
    <span class="page_title">Edit Ticket</span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"subject",type:"null", msg:"Subject is required"});
	validations.push({id:"message",type:"null", msg:"Message is required"});
    </script>
    <div align="right">
     <span ><a href="http://localhost:8080/ck/tickets_broadcast.php">Back</a></span>
    </div>
	<div class="form_box" style="width:500px;">
        <form method="post" action="?e=52" onsubmit="return validate(validations)" enctype="multipart/form-data">
        <input name="process" type="hidden" id="process" value="<? echo $tk->vars["id"] ?>" />
		
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Subject</td>
            <td>
            <textarea cols="45" rows="3" name="subject" id="subject" ><? echo $tk->vars["subject"] ?></textarea>      
            
          </tr> 
          
          <tr>
            <td>Message</td>
            <td>
             <textarea cols="45" rows="15" name="message" id="message" ><? echo $tk->vars["message"] ?></textarea>          
           </td>
          </tr> 
          <tr>
            <td>Status</td>
            
            <td>
             <select name="status" >
               <option <? if(!$tk->vars["open"]) { echo ' selected="selected" ';}?> value="0">Closed</option>
               <option <? if($tk->vars["open"]) { echo ' selected="selected" ';}?> value="1">Open</option>	               
             </select>
            
            </td>
            
          </tr> 
          <tr>
            <td>Expire Date</td>
            
            <td>
            <input type="text" id="from" name="exp_date" value="<? echo $tk->vars["exp_date"] ?>">
            </td>
            
          </tr> 
          
           
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	?>
 
<span class="page_title">Tickets Broadcast</span><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Subject</td>
   <td class="table_header" align="center">Messaje</td>  
    <td class="table_header" align="center">Deleted</td>
    <td class="table_header" align="center">Replied</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Expired Date</td>    
   <td class="table_header" align="center"></td>    
	        
  </tr>
  <?
  $i=0;
   $tickets = get_all_master_ticket();
   foreach( $tickets as $tk){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	  $deleted = get_master_ticket_action($tk->vars["id"],'d');
	  $replied = get_master_ticket_action($tk->vars["id"],'r');
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["subject"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["message"]; ?></td>        
    <td class="table_td<? echo $style ?>" align="center"><? echo $deleted["total"] ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $replied["total"] ?></td>
     <td class="table_td<? echo $style ?>" align="center"><? echo $tk->str_status() ?></td>
     <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["exp_date"] ?></td>     
    <td class="table_td<? echo $style ?>" align="center"><a href="?detail&idf=<? echo $tk->vars["id"]; ?>" class="normal_link">Edit</a></td>    
    
  </td>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>    
    <td class="table_last"></td>    
   
  </tr>

</table>


<?  } ?>
</div>



<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>