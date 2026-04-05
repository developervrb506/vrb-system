<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("method_regular_player")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>



<title>Method's Regular Players</title>

</head>
<body>
<? $page_style = " width:1200px;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;"><br /><br />
<span class="page_title">Method's Regular Players</span><br /><br />
<?
$method = $_GET["method"];
$type = $_GET["type"];
if($method == ""){$method = "western"; $type="P";}
?>
<form method="get">
Method:
<select name="method" >
 <option <? if ($method == "western"){ echo 'selected="selected"'; }?> value="western">Western Union</option>
 <option <? if ($method == "moneygram"){ echo 'selected="selected"'; }?>value="moneygram">Moneygram</option> 
 <option <? if ($method == "amazon"){ echo 'selected="selected"'; }?>value="amazon">Amazon Gift Card</option>  
 <option <? if ($method == "bank_to"){ echo 'selected="selected"'; }?>value="bank_to">Bank to Bank</option>  
 <option <? if ($method == "wire"){ echo 'selected="selected"'; }?>value="wire">Bank Wire</option>  
 <option <? if ($method == "bitcoins"){ echo 'selected="selected"'; }?>value="bitcoins">Bitcoins</option>     
 <option <? if ($method == "credit"){ echo 'selected="selected"'; }?>value="credit">Credit Card</option>  
 <option <? if ($method == "wallet"){ echo 'selected="selected"'; }?>value="wallet">Google Wallet</option>       
 <option <? if ($method == "liberty"){ echo 'selected="selected"'; }?>value="liberty">Liberty</option>        
 <option <? if ($method == "manual_credit"){ echo 'selected="selected"'; }?>value="manual_credit">Manual Credit Card</option>         
 <option <? if ($method == "money_order"){ echo 'selected="selected"'; }?>value="money_order">Money Order</option>  
 <option <? if ($method == "prepaid_gift"){ echo 'selected="selected"'; }?>value="prepaid_gift">Prepaid Gift Card</option>           
 <option <? if ($method == "paypal_to_paypal"){ echo 'selected="selected"'; }?>value="paypal_to_paypal">Paypal to Paypal</option>            
 <option <? if ($method == "paypal_cash"){ echo 'selected="selected"'; }?>value="paypal_cash">Paypal Cash</option> 
 <option <? if ($method == "special"){ echo 'selected="selected"'; }?>value="special">Special</option>              
 <option <? if ($method == "vanilla"){ echo 'selected="selected"'; }?>value="vanilla">Vanilla</option>               
</select>
Type:
<select name="type" >
 <option <? if ($type == "D"){ echo 'selected="selected"'; }?>value="D">Payouts</option>
 <option <? if ($type == "R"){ echo 'selected="selected"'; }?>value="R">Deposit</option> 
</select>
<input type="submit" value="Search" />
</form>
<br /><br />
<?
$data = "?m=".$method."&t=".$type;
?>

<? include "includes/print_error.php" ?> 
 
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_method_regular_player.php".$data); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>