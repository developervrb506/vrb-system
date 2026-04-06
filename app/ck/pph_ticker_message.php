<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("pph_ticker")){ 


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"system_list_from",type:"null", msg:"Please Select a System"});
	validations.push({id:"from_account",type:"null", msg:"Please Select an Account"});
	validations.push({id:"system_list_to",type:"null", msg:"Please Select a System"});
	validations.push({id:"to_account",type:"null", msg:"Please Select an Account"});
	validations.push({id:"amount",type:"numeric", msg:"Please Write a valid Amount"});
</script>
<script type="text/javascript">
<!--

function delete_ticker(id){
	if(confirm("Are you sure you want to DELETE this entry from the system?")){
		//document.getElementById("idel").src = BASE_URL . "/ck/process/actions/delete_pph_ticker.php?id="+id;
		$('#idel').attr('src',BASE_URL . "/ck/process/actions/delete_pph_ticker.php?id="+id)
		//document.getElementById("tr_"+id).style.display = "none";
		$("#tr_" + id).hide();
	}
}
//-->

function control_div(div){
	 $(".default-hidden").hide(); 
	 $("#" + div).show();
	 $("#a_" + div).show();
	 
	 if (div == 'div_new'){
	 	  $("#website").val('');
	      $("#message").val('');
		 
	}
	
	
}
</script>
</head>
<?
//Page Logic
if (isset($_POST["website"])) { 

	if (!isset($_POST["edit"])) {
		$ticker = new _pph_ticker();
		$ticker->vars["website"] = param('website');
		$ticker->vars["message"] = str_replace("'","__cs__",(param('message',false)));
		$ticker->vars["mdate"] = date('Y-m-d H:i:s');
		$ticker->vars["by"] = $current_clerk->vars["id"];
		$ticker->insert();
		$edit = false;
		unset($_GET["id"]);
		
	}
	else{
		$ticker = get_pph_ticker(param('edit'));
		$ticker->vars["website"] = param('website');
		$ticker->vars["message"] = str_replace("'","__cs__",param('message',false));
		$ticker->vars["mdate"] = date('Y-m-d H:i:s');
		$ticker->vars["by"] = $current_clerk->vars["id"];
		$ticker->update();	
		$edit = false;
		unset($_GET["id"]);
		
	}

}

$edit = false;
if (isset($_GET["id"])) { 
 
 $ticker = get_pph_ticker(param('id'));
 $edit = true;
 
}

$tickets = get_all_pph_ticker();
?>

<body style="background:#fff; padding:20px;">
<span class="page_title">PPH MESSAGES</span>&nbsp;&nbsp;
<a id="a_div_table" href="javascript:control_div('div_new')" class="normal_link default-hidden" >Add New Message</a>
<a id="a_div_new" href="javascript:control_div('div_table')" class="normal_link default-hidden" style="display:none" >Show Table Message</a><br /><br />
<div class="form_box">

<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>


<div id="div_table" class="default-hidden" <? if($edit){ echo 'style="display:none"';}?> > 
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="table_header" align="center" ><strong>Placed</strong></th>
    <td class="table_header" align="center" ><strong>Website</strong></th>
    <td class="table_header" align="center" ><strong>Message</strong></th>
    <td class="table_header" align="center" ><strong>Owner</strong></th>
    <td class="table_header" align="center"></th> 
    <td class="table_header" align="center"></th>   
  </tr>


   <?
  
   foreach( $tickets as $tk){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
  /* echo "<pre>";
   print_r($tk);
   echo "</pre>";*/
   
   ?>
  <tr id="tr_<? echo $tk->vars["id"] ?>">   	
        <th class="table_td<? echo $style ?>"><? echo $tk->vars["mdate"]; ?></th>
		<th class="table_td<? echo $style ?>"><? echo $tk->vars["website"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo str_replace("__cs__","'",$tk->vars["message"]); ?> 
        </th>
        <th class="table_td<? echo $style ?>"><? echo $tk->vars["by"]->vars["name"] ?></th>
        <th class="table_td<? echo $style ?>"><a class="normal_link" target="_self" href="<?= BASE_URL ?>/ck/pph_ticker_message.php?id=<? echo $tk->vars["id"] ?>">Edit</a></th>  
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="javascript:delete_ticker(<? echo $tk->vars["id"] ?>)">Delete</a>
        </th> 
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
	<input required name="edit" type="hidden" id="edit" value="<? echo $ticker->vars["id"] ?>" />
<? }?>
	<table width="50%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Website:</td>
		<td>
			<input required name="website" type="text" id="website" value="<? echo $ticker->vars["website"] ?>" /><BR> <span style="font-size:11px">example: fireonsports.ag, betowi.com</span> 
		</td>
	  </tr>
      <tr>
		<td>Message:</td>
		<td>
			<input required name="message" type="text" id="message" value="<? echo str_replace("__cs__","'",$ticker->vars["message"]) ?>" />
		</td>
	  </tr>
	  
	  <tr>    
		<td align="center" colspan="2"><input type="image" src="../images/temp/submit.jpg" /></td>
	  </tr>
	</table>
  </form>
</div>



</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>