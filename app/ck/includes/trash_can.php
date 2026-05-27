<? 
ini_set('memory_limit', -1);
include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"content",type:"null", msg:"Content is required"});
</script>

<style type="text/css">
body {
	background-color: #FFF;
}
</style>

<div style="padding:10px;">
<?
$messages = get_trash_messages();

if(isset($_GET["empty"])){
	foreach($messages as $msg){
		$msg->_empty();
	}
	$messages = array();
}

?>

<? if(count($messages)>0){ ?>
	<a href="javascript:;" onclick="empty();" class="normal_link">Empty Trash Can</a>
<? }else{ ?>
	No Deleted Items
<? } ?>
<br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td class="table_header">Date</td>
        <td class="table_header">From</td>
        <td class="table_header">To</td>
        <td class="table_header">Subject</td>            
    	<td class="table_header" align="center">Restore</td>
  </tr>
	<? 
	$i = 0;	
	foreach($messages as $msg){if($i % 2){$style = "2";}else{$style = "1";} $i++;
		$auto_from = false;
		$auto_to = false;
		if($msg->vars["from"]->vars["id"] == $current_clerk->vars["id"]){$auto_from = true;}
		if($msg->vars["to"]->vars["id"] == $current_clerk->vars["id"]){$auto_to = true;}
	?>
  	<tr>
        <td class="table_td<? echo $style ?> pointer" onclick="oplen_close('<? echo $msg->vars["id"] ?>');">			           
            <? echo date("Y/m/d H:i:s",strtotime($msg->vars["last_date"])); ?>
        </td>
        <td class="table_td<? echo $style ?> pointer" onclick="oplen_close('<? echo $msg->vars["id"] ?>');">
            <? 
            if($auto_from){echo "You";}
            else{echo $msg->vars["from"]->vars["name"]; }		
            ?>
        </td>
        <td class="table_td<? echo $style ?> pointer" onclick="oplen_close('<? echo $msg->vars["id"] ?>');">
            <? 
            if($auto_to){echo "You";}
            else{echo $msg->vars["to"]->vars["name"]; }		
            ?>
        </td>
        <td class="table_td<? echo $style ?> pointer" onclick="oplen_close('<? echo $msg->vars["id"] ?>');">
            <? echo text_preview($msg->vars["title"], 40); ?>
        </td>
        <td class="table_td<? echo $style ?>" align="center" >
            <a href="../process/actions/messages_processor.php?action=restore&m=<? echo $msg->vars["id"] ?>" target="_parent" class="normal_link">Restore</a>
        </td>
    </tr>
    <tr>
    	<td colspan="5" class="table_td<? echo $style ?>" id="<? echo $msg->vars["id"] ?>" style="border-top:1px solid #CCC; border-bottom:1px solid #CCC; font-weight:normal; background:#e4f8ff; text-align:justify; display:none;">
        	<? echo nl2br($msg->vars["content"]) ?> 
        </td>
    </tr>
    <? } ?>
  <tr >
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table> 
</div>
<script type="text/javascript">
function oplen_close(id){
	if(document.getElementById(id).style.display == "none"){		
		document.getElementById(id).style.display = "table-cell";
	}else{
		document.getElementById(id).style.display = "none";
	}
}
function empty(){
	action = confirm('Are you sure you want to Empty the Trash Can?');
	if(action){
		location.href = "?empty";	
	}
}
</script>