<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_ticker")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"expiration_date",
			dateFormat:"%Y-%m-%d"
		});
		
	};
</script>
<script type="text/javascript">
<!--
function delete_message(id){
	if(confirm("Are you sure you want to DELETE this entry from the system?")){		
		$('#idel').attr('src',BASE_URL . "/ck/process/actions/delete_agent_message.php?id="+id)
		$("#tr_" + id).hide();
	}
}
//-->

function control_div(div){
	 $(".default-hidden").hide(); 
	 $("#" + div).show();
	 $("#a_" + div).show();
	 
	 if (div == 'div_new'){
	 	  $("#agent_type").val('*');
		  $("#agent").val('');
	      $("#message").val('');
		  $("#expiration_date").val('');
		  $("#hour").val('');
		  $("#minute").val('');		  
		  $('input:checkbox').removeAttr('checked'); 		  	 
	 }	
}

function change_agent_type(id){	
  if (id == '*'){
	 $("#agent").attr("required", false); 
     $("#text_agent").hide();
	 $("#agent").val('');	 	     		 
  }  
  else{
	 $("#text_agent").show();
	 $("#agent").val('');
	 $("#agent").attr("required", true); 
  }	
}

</script>
</head>
<?
//Page Logic
if (isset($_POST["message"])) { 

	if (!isset($_POST["edit"])) {
		$message = new _agent_messages();
		
		if ( param('agent') != "" and !is_null(param('agent')) ){
		  $message->vars["agent"] = param('agent');			
		}
		else {
		  $message->vars["agent"] = "*";	
		}		
		
		$message->vars["message"] = str_replace("'","__cs__",(param('message',false)));
			
		$expiration_date = param('expiration_date',false);
		
		$expiration_date =  $expiration_date.':'.param('hour',false).':'.param('minute',false);
											
		$message->vars["expiration_date"] = $expiration_date;
		
		if ( param('allow_disable',false) != "" and !is_null(param('allow_disable',false)) ){
		  $message->vars["allow_disable"] = 1;			
		}
		else {
		  $message->vars["allow_disable"] = 0;	
		}				
		
		$message->insert();
		$edit = false;
		unset($_GET["id"]);		
	}
	else{		
				
		$message = get_agent_message(param('edit'));
		
		if ( param('agent') != "" and !is_null(param('agent')) ){
		  $message->vars["agent"] = param('agent');			
		}
		else {
		  $message->vars["agent"] = "*";	
		}		
		
		$message->vars["message"] = str_replace("'","__cs__",(param('message',false)));
				
		$expiration_date = param('expiration_date',false);
		
		$expiration_date =  explode(" ",$expiration_date);
		
		$expiration_date = $expiration_date[0];		
						
		$expiration_date = $expiration_date.':'.param('hour',false).':'.param('minute',false);
											
		$message->vars["expiration_date"] = $expiration_date;		
				
		if ( param('allow_disable',false) != "" and !is_null(param('allow_disable',false)) ){
		  $message->vars["allow_disable"] = 1;			
		}
		else {
		  $message->vars["allow_disable"] = 0;	
		}
				
		$message->update();	
		$edit = false;
		unset($_GET["id"]);		
	}
}

$edit = false;
if (isset($_GET["id"])) { 
 
 $message = get_agent_message(param('id'));
 $edit = true;
 
}

$messages = get_all_agents_messages();
?>

