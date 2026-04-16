<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
if(isset($_GET["change_home"])){
	$upagn = get_pph_account_test($_GET["aid"]);
	$upagn->vars["house"] = $_GET["change_home"];
	$upagn->update();
	exit(); //exit to run in hidden iframe
}
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upagn = get_pph_account_test($_POST["update_id"]);
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
		$newagn = new _pph_account_test();
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
	$agent = get_pph_account_test($_GET["acc"]);
	if(is_null($agent)){
		$title = "Add new Account";
	}else{
		$title = "Edit Account";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$agent->vars["id"] .'" />';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js?v=2"></script>
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
            <? $all_agents = get_all_pph_accounts_test(); ?>
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
   

	<?php /*?><? if($current_clerk->im_allow("backend_permissions")){ ?>
     &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?= BASE_URL ?>/ck/manage_backend_permissions.php" class="normal_link">Backend Permissions</a>
    <? } ?><?php */?>
    </p>

	<? include "includes/print_error.php" ?>  
    <? if(!$_GET["br"]){ ?>
     <iframe width="1" height="1" id="ichanger" name="ichanger" frameborder="0"></iframe>
     
    <p>
    
    
    </p>
     
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Account</td>
        <td class="table_header" align="center">Balance</td>

       
      </tr>
      <?
	  $i=0;
	   $show_type = "l";
	   switch($show_type){ 
		  case "a":
			  $agents = search_pph_accounts_test("","0");
		  break;
		  case "l":
			  $agents = search_pph_accounts_test();
		  break;
		  case "d":
			  $agents = search_pph_accounts_test("","1");
		  break;
		  default :
			  $agents = search_pph_accounts_test(1,"0");
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
      
        
      </tr>
  
    </table>
    <? } ?>
    <?

}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>