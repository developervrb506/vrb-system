<?

$dash_menu = array();

$dash_menu[] = array("title"=>"Websites", "links"=>array(
	array("label"=>"Sports headlines", "url"=>"http://localhost:8080/ck/main_brands_sports_headlines.php", "permissions"=>array("main_brands_sports"))
));

$dash_menu[] = array("title"=>"Customer Service", "links"=>array(
	array("label"=>"Manage Player Bonuses", "url"=>"http://localhost:8080/ck/manage_bonus_players.php", "permissions"=>array("manage_bonus")),
	array("label"=>"SBO Loyalty Program", "url"=>"http://localhost:8080/ck/sbo_loyalty.php", "permissions"=>array("sbo_loyalty")),
	array("label"=>"Player Interest", "url"=>"http://localhost:8080/ck/interest.php", "permissions"=>array("player_interest")),
	array("label"=>"10% Cashback Report", "url"=>"http://localhost:8080/ck/sbo_cashback.php", "permissions"=>array("sbo_cashback")),
	array("label"=>"Player IP's", "url"=>"http://localhost:8080/ck/player_ip.php", "permissions"=>array("player_ip")),
	array("label"=>"Player Security Question", "url"=>"http://localhost:8080/ck/player_security_question.php", "permissions"=>array("player_security_question"))
));

$dash_menu[] = array("title"=>"Financial Reports", "links"=>array(
	array("label"=>"SBO Hold % by League", "url"=>"http://localhost:8080/ck/sbo_hold_percentage.php", "permissions"=>array("hold_percentage")),
	array("label"=>"Live + betting", "url"=>"javascript:window.open('http://livesports.sportsbettingonline.ag:40127/#/login', '_blank');", "permissions"=>array("live_betting"))
));

$dash_menu[] = array("title"=>"Betting", "links"=>array(
	array("label"=>"Bettin Edge", "url"=>"http://localhost:8080/ck/betting_index.php", "permissions"=>array("betting_basics","betting_edge_system","graded_games_checker")),
	array("label"=>"Insert Bets", "url"=>"betting.php", "permissions"=>array("betting_basics")),
	array("label"=>"Auto Betting", "url"=>"http://localhost:8080/ck/autobet/sum_mode.php", "permissions"=>array("betting_basics")),
	array("label"=>"Grade Games", "url"=>"http://localhost:8080/ck/betting_grading.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Bank Accounts", "http://localhost:8080/ck/url"=>"betting_bank.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manual Win/Loss", "url"=>"http://localhost:8080/ck/betting_manual.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Agents", "url"=>"http://localhost:8080/ck/betting_agent.php", "permissions"=>array("betting_basics")),
	array("label"=>"Accounts Moves", "url"=>"http://localhost:8080/ck/betting_moves.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Accounts", "url"=>"http://localhost:8080/ck/betting_accounts.php", "permissions"=>array("betting_basics")),
	array("label"=>"Commission Accounts", "url"=>"http://localhost:8080/ck/betting_commisions.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Groups", "url"=>"http://localhost:8080/ck/betting_groups.php", "permissions"=>array("betting_basics")),
	array("label"=>"Grade Manual Picks", "url"=>"http://localhost:8080/ck/grade_manual_picks.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Identifiers", "url"=>"http://localhost:8080/ck/betting_identifier.php", "permissions"=>array("betting_basics")),
	array("label"=>"Reports", "url"=>"http://localhost:8080/ck/betting_reports.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Proxys", "url"=>"http://localhost:8080/ck/betting_proxys.php", "permissions"=>array("betting_basics")),
	//array("label"=>"Gambling Checklist", "url"=>"http://localhost:8080/ck/gambling_checklist.php", "permissions"=>array("betting_basics")),
	array("label"=>"Check Graded Games", "url"=>"http://localhost:8080/ck/graded_games.php", "permissions"=>array("betting_basics")),
	//array("label"=>"Gambling Checklist By Day", "url"=>"http://localhost:8080/ck/gambling_checklist_by_day.php", "permissions"=>array("betting_basics")),
	array("label"=>"Favorite and Over", "url"=>"http://localhost:8080/ck/sbo_over_favorite_report.php", "permissions"=>array("betting_basics")),
	//array("label"=>"Check Graded Games", "url"=>"http://localhost:8080/ck/graded_games.php", "permissions"=>array("graded_games_checker")),
	array("label"=>"Bet Changer", "url"=>"http://localhost:8080/ck/bet_changer.php", "permissions"=>array("graded_games_checker")),
));

