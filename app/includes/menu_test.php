<div class="menu" id="menudiv">
<div id="menu_header">
 <ul class="nav">
     <? // VRB MENU  ?>
	       
    <li><a href= "">VRB</a>
    <ul>
             
			 <li><a href= "http://localhost:8080/ck/index.php">HOME</a></li>
			 <? if($current_clerk->im_allow("users") || $current_clerk->admin()) { ?>
             <li><a href= "http://localhost:8080/ck/clerks.php">Users</a></li>
             <? } ?>
             
			 <? if($current_clerk->admin()){ ?>
             <li><a href= "http://localhost:8080/ck/user_groups.php">Groups</a></li>
             <? } ?>
             
			 <? if($current_clerk->im_allow("all_schedules") || $current_clerk->is_manager()){ ?>
             <li><a href= "http://localhost:8080/ck/schedules.php">Schedules</a></li>
             <? } ?>
             
			 <? if($current_clerk->admin()){ ?>
              <li><a href= "http://localhost:8080/ck/messages.php">MESSAGES</a></li>
             <? } ?>
             
			 <? if($current_clerk->admin()){ ?>
             <li><a href= "settings.php">IPs</a></li>
             <? } ?>
           
             <? if($current_clerk->im_allow("rules") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"] ){ ?>
             <li><a href= "http://localhost:8080/ck/rules.php">Rules</a></li>
             <? } ?>  
             
             <? if($current_clerk->im_allow("goals_admin")){ ?>
              <li><a href= "http://localhost:8080/ck/goals.php">GOALS</a></li>
             <? }else{ ?> 
              <li><a href="http://localhost:8080/ck/my_goals.php" >MY GOALS</a></li>
             <? } ?>    
    </ul></li> 
       
    <? // SBO ?> 
    <li><a href= "">SBO</a>
     <ul>
       <? if($current_clerk->im_allow("sbo_main_page")){ ?>
             <li><a href= "http://localhost:8080/ck/sbo_index.php">SBO Home</a></li>
        <? } ?>
        <? if(!$current_clerk->im_allow("sbo_main_page")){ ?>
                <? if($current_clerk->im_allow("sbo_cashback")) { ?>
                 <li><a href= "http://localhost:8080/ck/sbo_cashback.php">10% Cashback</a></li>
                <? } ?>
                
				<? if($current_clerk->im_allow("special_deposits")) { ?>
                <li><a href= "http://localhost:8080/ck/special_deposit.php">Special Deposits</a></li>
                <? } ?>
                
				<? if($current_clerk->im_allow("special_deposits")) { ?>
                <li><a href= "http://localhost:8080/ck/special_payout.php">Special Payouts</a></li>
                <? } ?>
                
				<? if(($current_clerk->im_allow("balance_adjustment")) || ($current_clerk->im_allow("balance_disbursements")) || ($current_clerk->im_allow("balance_receipt"))){ ?>
                <li><a href= "http://localhost:8080/ck/balance_manager.php">Balance Manager</a></li>
                <? } ?>
                
                 <? if($current_clerk->im_allow("sbo_banking")){ ?>
                <li><a href= "http://localhost:8080/ck/sbo_banking.php">SBO BANKING</a></li>
                <? } ?>
                
				<? if($current_clerk->im_allow("reverse_transactions")){ ?>
                <li><a href= "http://localhost:8080/ck/reverse_transactions.php">Reverse Transactions</a></li>
                 <? } ?>
         <? } ?>     
      </ul></li>
    
      <? // PPH ?>
      <li><a href= "">PPH</a>
      <ul>  
            <? if($current_clerk->im_allow("pph_accounting")){ ?>
              <li><a href= "http://localhost:8080/ck/pph.php">PPH</a></li>
            <? } ?>  
      </ul></li>
      
      <? // Accounting ?>
      <li><a href= "">Acounting</a>
      
      <ul>  
            <? if($current_clerk->im_allow("credit_accounting")){ ?>
              <li><a href= "http://localhost:8080/ck/credit.php">CREDIT</a></li>
      
            <? } ?> 
            
            <? if($current_clerk->im_allow("balances")){ ?>
              <li><a href= "http://localhost:8080/ck/balances.php">BALANCE SHEET</a></li>
            <? } ?>  
            
             <? if($current_clerk->im_allow("balances")){ ?>
              <li><a href= "http://localhost:8080/ck/income_statement.php">INCOME STATEMENT</a></li>
             <? } ?>  
             
             <? if($current_clerk->im_allow("processing_balances")){ ?>
             <li><a href= "http://localhost:8080/ck/processing_balances.php">PROCESING BALANCE SHEET</a></li>    <? } ?>
             
              <? if($current_clerk->im_allow("pph_balances")){ ?>
              <li><a href= "http://localhost:8080/ck/pph_balances.php">PPH BALANCE SHEET</a></li> 
              <? } ?>
            
      </ul></li>
       
      
      <? // Transactions Menu ?>
   
	 <li><a href= "">Transactions</a>
       <ul>  
           <? if($current_clerk->im_allow("prepaid_test")){ ?>
             <li><a href= "http://localhost:8080/ck/prepaid_test.php">PREPAID TEST</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("prepaid_transactions")){ ?>
            <li><a href= "http://localhost:8080/ck/prepaid_transactions.php">PREPAID</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("moneypak_transactions")){ ?>
            <li><a href= "http://localhost:8080/ck/moneypak_transactions.php">MONEYPAK</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("cc_cashback")){ ?>
              <li><a href= "http://localhost:8080/ck/cc_cashback.php">CC CHARGEBACK</a></li>
           <? } ?>
      </ul>
    </li>
    
    
    <? // Expenses Menu ?>
       <li><a href= "">Expenses</a>
        <ul>
           <? if($current_clerk->im_allow("dj_expenses")){ ?>
            <li><a href= "http://localhost:8080/ck/dj_expenses_index.php">Michael's Expenses</a></li>
           <? } ?>
          
           <? if($current_clerk->im_allow("office_expenses")){ ?>
             <li><a href= "http://localhost:8080/ck/office_expenses_index.php">Office's Expenses</a></li>
          <? } ?>
         
           <? if($current_clerk->im_allow("expenses_admin")){ ?>
             <li><a href= "http://localhost:8080/ck/expenses_index.php">Expenses</a></li>
           <? } ?>
       
       </ul>
      </li>
    
  
     <? // CRM Menu  ?>
       <li><a href= "">CRM</a>
       <ul>
             <? if($current_clerk->admin() || $current_clerk->im_allow("clerks_deposit_report")){ ?>
              <li><a href= "http://localhost:8080/ck/deposist_report_new.php">DEPOSITS</a></li>
             <? } ?>
			
             <? if($current_clerk->admin() || $current_clerk->im_allow("clerks_transaction")){ ?>
              <li><a href= "http://localhost:8080/ck/transactions.php">TRANSACTIONS</a></li>
             <? } ?>
			
			 <? if($current_clerk->im_allow("phone_admin") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"] ){ ?>
              <li><a href= "http://localhost:8080/ck/list.php">LIST</a></li>
             <? } ?>
           
              
              <? if($current_clerk->im_allow("email_requests")){ ?>
               <li><a href= "http://localhost:8080/ck/email_requests.php">Email Request</a></li>
              <? } ?>  
              
			  <? if($current_clerk->im_allow("phone_names") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"]){ ?>
                <li><a href= "http://localhost:8080/ck/names.php">NAMES</a></li>
              <? } ?>
              
              <? if($current_clerk->vars["level"]->vars["is_sales"]){ ?>
               
                  <? if($current_clerk->vars["user_group"]->vars["id"] == 15 ){ ?>
                    <li><a href= "http://localhost:8080/ck/name_agent_search_new.php">SEARCH</a></li>
				  <? }
                   else{ ?>
                    <li><a href= "http://localhost:8080/ck/name_search_new.php">SEARCH</a></li>
                 <? } ?>
			 <? } ?>
             
			 <? if($current_clerk->vars["level"]->vars["sale_manager"]){ ?>
			  <li><a href= "http://localhost:8080/ck/manage_sales_clerks.php">CLERKS</a></li>
             <? } ?>
            
			 <? if($current_clerk->vars["level"]->vars["sale_manager"]){ ?>
			   <li><a href= "http://localhost:8080/ck/calls.php">CALLS</a></li>
             <? } ?>
             
             <? if($current_clerk->vars["level"]->vars["sale_manager"]){ ?>
              <li><a href= "http://localhost:8080/ck/leads.php">MANAGE LEADS</a></li>
             <? } ?> 
             
             <? if($current_clerk->vars["level"]->vars["is_admin"]){ ?> 
               <li><a href= "http://localhost:8080/ck/admin_clerk_index.php">PHONE SYSTEM</a></li>
             <? } ?> 
             
             <? if($current_clerk->im_allow("cs_logs")){ ?>
               <li><a href= "http://localhost:8080/ck/cs_logs.php">CS LOGS</a></li>
             <? } ?> 
             
			 <? if($current_clerk->im_allow("durango_create")){ ?>
              <li><a href= "http://localhost:8080/ck/durango_create_name.php">DURANGO NAME</a></li>
             <? } ?>
          
             <? if($current_clerk->im_allow("phone_admin") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"]){ ?>
               <li><a href= "http://localhost:8080/ck/webs.php">WEBSITES</a></li>
             <? } ?> 
            
       </ul>
    </li>
    
   
    
    <? // Affiliates Menu ?>
	
    <li><a href= "">AFFILIATES</a>
     <ul>
         <? if($current_clerk->im_allow("affiliate_descriptions")){ ?>
             <li><a href= "http://localhost:8080/ck/affiliates_description.php">AF COMMENTS </a></li>
         <? } ?>
        
         <? if($current_clerk->im_allow("agent_freeplays")){ ?>
             <li><a href= "http://localhost:8080/ck/agent_freeplays.php">AF FREELAYS</a></li>
         <? } ?>
         
         <? if($current_clerk->im_allow("affiliate_leads")){ ?>
             <li><a href= "http://localhost:8080/ck/affiliates_leads.php">AF LEADS</a></li>
         <? } ?>
      
     </ul>
    </li>

    
    <? // Tickets Menu ?>
	<li><a href= "">TICKETS</a>
    <ul>
          <li><a href= "http://localhost:8080/ck/department_tickets.php">TICKETS</a></li>
		  
		  <? if($current_clerk->im_allow("rec_issues")){ ?>
             <li><a href= "http://localhost:8080/ck/rec_issues.php">REC ISSUES </a></li>
          <? } ?> 
          
          <? if($current_clerk->im_allow("tickets")){ ?> 
             <li><a href= "http://localhost:8080/ck/tickets.php">EMAIL TICKETS</a></li>
          <? } ?>              
    
     </ul>
    </li>  
    
     <? // Payouts ?>
      <li><a href= "">Payouts</a>
      <ul>  
            <? if($current_clerk->im_allow("process_payouts")){ ?>
               <li><a href= "http://localhost:8080/ck/bitcoins_payouts.php">BITCOINS (<? echo count(search_bitcoins_payouts("", "", "pe", "ac")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/prepaid_payouts.php">PREPAID (<? echo count(search_prepaid_payouts("", "", "pe", "ac")) ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/paypal_payouts.php">PAYPAL (<? echo count(search_paypal_payouts("", "", "pe", "ac")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/cash_transfer_payouts.php">CASHTRANSFER (<? echo count(search_cash_transfer_payouts_for_process("", "")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/special_payouts.php">SPECIAL (<? echo count(search_special_payouts_for_process("", "", "pe", "ac")) ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/moneyorder_payouts.php">MONEYORDER (<? echo count(search_moneyorder_payouts_for_process("", "")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/moneypak_limbos.php">MONEYPAK (<? echo count(get_waiting_mp_payouts()); ?>)</a></li>               
               <li><a href= "http://localhost:8080/ck/local_payouts.php">LOCALCASH  (<? echo count(get_local_cash_payouts_for_process()); ?>)</a></li>
            <? } ?>   
      </ul>
     </li>
     
    
     <? // Systems Menu  ?>
     <li><a href= "">Systems</a>
      <ul>
           <? if($current_clerk->im_allow("baseball_file")){ ?>
             <li><a href= "http://localhost:8080/ck/baseball_file/report.php">BASEBALL </a></li>
           <? } ?>
          
           <? if($current_clerk->im_allow("tweets")){ ?>
             <li><a href= "http://localhost:8080/ck/tweets_index.php">TWEETS</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("programmers_book")){ ?>
             <li><a href= "http://localhost:8080/ck/programmers_book.php">PROGRAMMER BOOK</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("betting_basics")){ ?> 
     <li><a href= "http://localhost:8080/ck/betting_index.php">Betting</a></li>
           <? } ?>  
        
     </ul>
    </li>  

   
    <li><a href= "">REPORTS</a>
       <ul>
                         
              <li><a href= "http://localhost:8080/ck/crm_reports.php">CRM REPORTS</a></li>
              
              <li><a href= "http://localhost:8080/ck/reports.php">REPORTS</a></li>
                     
              <li><a href= "http://localhost:8080/ck/players_reports.php">Players REPORTS</a></li>
                  
       </ul>
    </li>
    
    <? // EZPAY Menu ?>
	 
    <li><a href= "">EZPAY</a>
     <ul>
       
        <? if($current_clerk->im_allow("sbo_processing_clerk") && ! $current_clerk->im_allow("sbo_processing_admin")){ ?>
             <? $sbo_clerk_on = true; ?>
             <li><a class="menu_link" href="javascript:;" onclick="document.getElementById('f1').submit()">SBO Processing</a></li>
        <? } ?>
        
        <? if($current_clerk->im_allow("sbo_processing_admin")){ ?>
             <? $sbo_admin_on = true; ?>
             <li><a class="menu_link" href="javascript:;" onclick="document.getElementById('f2').submit()">SBO PROCESING </a></li>  
        <? } ?> 
           
        <? if($current_clerk->im_allow("php_processing_clerk")){ ?>
            <? $php_clerk_on = true; ?>
            <li><a class="menu_link" href="javascript:;" onclick="document.getElementById('f4').submit()">PPH PROCESING</a></li>
        <? } ?>
        
        <? if($current_clerk->im_allow("php_processing_admin")){ ?>
            <? $php_admin_on = true; ?>         
           <li><a class="menu_link" href="javascript:;" onclick="document.getElementById('f5').submit()">PPH PROCESING</a></li>
        <? } ?>
            
         <? if($current_clerk->im_allow("vrb_processing_admin")){ ?>
            <? $vrb_admin_on = true; ?>
            <li><a class="menu_link" href="javascript:;" onclick="document.getElementById('f3').submit()">VRB PROCESING</a></li>
         <? } ?>

     </ul>
    </li>
    
    <li><a href= "">LOGOUT</a></li>
    
    

  </ul>
</div>
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
