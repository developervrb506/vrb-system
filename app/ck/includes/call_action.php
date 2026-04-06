<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar_time/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	var global_email = '<? echo $name->vars["email"] ?>';
	var global_account = '<? echo $name->vars["acc_number"] ?>';
	var global_free_play = '<? echo $name->vars["free_play"] ?>';
	/*window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
	};*/
</script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"status_action",type:"null", msg:"Please Select an Action"});
validations.push({id:"email_desc",type:"null", msg:"What does he wants to receive by Email?"});
validations.push({id:"date",type:"null", msg:"Please Select a Call Back Date"});
validations.push({id:"extra_in",type:"null", msg:"This field is required"});
//validations.push({id:"conv_action",type:"null", msg:"Please Select a Conversation Result"});
</script>
<form method="post" action="process/actions/end_call.php<? echo $_GET["test"] ?>" onsubmit="return validate(validations)">
<input name="name_id" type="hidden" id="name_id" value="<? echo $name->vars["id"] ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="7">
  <tr>
    <td><strong>Action:</strong></td>
    <td colspan="3"><? $statuses = get_all_name_status("0") ?>
      <select name="status_action" id="status_action" onchange="change_call_action(this.value);">
        <option value="">- Select -</option>
        <? foreach($statuses as $status){ ?>
        <option value="<? echo $status->vars["id"] ?>"> <? echo $status->vars["name"] ?> &nbsp;&nbsp;&nbsp;(<? echo $status->vars["description"] ?>)</option>
        <? } ?>
    </select></td>
    <td colspan="2"><input name="important" type="checkbox" id="important" value="1" /> <strong>IMPORTANT</strong> 
      </td>
    </tr>
  
  <tr style="display:none;" id="email_desc_row">
    <td></td>
    <td colspan="5"><strong>What does he wants to receive by Email?:</strong><br /><textarea name="email_desc" cols="50" rows="3" id="email_desc" style="display:none;"><? echo $name->vars["email_desc"] ?></textarea></td>
  </tr>
  
  <tr>
    <td><strong>Conversation Result:</strong></td>
    <td><? $conv_statuses = get_all_conversation_status() ?>
      <select name="conv_action" id="conv_action" onchange="save_conv_time()">
        <option value="">- Select -</option>
        <? foreach($conv_statuses as $conv_status){ ?>
        <option value="<? echo $conv_status->vars["id"] ?>"> <? echo $conv_status->vars["name"] ?></option>
        <? } ?>
      </select>
      <input type="hidden" value="" id="conv_time" name="conv_time" /></td>
    <td><strong>Book:</strong></td>
    <td valign="top"><input name="book" type="text" id="book" size="10" value="<? echo $name->vars["book"] ?>" /></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td><strong id="extra_str"></strong> </td>
    <td>
    	<input name="date" type="text" id="date" style="display:none" size="17" readonly="readonly"  onClick="javascript:NewCssCal('date')" />
        <input name="extra_chk" type="checkbox" id="extra_chk" value="1" style="display:none" />
    </td>
    <td><strong id="extra2_str"></strong></td>
    <td><input style="display:none" name="extra_in" type="text" id="extra_in" /></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <? if($name->vars["list"]->vars["id"] == 66 || $name->vars["list"]->vars["id"] == 64 || $current_clerk->vars["user_group"]->vars["id"] == 9){ ?>
  <tr>
    <td valign="top"><strong>Important Info:</strong></td>
    <td valign="top"><? echo nl2br($name->vars["message_to_clerk"]); ?></td>
    <td colspan="4" rowspan="2" valign="top">
    	<strong>Transactions:</strong>
    	<iframe src="<?= BASE_URL ?>/ck/loader_sbo.php?type=player&data=<? echo $name->vars["acc_number"] ?>" frameborder="1" scrolling="auto" width="100%" height="200"></iframe>
    </td>
 </tr>
  <tr>
    <td valign="top"><strong>Player Info</strong></td>
    <td valign="top">
    	<? echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/player_net_balance.php?player=".$name->vars["acc_number"]); ?>
        
    </td>
  </tr>
 <? } ?>
  <tr>
    <td valign="top"><strong>Notes:</strong></td>
    <td colspan="5" valign="top"><textarea name="notes" cols="70" rows="9" id="notes"><? echo $name->vars["note"] ?></textarea></td>
 </tr>
  <input type="hidden" name="csource" id="csource" value="<? echo $name->vars["clerk_source"] ?>" />
  <tr style="display:none;">
    <td><strong>Diferent Source?:</strong></td>
    <td><label for="csource"></label>
      </td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  
  <? if(in_array($name->vars["list"],$reload_lists)){ ?>
  <tr>
    <td valign="top"><strong>Why stopped playing?:</strong></td>
    <td colspan="5" valign="top"><textarea name="whyno" cols="70" rows="5" id="whyno"><? echo $name->vars["why_stop"] ?></textarea></td>
  </tr>
  <? } ?>
  
  
  <tr>
    <td valign="top"><strong>New Lead:</strong></td>
    <td valign="top"><input name="lead" type="checkbox" value="1" id="lead" <? if($name->vars["lead"]){echo 'checked="checked"';} ?> /></td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" valign="top"><input type="image" src="../images/temp/end_call.jpg" /></td>
  </tr>
</table>

</form>

<script type="text/javascript">
function save_conv_time(){
	document.getElementById("conv_time").value = current_time();
}
function change_call_action(id){
	var label = document.getElementById("extra_str");
	var label2 = document.getElementById("extra2_str");
	var date = document.getElementById("date");
	var extra = document.getElementById("extra_in");	
	var chk = document.getElementById("extra_chk");	
	var email_desc_div = document.getElementById("email_desc_row");
	var email_desc = document.getElementById("email_desc");
	//alert(id);
	switch(id){
		case "6":
			label2.innerHTML = "";
			label.innerHTML = "When to call Back?:";
			date.style.display = "block";
			extra.style.display = "none";
			chk.style.display = "none";
			email_desc.style.display = "none";
			email_desc_div.style.display = "none";
		break;
		case "7":
			label2.innerHTML = "";
			label.innerHTML = "When to call Back?:";
			date.style.display = "block";
			extra.style.display = "none";
			chk.style.display = "none";
			email_desc.style.display = "none";
			email_desc_div.style.display = "none";
		break;
		case "8":
			label2.innerHTML = "";
			extra.style.display = "none";
			chk.style.display = "none";			
			<? if(!$name->vars["list"]->vars["mailing_system"]){ ?> 
				label.innerHTML = "When to call Back?:";
				date.style.display = "block";
				show_script('3');
			<? }else{ ?>
				email_desc.style.display = "block";
				email_desc_div.style.display = "table-row";
			<? } ?>
		break;
		case "9":
			label2.innerHTML = "Account Number:";
			label.innerHTML = "Free Play?";
			date.style.display = "none";
			extra.style.display = "block";
			chk.style.display = "block";
			if(global_free_play == "1"){chk.checked = true;}
			extra.value = global_account;
			document.getElementById("lead").checked = true;
			email_desc.style.display = "none";
			email_desc_div.style.display = "none";
			show_script('4');			
		break;
		default:
			label2.innerHTML = "";
			label.innerHTML = "";
			date.style.display = "none";
			extra.style.display = "none";
			chk.style.display = "none";
			email_desc.style.display = "none";
			email_desc_div.style.display = "none";
	}
}
</script>