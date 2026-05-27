<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="<?= BASE_URL ?>/includes/menu/src/css/sm-core-css.css" rel="stylesheet" type="text/css" />
<link href="<?= BASE_URL ?>/includes/menu/src/css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />

<div class="menu" id="menudiv" style="height:25px">
<div id="menu_header">

 <nav id="main-nav">
      <!-- Sample menu definition -->
      <ul id="main-menu" class="sm sm-blue" style="height:50px">
       <? if (!$current_clerk->im_allow("just_queue_calls")){ ?>   
       
        <li><a href= "javascript:;">Business</a>
          <ul>
          
            <? // Accounting ?>
      			<li><a href= "javascript:;">Acounting</a>
      
      <ul>  
            <? if($current_clerk->im_allow("credit_accounting")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/credit.php">CREDIT</a></li>
      
            <? } ?> 
            
            <? if($current_clerk->im_allow("balances")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/balances.php">BALANCE SHEET</a></li>
            <? } ?>  
            
             <? if($current_clerk->im_allow("balances")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/income_statement.php">INCOME STATEMENT</a></li>
             <? } ?>  
             
             <? if($current_clerk->im_allow("processing_balances")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/processing_balances.php">PROCESING BALANCE SHEET</a></li>    <? } ?>
             
              <? if($current_clerk->im_allow("pph_balances")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/pph_balances.php">PPH BALANCE SHEET</a></li> 
              <? } ?>
            
      </ul></li>
      
     	    <? // CRM Menu  ?>
      			 <li><a href= "javascript:;">CRM</a>
       <ul>
            
          <? if($current_clerk->vars["level"]->vars["sale_manager"] || $current_clerk->im_allow("phone_admin")  || $current_clerk->im_allow("marketing_names") || $current_clerk->im_allow("all_sbo_transactions") || $current_clerk->im_allow("sbo_daily_new_accounts") || $current_clerk->im_allow("sbo_search_accounts") ||$current_clerk->im_allow("first_deposit") || $current_clerk->im_allow("all_sbo_transactions") || $current_clerk->im_allow("sbo_reload") ){?>  
            
             <li><a href="<?= BASE_URL ?>/ck/crm_reports.php">CRM REPORTS</a></li>          
		 <? } ?>
            
              <? if($current_clerk->im_allow("central_phone")  && !$current_clerk->im_allow("phone_admin")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/calls_queue.php">Queue Calls</a></li>   
		   <? } ?>
            
             <? if($current_clerk->admin() || $current_clerk->im_allow("clerks_deposit_report")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/deposist_report_new.php">DEPOSITS</a></li>
             <? } ?>
			
             <? if($current_clerk->admin() || $current_clerk->im_allow("clerks_transaction")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/transactions.php">TRANSACTIONS</a></li>
             <? } ?>
			
			 <? if($current_clerk->im_allow("phone_admin") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"] ){ ?>
              <li><a href="<?= BASE_URL ?>/ck/list.php">LIST</a></li>
             <? } ?>
           
              
              <? if($current_clerk->im_allow("email_requests")){ ?>
               <li><a href="<?= BASE_URL ?>/ck/email_requests.php">Email Request</a></li>
              <? } ?>  
              
			  <? if($current_clerk->im_allow("phone_names") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"]){ ?>
                <li><a href="<?= BASE_URL ?>/ck/names.php">NAMES</a></li>
              <? } ?>
              
              <? if($current_clerk->im_allow("relesed_names")){ ?>
                <li><a href="<?= BASE_URL ?>/ck/relesed_names.php">RELEASED</a></li>
              <? } ?>
              
              <? if($current_clerk->vars["level"]->vars["is_sales"]){ ?>
               
                  <? if($current_clerk->vars["user_group"]->vars["id"] == 15 ){ ?>
                    <li><a href="<?= BASE_URL ?>/ck/name_agent_search_new.php">SEARCH </a></li>
				  <? }
                      else { ?>
                    <li><a href="<?= BASE_URL ?>/ck/name_search_new.php">SEARCH</a></li>
                 <? } ?>
			 <? } ?>
             
             <? if($current_clerk->im_allow("my_lists_crm_search")){ ?>
                <li><a href="<?= BASE_URL ?>/ck/full_name_search_new.php">FIND CRM NAME</a></li>
              <? } ?>
             
			 <? if($current_clerk->vars["level"]->vars["sale_manager"]){ ?>
			  <li><a href="<?= BASE_URL ?>/ck/manage_sales_clerks.php">CLERKS</a></li>
             <? } ?>
            
			 <? if($current_clerk->vars["level"]->vars["sale_manager"]){ ?>
			   <li><a href="<?= BASE_URL ?>/ck/calls.php">CALLS</a></li>
             <? } ?>
             
             <? if($current_clerk->vars["level"]->vars["sale_manager"]){ ?>
              <li><a href="<?= BASE_URL ?>/ck/leads.php">MANAGE LEADS</a></li>
             <? } ?> 
             
             <? if($current_clerk->vars["level"]->vars["is_admin"]){ ?> 
               <li><a href="<?= BASE_URL ?>/ck/admin_clerk_index.php">PHONE SYSTEM</a></li>
             <? } ?> 
             
             <? if($current_clerk->im_allow("cs_logs")){ ?>
               <li><a href="<?= BASE_URL ?>/ck/cs_logs.php">CS LOGS</a></li>
             <? } ?> 
             
			 <? if($current_clerk->im_allow("durango_create")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/durango_create_name.php">DURANGO NAME</a></li>
             <? } ?>
          
             <? if($current_clerk->im_allow("phone_admin") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"]){ ?>
               <li><a href="<?= BASE_URL ?>/ck/webs.php">WEBSITES</a></li>
             <? } ?> 
            
       </ul>
    </li>
    
		    <? // Expenses Menu ?>
       			<li><a href= "">Expenses</a>
        <ul>
           <? if($current_clerk->im_allow("dj_expenses")){ ?>
            <li><a href="<?= BASE_URL ?>/ck/dj_expenses_index.php">Michael's Expenses</a></li>
           <? } ?>
          
           <? if($current_clerk->im_allow("office_expenses")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/office_expenses_index.php">Office's Expenses</a></li>
          <? } ?>
         
           <? if($current_clerk->im_allow("expenses_admin")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/expenses_index.php">Expenses</a></li>
           <? } ?>
       
       </ul>
      </li>
      
     	    <? //Reports?>
     			<li><a href= "javascript:;">REPORTS</a>
       <ul>
                         
              <li><a href="<?= BASE_URL ?>/ck/reports.php">REPORTS</a></li>
              
                                   
              <li><a href="<?= BASE_URL ?>/ck/players_reports.php">Players REPORTS</a></li>
                  
       </ul>
    </li>
    
   		     <? // SBO ?> 
                <li><a href= "javascript:;">SBO</a>
         <ul>
           <? if($current_clerk->im_allow("sbo_main_page")){ ?>
                 <li><a href="<?= BASE_URL ?>/ck/sbo_index.php">SBO Home</a></li>
            <? } ?>
             
           
            <? if($current_clerk->im_allow("player_ip")) { ?>
                 <li><a href="<?= BASE_URL ?>/ck/player_ip.php">Player Ips</a></li>
            <? } ?>
            
            <? if($current_clerk->im_allow("player_security_question")) { ?>
                 <li><a href="<?= BASE_URL ?>/ck/player_security_question.php">Player  Security Question</a></li>
            <? } ?>
            
            
            
            <? if(!$current_clerk->im_allow("sbo_main_page")){ ?>
                    <? if($current_clerk->im_allow("sbo_cashback")) { ?>
                     <li><a href="<?= BASE_URL ?>/ck/sbo_cashback.php">10% Cashback</a></li>
                    <? } ?>
                    
                    <?php /*?><? if($current_clerk->im_allow("special_deposits")) { ?>
                    <li><a href="<?= BASE_URL ?>/ck/special_deposit.php">Special Deposits</a></li>
                    <? } ?>
                    
                    <? if($current_clerk->im_allow("special_deposits")) { ?>
                    <li><a href="<?= BASE_URL ?>/ck/special_payout.php">Special Payouts</a></li>
                    <? } ?><?php */?>
                    
                    <? if(($current_clerk->im_allow("balance_adjustment")) || ($current_clerk->im_allow("balance_disbursements")) || ($current_clerk->im_allow("balance_receipt"))){ ?>
                    <li><a href="<?= BASE_URL ?>/ck/balance_manager.php">Balance Manager</a></li>
                    <? } ?>
                    
                     <? if($current_clerk->im_allow("sbo_banking")){ ?>
                    <li><a href="<?= BASE_URL ?>/ck/sbo_banking.php">SBO BANKING</a></li>
                    <? } ?>
                    
                    <?php /*?><? if($current_clerk->im_allow("reverse_transactions")){ ?>
                    <li><a href="<?= BASE_URL ?>/ck/reverse_transactions.php">Reverse Transactions</a></li>
                     <? } ?><?php */?>
                     
                    <? if($current_clerk->im_allow("agent_draw")){ ?>
                    <li><a href="affiliate_draw_report.php">Affiliate Draw</a></li>
                    <? } ?>
                    
                    <? if($current_clerk->im_allow("affiliate_balance")){ ?>
                    <li><a href="affiliate_balance_report.php">Affiliate Balance Report</a></li>
                    <? } ?>
                     
             <? } ?>  
             
               
                
          </ul></li>
    
      	     <? // PPH ?>
						     <li><a href= "javascript:;">PPH</a>
     		 <ul>  
            <? if($current_clerk->im_allow("pph_accounting")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/pph.php">PPH</a></li>
            <? } ?>  
             <? if($current_clerk->im_allow("live_betting")){ ?>
    		  <li><a class="normal_link" href="live_betting_access.php">Live Betting Access</a></li>
		    <? } ?>
            
      </ul></li>
      
		     <? // Tickets Menu ?>
				<li><a href= "">TICKETS</a>
    <ul>
    
        
         <? if($current_clerk->im_allow("department_tickets") || $current_clerk->admin()){ ?>
          <li><a href="<?= BASE_URL ?>/ck/department_tickets.php">TICKETS</a></li>
		 <? } ?>   
         
		  <? if($current_clerk->im_allow("rec_issues")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/rec_issues.php">REC ISSUES </a></li>
          <? } ?> 
          
          <? if($current_clerk->im_allow("tickets")){ ?> 
             <li><a href="<?= BASE_URL ?>/ck/tickets.php">EMAIL TICKETS</a></li>
          <? } ?> 
          
           <? if($current_clerk->im_allow("tickets_categories")){ ?> 
             <li><a href="<?= BASE_URL ?>/ck/tickets_categories.php">TICKETS CATEGORIES</a></li>
          <? } ?> 
          
           <? if($current_clerk->im_allow("tickets_categories")){ ?> 
             <li><a href="<?= BASE_URL ?>/ck/tickets_feedback.php">FEEDBACKS TICKETS</a></li>
          <? } ?> 
          
          <? if($current_clerk->im_allow("tickets_categories")){ ?> 
             <li><a href="<?= BASE_URL ?>/ck/tickets_broadcast.php">BROADCAST TICKETS</a></li>
          <? } ?> 
          
           <? if($current_clerk->im_allow("programmers_issues")){ ?> 
             <li><a href="<?= BASE_URL ?>/ck/programmers_issues.php">Programmers Issues</a></li>
          <? } ?>              
    
     </ul>
    </li>  
    
	    
    		 <? // VRB ?>   
                <li><a href= "javascript:;">VRB</a>
                <ul>
        
        
    
                 <li><a href="<?= BASE_URL ?>/ck/index.php">HOME</a></li>
                 <? if($current_clerk->im_allow("users") || $current_clerk->admin()) { ?>
                 <li><a href="<?= BASE_URL ?>/ck/clerks.php">Users</a></li>
                 <? } ?>
                 
                 <? if($current_clerk->im_allow("token_generator")){ ?>
                 <li><a href="<?= BASE_URL ?>/ck/token_generator.php">Token Generator</a></li>
                 <? } ?>
                 
                 <? if($current_clerk->im_allow("users") || $current_clerk->admin()){ ?>
                 <li><a href="<?= BASE_URL ?>/ck/user_groups.php">Groups</a></li>
                 <? } ?>
                 
                  <? if($current_clerk->im_allow("group_permissions") || $current_clerk->im_allow("user_permissions")){ ?>
                 <li><a href="javascript:;">Permissions</a>
                  <ul>
                     <? if($current_clerk->im_allow("user_permissions")) { ?>
                     <li><a href="<?= BASE_URL ?>/ck/permissions_user.php"> Users Permissions</a></li>
                     <? } ?>
                    <? if($current_clerk->im_allow("group_permissions")) { ?>
                     <li><a href="<?= BASE_URL ?>/ck/permissions_group.php"> Groups Permissions</a></li>
                     <? } ?>
            
                  </ul>
                 </li>
                 <? } ?>
                 
                 <? if($current_clerk->im_allow("all_schedules") || $current_clerk->is_manager()){ ?>
                 <li><a href="<?= BASE_URL ?>/ck/schedules.php">Schedules</a></li>
                 <? } ?>
                 
                 <? if($current_clerk->admin()){ ?>
                  <li><a href="<?= BASE_URL ?>/ck/messages.php">MESSAGES</a></li>
                 <? } ?>
                 
                 <? if($current_clerk->admin()){ ?>
                 <li><a href= "settings.php">System Settings</a></li>
                 <? } ?>
               
                 <? if($current_clerk->im_allow("rules") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"] ){ ?>
                 <li><a href="<?= BASE_URL ?>/ck/rules.php">Rules</a></li>
                 <? } ?>  
                 
                 <? if($current_clerk->im_allow("goals_admin")){ ?>
                  <li><a href="<?= BASE_URL ?>/ck/goals.php">GOALS</a></li>
                 <? }else{ ?> 
                  <li><a href="<?= BASE_URL ?>/ck/my_goals.php" >MY GOALS</a></li>
                 <? } ?>    
        </ul>
    
      </ul>
      </li> 
        
        
        
      
        <li><a href=" "javascript:;">Systems</a>
          <ul>
          
            <?  //AFFILIATES //?>   
                <? if(($current_clerk->im_allow("affiliates_system")) || ($current_clerk->im_allow("affiliate_descriptions")) || ($current_clerk->im_allow("agent_freeplays")) || ($current_clerk->im_allow("affiliate_leads"))  ){ ?>
             
              
              <li><a href="<?= BASE_URL ?>/ck/affiliates/affiliates_index.php"> AFFILIATES</a></li>
            		   
		   <? } ?>
           
             <?  //AGENTS //?>
       		         
                 <? if($current_clerk->im_allow("agent_manager")){ ?>
                  <li><a href="<?= BASE_URL ?>/ck/agent_manager/agent_index.php">Agent Manager</a></li>   
               <? } ?>
             
            <?  //BETTING //?> 
            
    				     <? if(($current_clerk->im_allow("betting_basics")) || ($current_clerk->im_allow("betting_edge_system")) || ($current_clerk->im_allow("graded_games_checker"))){ ?>
              <li><a href="<?= BASE_URL ?>/ck/betting_index.php">Betting</a>
           <ul> 
           <? if($current_clerk->im_allow("betting_basics")){ ?> 
     		<li><a href="<?= BASE_URL ?>/ck/betting_index.php">Betting System</a></li>
           <? } ?> 
           
            <? if($current_clerk->im_allow("betting_edge_system")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/betting_edge/betting_edge.php">BETTING EDGE </a></li>
           <? } ?>
             </ul>
             </li>
           
          <?  } ?>
          
            <?  //CASHIER //?> 
      		      <? if($current_clerk->im_allow("cashier_admin")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/cashier">Cashier</a></li>   
		   <? } ?>
           
            <?  //CONTEST//?>
         	    <? if($current_clerk->im_allow("march_madness") || $current_clerk->im_allow("braket_admin") ){ ?>
           <li><a href=" "javascript:;">Contest</a>
               <ul>
           
           <? if($current_clerk->im_allow("march_madness")){ ?>
           <li><a href="<?= BASE_URL ?>/ck/add_braket.php">March Madness</a></li> 
           <? } ?>
           
            <? if($current_clerk->im_allow("braket_admin")) { $braket_admin_on = true; ?>
             <li><a href="javascript:;" onclick="document.getElementById('braketlogin').submit()">Bracket</a></li>
        	<? } ?>
             </ul>
             </li>
             
             <? } ?>

            <?  //CREDIT CARDS //?> 
  		         <? if($current_clerk->im_allow("cc_system")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/cc_index.php">Credit Cards</a></li>   
		   <? } ?>
           
             <?  //PROGRAMMERS//?>
 
 		         <? if($current_clerk->im_allow("programmers_book")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/programmers_book.php">PROGRAMMER BOOK</a></li>
           <? } ?>  
           	 
		     <?  //SEO//?>
		   
			    <? if($current_clerk->im_allow("seo_system") || $current_clerk->im_allow("system_metatags") || $current_clerk->im_allow("posting")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/seo_index.php">SEO</a></li>   
		   <? } ?>
                        
             
              <?  //SPORTS//?>
           
          		 <? if($current_clerk->im_allow("baseball_file") || $current_clerk->im_allow("nba_system")  || $current_clerk->im_allow("nhl_system")  || $current_clerk->im_allow("props_system")  || $current_clerk->im_allow("lines_system")  || $current_clerk->im_allow("teams_system") || $current_clerk->im_allow("tweets") || $current_clerk->im_allow("widget_manager") || $current_clerk->im_allow("job_manager") ){ ?>
             <li><a href= "">SPORTS SYSTEM </a>
              <ul>
                <li><a href="">Tools</a>   
                <ul>
                <? if($current_clerk->im_allow("props_system")){ ?>
           		<li>
            	<a href="javascript:;">Props System</a>
                <ul>
                	<li><a href="<?= BASE_URL ?>/ck/props_alerts.php">Alerts Props</a></li>
                	<li><a href="<?= BASE_URL ?>/ck/import_props.php">Import Props</a></li>
                    <li><a href="<?= BASE_URL ?>/ck/import_odds.php">Import Odds</a></li>
                </ul>
            		</li>
           		<? } ?>
			   
                 <? if($current_clerk->im_allow("lines_system")){ ?>
              <li><a href="<?= BASE_URL ?>/ck/sbo_winners.php">Lines</a></li>   
		        <? } ?>
                
                
                 <? if($current_clerk->im_allow("teams_system")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/teams_file/teams_logos.php">TEAM SYSTEM</a></li>
           <? } ?>
          
           <? if($current_clerk->im_allow("tweets")){ ?>
             <li><a href="<?= BASE_URL ?>/ck/tweets_index.php">TWEETS</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("widget_manager")){ ?>
           <li><a href="">WIDGETS MANAGER </a>
                <ul>
                <li ><a href="<?= BASE_URL ?>/ck/widget_manager/events_leagues.php">Events leagues</a></li>
                 <li ><a href="<?= BASE_URL ?>/ck/widget_manager/poker_tweets/tweets_index.php">Poker Tweets</a></li>
                </ul>
            </li>
           <? } ?>

  			<? if($current_clerk->im_allow("job_manager")){ ?>
           <li><a href="">JOBS MANAGER </a>
                <ul>
                <li ><a href="<?= BASE_URL ?>/ck/jobs_manager/espn_games.php">Espn Games ID</a></li>
               </ul>
            </li>
           <? } ?>

               </ul>
         		</li>
			   
			   <? if($current_clerk->im_allow("baseball_file")){ ?>
             	<li><a href="<?= BASE_URL ?>/ck/baseball_file/index.php"><img src="../images/mlb.png" width="25px" /><span style="float:right; margin-right: 55px;">MLB</span> </a></li>
         	  <? } ?>
             
              
                <? if($current_clerk->im_allow("nba_system")){ ?>
             	<li><a href="<?= BASE_URL ?>/ck/nba_file/index.php"><img src="../images/nba.png" width="25px" /><span style="float:right; margin-right: 55px;">NBA</span> </a></li>
          		 <? } ?>
              
               <? if($current_clerk->im_allow("nhl_system")){ ?>
             	<li><a href="<?= BASE_URL ?>/ck/nhl_file/index.php"><img src="../images/nhl.png" width="25px" /><span style="float:right; margin-right: 55px;">NHL</span> </a></li>
    	 	   <? } ?>
              </ul>
             
             
             </li>
           <? } ?>
           
              <?  //Volunteer Center //?>

         	     <? if(($current_clerk->im_allow("rescue_center")) || ($current_clerk->im_allow("cranimal_rescue_center")) || ($current_clerk->im_allow("volunteer_tours"))){ ?>
              
               <li><a href=" "javascript:;">Volunteer Center</a>
                 <ul>
				<? if($current_clerk->im_allow("rescue_center")){ ?> 
                <li><a href="<?= BASE_URL ?>/ck/rescue_center/index.php">Rescue Center</a></li>
               <? } ?>
               
               <? if($current_clerk->im_allow("cranimal_rescue_center")){ ?> 
                <li><a href="<?= BASE_URL ?>/ck/cranimal_rescue_center/index.php">CR Animal Rescue Center</a></li>
               <? } ?>
               
               <? if($current_clerk->im_allow("volunteer_tours")){ ?> 
                <li><a href="<?= BASE_URL ?>/ck/volunteer_tours/index.php">Volunteer Tours</a></li>
               <? } ?> 
             <? } ?>
             </ul>
             </li>
             
          
         
          </ul>
        </li>
          <li><a href="<?= BASE_URL ?>/process/login/logout.php">LOGOUT</a></li>
    <? } else { ?>
        <li><a href="<?= BASE_URL ?>/ck/calls_queue.php">CRM</a></li>
        <li><a href="<?= BASE_URL ?>/process/login/logout.php">LOGOUT</a></li>
    <? } ?>
  </ul>
  </nav>


</div>
</div>

   <!-- jQuery -->
    <script type="text/javascript" src="<?= BASE_URL ?>/includes/menu/src/libs/jquery/jquery.js"></script>

    <!-- SmartMenus jQuery plugin -->
    <script type="text/javascript" src="<?= BASE_URL ?>/includes/menu/src/jquery.smartmenus.js"></script>

    <!-- SmartMenus jQuery init -->
    <script type="text/javascript">
    	$(function() {
    		$('#main-menu').smartmenus({
    			subMenusSubOffsetX: 1,
    			subMenusSubOffsetY: -8
    		});
    	});
    </script>
