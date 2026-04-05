<div class="menu_ezpay">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    	<a class="menu_link" href="index.php">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
		<?
        if($wuloged_admin){
            ?><? if(!$pclerk){ ?> <a class="menu_link" href="names.php">Names</a>&nbsp;&nbsp;&nbsp;&nbsp;<? } ?><?
        }
        else{
            ?><a class="menu_link" href="names_new.php">Deposits</a>&nbsp;&nbsp;&nbsp;&nbsp;<?
			if($current_customer->batch){ ?><a class="menu_link" href="batchs.php">Batch Deposits</a>&nbsp;&nbsp;&nbsp;&nbsp;<? }
			?><a class="menu_link" href="send_new.php">Payout</a>&nbsp;&nbsp;&nbsp;&nbsp;<?
        }
        ?>
		<? if($current_customer->is_manager){ ?> <a class="menu_link" href="report_index.php">Reports</a>&nbsp;&nbsp;&nbsp;&nbsp; <? } ?>
        <? if($wuloged_admin && !$pclerk){ ?> <!--<a class="menu_link" href="names_today.php">Today's names</a>&nbsp;&nbsp;&nbsp;&nbsp;--> <? } ?>
        <? if(!$wuloged_admin){ ?>  <!--<a class="menu_link" href="receive.php">New Deposit</a>&nbsp;&nbsp;&nbsp;&nbsp;--><? } ?>
        <? if($no_clerk || $wuloged_admin){ ?>  
        
			<? if(!$wuloged_admin){ ?>
            
            <a class="menu_link" href="request_payment.php">Bankwire</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- <a class="menu_link" href="request_payment.php?send">Send Payment</a>&nbsp;&nbsp;&nbsp;&nbsp; -->
            
            <? }elseif($super_admin){ ?>
            <a class="menu_link" href="admin_trans.php">Payouts</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="manual_deposit.php">New Deposit</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="customers.php">Customers</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="processors.php">Processors</a>&nbsp;&nbsp;&nbsp;&nbsp;
           <!-- <a class="menu_link" href="settings.php">Settings</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
            <? } ?>
            <? if(!$pclerk){ ?> <a class="menu_link" href="report_index.php">Reports</a>&nbsp;&nbsp;&nbsp;&nbsp; <? } ?>
            <? if(!$wuloged_admin){ ?> 
            <a class="menu_link" href="user_profile.php">Profile</a>&nbsp;&nbsp;&nbsp;&nbsp; 
            <? } ?>       
        <? } ?>
        
    </td>
    <td style="text-align:right;">
		<a class="menu_link" href="../process/login/logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
</table>
</div>
<div style="font-size:12px; font-weight:normal; text-align:right; font-weight:bold; margin-top:3px;">
	<? echo date("Y-m-d / h:i:s A"); ?>
</div>
