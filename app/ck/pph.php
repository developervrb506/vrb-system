<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
if(isset($_GET["change_home"])){
	$upagn = get_pph_account($_GET["aid"]);
	$upagn->vars["house"] = $_GET["change_home"];
	$upagn->update();
	exit(); //exit to run in hidden iframe
}
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upagn = get_pph_account($_POST["update_id"]);
		$upagn->vars["name"] = $_POST["name"];
		$upagn->vars["description"] = $_POST["description"];
		$upagn->vars["phone_price"] = $_POST["phone_price"];
		$upagn->vars["internet_price"] = $_POST["internet_price"];
		$upagn->vars["liveplus_price"] = $_POST["liveplus_price"];
		$upagn->vars["horsesplus_price"] = $_POST["horsesplus_price"];
		$upagn->vars["propsplus_price"] = $_POST["propsplus_price"];
		$upagn->vars["payment_method"] = $_POST["payment_method"];
		$upagn->vars["livecasino_price"] = $_POST["livecasino_price"];
		$upagn->vars["base_price"] = $_POST["base_price"];
		$upagn->vars["max_players"] = $_POST["max_players"];
		
		$upagn->vars["balance_alert"] = $_POST["balance_alert"];		
		
		$upagn->vars["person_name"] = $_POST["person_name"];
		$upagn->vars["phone"] = $_POST["phone"];
		$upagn->vars["city"] = $_POST["city"];
		$upagn->vars["state"] = $_POST["state"];
		$upagn->vars["pph_agent"] = $_POST["pph_agent"];
		$upagn->vars["master_agent"] = $_POST["master_agent"];
		$upagn->vars["house"] = $_POST["house"];
		
		$upagn->vars["is_commission"] = $_POST["is_commission"];
		$upagn->vars["commission_owner"] = $_POST["commission_owner"];
		if(!$upagn->vars["is_commission"]){$upagn->vars["commission_owner"] = 0;}
		
		$upagn->update();
		$setid = $upagn ->vars["id"];
		
	}else{
		$newagn = new _pph_account();
		$newagn->vars["name"] = $_POST["name"];
		$newagn->vars["description"] = $_POST["description"];
		$newagn->vars["phone_price"] = $_POST["phone_price"];
		$newagn->vars["internet_price"] = $_POST["internet_price"];
		$newagn->vars["liveplus_price"] = $_POST["liveplus_price"];
		$newagn->vars["livecasino_price"] = $_POST["livecasino_price"];
		$newagn->vars["horsesplus_price"] = $_POST["horsesplus_price"];
		$newagn->vars["propsplus_price"] = $_POST["propsplus_price"];
		$newagn->vars["payment_method"] = $_POST["payment_method"];
		$newagn->vars["base_price"] = $_POST["base_price"];
		$newagn->vars["max_players"] = $_POST["max_players"];
		
		$newagn->vars["balance_alert"] = $_POST["balance_alert"];	
		
		$newagn->vars["person_name"] = $_POST["person_name"];
		$newagn->vars["phone"] = $_POST["phone"];
		$newagn->vars["city"] = $_POST["city"];
		$newagn->vars["state"] = $_POST["state"];
		$newagn->vars["pph_agent"] = $_POST["pph_agent"];
		$newagn->vars["master_agent"] = $_POST["master_agent"];
		$newagn->vars["house"] = $_POST["house"];
		
		$newagn->vars["is_commission"] = $_POST["is_commission"];
		$newagn->vars["commission_owner"] = $_POST["commission_owner"];
		if(!$newagn->vars["is_commission"]){$newagn->vars["commission_owner"] = 0;}
		
		$newagn->insert();
		$setid = $newagn ->vars["id"];
	}
	
	delete_all_cashier_methods_by_agent($setid);
	$pkeys = array_keys($_POST);
	foreach($pkeys as $pk){
		if(contains_ck($pk,"cashierm_") && $_POST[$pk] == 1){
			$mid = str_replace("cashierm_","",$pk);
			insert_cashier_method_by_agent($setid, $mid);
		}	
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>PPH Accounts</title>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>

</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<? 
if(isset($_GET["detail"])){
	//details
	$agent = get_pph_account($_GET["acc"]);
	if(is_null($agent)){
		$title = "Add new Account";
	}else{
		$title = "Edit Account";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$agent->vars["id"] .'" />';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"name",type:"null", msg:"Name is required"});
	validations.push({id:"phone_price",type:"numeric", msg:"Phone Price is required"});
	validations.push({id:"internet_price",type:"numeric", msg:"Internet Price is required"});
    </script>
	<div class="form_box" style="width:400px;">
    	
        <form method="post" action="pph.php?e=39&br=1" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <?
		//$data = json_decode(file_get_contents("http://cashier.vrbmarketing.com/utilities/process/actions/admin/get_all_methods.php"),true);	
		$methods = json_decode(file_get_contents("http://cashier.vrbmarketing.com/utilities/api/basic/list.php"),true);
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Account</td>
            <td><input name="name" type="text" id="name" value="<? echo $agent->vars["name"] ?>" /></td>
          </tr>
          <tr>
            <td>Balance Alert</td>
            <td><input name="balance_alert" type="text" id="balance_alert" value="<? echo $agent->vars["balance_alert"] ?>" /></td>
          </tr> 
          <tr>
            <td>Phone Price</td>
            <td><input name="phone_price" type="text" id="phone_price" value="<? echo $agent->vars["phone_price"] ?>" /></td>
          </tr> 
          <tr>
            <td>Internet Price</td>
            <td><input name="internet_price" type="text" id="internet_price" value="<? echo $agent->vars["internet_price"] ?>" /></td>
          </tr> 
          <tr>
            <td>Live+ Price</td>
            <td><input name="liveplus_price" type="text" id="liveplus_price" value="<? echo $agent->vars["liveplus_price"] ?>" /></td>
          </tr> 
          
          <?php /*?><tr>
            <td>Horses+ Price</td>
            <td><input name="horsesplus_price" type="text" id="horsesplus_price" value="<? echo $agent->vars["horsesplus_price"] ?>" /></td>
          </tr> <?php */?>
          
          <tr>
            <td>Props+ Price</td>
            <td><input name="propsplus_price" type="text" id="propsplus_price" value="<? echo $agent->vars["propsplus_price"] ?>" /></td>
          </tr>
          
          <tr>
            <td>Payment Method</td>
            <td>
            	<select name="payment_method" id="payment_method">
                	<option value="">None</option>
                    <option value="Cash pick up">Cash pick up</option>
                    <? foreach($methods["deposit"] as $pm){ ?>
                    <option value="<? echo $pm["name"] ?>" <? if($agent->vars["payment_method"] == $pm["name"]){ echo 'selected="selected"';} ?>> <? echo $pm["name"] ?> </option> 
                    <? } ?>
                </select>
            </td>
          </tr> 
          
          <tr>
            <td>Person Name</td>
            <td><input name="person_name" type="text" id="person_name" value="<? echo $agent->vars["person_name"] ?>" /></td>
          </tr>
          <tr>
            <td>Phone</td>
            <td><input name="phone" type="text" id="phone" value="<? echo $agent->vars["phone"] ?>" /></td>
          </tr>
          <tr>
            <td>City</td>
            <td><input name="city" type="text" id="city" value="<? echo $agent->vars["city"] ?>" /></td>
          </tr>
          <tr>
            <td>State</td>
            <td><input name="state" type="text" id="state" value="<? echo $agent->vars["state"] ?>" /></td>
          </tr>
          <tr>
            <td>PPH Agent</td>
            <td><input name="pph_agent" type="text" id="pph_agent" value="<? echo $agent->vars["pph_agent"] ?>" /></td>
          </tr>
          <tr>
            <td>Master Agent</td>
            <? $all_agents = get_all_pph_accounts(); ?>
            <td><? create_objects_list("master_agent", "master_agent", $all_agents, "id", "name", "None", $agent->vars["master_agent"]) ?></td>
          </tr> 
          <tr>
            <td>House Agent:</td>
            <td>
            	<select name="house" id="house">
                	<option value="0">No</option>
                    <option value="1" <? if($agent ->vars["house"]){ echo 'selected="selected"';} ?>>Yes</option> 
                </select>
            </td>
          </tr>
          
          <tr>
            <td>Commission Acc:</td>
            <td>
            	<select name="is_commission" id="is_commission" onchange="$('#commrow').toggle(500);">
                	<option value="0">No</option>
                    <option value="1" <? if($agent ->vars["is_commission"]){ echo 'selected="selected"';} ?>>Yes</option> 
                </select>
            </td>
          </tr>
          
          <tr <? if(!$agent ->vars["is_commission"]){ ?> style="display:none" <? } ?> id="commrow">
            <td>Commission Owner</td>
            <? $nc_agents = search_pph_accounts("","0","0"); ?>
            <td><? create_objects_list("commission_owner", "commission_owner", $nc_agents, "id", "name", "-- Select --", $agent->vars["commission_owner"]) ?></td>
          </tr> 
          
          
          <?php /*?><tr>
            <td>Live Casino Price</td>
            <td><input name="livecasino_price" type="text" id="livecasino_price" value="<? echo $agent->vars["livecasino_price"] ?>" /></td>
          </tr> <?php */?>
          <tr>
            <td>Base Price</td>
            <td><input name="base_price" type="text" id="base_price" value="<? echo $agent->vars["base_price"] ?>" /></td>
          </tr> 
          <tr>
            <td>Max Players</td>
            <td><input name="max_players" type="text" id="max_players" value="<? echo $agent->vars["max_players"] ?>" /></td>
          </tr> 
          <tr>
            <td>Description</td>
            <td><textarea name="description" cols="40" rows="10" id="description"><? echo $agent->vars["description"] ?></textarea></td>
          </tr>
          <tr>
            <td colspan="100">
            	<a href="javascript:;" class="normal_link" onclick="$('.cmethods').toggle(500);">Cashier Methods Used</a> 
            </td>
          </tr>
          <? $my_methods = get_cashier_methods_by_agent($agent->vars["id"]); ?>
          <? foreach($methods["deposit"] as $dm){ ?>
          <tr  class="cmethods" style="display:none;">
            <td><? echo $dm["name"] ?>:</td>
            <td>
            	<select name="cashierm_<? echo $dm["id"] ?>" id="cashierm_<? echo $dm["id"] ?>">
                	<option value="0">No</option>
                    <option value="1" <? if(!is_null($my_methods[$dm["id"]])){ echo 'selected="selected"';} ?>>Yes</option> 
                </select>
            </td>
          </tr>
          <? } ?>
          
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
	//list
	?>
    <span class="page_title">PPH</span><br /><br />
    
    <p><strong>Admin</strong><br />
    <a href="?detail" class="normal_link">+ Add Account</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_transaction.php" class="normal_link" rel="shadowbox;height=420;width=405">New Transaction</a>
    
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_expense.php" class="normal_link" rel="shadowbox;height=420;width=405">New Expense</a>
    
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_reverse.php" class="normal_link" rel="shadowbox;height=350;width=405">Reverse Bill</a>
    
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_bill.php" class="normal_link" rel="shadowbox;height=480;width=405">New Bill</a>
    
    <? if($current_clerk->im_allow("intersystem_transactions")){ ?>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="intersystem_transaction.php" class="normal_link" rel="shadowbox;height=470;width=430">New Intersystem Transaction</a>
    <? } ?>
    <? if($current_clerk->im_allow("pph_ticker")){ ?>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_ticker_message.php" class="normal_link" rel="shadowbox;height=470;width=830">PPH Ticker Message</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="agents_messages.php" class="normal_link" rel="shadowbox;height=470;width=830">Agents Messages</a>
    <? } ?>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="hidden_agents_cashier.php" class="normal_link">Remove Cashier From Agent</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="new_feature.php" class="normal_link">New Features Notes</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="sports_headlines.php" class="normal_link">Sports Headlines</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?= BASE_URL ?>/ck/agent_manager/agent_index.php" class="normal_link">Agent Manager</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <? /* <a href="<?= BASE_URL ?>/ck/agent_money_line_blocker.php" class="normal_link">Agent Money Blocker</a> */?>
     <a href="<?= BASE_URL ?>/ck/agent_money_line_blocker_sport.php" class="normal_link">Agent Money Blocker</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="<?= BASE_URL ?>/ck/agent_period_blocker.php" class="normal_link">Agent Period Blocker</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?= BASE_URL ?>/ck/pph_videos_view.php" class="normal_link">Videos PPH Sites</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?= BASE_URL ?>/ck/manage_backends.php" class="normal_link">Agent Backends</a>

	<?php /*?><? if($current_clerk->im_allow("backend_permissions")){ ?>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?= BASE_URL ?>/ck/manage_backend_permissions.php" class="normal_link">Backend Permissions</a>
    <? } ?><?php */?>
    </p>
    <p>
    <strong>Reports</strong><br />
     <a href="pph_agent_phone_web_2014.php" class="normal_link">Phone vs Web 2014</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
     <a href="pph_agent_phone_web.php" class="normal_link">Phone vs Web</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
     <a href="pph_agent_livebetting.php" class="normal_link">Live / Props Count</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
     <a href="pph_report.php" class="normal_link">Transaction Report</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_bill_report.php" class="normal_link">Billing Report</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_current_bill_report.php" class="normal_link">Current Billing Report</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="?br=1" class="normal_link">Balance Report</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_reconciliation_report.php" class="normal_link">Reconciliation Report</a>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="agent_hold_percentage.php" class="normal_link">Agent Hold Percentage</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="pph_cashier_methods_report.php" class="normal_link">Cashier Methods by Agent</a>
    </p>
    
    
     <br /><br />
	<? include "includes/print_error.php" ?>  
    <? if($_GET["br"]){ ?>
     <iframe width="1" height="1" id="ichanger" name="ichanger" frameborder="0"></iframe>
     
    <p>
    Show:
    	<? $show_type = param("show"); ?>
    	<select name="" onchange="location.href = 'pph.php?br=1&show='+this.value;">
        	<option value="h">House</option>
            <option value="a" <? if($show_type == "a"){ ?> selected="selected" <? } ?> >Active</option> php
            <option value="d" <? if($show_type == "d"){ ?> selected="selected" <? } ?>>Deleted</option>
            <option value="l" <? if($show_type == "l"){ ?> selected="selected" <? } ?>>All</option>
        </select>
    
    </p>
     
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Account</td>
        <td class="table_header" align="center">Balance</td>
        <td class="table_header" align="center">Balance<br />Alert</td>
        <td class="table_header" align="center">Phone<br />Price</td>
        <td class="table_header" align="center">Internet<br />Price</td>
        <td class="table_header" align="center">Live+<br />Price</td>
        <?php /*?><td class="table_header" align="center">Horses+<br />Price</td><?php */?>
        <td class="table_header" align="center">Props+<br />Price</td>
        <td class="table_header" align="center">Payment<br />Method</td>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center" width="125">Phone</td>
        <td class="table_header" align="center">City</td>
        <td class="table_header" align="center">State</td>
        <td class="table_header" align="center">PPH Agent</td>
        <td class="table_header" align="center">Master</td>
        <td class="table_header" align="center">Comm</td>
        <td class="table_header" align="center">House</td>
        <?php /*?><td class="table_header" align="center">Live Casino<br />Price</td>
        <td class="table_header" align="center">Base<br />Price</td>
        <td class="table_header" align="center">Max<br />Payers</td><?php */?>
        <td class="table_header" align="center">Description</td>
        <td class="table_header" align="center">Edit</td>
        <td class="table_header" align="center">Delete</td>
        <td class="table_header" align="center">Payments</td>
      </tr>
      <?
	  $i=0;
	   
	   switch($show_type){ 
		  case "a":
			  $agents = search_pph_accounts("","0");
		  break;
		  case "l":
			  $agents = search_pph_accounts();
		  break;
		  case "d":
			  $agents = search_pph_accounts("","1");
		  break;
		  default :
			  $agents = search_pph_accounts(1,"0");
		  break;
	  }
	  
	  $groups = array();
	  
	  foreach($agents as $agent){
		  $groups[$agent ->vars["master_agent"]][$agent ->vars["id"]] = $agent;
	  }
	  
	  //move masters to its group
	  foreach($groups[0] as $master){
		 //if(count($groups[$master ->vars["id"]])>0){
		   if(!empty($groups[$master ->vars["id"]])){	 
			 array_unshift($groups[$master ->vars["id"]], $master);
			 unset($groups[0][$master ->vars["id"]]);
		 }
	  }
	  
	   $total_balance = 0;
	   
	   foreach($groups as $grp){
	   
		   $subtotal = 0;
		   foreach($grp as $acc){
			   if($i % 2){$style = "1";}else{$style = "2";}
			   $i++;
			   $total_balance += $acc->vars["balance"];
			  ?>
			  
			  <? $subtotal += $acc->vars["balance"]; ?>
			  
			  
			  <tr>
				<td class="table_td<? echo $style ?>" align="center" <? echo $bold ?>><? echo $acc->vars["name"]; ?></td>
				<td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["balance"]); ?></td>
                <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["balance_alert"]; ?></td>
				<td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["phone_price"]); ?></td>
				<td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["internet_price"]); ?></td>
				<td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["liveplus_price"]); ?></td>
                <?php /*?><td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["horsesplus_price"]); ?></td><?php */?>
                <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["propsplus_price"]); ?></td>
                <td class="table_td<? echo $style ?>" align="center"><? echo ($acc->vars["payment_method"]); ?></td>
				<td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["person_name"]; ?></td>
				<td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["phone"]; ?></td>
				<td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["city"]; ?></td>
				<td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["state"]; ?></td>
				<td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["pph_agent"]; ?></td>
				<td class="table_td<? echo $style ?>" align="center"><? echo $agents[$acc->vars["master_agent"]] ->vars["name"]; ?></td> 
				<td class="table_td<? echo $style ?>" align="center"><? echo $agents[$acc->vars["commission_owner"]] ->vars["name"]; ?></td> 
				<td class="table_td<? echo $style ?>" align="center"> 
					<?php /*?><input name="" type="checkbox" value="1" <? if($acc ->vars["house"]){ ?> checked="checked" <? } ?> onclick='document.getElementById("ichanger").src = "pph.php?change_home="+(this.checked*1)+"&aid=<? echo $acc->vars["id"]; ?>";' /><?php */?>
					<? echo yesno_boolean($acc ->vars["house"]); ?>
				</td>
				<?php /*?><td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["livecasino_price"]); ?></td>
				<td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($acc->vars["base_price"]); ?></td>
				<td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["max_players"]; ?></td><?php */?>
				<td class="table_td<? echo $style ?>" align="center"><? echo nl2br($acc->vars["description"]); ?></td>
				<td class="table_td<? echo $style ?>" align="center">
					<a href="?detail&acc=<? echo $acc->vars["id"]; ?>" class="normal_link">Edit</a>
				</td>
				<td class="table_td<? echo $style ?>" align="center">
				
					<? if($acc ->vars["deleted"]){ ?>
						
						<a href="javascript:;" onclick="if(confirm('Are you sure you want to undelete this account?')){location.href='process/actions/delete_pph_account.php?ac=<? echo $acc->vars["id"]; ?>'}" class="normal_link">UnDelete</a>
						
					<? }else{ ?>
					
						<a href="javascript:;" onclick="if(confirm('Are you sure you want to delete this account?')){location.href='process/actions/delete_pph_account.php?ac=<? echo $acc->vars["id"]; ?>'}" class="normal_link">Delete</a>
					
					<? } ?>
				
					
				</td>
				<td class="table_td<? echo $style ?>" align="center"><a target="_blank" href="pph_report.php?acc=<? echo $acc->vars["id"]; ?>&from=<? echo date("Y-m-d",strtotime(date("Y-m-d")." -6 months")) ?>&to=<? echo date("Y-m-d") ?>" class="normal_link">View</a></td>
			  </td>
		  <? } ?>
          
          <tr>
            <td class="table_header" align="center">Subtotal</td>
            <td class="table_header" align="center">$<? echo basic_number_format($subtotal); ?></td>
            <td class="table_header" align="center" colspan="1000"></td>
          </tr>
          <tr>
            <td colspan="1000" style="height:20px;"></td>
          </tr>
      
      <? } ?>
      
      <tr>
        <td class="table_header" align="center">TOTAL</td>
        <td class="table_header" align="center">$<? echo basic_number_format($total_balance) ?></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"><?php /*?><a href="javascript:;" onclick="location.href = location.href" class="normal_link">Refresh</a><?php */?></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
      </tr>
  
    </table>
    <? } ?>
    <?

}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>