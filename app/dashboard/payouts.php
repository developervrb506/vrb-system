<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Payouts</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<? $way = $_GET["w"]; ?>
<? $balance = str_replace("$","",get_wagerweb_customer_balance(get_affiliate_code($current_affiliate->id,1))); ?>
<div class="page_content" style="padding-left:20px; display:inline-block; width:928px;">

    <div class="left_column" style="width:150px;">    
        <div style="cursor:pointer; float:none;" class="gray_box" onclick="location.href = 'payouts.php'"><strong>Payout Policies</strong></div>
        <?php /*?><div style="cursor:pointer; float:none;" class="gray_box" onclick="location.href = 'payouts.php?w=neteller'"><strong>Neteller</strong></div><?php */?>
        <div style="cursor:pointer; float:none;" class="gray_box" onclick="location.href = 'payouts.php?w=moneybookers'"><strong>Moneybookers</strong></div>
        <div style="cursor:pointer; float:none;" class="gray_box" onclick="location.href = 'payouts.php?w=westernunion'"><strong>Western Union</strong></div>
        <div style="cursor:pointer; float:none;" class="gray_box" onclick="location.href = 'payouts.php?w=moneygram'"><strong>MoneyGram</strong></div>
        <div style="cursor:pointer; float:none;" class="gray_box" onclick="location.href = 'payouts.php?w=cashierscheck'"><strong>Cashiers Check</strong></div>
    </div>
    
    <div class="right_column" style="width:750px;">
    	<span class="error"><? if (isset($_GET["e"])) { echo "<br />" . get_error($_GET["e"]) . "<br /><br />"; }?></span>        
        <div class="conte_banners" style="margin-top:25px;">
        <?
		switch ($way) {
			/*case "neteller":
				?>
                <div class="conte_banners_header"><strong>Neteller</strong> </div>
                <div style="font-size:12px; padding:20px;">
                	<script type="text/javascript">
					validations.push({id:"amount",type:"numeric", msg:"Please Wrtie a valid Amount"});
					validations.push({id:"amount",type:"smaller:balance", msg:"You don't have enough balance"});
					validations.push({id:"account",type:"null", msg:"Please Wrtie the NETeller Account ID"});
					</script>
                    <form method="post" action="../process/actions/request_payout_action.php" onsubmit="return validate(validations);">
                    <input name="type" type="hidden" id="type" value="neteller" />
                	<table width="300" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Your Balance (USD):</td>
                        <td width="100"><input name="balance" type="text" id="balance" readonly="readonly" value="<? echo $balance ?>" /><br /></td>
                      </tr>
                      <tr>
                        <td>Payout Amount (USD):</td>
                        <td width="100"><input name="amount" type="text" id="amount" /><br /></td>
                      </tr>
                      <tr>
                        <td>NETeller Account ID:</td>
                        <td><input name="account" type="text" id="account" /></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="text-align:right;"><input name="" type="submit" value="Submit" /></td>
                      </tr>
                    </table>
                    </form>
			     	<br /><br /> 
                    <strong>Terms & Conditions:</strong><br /><br /> 
                    <ul>
                        <li>Free Monthly Payout maximum is $1,000.</li><br />
                        <li>If you have already used your (1) free monthly payout, you will incur in a $20 processing fee for the next one.</li><br />
                        <li>Confirmation will be provided by 5:00pm EST if request is submitted before 11:00am EST. </li><br />
                        <li>If request is submitted after 11:00am EST payout is processed the following business day.</li>
                    </ul>
                </div>
                <?
				break;*/
			case "moneybookers":
				?>
                <div class="conte_banners_header"><strong>Moneybookers</strong> </div>
                <div style="font-size:12px; padding:20px;">
                	<script type="text/javascript">
					validations.push({id:"amount",type:"numeric", msg:"Please Wrtie a valid Amount"});
					validations.push({id:"amount",type:"smaller:balance", msg:"You don't have enough balance"});
					validations.push({id:"email",type:"email", msg:"Please Wrtie a valid Email"});
					</script>
                    <form method="post" action="../process/actions/request_payout_action.php" onsubmit="return validate(validations);">
                    <input name="type" type="hidden" id="type" value="moneybookers" />
                	<table width="350" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Your Balance (USD):</td>
                        <td width="100"><input name="balance" type="text" id="balance" readonly="readonly" value="<? echo $balance ?>" /><br /></td>
                      </tr>
                      <tr>
                        <td>Payout Amount (USD):</td>
                        <td width="100"><input name="amount" type="text" id="amount" /><br /></td>
                      </tr>
                      <tr>
                        <td>Email registered with MB:</td>
                        <td><input name="email" type="text" id="email" /></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="text-align:right;"><input name="" type="submit" value="Submit" /></td>
                      </tr>
                    </table>
                    </form>
                    <br /><br /> 
                    <strong>Terms & Conditions:</strong><br /><br /> 
                    <ul>
                        <li>Payout Limit: $1,000 max. per week.</li><br />
                        <li>If you have already used your (1) free monthly payout, you will incur in a $20 processing fee for the next one.</li><br /> 
                        <li>Confirmation will be provided by 5:00pm EST if request is submitted before 11:00am EST. </li><br />
                        <li>If request is submitted after 11:00am EST payout is processed the following business day.</li>
                    </ul>
                </div>
                <?
				break;
			case "westernunion":
				?>
                <div class="conte_banners_header"><strong>Western Union</strong> </div>
                <div style="font-size:12px; padding:20px;">
                    <script type="text/javascript">
					validations.push({id:"amount",type:"numeric", msg:"Please Wrtie a valid Amount"});
					validations.push({id:"amount",type:"smaller:balance", msg:"You don't have enough balance"});
					</script>
                    <form method="post" action="../process/actions/request_payout_action.php" onsubmit="return validate(validations);">
                    <input name="type" type="hidden" id="type" value="westernunion" />
                	<table width="350" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Your Balance (USD):</td>
                        <td width="100"><input name="balance" type="text" id="balance" readonly="readonly" value="<? echo $balance ?>" /><br /></td>
                      </tr>
                      <tr>
                        <td>Payout Amount (USD):</td>
                        <td width="100"><input name="amount" type="text" id="amount" /><br /></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="text-align:right;"><input name="" type="submit" value="Submit" /></td>
                      </tr>
                    </table>
                    </form>
                    <br /><br /> 
                    <strong>Terms & Conditions:</strong><br /><br /> 
                    <ul>
                        <li>Processing fees on a Free Payout will be credited as a "free play".  </li><br />
                        <li>Payout Limit: $500 max. per week.</li><br />
                        <li>Confirmation will be provided by 5:00pm EST if request is submitted before 11:00am EST. </li><br /> 
                        <li>If you have already used your (1) free monthly payout,  you will be charged processing fees for the next one: <br />
							$1-$250	$50<br />
							$251-$500	$65
                        </li>
                    </ul>
                </div>
                <?
				break;
			case "moneygram":
				?>
                <div class="conte_banners_header"><strong>MoneyGram</strong> </div>
                <div style="font-size:12px; padding:20px;">
                     <script type="text/javascript">
					validations.push({id:"amount",type:"numeric", msg:"Please Wrtie a valid Amount"});
					validations.push({id:"amount",type:"smaller:balance", msg:"You don't have enough balance"});
					</script>
                    <form method="post" action="../process/actions/request_payout_action.php" onsubmit="return validate(validations);">
                    <input name="type" type="hidden" id="type" value="moneygram" />
                	<table width="350" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Your Balance (USD):</td>
                        <td width="100"><input name="balance" type="text" id="balance" readonly="readonly" value="<? echo $balance ?>" /><br /></td>
                      </tr>
                      <tr>
                        <td>Payout Amount (USD):</td>
                        <td width="100"><input name="amount" type="text" id="amount" /><br /></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="text-align:right;"><input name="" type="submit" value="Submit" /></td>
                      </tr>
                    </table>
                    </form>
                     <br /><br /> 
                    <strong>Terms & Conditions:</strong><br /><br /> 
                    <ul>
                        <li>Processing fees on a Free Payout will be credited as a "free play".  </li><br />
                        <li>Payout Limit: $800 max. per week.</li><br />
                        <li>If you have already used your (1) free monthly payout,  you will be charged processing fees for the next one: <br />
							$1-$250	$50<br />
							$251-$500 $65<br />
							$501-$1000 $80
                        </li>
                    </ul>
                </div>
                <?
				break;
			case "cashierscheck":
				?>
                <div class="conte_banners_header"><strong>Cashiers Check</strong> </div>
                <div style="font-size:12px; padding:20px;">
                    <script type="text/javascript">
					validations.push({id:"amount",type:"numeric", msg:"Please Wrtie a valid Amount"});
					validations.push({id:"amount",type:"smaller:balance", msg:"You don't have enough balance"});
					validations.push({id:"name",type:"null", msg:"Please Wrtie the Payee Name"});
					validations.push({id:"address",type:"null", msg:"Please Wrtie your Address"});
					validations.push({id:"city",type:"null", msg:"Please Wrtie your City"});
					validations.push({id:"state",type:"null", msg:"Please Wrtie your State / Province"});
					validations.push({id:"country",type:"null", msg:"Please Wrtie your Country"});
					validations.push({id:"zip",type:"null", msg:"Please Wrtie your Zip Code"});
					</script>
                    <form method="post" action="../process/actions/request_payout_action.php" onsubmit="return validate(validations);">
                    <input name="type" type="hidden" id="type" value="cashierscheck" />
                	<table width="350" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Your Balance (USD):</td>
                        <td width="100"><input name="balance" type="text" id="balance" readonly="readonly" value="<? echo $balance ?>" /><br /></td>
                      </tr>
                      <tr>
                        <td>Payout Amount (USD):</td>
                        <td width="100"><input name="amount" type="text" id="amount" /><br /></td>
                      </tr>
                      <tr>
                        <td>Payee Name:</td>
                        <td><input name="name" type="text" id="name" /></td>
                      </tr>
                      <tr>
                        <td>Address:</td>
                        <td><input name="address" type="text" id="address" /></td>
                      </tr>
                      <tr>
                        <td>City:</td>
                        <td><input name="city" type="text" id="city" /></td>
                      </tr>
                      <tr>
                        <td>State / Province:</td>
                        <td><input name="state" type="text" id="state" /></td>
                      </tr>
                      <tr>
                        <td>Country:</td>
                        <td><input name="country" type="text" id="country" /></td>
                      </tr>
                      <tr>
                        <td>Zip Code:</td>
                        <td><input name="zip" type="text" id="zip" /></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="text-align:right;"><input name="" type="submit" value="Submit" /></td>
                      </tr>
                    </table>
                    </form>
                    <br /><br /> 
                    <strong>Terms & Conditions:</strong><br /><br /> 
                    <ul>
                        <li>Payout Limit: $3,000 max. per month.</li><br />
                        <li>If you have already used your (1) free monthly payout, you will be charged a $65 processing fee for the next one. (US & Canada)
</li><br />
                        <li>Package can take up to 2 weeks to arrive.</li>
                    </ul>
                </div>
                <?
				break;
			default:
        		?>
                <div class="conte_banners_header" style="width:250px;"><strong>Wagerweb Payout Policies</strong> </div>
                <div style="font-size:12px; padding:20px;">
                    Payouts are sent out only upon request.  Payouts can be sent weekly, but fees will only be covered for one per month. <br /><br /> 
                    <strong>Terms & Conditions:</strong><br /><br /> 
                    <ul>
                        <li>Minimum payout amount is $50.</li><br />
                        <li>To be eligible for a payout affiliates must have an active account. (visibly promoting WagerWeb)</li><br />
                        <li>Multiple payouts over a 30 day period will incur a small processing fee.  </li>
                    </ul>
                </div>
                <?
		}
		?>
        </div>
    
    </div>

</div>
<? include "../includes/footer.php" ?>