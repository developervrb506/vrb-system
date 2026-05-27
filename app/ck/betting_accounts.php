<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upacc = get_betting_account($_POST["update_id"]);
		$upacc->vars["name"] = $_POST["name"];		
		$upacc->vars["autobet"] = $_POST["autobet"];
		$upacc->vars["description"] = $_POST["description"];
		$upacc->vars["agent"] = $_POST["betting_agents_list"];
		$upacc->vars["bank"] = $_POST["betting_banks_list"];
		$upacc->vars["comment"] = $_POST["comment"];
		$upacc->vars["available"] = $_POST["available"];
		$upacc->update();
	}else{
		if(is_null(get_betting_account_by_name($_POST["name"]))){
			$newacc = new _betting_account();
			$newacc->vars["name"] = $_POST["name"];			
			$newacc->vars["autobet"] = $_POST["autobet"];
			$newacc->vars["description"] = $_POST["description"];
			$newacc->vars["agent"] = $_POST["betting_agents_list"];			
			$newacc->vars["bank"] = $_POST["betting_banks_list"];
			$newacc->vars["comment"] = $_POST["comment"];
			$newacc->insert();			
		}else{
			header("Location: betting_accounts.php?e=61&detail");
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Accounts</title>
<script type="text/javascript" src="includes/js/bets.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<? 
if(isset($_GET["detail"])){
	//details
	$account = get_betting_account($_GET["acc"]);
	if(is_null($account)){
		$title = "Add new Account";
	}else{
		$title = "Edit Account";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$account->vars["id"] .'" />';
		$read_name = 'readonly="readonly"';
		$extra_action = "&detail&acc=".$account->vars["id"];
		$edit = true;
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"name",type:"null", msg:"Number is required"});
	validations.push({id:"description",type:"numeric", msg:"Percentage is required"});
    </script>
    <a href="betting_accounts.php" class="normal_link">&lt;&lt; Back to Accounts List</a>
	<div class="form_box" style="width:400px;">
        <form method="post" action="betting_accounts.php?e=39<? echo $extra_action ?>" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>        
		<table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Name</td>
            <td colspan="2"><input name="name" <? echo $read_name ?> type="text" id="name" value="<? echo $account->vars["name"] ?>" onkeyup="make_upper(this);" /></td>
          </tr>          
          <tr>
            <td>Auto Bet</td>
            <td>
            	<input name="autobet" type="checkbox" id="autobet" value="1" <? if($account->vars["autobet"]){echo 'checked="checked"';} ?> onclick="show_hide('auto_settings')" />
                
            </td>
            <td>
            	<? if($edit){ ?>
            	<a href="betting_accounts_auto_settings.php?aid=<? echo $account->vars["id"] ?>" class="normal_link" rel="shadowbox;height=500;width=600" title="Auto Bet Settings" id="auto_settings" <? if(!$account->vars["autobet"]){echo 'style="display:none;"';} ?>>
                	Settings
                </a>
                <? } ?>
            </td>
          </tr> 
          <tr>
            <td>Percentage</td>
            <td colspan="2"><input name="description" type="text" id="description" value="<? echo $account->vars["description"] ?>" /></td>
          </tr>
          <tr>
            <td>Agent</td>
            <td colspan="2"><? $select_option = false; $current_agent = $account->vars["agent"]->vars["id"]; include "includes/betting_agents_list.php"; ?></td>
          </tr>
          <tr>
            <td>Bank Account</td>
            <td colspan="2"><? $select_option = false; $current_bank = $account->vars["bank"]->vars["id"]; include "includes/betting_banks_list.php"; ?></td>
          </tr>
          <tr>
            <td>Description</td>
            <td colspan="2"><textarea name="comment" id="comment"><? echo $account->vars["comment"] ?></textarea></td>
          </tr> 
          <? if(!is_null($account)){ ?>
          <tr>
            <td colspan="3">
            Show in <strong>Daily Figures Report</strong> 
            <input name="available" type="checkbox" id="available" value="1" <? if($account->vars["available"]){echo 'checked="checked"';} ?> />
            </td>
          </tr>
          <? } ?> 
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
	?>
    <span class="page_title">Betting Accounts</span><br /><br />
    <a href="?detail" class="normal_link">+ Add Account</a><br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Balance</td>
        <td class="table_header" align="center">Perc.</td>
        <td class="table_header" align="center">Agent</td>
        <td class="table_header" align="center">Bank Acc.</td>
        <td class="table_header" align="center">Description</td>
        <td class="table_header" align="center">Edit</td>
        <td class="table_header" align="center">Auto</td>
      </tr>
      <?
	  $i=0;
	   $accounts = get_all_betting_accounts();
	   foreach($accounts as $acc){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? //echo $acc->current_balance(); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["description"]; ?>%</td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["agent"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["bank"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="left" width="200" style="font-size:12px;"><? echo nl2br($acc->vars["comment"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&acc=<? echo $acc->vars["id"]; ?>" class="normal_link">Edit</a>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        <? if($acc->vars["autobet"]){ ?>
        	<a href="betting_accounts_auto_settings.php?aid=<? echo $acc->vars["id"] ?>" class="normal_link" rel="shadowbox;height=500;width=600" title="Auto Bet Settings" id="auto_settings">
                Settings
            </a>
        <? } ?>
        </td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>
      
    <?
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>