<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<?
$preusers = array();
$preusers[] = array("name"=>"Frank","email"=>"eldorado007@gmail.com");
$preusers[] = array("name"=>"Kevin","email"=>"plutopluto113@hotmail.com");
$preusers[] = array("name"=>"Michael","email"=>"davejohnson000@hotmail.com");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">var BASE_URL = "<?= BASE_URL ?>";</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"system_list_from",type:"null", msg:"Please Select a System"});
	validations.push({id:"from_account",type:"null", msg:"Please Select an Account"});
	validations.push({id:"system_list_to",type:"null", msg:"Please Select a System"});
	validations.push({id:"to_account",type:"null", msg:"Please Select an Account"});
	validations.push({id:"amount",type:"numeric", msg:"Please Write a valid Amount"});
</script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">New Transaction</span><br /><br />
<div class="form_box">
	<form method="post" onsubmit="return validate(validations)" action="process/actions/insert_intersystem_action.php" target="_parent">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>From:</td>
        <td>
            <?
            $select_option = true;
            $extra_name = "_from";
            $system_change = "load_system_accounts('from_div', this.value, 'from_account', 1)";
            include("includes/systems_list.php");
            ?>
            <br /><div id="from_div"><input type="hidden" value="" name="from_account" id="from_account" /></div>
        </td>
      </tr>
      <tr>
        <td>To:</td>
        <td>
            <?
            $select_option = true;
            $extra_name = "_to";
            $system_change = "load_system_accounts('to_div', this.value, 'to_account', 1)";
            include("includes/systems_list.php");
            ?>
            <br /><div id="to_div"><input type="hidden" value="" name="to_account" id="to_account" /></div>
        </td>
      </tr>
      <tr>
        <td>Amount:</td>
        <td><input name="amount" type="text" id="amount" size="5" /></td>
      </tr>
      <tr>
        <td>Note:</td>
        <td><textarea name="note" id="note"></textarea></td>
      </tr>
      <tr>
        <td>Notification to:</td>
        <td>
        	<? foreach($preusers as $us){ ?>
            	<? echo $us["name"] ?> <input name="emails[]" type="checkbox" value="<? echo $us["email"] ?>" /> 
            <? } ?>
            <br />
        	<input name="other" type="text" id="other" /><br />
            <span style="font-size:11px;">Ex. test1@some.com,vrb@test.com</span>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input name="" type="submit" value="Submit" /></td>
      </tr>
    </table>
	</form>
</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>