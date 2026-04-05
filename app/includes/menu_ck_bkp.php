
<div class="menu" id="menudiv"<?php /*?> style="width:inherit;"<?php */?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
        <a class="menu_link" href="http://localhost:8080/ck/index.php">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
        <? if($current_clerk->im_allow("email_requests")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/email_requests.php">Email Requests</a>&nbsp;&nbsp;&nbsp;&nbsp;
         <? } ?>
        
        
        <? if($current_clerk->im_allow("phone_admin")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/list.php">Lists</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="menu_link" href="http://localhost:8080/ck/names.php">Names</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
        <a class="menu_link" href="http://localhost:8080/ck/webs.php">Websites</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="menu_link" href="http://localhost:8080/ck/rules.php">Rules</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        <? if($current_clerk->im_allow("rules")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/rules.php">Rules</a>&nbsp;&nbsp;&nbsp;&nbsp;
         <? } ?>
		<? if($current_clerk->im_allow("phone_names")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/names.php">Names</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("users") || $current_clerk->admin()) { ?>
        <a class="menu_link" href="http://localhost:8080/ck/clerks.php">Users</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("all_schedules") || $current_clerk->is_manager()){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/schedules.php">SCHEDULES</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <?
		if($current_clerk->admin()){
			?>
			
            <a class="menu_link" href="http://localhost:8080/ck/user_groups.php">Groups</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="http://localhost:8080/ck/list.php">Lists</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="http://localhost:8080/ck/names.php">Names</a>&nbsp;&nbsp;&nbsp;&nbsp;
          
            <a class="menu_link" href="http://localhost:8080/ck/webs.php">Websites</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="http://localhost:8080/ck/rules.php">Rules</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="http://localhost:8080/ck/messages.php" onclick="document.cookie = 'msgdays=; path=/';document.cookie = 'mstitle=; path=/'; ">
            	Messages
            </a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="http://localhost:8080/ck/deposist_report_new.php">Deposits</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="http://localhost:8080/ck/transactions.php">Transactions</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="menu_link" href="settings.php">Settings</a>&nbsp;&nbsp;&nbsp;&nbsp;            
			<?
		}else if($current_clerk->vars["level"]->vars["is_sales"]){
			?>
			<? if($current_clerk->vars["user_group"]->vars["id"] == 15 ){?>
            		<a class="menu_link" href="http://localhost:8080/ck/name_agent_search_new.php">Search</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <? }else{ ?>
            		<a class="menu_link" href="http://localhost:8080/ck/name_search_new.php">Search</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <? } ?>
            
            <iframe frameborder="0" width="1" height="1" scrolling="no" src="http://localhost:8080/ck/process/actions/auto_transfer.php"></iframe>
			<?
			if($current_clerk->vars["level"]->vars["sale_manager"]){
				?>
                <a class="menu_link" href="http://localhost:8080/ck/manage_sales_clerks.php">Clerks</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="menu_link" href="http://localhost:8080/ck/list.php">Lists</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="menu_link" href="http://localhost:8080/ck/leads.php">Manage Leads</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="menu_link" href="http://localhost:8080/ck/names.php">Names</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="menu_link" href="http://localhost:8080/ck/calls.php">Calls</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="menu_link" href="http://localhost:8080/ck/webs.php">Websites</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="menu_link" href="http://localhost:8080/ck/rules.php">Rules</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<?
			}
		}?>
        
        <? if($current_clerk->im_allow("clerks_deposit_report")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/deposist_report_new.php">Deposits</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        <? if($current_clerk->im_allow("clerks_transaction")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/transactions.php">Transactions</a>&nbsp;&nbsp;&nbsp;&nbsp;        
        <? } ?>
        <? if($current_clerk->im_allow("betting_basics")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/betting_index.php">Betting</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        <? if($current_clerk->im_allow("sbo_main_page")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/sbo_index.php">SBO</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if(!$current_clerk->im_allow("sbo_main_page") && $current_clerk->im_allow("sbo_banking")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/sbo_banking.php">SBO Banking</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
             
        <? if($current_clerk->im_allow("expenses_admin")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/expenses_index.php">Expenses</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
          <? if($current_clerk->im_allow("office_expenses")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/office_expenses_index.php">Office's Expenses</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("dj_expenses")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/dj_expenses_index.php">Michael's Expenses</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("credit_accounting")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/credit.php">Credit</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("pph_accounting")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/pph.php">PPH</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("balances")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/balances.php">Balance Sheet</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="menu_link" href="http://localhost:8080/ck/income_statement.php">Income Statement</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        <? if($current_clerk->im_allow("processing_balances")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/processing_balances.php">Processing Balance Sheet</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        <? if($current_clerk->im_allow("pph_balances")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/pph_balances.php">PPH Balance Sheet</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->vars["level"]->vars["is_admin"]){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/admin_clerk_index.php">Phone System</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("affiliate_descriptions")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/affiliates_description.php">AF Comments</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("programmers_book")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/programmers_book.php">Programmers</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("agent_freeplays")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/agent_freeplays.php">AF FreePlays</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("sbo_search_accounts")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/sbo_search_accounts.php">Search SBO Accounts</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("affiliate_leads")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/affiliates_leads.php">AF Leads</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("goals_admin")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/goals.php">Goals</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? }else{ ?>
        <a class="menu_link" href="http://localhost:8080/ck/my_goals.php">My Goals</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("sbo_cashback") && !$current_clerk->im_allow("sbo_main_page")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/sbo_cashback.php">10% Cashback</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("prepaid_transactions")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/prepaid_transactions.php">Prepaid</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("moneypak_transactions")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/moneypak_transactions.php">Moneypak</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        
        
        <? if($current_clerk->im_allow("process_payouts")){ ?>
        <a class="menu_link" href="javascript:;" onMouseOver="submenu_action(1,true,true)"  onMouseOut="submenu_action(1,false,true)">Payouts</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="subbox1" id="sub1" style="display:none;margin-top: -5px;" onMouseOver="submenu_action(1,true,false)"  onMouseOut="submenu_action(1,false,false)">
        	<a class="menu_link" href="http://localhost:8080/ck/bitcoins_payouts.php">
            	Bitcoin Payouts (<? echo count(search_bitcoins_payouts("", "", "pe", "ac")); ?>)
            </a><br />
            <a class="menu_link" href="http://localhost:8080/ck/prepaid_payouts.php">
            	Prepaid Payouts (<? echo count(search_prepaid_payouts("", "", "pe", "ac")); ?>)
            </a><br />
            <a class="menu_link" href="http://localhost:8080/ck/paypal_payouts.php">
            	Paypal Payouts (<? echo count(search_paypal_payouts("", "", "pe", "ac")); ?>)
            </a><br />
            <a class="menu_link" href="http://localhost:8080/ck/cash_transfer_payouts.php">
            	Cash Transfer Payouts (<? echo count(search_cash_transfer_payouts_for_process("", "")); ?>)
            </a><br />
            <a class="menu_link" href="http://localhost:8080/ck/special_payouts.php">
            	Special Payouts (<? echo count(search_special_payouts_for_process("", "", "pe", "ac")); ?>)
            </a><br />
            <a class="menu_link" href="http://localhost:8080/ck/moneyorder_payouts.php">
            	Money Order Payouts (<? echo count(search_moneyorder_payouts_for_process("", "")); ?>)
            </a><br />
            <a class="menu_link" href="http://localhost:8080/ck/moneypak_limbos.php">
           	 Moneypak Payouts (<? echo count(get_waiting_mp_payouts()); ?>)
            </a><br />
            <a class="menu_link" href="http://localhost:8080/ck/local_payouts.php">
            	Local Cash Payouts (<? echo count(get_local_cash_payouts_for_process()); ?>)
            </a><br />
        </div>
        <? } ?>
        
        <? if(!$current_clerk->im_allow("sbo_main_page") && $current_clerk->im_allow("special_deposits")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/special_deposit.php">Special Deposits</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="menu_link" href="http://localhost:8080/ck/special_payout.php">Special Payouts</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if((!$current_clerk->im_allow("sbo_main_page")) && (($current_clerk->im_allow("balance_adjustment")) || ($current_clerk->im_allow("balance_disbursements")) || ($current_clerk->im_allow("balance_receipt")))){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/balance_manager.php">Balance Manager</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
        <? } ?>
        
     
   
  
   <? if(!$current_clerk->im_allow("sbo_main_page") && $current_clerk->im_allow("reverse_transactions")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/reverse_transactions.php">Reverse Transactions</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
        <? } ?>
  
     <? if($current_clerk->im_allow("rec_issues")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/rec_issues.php">Rec Issues</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        
        <? // PPH tickets was replaced by department tickets 2013-11-12
		/* if($current_clerk->im_allow("pph_tickets")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/pph_tickets.php">PPH Tickets</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } */ ?>
        
         
        <a class="menu_link" href="http://localhost:8080/ck/department_tickets.php">Tickets</a>&nbsp;&nbsp;&nbsp;&nbsp;
       
        
        <? if($current_clerk->im_allow("tickets")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/tickets.php"> Email Tickets</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("tickets_clerk")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/tickets_clerk.php">Tickets Clerk</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("cs_logs")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/cs_logs.php" target="_blank">C.S. Logs</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        <? if($current_clerk->im_allow("durango_create")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/durango_create_name.php" target="_blank">Add Durango Name</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
                
        <a class="menu_link" href="http://localhost:8080/ck/reports.php">Reports</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
        <a class="menu_link" href="http://localhost:8080/ck/players_reports.php">Players Reports</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
        <a class="menu_link" href="http://localhost:8080/ck/crm_reports.php">CRM Reports</a>&nbsp;&nbsp;&nbsp;&nbsp;
        
        <!--Processing-->
        <? if($current_clerk->im_allow("sbo_processing_clerk") && ! $current_clerk->im_allow("sbo_processing_admin")){ ?>
            <? $sbo_clerk_on = true; ?>
            <a class="menu_link" href="javascript:;" onclick="document.getElementById('f1').submit()">
                SBO Processing
            </a>&nbsp;&nbsp;&nbsp;&nbsp;      		
        <? } ?>
        <? if($current_clerk->im_allow("sbo_processing_admin")){ ?>
            <? $sbo_admin_on = true; ?>
            <a class="menu_link" href="javascript:;" onclick="document.getElementById('f2').submit()">
                SBO Processing
            </a>&nbsp;&nbsp;&nbsp;&nbsp;      		
        <? } ?>
        
        <? if($current_clerk->im_allow("php_processing_clerk")){ ?>
            <? $php_clerk_on = true; ?>
            <a class="menu_link" href="javascript:;" onclick="document.getElementById('f4').submit()">
                PHP Processing
            </a>&nbsp;&nbsp;&nbsp;&nbsp;      		
        <? } ?>
        <? if($current_clerk->im_allow("php_processing_admin")){ ?>
            <? $php_admin_on = true; ?>
            <a class="menu_link" href="javascript:;" onclick="document.getElementById('f5').submit()">
                PHP Processing
            </a>&nbsp;&nbsp;&nbsp;&nbsp;      		
        <? } ?>
        
        <? if($current_clerk->im_allow("vrb_processing_admin")){ ?>
            <? $vrb_admin_on = true; ?>
            <a class="menu_link" href="javascript:;" onclick="document.getElementById('f3').submit()">
                VRB Processing
            </a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        <? if($current_clerk->im_allow("baseball_file")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/baseball_file/report.php">Baseball</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
		<? if($current_clerk->im_allow("tweets")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/tweets_index.php">Tweets</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        		<? if($current_clerk->im_allow("prepaid_test")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/prepaid_test.php">Prepaid Test</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        
        <? if($current_clerk->im_allow("cc_cashback")){ ?>
        <a class="menu_link" href="http://localhost:8080/ck/cc_cashback.php">CC ChargeBack</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <? } ?>
        
        
        
        <? if($sbo_clerk_on){ ?>
            <form id="f1" name="f1" method="post" action="https://www.ezpay.com/process/login/login-process.php" target="_blank">
            <input name="email" type="hidden" id="email_login" value="clerk@sportsbettingonline.com" />
            <input name="pass" type="hidden" id="pass" value="1234567" />
          	<input name="no_fail" type="hidden" id="no_fail" value="1" />
            <input name="internal" type="hidden" id="internal" value="1" />
            <input name="clerk_id" type="hidden" id="clerk_id" value="<? echo $current_clerk->vars["id"] ?>" />
            
          	</form>
        <? } ?>
        <? if($sbo_admin_on){ ?>
            <form id="f2" name="f2" method="post" action="https://www.ezpay.com/process/login/login-process.php" target="_blank">
            <input name="email" type="hidden" id="email_login" value="admin@sportsbettingonline.com" />
            <input name="pass" type="hidden" id="pass" value="mainlineposse" />
          	<input name="no_fail" type="hidden" id="no_fail" value="1" />
            <input name="internal" type="hidden" id="internal" value="1" />
            <input name="clerk_id" type="hidden" id="clerk_id" value="<? echo $current_clerk->vars["id"] ?>" />
          	</form>
        <? } ?>
        <? if($vrb_admin_on){ ?>            
      		<form id="f3" name="f3" method="post" action="https://www.ezpay.com/process/login/login-process.php" target="_blank">
            <input name="email" type="hidden" id="email_login" value="admin@vrbmarketing.com" />
            <input name="pass" type="hidden" id="pass" value="VRB7777" />
          	<input name="no_fail" type="hidden" id="no_fail" value="1" />
            <input name="internal" type="hidden" id="internal" value="1" />
            <input name="clerk_id" type="hidden" id="clerk_id" value="<? echo $current_clerk->vars["id"] ?>" /> 
          	</form>
        <? } ?>
        <? if($php_clerk_on){ ?>            
      		<form id="f4" name="f4" method="post" action="https://www.ezpay.com/process/login/login-process.php" target="_blank">
            <input name="email" type="hidden" id="email_login" value="clerk@pph.ag" />
            <input name="pass" type="hidden" id="pass" value="VRB7777" />
          	<input name="no_fail" type="hidden" id="no_fail" value="1" />
            <input name="internal" type="hidden" id="internal" value="1" />
            <input name="clerk_id" type="hidden" id="clerk_id" value="<? echo $current_clerk->vars["id"] ?>" /> 
          	</form>
        <? } ?>
        <? if($php_admin_on){ ?>            
      		<form id="f5" name="f5" method="post" action="https://www.ezpay.com/process/login/login-process.php" target="_blank">
            <input name="email" type="hidden" id="email_login" value="admin@pph.ag" />
            <input name="pass" type="hidden" id="pass" value="VRB7777" />
          	<input name="no_fail" type="hidden" id="no_fail" value="1" />
            <input name="internal" type="hidden" id="internal" value="1" />
            <input name="clerk_id" type="hidden" id="clerk_id" value="<? echo $current_clerk->vars["id"] ?>" />
          	</form>
        <? } ?>
        <!--End Processing-->
    </td>
    <td style="text-align:right;">
		<a class="menu_link" href="http://localhost:8080/process/login/logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
</table>
</div>
<div style="font-size:12px; font-weight:normal; text-align:right; font-weight:bold; margin-top:3px; position:">
	<? echo date("Y-m-d / h:i:s a"); ?> ET
</div>
<script type="text/javascript">
function submenu_action(box, on, setpos){
	var boxdiv = document.getElementById("sub"+box)
	var menudiv = document.getElementById("menudiv");
	var menusize = menudiv.parentNode.style.width;
	if(menusize == "100%"){menusize = browser_width();}else{menusize = 970;}
	if(setpos){
		boxdiv.style.marginLeft = (window.event.clientX - ((browser_width() - menusize)/2) - 40)+"px";
	}
	if(on){sdis = "block";}
	else{sdis = "none";}
	boxdiv.style.display = sdis;
}
function browser_width(){
	if(window.innerHeight !==undefined)A= window.innerWidth; // most browsers
	else{ // IE varieties
	var D= (document.body.clientWidth)? document.body: document.documentElement;
	A= D.clientWidth;	
	}
	return A;
}
</script>