<body style="background:#fff; padding:20px;">
<span class="page_title">AGENTS MESSAGES</span>&nbsp;&nbsp; <a id="a_div_table" href="javascript:control_div('div_new')" class="normal_link default-hidden">Add New Message</a> <a id="a_div_new" href="javascript:control_div('div_table')" class="normal_link default-hidden" style="display:none" >Show Table Message</a><br />
<br />
<div class="form_box">
  <iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
  <div id="div_table" class="default-hidden" <? if($edit){ echo 'style="display:none"';}?> >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center"><strong>Agent</strong>
          </th>
        <td class="table_header" align="center"><strong>Expiration Date</strong>
          </th>
        <td class="table_header" align="center"><strong>Message</strong>
          </th>
        <td class="table_header" align="center"><strong>Allow Disable</strong>
          </th>
        <td class="table_header" align="center"></th>
        <td class="table_header" align="center"></th>
      </tr>
      <?  
   foreach( $messages as $msj){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++;   
   ?>
      <tr id="tr_<? echo $msj->vars["id"] ?>">
        <th class="table_td<? echo $style ?>"><? echo $msj->vars["agent"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $msj->vars["expiration_date"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo str_replace("__cs__","'",$msj->vars["message"]); ?></th>
        <th class="table_td<? echo $style ?>"> <? 
		if($msj->vars["allow_disable"] == 1){
		   echo "Yes";
		}else{
		   echo "No";	
		}
		?>
        </th>
        <th class="table_td<? echo $style ?>"><a class="normal_link" target="_self" href="<?= BASE_URL ?>/ck/agents_messages.php?id=<? echo $msj->vars["id"] ?>">Edit</a></th>
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="javascript:delete_message(<? echo $msj->vars["id"] ?>)">Delete</a> </th>
      </tr>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
    </table>
  </div>
  <div align="center" id="div_new" <? if($edit) { echo 'style="display:block"';}else{ echo 'style="display:none"';}?>  class="default-hidden">
    <form action="" method="post" target="_self" onsubmit="" >
      <? if($edit) {?>
      <input required name="edit" type="hidden" id="edit" value="<? echo $message->vars["id"] ?>" />
      <? } ?>
      
      <?
	  $exp_date = explode(" ",$message->vars["expiration_date"]);
	  $time     = $exp_date[1];
	  $time     = explode(":",$time);
	  $hour     = $time[0];
	  $minute   = $time[1]; 
	  ?>
      
      <table width="50%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td>Agent:</td>
          <td><select name="agent_type" id="agent_type" onchange="change_agent_type(this.value);">
              <option value="*"  <? if ($message->vars["agent"] == "*" or $message->vars["agent"] == "" ) { ?> selected="selected" <? } ?>>All</option>
              <option value="SA" <? if ($message->vars["agent"] != "*") { ?> selected="selected" <? } ?>>Specific agent</option>
            </select></td>
          <td colspan="2"><div class="default-hidden" id="text_agent">
              <input name="agent" type="text" id="agent" value="<? echo $message->vars["agent"] ?>" />
            </div></td>
          <td>&nbsp;</td>  
        </tr>
        <tr>
          <td nowrap="nowrap">Expiration Date:</td>
          <td><input required name="expiration_date" type="text" id="expiration_date" value="<? echo $message->vars["expiration_date"] ?>" /></td>
          <td><select required name="hour" id="hour">
              <option value="">hour</option>
              <?
              for ($i = 0; $i <= 23; $i++) {
				  if ($i < 10) {
					 $option_value_hour = "0".$i;
				  } else {
					 $option_value_hour = $i; 
				  }
				  ?>
			  <option value="<? echo $option_value_hour ?>" <? if ( $hour == $option_value_hour ) { ?> selected="selected" <? } ?>>
			  <? echo $option_value_hour ?></option> 
              <? } ?>            
            </select> :</td>
          <td><select required name="minute" id="minute">
              <option value="">minute</option>
              <?
              for ($k = 0; $k <= 59; $k++) {
				  if ($k < 10) {
					 $option_value_minute = "0".$k;
				  } else {
					 $option_value_minute = $k; 
				  }
				  ?>
			  <option value="<? echo $option_value_minute ?>" <? if ( $minute == $option_value_minute ) { ?> selected="selected" <? } ?>>
			  <? echo $option_value_minute ?></option>
              <? } ?>
            </select></td>
          <td></td>
        </tr>
        <tr>
          <td>Message:</td>
          <td colspan="5"><textarea required name="message" id="message" rows="5" cols="21"><? echo str_replace("__cs__","'",$message->vars["message"]) ?></textarea></td>
        </tr>
        <tr>
          <td nowrap="nowrap">Allow agent to hide this message:</td>
          <td colspan="5"><input name="allow_disable" id="allow_disable" type="checkbox" value="<? echo $message->vars["allow_disable"] ?>" <? if ($message->vars["allow_disable"] == 1) { ?> checked="checked" <? } ?> /></td>
        </tr>
        <tr>
          <td align="center" colspan="5"><input type="image" src="../images/temp/submit.jpg" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
</body>
</html>
<? }else{echo "Access Denied";} ?>