$dash_menu[] = array("title"=>"Rescue Center", "links"=>array(
	array("label"=>"Photo Galleries", "url"=>"http://localhost:8080/ck/rescue_center/tools/photo-galleries.php", "permissions"=>array("rescue_center")),
	array("label"=>"Current Volunteers Report", "url"=>"http://localhost:8080/ck/rescue_center/current-volunteers-report.php", "permissions"=>array("rescue_center")),
	array("label"=>"Payment Report", "url"=>"http://localhost:8080/ck/rescue_center/payment-report.php", "permissions"=>array("rescue_center")),
	array("label"=>"Manual Entries", "url"=>"http://localhost:8080/ck/rescue_center/manual-entries.php", "permissions"=>array("rescue_center")),
	array("label"=>"Products", "url"=>"http://localhost:8080/ck/rescue_center/products.php", "permissions"=>array("rescue_center")),
	array("label"=>"Main Products Categories", "url"=>"http://localhost:8080/ck/rescue_center/main-products-categories.php", "permissions"=>array("rescue_center")),
	array("label"=>"Products Categories", "url"=>"http://localhost:8080/ck/rescue_center/products-categories.php", "permissions"=>array("rescue_center")),
	array("label"=>"Purchases", "url"=>"http://localhost:8080/ck/rescue_center/purchases.php", "permissions"=>array("rescue_center")),
	array("label"=>"Rooms", "url"=>"http://localhost:8080/ck/rescue_center/rooms.php", "permissions"=>array("rescue_center")),
	array("label"=>"Check Repeated Emails", "url"=>"http://localhost:8080/ck/rescue_center/check_repeated_emails.php", "permissions"=>array("rescue_center")),
	array("label"=>"Donations", "url"=>"http://localhost:8080/ck/rescue_center/donations.php", "permissions"=>array("rescue_center")),
	array("label"=>"Manual Donations", "url"=>"http://localhost:8080/ck/rescue_center/manual-donations.php", "permissions"=>array("rescue_center")),
	array("label"=>"Sponsors", "url"=>"http://localhost:8080/ck/rescue_center/sponsors.php", "permissions"=>array("rescue_center")),
	array("label"=>"Day Visits", "url"=>"http://localhost:8080/ck/rescue_center/day-visits.php", "permissions"=>array("rescue_center")),
	array("label"=>"Internships", "url"=>"http://localhost:8080/ck/rescue_center/internships.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteers", "url"=>"http://localhost:8080/ck/rescue_center/volunteers.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteers Preview Step 1", "url"=>"http://localhost:8080/ck/rescue_center/volunteers-preview.php", "permissions"=>array("rescue_center")),
	array("label"=>"Drivers", "url"=>"http://localhost:8080/ck/rescue_center/drivers.php", "permissions"=>array("rescue_center")),
	array("label"=>"Top Headers Quotes", "url"=>"http://localhost:8080/ck/rescue_center/top-header-quotes.php", "permissions"=>array("rescue_center")),
	array("label"=>"Daily Work", "url"=>"http://localhost:8080/ck/rescue_center/daily-work.php", "permissions"=>array("rescue_center")),
	array("label"=>"Food options", "url"=>"http://localhost:8080/ck/rescue_center/food-options.php", "permissions"=>array("rescue_center")),
	array("label"=>"Diets", "url"=>"http://localhost:8080/ck/rescue_center/diets.php", "permissions"=>array("rescue_center")),
	array("label"=>"Calendar Payment Details Volunteers", "url"=>"http://localhost:8080/ck/rescue_center/calendar_payment_details_volunteers.php", "permissions"=>array("rescue_center")),
	array("label"=>"Coordinators", "url"=>"http://localhost:8080/ck/rescue_center/coordinators.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteers, Internships, Coordinators, Day Visits and Manual Entries Calendar", "url"=>"http://localhost:8080/ck/rescue_center/calendar.php", "permissions"=>array("rescue_center")),
	array("label"=>"Contact Us", "url"=>"http://localhost:8080/ck/rescue_center/contact.php", "permissions"=>array("rescue_center")),
	array("label"=>"Newsletter", "url"=>"http://localhost:8080/ck/rescue_center/newsletter.php", "permissions"=>array("rescue_center")),
	array("label"=>"Animals", "url"=>"http://localhost:8080/ck/rescue_center/animals.php", "permissions"=>array("rescue_center")),
	array("label"=>"Animals Categories", "url"=>"http://localhost:8080/ck/rescue_center/animals-categories.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteer Experiences Links", "url"=>"http://localhost:8080/ck/rescue_center/experiences-links.php", "permissions"=>array("rescue_center")),
	array("label"=>"Approved Reviews", "url"=>"http://localhost:8080/ck/rescue_center/approved-reviews.php", "permissions"=>array("rescue_center")),
	array("label"=>"Manual Reviews", "url"=>"http://localhost:8080/ck/rescue_center/manual-reviews.php", "permissions"=>array("rescue_center")),
	array("label"=>"Transportation Requests", "url"=>"http://localhost:8080/ck/rescue_center/transportation.php", "permissions"=>array("rescue_center")),
	array("label"=>"Calendar Transportation", "url"=>"http://localhost:8080/ck/rescue_center/calendar_transportation.php", "permissions"=>array("rescue_center"))
));

