<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("buy_moneypaks_promo")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Buy Moneypaks Promo</title>

<script type="text/javascript">
function sent_moneypak(id){
	if(confirm("Are you sure you want Sent this moneypak Promo?")){
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/buy_moneypaks_promo_action.php?id="+id+"&action=sent";
		document.getElementById("td_"+id).innerHTML = "<strong>YES</strong>";
	}
}
</script>
<script type="text/javascript">
function delete_moneypak(id){
	if(confirm("Are you sure you want to DELETE "+name+" from the system?")){
				document.getElementById("idel").src = BASE_URL . "/ck/process/actions/buy_moneypaks_promo_action.php?id="+id+"&action=active";

		document.getElementById("tr_"+id).style.display = "none";
	}
}
</script>

</head>
<body>
<? $sent = $_POST["sent"] ?>
<? if (!isset($_POST["search"])){ $sent = 0;} ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;" >
    <div align="right">
        <a href="moneypak_transactions.php" class="normal_link" >Back to Moneypaks</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>    
    
<span class="page_title">Buy Moneypaks Promo</span><BR/>
<br />
<form method="post">

Sent: 
<select name="sent">
<option <? if ($sent == ""){ echo 'selected="selected"'; } ?>  value = "">All</option>
<option <? if ($sent == "1"){ echo 'selected="selected"'; } ?> value = "1">YES</option>
<option <? if ($sent == "0"){ echo 'selected="selected"'; } ?> value = "0">NO</option>
</select>

&nbsp;&nbsp;&nbsp;
<input name='search' type="submit" value="Search" />
<br /><br />
</form>

<? 

$columns = get_all_buy_moneypaks_promo($sent,true);

if (!is_null($columns)) {

	?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="table_header" align="center">Nickname</td>
		<td class="table_header" align="center">Phone</td>
		<td class="table_header" align="center">email</td>
		<td class="table_header" align="center">date</td>
		<td class="table_header" align="center">Sent</td>
		<td class="table_header" align="center"></td>
	  </tr>
	  
	<? foreach($columns as $col){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>  
	  
	   <tr id="tr_<? echo $col->vars["id"]; ?>">
		  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $col->vars["nickname"] ?></td>
		  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $col->vars["phone"] ?></td>
		  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $col->vars["email"] ?></td>      
		  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $col->vars["tdate"] ?></td>
		  <td  id="td_<? echo $col->vars["id"]; ?>" class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		   <?
			 if ($col->vars["sent"]) {echo "<strong>YES</strong>"; }
			 else { ?>
			  <a class="normal_link" href="javascript:;" onclick="sent_moneypak('<? echo $col->vars["id"] ?>');">
				NO
			</a>	 
			<?  }
		   
			?>
		  
		  </td>
		  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
			<a class="normal_link" href="javascript:;" onclick="delete_moneypak('<? echo $col->vars["id"] ?>');">
				Delete
			</a>	
		  </td>            
	   </tr>
	  
	 <? }  ?> 
	  <tr>
		<td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>
	  </tr>
	 
	  
	 </table> 
<? } else { echo "There are not information";}?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>