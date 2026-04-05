<div class="menu" id="menudiv">
<div id="menu_header">
 <ul class="nav">
     <?
      //echo "<pre>";
     //print_r($current_clerk);// VRB MENU   ?>



    
    
    <? if ($current_clerk->vars['user_group']->vars['id'] == 27 ){ ?>      

     <li><a href= "javascript:;">SYSTEM</a></li>
	 
	<? if($current_clerk->im_allow("external_pph_billing")) { ?>
		<li><a href= "http://localhost:8080/ck/pph_external.php">Billing</a></li>
    <? } ?>
             
	 
     <ul>

<? if($current_clerk->im_allow("lines_system") || $current_clerk->im_allow("props_system")){ ?>
              <li>
                  <a href="http://localhost:8080/ck/sbo_winners.php">Lines</a>
                   <ul>
                      <li><a href= "http://localhost:8080/ck/grading_unlock.php">Grading Unlock</a></li>
                      <? if($current_clerk->im_allow("props_system")){ ?>
                        <li>
                            <a href="javascript:;">Props System</a>
                            <ul>
                                <li><a href= "http://localhost:8080/ck/props_alerts.php">Alerts Props</a></li>
                                <li><a href= "http://localhost:8080/ck/import_props.php">Import Props</a></li>
                                <li><a href= "http://localhost:8080/ck/import_odds.php">Import Odds</a></li>
                            </ul>
                        </li>
                     <? } ?>
                      <? if($current_clerk->im_allow("lines_system")){ ?>
                      <li>
                          <a  href= "http://localhost:8080/ck/create_periods.php">Periods</a>
                      </li> 
                       <li>
                          <a  href= "http://localhost:8080/ck/game_description.php">Game Description</a>
                      </li> 
                       <li>
                          <a  href= "http://localhost:8080/ck/graded_games.php">Graded Games</a>
                      </li> 
                       <li>
                          <a  href= "http://localhost:8080/ck/graded_games_pending.php">Pending Graded Games</a>
                      </li> 
                      <li>
                          <a  href= "http://localhost:8080/ck/bet_changer.php">Bet Changer</a>
                      </li> 
                      <li>
                          <a  href= "http://localhost:8080/ck/graded_games.php">Graded Games</a>
                      </li> 

                      <?/*
                      <li>
                          <a href=" http://localhost:8080/ck/graded_games.php">Gadred Games</a>
                         
                      </li> 

                       <li>
                          <a href=" http://localhost:8080/ck/graded_games_pending.php">Pending Graded Games (WIP) </a>
                         
                      </li> 

                     
                      
                       <li>
                          <a href="http://localhost:8080/ck/sbo_winners.php">Weather System</a>
                          <ul>
                              <li><a href= "http://localhost:8080/ck/weather_system/">Check Weather</a></li>
                              <li><a href= "http://localhost:8080/ck/weather_system/create_line.php">Create Game</a></li>
                              <li><a href= "http://localhost:8080/ck/weather_system/create_matchups.php">Create Matchups</a></li>
                          </ul>
                      </li>  */ ?>
                     <? } ?>
                  </ul>
              </li>   
           <? } ?>
           </ul>
              </li>   
    <? } ?> 

   <? if (!$current_clerk->im_allow("just_queue_calls") && $current_clerk->vars['user_group']->vars['id'] != 27 ){ ?>      
   
    
  
    <li><a href= "javascript:;">VRB</a>
    <ul>
    
    
             
			 <li><a href= "http://localhost:8080/ck/index.php">HOME</a></li>
			 <? if($current_clerk->im_allow("users") || $current_clerk->admin()) { ?>
             <li><a href= "http://localhost:8080/ck/clerks.php">Users</a></li>
             <? } ?>
             
             <? if($current_clerk->im_allow("token_generator")){ ?>
             <li><a href= "http://localhost:8080/ck/token_generator.php">Token Generator</a></li>
             <? } ?>
             
			 <? if($current_clerk->im_allow("users") || $current_clerk->admin()){ ?>
             <li><a href= "http://localhost:8080/ck/user_groups.php">Groups</a></li>
             <? } ?>
             
              <? if($current_clerk->im_allow("group_permissions") || $current_clerk->im_allow("user_permissions")){ ?>
             <li><a href="javascript:;">Permissions</a>
              <ul>
			     <? if($current_clerk->im_allow("user_permissions")) { ?>
                 <li><a href= "http://localhost:8080/ck/permissions_user.php"> Users Permissions</a></li>
                 <? } ?>
                <? if($current_clerk->im_allow("group_permissions")) { ?>
                 <li><a href= "http://localhost:8080/ck/permissions_group.php"> Groups Permissions</a></li>
                 <? } ?>
                 
                 <? if($current_clerk->im_allow("manage_permission")) { ?>
                 <li><a href="manage_permission.php">Manage  Access Permissions</a></li>
                 <? } ?>
        
              </ul>
             </li>
             <? } ?>
             
			 <? if($current_clerk->im_allow("all_schedules") || $current_clerk->is_manager()){ ?>
             <li><a href= "http://localhost:8080/ck/schedules.php">Schedules</a></li>
             <? } ?>
             
			 <? if($current_clerk->admin()){ ?>
              <li><a href= "http://localhost:8080/ck/messages.php">MESSAGES</a></li>
             <? } ?>
             
			 <? //if($current_clerk->admin()){ ?>
             <li><a href= "settings.php">System Settings</a></li>
             <? // } ?>
           
             <? if($current_clerk->im_allow("rules") || $current_clerk->admin() || $current_clerk->vars["level"]->vars["sale_manager"] ){ ?>
             <li><a href= "http://localhost:8080/ck/rules.php">Rules</a></li>
             <? } ?>  
             
             <? if($current_clerk->im_allow("goals_admin")){ ?>
              <li><a href= "http://localhost:8080/ck/goals.php">GOALS</a></li>
             <? }else{ ?> 
              <li><a href="http://localhost:8080/ck/my_goals.php" >MY GOALS</a></li>
             <? } ?>    
    </ul></li> 
    
    
    <? // AFFILIATES MENU  ?>
	<? if(($current_clerk->im_allow("affiliates_system")) || ($current_clerk->im_allow("affiliate_descriptions")) || ($current_clerk->im_allow("agent_freeplays")) || ($current_clerk->im_allow("affiliate_leads"))  ){ ?>   
       
    <li><a href="http://localhost:8080/ck/affiliates/affiliates_index.php">AFFILIATES</a>
    <ul>
                	                    					
					<? if($current_clerk->im_allow("agent_draw")){ ?> 
                      <li><a href="http://localhost:8080/ck/affiliate_draw_report.php">Affiliate Draw</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("affiliate_balance")){ ?> 
                      <li><a href="http://localhost:8080/ck/affiliate_balance_report.php">Affiliate Balances</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_agent_report")){ ?> 
                      <li><a href="http://localhost:8080/ck/sbo_weekly_agent_report.php" >Weekly Agent Report</a></li>
                     <? } ?> 
                    
                </ul>
    
    <? } ?>

    
    
    
    <? // Systems Menu  ?>
     <li><a href= "javascript:;">Systems</a>
      <ul>
           
           
           
           <li>
           		<a href="javascript:;">Handicappers </a>
                
                <ul>
                
                	 <? if($current_clerk->im_allow("twitter_updater")){ ?> 
                      <li><a href="twitter_updater.php">Twitter Updater</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sports_jobs")){ ?> 
                      <li><a href="sports_jobs.php">Sports Jobs</a></li>
                     <? } ?>
                     
                     <? if($current_clerk->im_allow("leagues_order")){ ?> 
                      <li><a href="leagues_order.php">Leagues Order</a></li>
                     <? } ?>
                
                </ul>
           
           </li>
           
           <li>
           		<a href="javascript:;">Websites </a>
                
                <ul>
                
                	 <? if($current_clerk->im_allow("main_brands_sports")){ ?> 
                      <li><a href="main_brands_sports_headlines.php">Sports Headlines</a></li>
                      <li><a href="/ck/headlines/index.php">Sports Headlines ** NEW **</a></li>
                    
                     <? } ?> 
                      <? if($current_clerk->im_allow("main_brands_sports") && !$current_clerk->im_allow("new_features")){ ?> 
                      <li><a href="sports_headlines.php">PPH Sports Headlines</a></li>
                     <? } ?> 
                
                </ul>
           
           </li>
           
           <li>
           		<a href="javascript:;">Contests </a>
                
                <ul>
                
                	<? if($current_clerk->im_allow("wc_bracket_admin")){ ?> 
                      <li><a href="grade_wc_bracket.php">WC Bracket</a></li>
                    <? } ?>
                    <? if($current_clerk->im_allow("braket_admin")) { $braket_admin_on = true; ?>
                         <li><a href="javascript:;" onclick="document.getElementById('braketlogin').submit()">Bracket</a></li>
                    <? } ?>
                    <? if($current_clerk->im_allow("beat_bookie_admin")) { $beat_bookie_admin_on = true; ?>
                         <li><a href="javascript:;" onclick="document.getElementById('beat_bookie_login').submit()">Beat the bookie</a></li>
                    <? } ?>
                    <? if($current_clerk->im_allow("superbowl_admin")) { $superbowl_admin_on = true; ?>
                         <li><a href="javascript:;" onclick="document.getElementById('superbowl_login').submit()">Superbowl Winner</a></li>
                    <? } ?>  
                
                </ul>
           
           </li>
           
           <li>
           		<a href="javascript:;">Financial Reports </a>
                
                <ul>
                
                	 <? if($current_clerk->im_allow("profitablity_deposit")){ ?> 
                      <li><a href="profitablity_deposit_method.php">Deposits Profitablity</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_accounting_trans_report")){ ?> 
                      <li><a href="sbo_accounting_transactions_sort_by_method.php">Accounting Trans.</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_banking")){ ?> 
                      <li><a href="sbo_banking.php">SBO Banking</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("hold_percentage")){ ?> 
                      <li><a href="sbo_hold_percentage.php">League Hold perc.</a></li>
                     <? } ?> 
                     
                     <? if(($current_clerk->im_allow("balance_adjustment")) || ($current_clerk->im_allow("balance_disbursements")) || ($current_clerk->im_allow("balance_receipt"))  ){ ?>
                      <li><a href="balance_manager.php">Balance Manager</a></li>
                     <? } ?> 
                
                </ul>
           
           </li>
           
           <li>
           		<a href="javascript:;">Customer Service</a>
                
                <ul>
                
                	 <? if($current_clerk->im_allow("sbo_bonus_converter_report")){ ?> 
                      <li><a href="bonus_converter_report.php">Bonus Convertions</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("manage_bonus")){ ?> 
                      <li><a href="manage_bonus_players.php">Player Bonuses</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("player_interest")){ ?> 
                      <li><a href="interest.php">Player Interest</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("manage_bonus")){ ?> 
                      <li><a href="sbo_push_freeplays.php">Freplay Report</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_cashback")){ ?> 
                      <li><a href="sbo_cashback.php">10% Cashback</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_loyalty")){ ?> 
                      <li><a href="sbo_loyalty.php">SBO Loyalty</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("player_ip")) { ?>
                         <li><a href= "http://localhost:8080/ck/player_ip.php">Player Ips</a></li>
                    <? } ?>
                    
                    <? if($current_clerk->im_allow("player_security_question")) { ?>
                         <li><a href= "http://localhost:8080/ck/player_security_question.php">Player Sec. Question</a></li>
                    <? } ?>
                     
                     
                     
                     
                
                </ul>
           
           </li>
           
           <li>
           		<a href="javascript:;">Casinos</a>
                
                <ul>
                
                	 <? if($current_clerk->im_allow("website_casino_access")){ ?> 
                      <li><a href="casinos_access.php">Casinos by Website</a></li>
                      <li><a href="agent_manager/player_casino_access.php">Player Casino Access</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_main_page")){ ?> 
                      <li><a href="casino_winloss.php">Casino Win/Loss</a></li>
                     <? } ?>
                     
                     
                     
                     
                     
                
                </ul>
           
           </li>
           
           <li>
           		<a href="javascript:;">Credit Cards</a>
                
                <ul>
                
                	 <? if($current_clerk->im_allow("creditcard_players")){ ?> 
                      <li><a href="creditcard_players.php" >CC Players Info</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_banking")){ ?> 
                      <li><a href="sbo_gold_silver_pt.php">GOLD/SILVER amounts</a></li>
                     <? } ?> 
                     
                     
                     
                
                </ul>
           
           </li>
           
           
           
            <? if($current_clerk->im_allow("agent_manager")){ ?>
              <li><a href="http://localhost:8080/ck/agent_manager/agent_index.php">Agent Manager</a></li>   
		   <? } ?>
           
            <?php /*?><? if(($current_clerk->im_allow("affiliates_system")) || ($current_clerk->im_allow("affiliate_descriptions")) || ($current_clerk->im_allow("agent_freeplays")) || ($current_clerk->im_allow("affiliate_leads"))  ){ ?>
             
              <li><a href="http://localhost:8080/ck/affiliates/affiliates_index.php"> AFFILIATES</a>
              
              	<ul>
                	
                    <? if($current_clerk->im_allow("agent_draw")){ ?> 
                      <li><a href="affiliate_draw_report.php">Affiliate Draw</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("affiliate_balance")){ ?> 
                      <li><a href="affiliate_balance_report.php">Affiliate Balances</a></li>
                     <? } ?> 
                     
                     <? if($current_clerk->im_allow("sbo_agent_report")){ ?> 
                      <li><a href="sbo_weekly_agent_report.php" >Weekly Agent Report</a></li>
                     <? } ?> 
                    
                </ul>
              
              </li>
            		   
		   <? } ?><?php */?>
           
            
         <? if(($current_clerk->im_allow("betting_basics")) || ($current_clerk->im_allow("betting_edge_system")) || ($current_clerk->im_allow("graded_games_checker"))){ ?>
              <li><a href= "http://localhost:8080/ck/betting_index.php">Betting</a>
           <ul> 
           <? if($current_clerk->im_allow("betting_basics")){ ?> 
     		<li><a href= "http://localhost:8080/ck/betting_index.php">Betting System</a></li>
           <? } ?> 
           
            <? if($current_clerk->im_allow("betting_edge_system")){ ?>
             <li><a href= "http://localhost:8080/ck/betting_edge/betting_edge.php">BETTING EDGE </a></li>
           <? } ?>
             </ul>
             </li>
           
          <?  } ?>
            <? if($current_clerk->im_allow("cashier_admin")){ ?>
              <li><a href="http://localhost:8080/ck/cashier">Cashier</a></li>   
		   <? } ?>
           
           <? if($current_clerk->im_allow("cc_system")){ ?>
              <li><a href="http://localhost:8080/ck/cc_index.php">Credit Cards</a></li>   
		   <? } ?>
           
           
           
            <? if($current_clerk->im_allow("job_manager")){ ?>
           <li><a href="">JOBS MANAGER </a>
                <ul>
                <li ><a href="http://localhost:8080/ck/jobs_manager/espn_games.php">Espn Games ID</a></li>
               </ul>
            </li>
           <? } ?>
           
            <? if($current_clerk->im_allow("lines_system") || $current_clerk->im_allow("props_system")){ ?>
              <li>
                  <a href="http://localhost:8080/ck/sbo_winners.php">Lines</a>
                   <ul>
                      <li><a href= "http://localhost:8080/ck/grading_unlock.php">Grading Unlock</a></li>
                      <? if($current_clerk->im_allow("props_system")){ ?>
                        <li>
                            <a href="javascript:;">Props System</a>
                            <ul>
                                <li><a href= "http://localhost:8080/ck/props_alerts.php">Alerts Props</a></li>
                                <li><a href= "http://localhost:8080/ck/import_props.php">Import Props</a></li>
                                <li><a href= "http://localhost:8080/ck/import_odds.php">Import Odds</a></li>
                            </ul>
                        </li>
          			 <? } ?>
                      <? if($current_clerk->im_allow("lines_system")){ ?>
                      <li>
                          <a  href= "http://localhost:8080/ck/create_periods.php">Periods</a>
                      </li> 
                       <li>
                          <a  href= "http://localhost:8080/ck/game_description.php">Game Description</a>
                      </li> 
                       <li>
                          <a  href= "http://localhost:8080/ck/graded_games.php">Graded Games</a>
                      </li> 
                       <li>
                          <a  href= "http://localhost:8080/ck/graded_games_pending.php">Pending Graded Games</a>
                      </li> 

                      <?/*
                      <li>
                          <a href=" http://localhost:8080/ck/graded_games.php">Gadred Games</a>
                         
                      </li> 

                       <li>
                          <a href=" http://localhost:8080/ck/graded_games_pending.php">Pending Graded Games (WIP) </a>
                         
                      </li> 

                     
                      
                       <li>
                          <a href="http://localhost:8080/ck/sbo_winners.php">Weather System</a>
                          <ul>
                              <li><a href= "http://localhost:8080/ck/weather_system/">Check Weather</a></li>
                              <li><a href= "http://localhost:8080/ck/weather_system/create_line.php">Create Game</a></li>
                              <li><a href= "http://localhost:8080/ck/weather_system/create_matchups.php">Create Matchups</a></li>
                          </ul>
                      </li>  */ ?>
		             <? } ?>
                  </ul>
              </li>   
		   <? } ?>
           
           <? if($current_clerk->im_allow("march_madness")){ ?>
           <li><a href="http://localhost:8080/ck/add_braket.php">March Madness</a></li> 
           <? } ?>
           
           <? if($current_clerk->im_allow("baseball_file") || $current_clerk->im_allow("nba_system")  || $current_clerk->im_allow("nhl_system") ){ ?>
             <li><a href= "">SPORTS SYSTEM </a>
              <ul>
               <? if($current_clerk->im_allow("baseball_file")){ ?>
             	<li><a href= "http://localhost:8080/ck/baseball_file/index.php"><img src="../images/mlb.png" width="25px" /><span style="float:right; margin-right: 55px;">MLB</span> </a></li>
         	  <? } ?>
             
              
                <? if($current_clerk->im_allow("nba_system")){ ?>
             	<li><a href= "http://localhost:8080/ck/nba_file/index.php"><img src="../images/nba.png" width="25px" /><span style="float:right; margin-right: 55px;">NBA</span> </a></li>
          		 <? } ?>
              
               <? if($current_clerk->im_allow("nhl_system")){ ?>
             	<li><a href= "http://localhost:8080/ck/nhl_file/index.php"><img src="../images/nhl.png" width="25px" /><span style="float:right; margin-right: 55px;">NHL</span> </a></li>
    	 	   <? } ?>
              </ul>
             
             
             </li>
           <? } ?>
           
          
           
          
			
		

           <? if($current_clerk->im_allow("programmers_book")){ ?>
             <li><a href= "http://localhost:8080/ck/programmers_book.php">PROGRAMMER BOOK</a></li>
           <? } ?>           
           
          <?php /*?> <? if($current_clerk->im_allow("rescue_center_oldsite")){ ?> 
     		<li><a href= "http://localhost:8080/ck/rescue_center_oldsite/index.php">Rescue Center Old Site</a></li>
           <? } ?><?php */?>
           
           <? if($current_clerk->im_allow("rescue_center")){ ?> 
     		<li>
            
            <a href="">Rescue Center</a>
               <ul>
                 <li><a href="http://localhost:8080/ck/rescue_center/index.php">Admin</a></li>
                 <li><a href="http://localhost:8080/ck/rc_partners/index.php">Partners</a></li>
                 <li><a href="http://localhost:8080/ck/rescue_center_oldsite/index.php">Old Site Admin</a></li>
               </ul>
            </li>         
            
           <? } ?>
           
           <? if($current_clerk->im_allow("rc_center_org")){ ?> 
     		<li><a href= "http://localhost:8080/ck/rc_center_org/index.php">Rescue Center.ORG Admin</a></li>
           <? } ?>        
		   
		   <?php /*?><? if($current_clerk->im_allow("volunteer_tours")){ ?> 
     		<li><a href= "http://localhost:8080/ck/volunteer_tours/index.php">Volunteer Tours</a></li>
           <? } ?><?php */?>
           
           <? if($current_clerk->im_allow("costarican_traveler")){ ?> 
     		<li><a href= "http://localhost:8080/ck/costarican_traveler/index.php">Costa Rican Traveler</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("real_estate")){ ?> 
     		<li><a href= "http://localhost:8080/ck/real_estate/index.php">Real Estate</a></li>
           <? } ?>  
		   
		  <? if($current_clerk->im_allow("seo_system") || $current_clerk->im_allow("system_metatags") || $current_clerk->im_allow("posting")){ ?>
              <li><a href="http://localhost:8080/ck/seo_index.php">SEO</a></li>   
		   <? } ?>
          
          <? if($current_clerk->im_allow("teams_system")){ ?>
             <li><a href= "http://localhost:8080/ck/teams_file/teams_logos.php">TEAM SYSTEM</a></li>
           <? } ?>
          
           <? if($current_clerk->im_allow("tweets")){ ?>
             <li><a href= "http://localhost:8080/ck/tweets_index.php">TWEETS</a></li>
           <? } ?>
           
          
           
           <? if($current_clerk->im_allow("widget_manager")){ ?>
           <li><a href="">WIDGETS MANAGER</a>
                <ul>
                <li><a href="http://localhost:8080/ck/widget_manager/leagues.php">Leagues</a></li>
                <li><a href="http://localhost:8080/ck/widget_manager/books_order/">Books</a></li>
                 <?php /*?><li><a href="http://localhost:8080/ck/widget_manager/events_leagues.php">Events leagues</a></li><?php */?>
                 <li ><a href="http://localhost:8080/ck/widget_manager/poker_tweets/tweets_index.php">Poker Tweets</a></li>
                </ul>
            </li>
             
            
               
           <? } ?>
           
           
           
           
           
           
           
        
     </ul>
    </li>  
    
    

    
      <? // PPH ?>
      <li><a href= "javascript:;">PPH</a>
      <ul>  
            <? if($current_clerk->im_allow("pph_accounting")){ ?>
              <li><a href= "http://localhost:8080/ck/pph.php">PPH</a></li>
            <? } ?> 
      </ul></li>
      
      <? // PPH ?>
      <? if($current_clerk->im_allow("pph_accounting")){ ?>
      <li><a href= "javascript:;">PPH2</a>
      <ul>  
            
         <li><a href= "javascript:;">Admin</a>
         	<ul>
            	<li><a href= "http://localhost:8080/ck/pph.php?detail">Add Acount</a></li>
                <li><a href= "http://localhost:8080/ck/pph_transaction.php" rel="shadowbox;height=420;width=405">New Transaction</a></li>
                <li><a href= "http://localhost:8080/ck/pph_reverse.php" rel="shadowbox;height=350;width=405">Add Expense</a></li>
                <li><a href= "http://localhost:8080/ck/pph_bill.php" rel="shadowbox;height=480;width=405">Manual Bill</a></li>
                <li><a href= "http://localhost:8080/ck/pph_ticker_message.php" rel="shadowbox;height=470;width=830">Player Ticker Message</a></li>
                <li><a href= "http://localhost:8080/ck/agents_messages.php" rel="shadowbox;height=470;width=830">Agent Report Message</a></li>
                <li><a href= "http://localhost:8080/ck/pph_manage_cashier.php" rel="shadowbox;height=320;width=405">Add Cashier</a></li>
                <li><a href= "http://localhost:8080/ck/pph_agents_list.php">Agents Accounts</a></li>
                <li><a href="http://localhost:8080/ck/manage_backends.php" >Agent Backends</a></li>
                <? if($current_clerk->im_allow("backend_permissions")){ ?>
                <li><a href="http://localhost:8080/ck/manage_backend_permissions.php" >Backend Permissions</a></li>
                <? } ?>
                <? if($current_clerk->im_allow("access_manager")){ ?>
                <li><a href="http://localhost:8080/ck/access_manager.php" >Access manager</a></li>
                <? } ?>
                <li><a href="http://localhost:8080/ck/player_password.php" >Player Password</a></li>
                
                <? if($current_clerk->im_allow("new_features")){ ?>
                <li><a href="http://localhost:8080/ck/new_feature.php">New Features Notes</a></li>
                <? } ?>
                <? if($current_clerk->im_allow("line_blocker")){ ?>
                <li><a href="http://localhost:8080/ck/agent_money_line_blocker_sport.php">Agent Money Blocker</a></li>
                <li><a href="http://localhost:8080/ck/agent_period_blocker.php">Agent Period Blocker</a></li>
                <? } ?>
                
            </ul>
         </li>
         <li><a href= "javascript:;">Agents</a>
         	<ul>
            	
            </ul>
         </li>
         <li>
         	<a href= "javascript:;">Reports</a>
            <ul>
            	<li><a href="http://localhost:8080/ck/pph_current_bill_report.php" >Current Billing Report</a></li>
                <li><a href="http://localhost:8080/ck/pph.php?br=1" >Balance Report</a></li>
                <li><a href="http://localhost:8080/ck/pph_cashier_methods_report.php" class="normal_link">Cashier Methods by Agent</a></li>
                <? if($current_clerk->im_allow("access_manager")){ ?>
                <li><a href="http://localhost:8080/ck/player_access_report.php" >Player Access Report</a></li>
                <? } ?>
            </ul>
         </li>
            
      </ul></li>
      <? } ?> 
      
      <? // Accounting ?>
      <li><a href= "javascript:;">Acounting</a>
      
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
   
	 <?php /*?><li><a href= "javascript:;">Transactions</a>
       <ul>  
           <? if($current_clerk->im_allow("prepaid_test")){ ?>
             <li><a href= "http://localhost:8080/ck/prepaid_test.php">PREPAID TEST</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("prepaid_transactions")){ ?>
            <li><a href= "http://localhost:8080/ck/prepaid_transactions.php">PREPAID</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("moneypak_transactions")){ ?>
            <li><a href= "http://localhost:8080/ck/moneypak_transactions.php">PAKS</a></li>
            <li><a href= "http://localhost:8080/ck/moneypak_transactions.php?safe=1">SAFE PAKS</a></li>
           <? } ?>
           
           <? if($current_clerk->im_allow("cc_cashback")){ ?>
              <li><a href= "http://localhost:8080/ck/cc_cashback.php">CC CHARGEBACK</a></li>
           <? } ?>
           
             <li><a href= "javascript:;">Bitcoins</a>
              <ul>
              <? if($current_clerk->im_allow("bitcoin_address")){ ?>
              <li><a href= "http://localhost:8080/ck/bitcoin_address.php">BITCOINS ADDRESS</a></li>
             <? } ?>
             <? if($current_clerk->im_allow("buymoneypaks_settings")){ ?>
              <li><a href= "http://localhost:8080/ck/buymoneypak_settings.php">BUYMONEYPAKS SETTINGS</a></li>
             <? } ?>
             <? if($current_clerk->im_allow("bitbet_deposits")){ ?>
              <li><a href= "http://localhost:8080/ck/bitbet_deposits.php">BitBet Transactions</a></li>
             <? } ?>
              </ul>
             </li>
           
           
      </ul>
    </li><?php */?>
    
    
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
       <li><a href= "javascript:;">CRM</a>
       <ul>
            
          <? if($current_clerk->vars["level"]->vars["sale_manager"] || $current_clerk->im_allow("phone_admin")  || $current_clerk->im_allow("marketing_names") || $current_clerk->im_allow("all_sbo_transactions") || $current_clerk->im_allow("sbo_daily_new_accounts") || $current_clerk->im_allow("sbo_search_accounts") ||$current_clerk->im_allow("first_deposit") || $current_clerk->im_allow("all_sbo_transactions") || $current_clerk->im_allow("sbo_reload") ){?>  
            
             <li><a href= "http://localhost:8080/ck/crm_reports.php">CRM REPORTS</a></li>          
		 <? } ?>
            
              <? if($current_clerk->im_allow("central_phone")  && !$current_clerk->im_allow("phone_admin")){ ?>
              <li><a href="http://localhost:8080/ck/calls_queue.php">Queue Calls</a></li>   
		   <? } ?>
            
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
              
              <? if($current_clerk->im_allow("relesed_names")){ ?>
                <li><a href= "http://localhost:8080/ck/relesed_names.php">RELEASED</a></li>
              <? } ?>
              
              <? if($current_clerk->vars["level"]->vars["is_sales"]){ ?>
               
                  <? if($current_clerk->vars["user_group"]->vars["id"] == 15 ){ ?>
                    <li><a href= "http://localhost:8080/ck/name_agent_search_new.php">SEARCH </a></li>
				  <? }
                      else { ?>
                    <li><a href= "http://localhost:8080/ck/name_search_new.php">SEARCH</a></li>
                 <? } ?>
			 <? } ?>
             
             <? if($current_clerk->im_allow("my_lists_crm_search")){ ?>
                <li><a href= "http://localhost:8080/ck/full_name_search_new.php">FIND CRM NAME</a></li>
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
    

    
    <? /* // Affiliates Menu ?>
	
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
    */ ?>
    
    <? // Tickets Menu ?>
	<li><a href= "">TICKETS</a>
    <ul>
    
        
         <? if($current_clerk->im_allow("department_tickets") || $current_clerk->admin()){ ?>
          <li><a href= "http://localhost:8080/ck/department_tickets.php">TICKETS</a></li>
		 <? } ?>   
         
		  <? if($current_clerk->im_allow("rec_issues")){ ?>
             <?  // <li><a href= "http://localhost:8080/ck/rec_issues.php">REC ISSUES </a></li> // ?>
          <? } ?> 
          
          <? if($current_clerk->im_allow("tickets")){ ?> 
             <li><a href= "http://localhost:8080/ck/tickets.php">EMAIL TICKETS</a></li>
          <? } ?> 
          
           <? if($current_clerk->im_allow("tickets_categories")){ ?> 
             <li><a href= "http://localhost:8080/ck/tickets_categories.php">TICKETS CATEGORIES</a></li>
          <? } ?> 
          
           <? if($current_clerk->im_allow("tickets_categories")){ ?> 
             <li><a href= "http://localhost:8080/ck/tickets_feedback.php">FEEDBACKS TICKETS</a></li>
          <? } ?> 
          
          <? if($current_clerk->im_allow("tickets_categories")){ ?> 
             <? // <li><a href= "http://localhost:8080/ck/tickets_broadcast.php">BROADCAST TICKETS</a></li> ?>
          <? } ?> 
          
           <? if($current_clerk->im_allow("programmers_issues")){ ?> 
             <li><a href= "http://localhost:8080/ck/programmers_issues.php">Programmers Issues</a></li>
          <? } ?>              
    
     </ul>
    </li>  
    
     <? // Payouts ?>
      <?php /*?><li><a href= "javascript:;">Payouts</a>
      <ul>  
            <? if($current_clerk->im_allow("process_payouts")){ ?>
               <li><a href= "http://localhost:8080/ck/bitcoins_payouts.php">BITCOINS (<? echo count(search_bitcoins_payouts("", "", "pe", "ac")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/prepaid_payouts.php">PREPAID (<? echo count(search_prepaid_payouts("", "", "pe", "ac")) ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/paypal_payouts.php">PAYPAL (<? echo count(search_paypal_payouts("", "", "pe", "ac")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/cash_transfer_payouts.php">CASHTRANSFER (<? echo count(search_cash_transfer_payouts_for_process("", "")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/special_payouts.php">SPECIAL (<? echo count(search_special_payouts_for_process("", "", "pe", "ac")) ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/moneyorder_payouts.php">MONEYORDER (<? echo count(search_moneyorder_payouts_for_process("", "")); ?>)</a></li>
               <li><a href= "http://localhost:8080/ck/moneypak_limbos.php">PAKS (<? echo count(get_waiting_mp_payouts()); ?>)</a></li>               
               <li><a href= "http://localhost:8080/ck/local_payouts.php">LOCALCASH  (<? echo count(get_local_cash_payouts_for_process()); ?>)</a></li>
               
               <li><a href= "http://localhost:8080/ck/wire_payouts.php">BANK WIRE  (<? echo count(get_bankwire_payouts_for_process()); ?>)</a></li>
                      
             <li><a href= "http://localhost:8080/ck/cashier_checks_payouts.php">CASHIER CHECKS  (<? echo count(get_checks_transactions_for_process()); ?>)</a></li>
            <? } ?>    
            
      </ul>
     </li><?php */?>
     
    
     

   
    <li><a href= "javascript:;">REPORTS</a>
       <ul>
                         
              <li><a href= "http://localhost:8080/ck/reports.php">REPORTS</a></li>
              
                                   
              <li><a href= "http://localhost:8080/ck/players_reports.php">Players REPORTS</a></li>
                  
       </ul>
    </li>
    
    <? // EZPAY Menu ?>
	 
   <?php /*?> <li><a href= "javascript:;">EZPAY</a>
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
    </li><?php */?>
    
    <li><a href= "http://localhost:8080/process/login/logout.php">LOGOUT</a></li>
    <? } else { ?>
        <? if($current_clerk->vars['user_group']->vars['id'] != 27)  { //horizon?>
         <li><a href= "http://localhost:8080/ck/calls_queue.php">CRM</a></li>
      <? } ?>
        <? if($current_clerk->im_allow("agent_manager")){ ?>
            <li><a class="normal_link" href="http://localhost:8080/ck/live_betting_access.php">Live Betting Access</a></li>   
         <? } ?>
        <li><a href= "http://localhost:8080/process/login/logout.php">LOGOUT</a></li>
    <? } ?>
  </ul>
</div>
<? /* for test if($sbo_admin_on){ ?>
            <form id="f18" name="f18" method="post" action="https://www.ezpay.com/process/login/login-process_test.php" target="_blank">
            <input name="email" type="hidden" id="email_login" value="admin@sportsbettingonline.com" />
            <input name="pass" type="hidden" id="pass" value="mainlineposse" />
          	<input name="no_fail" type="hidden" id="no_fail" value="1" />
            <input name="internal" type="hidden" id="internal" value="1" />
            <input name="clerk_id" type="hidden" id="clerk_id" value="<? echo $current_clerk->vars["id"] ?>" />
          	
          	</form>
        <? }*/ ?>
        
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
        <? if($braket_admin_on){ ?>            
      		<form action="https://www.sportsbettingonline.ag/bracket/admin/index.php" id="braketlogin" method="post" target="_blank">
            <input name="username" type="hidden" value="admin" />
            <input name="password" type="hidden" value="admin" >
            </form>
        <? } ?>
        <? if($beat_bookie_admin_on){ ?>            
      		<form action="https://www.sportsbettingonline.ag/contest/beat-the-bookie/admin/" id="beat_bookie_login" method="post" target="_blank">
            <input name="username" type="hidden" value="admin" />
            <input name="password" type="hidden" value="admin" >
            </form>
        <? } ?>
        <? if($superbowl_admin_on){ ?>            
      		<form action="https://www.sportsbettingonline.ag/contest/superbowl-contest/admin/" id="superbowl_login" method="post" target="_blank">
            <input name="username" type="hidden" value="admin" />
            <input name="password" type="hidden" value="admin" >
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
