<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<script>
function show_braodcast(){

   if (document.getElementById("form_div_broad").style.display == 'none'){
   	   document.getElementById("form_div").style.display = 'none';
	   document.getElementById("form_div_broad").style.display = 'block';
	    document.getElementById("a_broad").innerHTML = 'Normal Ticket';

   }else{
	   document.getElementById("form_div").style.display = 'block';
	   document.getElementById("form_div_broad").style.display = 'none';
	   document.getElementById("a_broad").innerHTML = 'BroadCast Ticket'; 
	   
   }
 
 
 
}
</script>
<body>
<div class="page_content" style="padding:10px;">
<strong>New Ticket</strong>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <? if($current_clerk->im_allow("delete_tickets")){ ?>
 <a id="a_broad" class="normal_link" onclick="show_braodcast();" href="#" >BroadCast Ticket</a>
 <? } ?>
<br /><br />
<script type="text/javascript" src="../process/js/functions.js"></script>
    
<div class="form_box" id="form_div" style="display:block">
    <script type="text/javascript">
    var validations = new Array();
    validations.push({id:"player",type:"null", msg:"Player is required"});
	validations.push({id:"name",type:"null", msg:"Name is required"});
	validations.push({id:"email",type:"null", msg:"Email is required"});
	validations.push({id:"department",type:"null", msg:"Department is required"});
	validations.push({id:"subject",type:"null", msg:"Subject is required"});
	validations.push({id:"msg",type:"null", msg:"Message is required"});
    </script>
    <div align="center">
    <span><strong>Attn:</strong> If you are adding a ticket and do NOT want the customer to receive add "NA" in the required fields.</span>
    </div><BR>
    <form method="post" action="../tickets/actions/clerk_create.php" id="fsender" name="fsender" target="_top" onsubmit="return validate(validations);">
    <table width="100%" border="0" cellspacing="0" cellpadding="10">        
      <tr>
        <td>Player</td>
        <td><input name="player" type="text" id="player" /></td>
      </tr> 
      <tr>
        <td>Player Name</td>
        <td><input name="name" type="text" id="name" /></td>
      </tr>
      <tr>
        <td>Player Email</td>
        <td><input name="email" type="text" id="email" /></td>
      </tr>
      <tr>
        <td>Department</td>
        <td>
        	<? $live_help_departments = get_live_help_departments(); ?>
        	<select name="department" id="department">        
              <option value="" selected="selected">Choose</option>
              <? foreach ($live_help_departments as $dep) { ?>
                <? if ($dep->vars["deptID"] != 11) { ?>
                <option value="<? echo $dep->vars["deptID"]; ?>"><? echo $dep->vars["name"]; ?></option>
                <? } ?>
              <? } ?>      
            </select>
        </td>
      </tr>
      <tr>
        <td>Subject</td>
        <td><input name="subject" type="text" id="subject" /></td>
      </tr>
      <tr>
        <td>Message</td>
        <td><textarea name="msg" cols="20" rows="5" id="msg"></textarea></td>
      </tr> 
      <tr>    
        <td><input type="image" src="<?= BASE_URL ?>/images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>

<div class="form_box" id="form_div_broad" style="display:none">
    <script type="text/javascript">
    var validations1 = new Array();
  	validations1.push({id:"department2",type:"null", msg:"Department is required"});
	validations1.push({id:"subject2",type:"null", msg:"Subject is required"});
	validations1.push({id:"msg2",type:"null", msg:"Message is required"});
    </script>
    <div align="center">
    <span><strong>Attn:</strong> You will create a ticket for all the Post-Ups players.</span>
    </div><BR>
    <form method="post" action="../tickets/actions/clerk_create.php" id="fsender" name="fsender" target="_top" onsubmit="return validate(validations1);">
    <input type="hidden" id="broadcast" name="broadcast" value="1">
    <table width="100%" border="0" cellspacing="0" cellpadding="10">        
     
      <tr>
        <td>Department</td>
        <td>
        	<? $live_help_departments = get_live_help_departments(); ?>
        	<select name="department" id="department2">        
              <option value="" selected="selected">Choose</option>
              <? foreach ($live_help_departments as $dep) { ?>
                <? if ($dep->vars["deptID"] != 11) { ?>
                <option value="<? echo $dep->vars["deptID"]; ?>"><? echo $dep->vars["name"]; ?></option>
                <? } ?>
              <? } ?>      
            </select>
        </td>
      </tr>
      <tr>
        <td>Subject</td>
        <td><input name="subject" type="text" id="subject2" /></td>
      </tr>
      <tr>
        <td>Message</td>
        <td><textarea name="msg" cols="30" rows="10" id="msg2"></textarea></td>
      </tr> 
      <tr>    
        <td><input type="image" src="<?= BASE_URL ?>/images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>


<? }else{echo "Access Denied";} ?>