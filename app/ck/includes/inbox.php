<script type="text/javascript">
var main_ids = Array();
</script>
<?
//Settings
$row_colors[0] = "#f1f1f1";
$row_colors[1] = "#FFF";
$important_colors[0] = "#f8c052";
$important_colors[1] = "#fddc9b";
$complete_colors[0] = "#4393ff";
$complete_colors[1] = "#84b7fc";
//
$opener = $_GET["open"];

if($mdate == ""){$mdate = "1900-01-01";}

if(isset($_POST["reply"])){
	$rmessage = get_ck_message(clean_get("reply"));
	if(!is_null($rmessage)){
		$vars["from"] = $current_clerk->vars["id"];
		$vars["to"] = $rmessage->vars["from"];
		$vars["title"] = "RE:".$rmessage->vars["title"];
		$vars["content"] = clean_get("reply_text");
		$vars["send_date"] = date("Y-m-d H:i:s");
		$vars["last_date"] = date("Y-m-d H:i:s");
		$vars["reply_from"] = $rmessage->vars["id"];
		$reply_message = new ck_message($vars);
		$reply_message->attach("attachment", "attachments/");
		$reply_message->send();
		$opener = $rmessage->vars["id"];
		
		$rmessage->resend($current_clerk);
	}
}
?>
<iframe frameborder="0" width="0" height="0" src="" id="frame_read"></iframe>
<iframe frameborder="0" width="0" height="0" src="" id="action_frame"></iframe>
<span style="font-size:12px;">
    <a href="?r" class="normal_link">Refresh Inbox</a>
    <? if($current_clerk->admin()){ ?>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a class="normal_link" href="includes/trash_can.php" rel="shadowbox;height=470;width=670" title='Deleted Items'>Deleted Items</a>
    <? } ?>
    <br /><br />
<strong>Selected: </strong>&nbsp;
<? if($current_clerk->admin()){ ?>
<a href="javascript:;" class="normal_link" onclick="delete_group();" >Delete</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<? }?>
<a href="javascript:;" class="normal_link" onclick="complete_group();">Mark as Complete / Incomplete</a>
    
</span>    
    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td class="table_header"></td>
        <td class="table_header"></td>
<td class="table_header">Date</td>
        <td class="table_header">From</td>
        <td class="table_header">To</td>
        <td class="table_header">Subject</td>        
        <? if($current_clerk->admin()){ ?>
        <td class="table_header" width="300">Preview</td>        
    	<td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
    <? } ?>
  </tr>
    <?
	$i=0;
	if($preview || $name_sort){
		//$messages = get_preview_messages($current_clerk, $mdate, $mstitle);
		$ids = get_ids_preview_messages($current_clerk, $mdate, $mstitle);
		
		$message_user = NULL;
		$sort = "name";
	}
    else{
		//$messages = get_clerk_messages($current_clerk, $mdate, $mstitle);
		$ids = get_ids_clerk_messages($current_clerk, $mdate, $mstitle);
		$sort = "date";
	}
	
	$block = 50000;
	$count = count($ids);
	$mcount = ceil($count / $block);
	
	$ids_index = "-" . $block;
	
	for($e = 0; $e < $mcount; $e++){
	$ids_index += $block;
	$slide = array_slice($ids, $ids_index, $block);
	
	$str_ids = "";
	foreach($slide as $sld){$str_ids .= ",".$sld["id"];}
	$str_ids = substr($str_ids,1);
	
	$messages = get_messages_by_ids($str_ids,$current_clerk, $sort);
	
	
   include("display_messages.php"); 
   if($name_sort || $preview){
		$messages = get_own_clerk_messages($current_clerk, $mdate, $mstitle);
		include("display_messages.php"); 
	}
    
   } ?>  
  <tr >
  	<td class="table_last"></td>
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

<? if(empty($messages)){echo "No Messages";} ?>

<br /><br />
<?
if($preview){
	?><a href="javascript:;" class="normal_link" onclick="window.print();">Print Page</a><?	
}
?>
    
<script type="text/javascript">
var action_frame = document.getElementById("action_frame");
var action_url = BASE_URL . "/ck/process/actions/messages_processor.php";
var error_box = document.getElementById("error_box");
function open_close_message(id){
	line = document.getElementById(id);
	frame = document.getElementById("frame_read");
	tr = document.getElementById("tr_"+id);
	if(line.style.display == "none"){
		line.style.display = "table-cell";
		frame.src = BASE_URL . "/ck/process/actions/read_message_action.php?m=" + id;
		tr.className = "tr_read";
	}else{
		line.style.display = "none";
	}
}
function delete_group(){
	action = confirm('Are you sure you want to delete the Selected Messages?');	
	if(action){
		var ms = "";
		for(var i = 0; i<main_ids.length; i++){
			var check = document.getElementById("select_"+main_ids[i]);
			if(check.checked){
				delete_ck_message(main_ids[i],"",false,false)
				ms += "," + main_ids[i]
			}
		}
		action_frame.src = action_url+"?action=delete_group&ms=" + ms.substring(1);
		error_box.innerHTML = "Messages Deleted<br /><br />";
	}
}

function delete_ck_message(id,name,isreply,real){
	if(real){action = confirm('Are you sure you want to delete "'+name+'"?');}
	else{action = true;}
	//if(!isreply){open_close_message(id);}
	if(action){
		if(real){
			action_frame.src = action_url+"?action=delete&m="+id;
			error_box.innerHTML = "Message Deleted<br /><br />";
		}
		document.getElementById("tr_" + id).style.display = "none";
		if(!isreply){document.getElementById("inside_" + id).style.display = "none";}		
	}
}
function change_important(id, color1, color2, real){
	if(real){
		action_frame.src = action_url+"?action=important&m="+id;
	}
	var line = document.getElementById("tr_" + id);
	
	if(line.style.fontStyle != "italic"){
		line.style.fontStyle = "italic";
		line.style.backgroundColor = color2;
	}else{
		line.style.fontStyle = "";
		line.style.backgroundColor = color1;
	}
}
function complete_group(){
	var ms = "";
	for(var i = 0; i<main_ids.length; i++){
		var check = document.getElementById("select_"+main_ids[i]);
		if(check.checked){
			change_complete(main_ids[i],false)
			ms += "," + main_ids[i]
			check.checked = false;
		}
	}
	action_frame.src = action_url+"?action=complete_group&ms=" + ms.substring(1);
}
function change_complete(id, real){
	if(real){
		action_frame.src = action_url+"?action=complete&m="+id;
	}
	var image = document.getElementById("check_" + id);
	var txt = document.getElementById("complete_txt_" + id);
	if(image.style.display != "none"){
		image.style.display = "none"
		txt.innerHTML = "Complete";
	}else{
		image.style.display = "block"
		txt.innerHTML = "Incomplete";
	}
}
</script>