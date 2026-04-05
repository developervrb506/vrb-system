<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<? 
if(isset($_GET["edit"])){ 
	$commission = get_commission_relation($_GET["edit"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">

<span class="page_title">Account Commissions</span><br /><br />
<? if(!isset($_POST["store"])){ ?>
<script type="text/javascript" src="includes/js/bets.js"></script>
<? $accounts = get_all_betting_accounts(); ?>
<script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"account",type:"null", msg:"Please Write an Account Number"});
	validations.push({id:"caccount",type:"null", msg:"Please Write a Commission Account Number"});
	validations.push({id:"percentage",type:"numeric", msg:"Please insert the Commission Percentage"});
	
	var accounts = new Array();
	<? foreach($accounts as $acc){ ?>
	accounts.push('<? echo $acc->vars["name"] ?>');
	<? } ?>
</script>
<div class="form_box">
<form action="?done" method="post" onsubmit="return prevalidate_commission(validations);">
	<input name="store" type="hidden" id="store" value="1"  />
    <? if(isset($_GET["edit"])){ ?><input name="edit" type="hidden" id="edit" value="<? echo $commission->vars["id"]  ?>"  /><? } ?>
	<table width="100%" border="0">
      <tr>
        <td>Account:</td>
        <td><input name="account" type="text" id="account" onkeyup="make_upper(this);" value="<? echo $commission->vars["account"]->vars["name"]  ?>" /></td>
      </tr>
      <tr>
        <td>Commission Account:</td>
        <td><input name="caccount" type="text" id="caccount" onkeyup="make_upper(this);" value="<? echo $commission->vars["caccount"]->vars["name"]   ?>" /></td>
      </tr>
      <tr>
        <td>Percentage:</td>
        <td><input name="percentage" type="text" id="percentage" value="<? echo $commission->vars["percentage"]  ?>" /></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
      </tr>
    </table>
</form>
</div>
<? }else{?>
<?
//New code:
$account_obj  = get_betting_account_by_name(clean_get("account"));
$caccount_obj = get_betting_account_by_name(clean_get("caccount"));
//End New code

if(isset($_POST["edit"])){
	$comm = get_commission_relation($_POST["edit"]);
		
	//New code:
	$comm->vars["account"]  = $account_obj->vars["id"];
	$comm->vars["caccount"] = $caccount_obj->vars["id"];
	//End New code
	
	//Original code:	
	//$comm->vars["account"]  = get_betting_account_by_name(clean_get("account"));
	//$comm->vars["caccount"] = get_betting_account_by_name(clean_get("caccount"));	
	//End Original code
	
	$comm->vars["percentage"] = clean_get("percentage");
	$comm->update();
}else{
	$comm = new _betting_commission();
	
	//New code:
	$comm->vars["account"]  = $account_obj->vars["id"];
	$comm->vars["caccount"] = $caccount_obj->vars["id"];
	//End New code
	
	//Original code:
	//$comm->vars["account"]    = get_betting_account_by_name(clean_get("account"));
	//$comm->vars["caccount"]   = get_betting_account_by_name(clean_get("caccount"));
	//End Original code	
	
	$comm->vars["percentage"] = clean_get("percentage");
	
	$comm_account = get_commission_relation_x_account($account_obj->vars["id"],$caccount_obj->vars["id"]);
	
	if(empty($comm_account)){	
	  $comm->insert();
	}else{ ?>
	  <script>
	  alert("This record already exists");	  
	  </script>
    <? }		
}
?>
<script type="text/javascript">parent.location.href = 'betting_commisions.php?e=45';</script>
<? } ?>


</body>
</html>
<? }else{echo "Access Denied";} ?>