$dash_menu[] = array("title"=>"Expenses", "links"=>array(
	
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"Contests", "links"=>array(
	array("label"=>"MM Brackets", "url"=>"javascript:document.getElementById('braketlogin').submit();", "permissions"=>array("braket_admin"))
));

$dash_menu[] = array("title"=>"Affiliates", "links"=>array(
	array("label"=>"Affiliate Draw", "url"=>"http://localhost:8080/ck/affiliate_draw_report.php", "permissions"=>array("agent_draw")),
	array("label"=>"Affiliate Balances", "url"=>"http://localhost:8080/ck/affiliate_balance_report.php", "permissions"=>array("affiliate_balance")),
	array("label"=>"Weekly Agent Report", "url"=>"http://localhost:8080/ck/sbo_weekly_agent_report.php", "permissions"=>array("sbo_agent_report")),
	array("label"=>"AF Comments", "url"=>"http://localhost:8080/ck/affiliates_description.php", "permissions"=>array("affiliate_descriptions")),
	array("label"=>"AF Freelays", "url"=>"http://localhost:8080/ck/agent_freeplays.php", "permissions"=>array("agent_freeplays")),
	array("label"=>"AF Leads", "url"=>"http://localhost:8080/ck/affiliates_leads.php", "permissions"=>array("affiliate_leads")),
	array("label"=>"Approve Partners", "url"=>"http://localhost:8080/ck/affiliates/partners_approve.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Default Endorsements", "url"=>"http://localhost:8080/ck/affiliates/endorsements_default.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Campaigns", "url"=>"http://localhost:8080/ck/affiliates/partners_campaignes.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Casino Games", "url"=>"http://localhost:8080/ck/affiliates/partners_campaignes.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Partners", "url"=>"http://localhost:8080/ck/affiliates/partners_affiliates.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Text Links", "url"=>"http://localhost:8080/ck/affiliates/partners_text_link_view.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Custom Promotypes", "url"=>"http://localhost:8080/ck/affiliates/partners_custom_promotype_view.php", "permissions"=>array("affiliates_system")),
	array("label"=>"News & Updates", "url"=>"http://localhost:8080/ck/affiliates/partners_news.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Search by Id", "url"=>"http://localhost:8080/ck/affiliates/partners_search_ids.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Testimonials", "url"=>"http://localhost:8080/ck/affiliates/partners_testimonials.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Special Trends", "url"=>"http://localhost:8080/ck/affiliates/20games.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Insider Contests", "url"=>"http://localhost:8080/ck/affiliates/contest.php", "permissions"=>array("affiliates_system")),
));

$dash_menu[] = array("title"=>"Player Reports", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"SEO", "links"=>array(
	array("label"=>"SEO Links", "url"=>"http://localhost:8080/ck/seo_system.php", "permissions"=>array("seo_system")),
	array("label"=>"Manage Lists", "url"=>"http://localhost:8080/ck/seo_lists.php", "permissions"=>array("seo_system")),
	array("label"=>"Website Information", "url"=>"http://localhost:8080/ck/seo_insert_info.php", "permissions"=>array("seo_system")),
	array("label"=>"My Leads", "url"=>"http://localhost:8080/ck/seo_get_lead.php", "permissions"=>array("seo_system")),
	array("label"=>"Rankings", "url"=>"http://localhost:8080/ck/seo_rankings.php", "permissions"=>array("seo_system")),
	array("label"=>"Report", "url"=>"http://localhost:8080/ck/seo_report.php", "permissions"=>array("seo_system")),
	array("label"=>"Brands", "url"=>"http://localhost:8080/ck/seo_brands.php", "permissions"=>array("seo_system")),
	array("label"=>"Stats", "url"=>"http://localhost:8080/ck/seo_stats.php", "permissions"=>array("seo_system")),
	array("label"=>"Articles", "url"=>"http://localhost:8080/ck/seo_articles.php", "permissions"=>array("seo_system")),
	array("label"=>"Black List", "url"=>"http://localhost:8080/ck/seo_black_list.php", "permissions"=>array("seo_system")),
	array("label"=>"Metatags", "url"=>"http://localhost:8080/ck/metatags.php", "permissions"=>array("seo_system")),
	array("label"=>"Postings", "url"=>"http://localhost:8080/ck/posting/posting_view.php", "permissions"=>array("seo_system"))
));


$dash_menu[] = array("title"=>"R.C. Partners", "links"=>array(
	array("label"=>"Manage Partners", "url"=>"http://localhost:8080/ck/rc_partners/partners_affiliates.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Partners News", "url"=>"http://localhost:8080/ck/rc_partners/partners_news.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Campaigns", "url"=>"http://localhost:8080/ck/rc_partners/partners_campaigns.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Custom Promotypes", "url"=>"http://localhost:8080/ck/rc_partners/partners_custom_promotype_view.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Endorsements", "url"=>"http://localhost:8080/ck/rc_partners/partners_endorsements.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Posts: Articles, Press Releases and Infographics", "url"=>"http://localhost:8080/ck/rc_partners/partners_posts.php", "permissions"=>array("rc_partners"))
));

$dash_menu[] = array("title"=>"CRM", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"Cashier", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"PPH", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"Casino", "links"=>array(
	array("label"=>"Casino Win/Loss", "url"=>"http://localhost:8080/ck/casino_winloss.php", "permissions"=>array("sbo_main_page"))
));

$dash_menu[] = array("title"=>"Handicappers", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"Volunteer Tours", "links"=>array(
	array("label"=>"Available Dates", "url"=>"http://localhost:8080/ck/volunteer_tours/available_dates.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Bookings", "url"=>"http://localhost:8080/ck/volunteer_tours/bookings.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Newsletter Subscriptions", "url"=>"http://localhost:8080/ck/volunteer_tours/newsletter_subscriptions.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Contacts", "url"=>"http://localhost:8080/ck/volunteer_tours/contacts.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"In the news", "url"=>"http://localhost:8080/ck/volunteer_tours/news.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Booking Pending Payments Calendar", "url"=>"http://localhost:8080/ck/volunteer_tours/bookings_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Customized Tours", "url"=>"http://localhost:8080/ck/volunteer_tours/customized_tours.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Trips Requests", "url"=>"http://localhost:8080/ck/volunteer_tours/trips_requests.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Trips Requests Calendar", "url"=>"http://localhost:8080/ck/volunteer_tours/trips_requests_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Transportation Requests", "url"=>"http://localhost:8080/ck/volunteer_tours/transportation_requests.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Calendar Transportation", "url"=>"http://localhost:8080/ck/volunteer_tours/transportation_arrival_dates_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Transportation Departure Dates Calendar", "url"=>"http://localhost:8080/ck/volunteer_tours/transportation_departure_dates_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Categories", "url"=>"http://localhost:8080/ck/volunteer_tours/categories.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Itineraries", "url"=>"http://localhost:8080/ck/volunteer_tours/itineraries.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Approved Reviews", "url"=>"http://localhost:8080/ck/volunteer_tours/approved-reviews.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Manual Reviews", "url"=>"http://localhost:8080/ck/volunteer_tours/manual-reviews.php", "permissions"=>array("volunteer_tours"))
));

$dash_menu[] = array("title"=>"Tickets", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

?>

<div>
    <div class="dash_search_box">
        <div class="dash_box_title" > <input type="text" placeholder="Search" onkeyup="search_link(this.value);" size="10" /> </div>
        <div class="dash_box_search" id="search_list">
            
        </div>
    </div>
</div>

<script type="text/javascript">
function search_link(str){

	$("#search_list").html("");

	if(str.length>=4){
	console.log("in");
		$('*[id*='+str+']').each(function() {
			if($(this).hasClass("dash_box_item")){
				$("#search_list").append('<div class="dash_box_item">'+$(this).html()+'</div>');
			}
		});
	
	}
	
}
</script>

<div style="display:inline-block;">
<? foreach($dash_menu as $item){ ?>
<? $id = mt_rand(1,999999999); ?> 

<div class="dash_box">
	<div class="dash_box_title" onclick="$('#bid<? echo $id ?>').toggle(500)"><? echo $item["title"] ?></div>
    <div class="dash_box_list" id="bid<? echo $id ?>" style="display:none;">
    	<? foreach($item["links"] as $link){ ?>
			<?
            $allowed = false;
            foreach($link["permissions"] as $perm){	
				if($current_clerk->im_allow($perm)){$allowed = true; break;}
			}
			if($allowed){
            ?>
            	<div class="dash_box_item" id="<? echo strtolower($link["label"]) ?>"><a class="normal_link" href="<? echo $link["url"] ?>"><? echo $link["label"] ?></a></div>
            <? } ?>
        <? } ?>
    </div>
</div>

<? } ?>
</div>

<? if($current_clerk->im_allow("braket_admin")) { ?>
<form action="http://www.sportsbettingonline.ag/bracket/admin/index.php" id="braketlogin" method="post" target="_blank">
<input name="username" type="hidden" value="admin" />
<input name="password" type="hidden" value="admin" >
</form>
<? } ?>