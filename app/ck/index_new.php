<?

$dash_menu = array();

$dash_menu[] = array("title"=>"Websites", "links"=>array(
	array("label"=>"Sports headlines", "url"=>BASE_URL . "/ck/main_brands_sports_headlines.php", "permissions"=>array("main_brands_sports"))
));

$dash_menu[] = array("title"=>"Customer Service", "links"=>array(
	array("label"=>"Manage Player Bonuses", "url"=>BASE_URL . "/ck/manage_bonus_players.php", "permissions"=>array("manage_bonus")),
	array("label"=>"SBO Loyalty Program", "url"=>BASE_URL . "/ck/sbo_loyalty.php", "permissions"=>array("sbo_loyalty")),
	array("label"=>"Player Interest", "url"=>BASE_URL . "/ck/interest.php", "permissions"=>array("player_interest")),
	array("label"=>"10% Cashback Report", "url"=>BASE_URL . "/ck/sbo_cashback.php", "permissions"=>array("sbo_cashback")),
	array("label"=>"Player IP's", "url"=>BASE_URL . "/ck/player_ip.php", "permissions"=>array("player_ip")),
	array("label"=>"Player Security Question", "url"=>BASE_URL . "/ck/player_security_question.php", "permissions"=>array("player_security_question"))
));

$dash_menu[] = array("title"=>"Financial Reports", "links"=>array(
	array("label"=>"SBO Hold % by League", "url"=>BASE_URL . "/ck/sbo_hold_percentage.php", "permissions"=>array("hold_percentage")),
	array("label"=>"Live + betting", "url"=>"javascript:window.open('http://livesports.sportsbettingonline.ag:40127/#/login', '_blank');", "permissions"=>array("live_betting"))
));

$dash_menu[] = array("title"=>"Betting", "links"=>array(
	array("label"=>"Bettin Edge", "url"=>BASE_URL . "/ck/betting_index.php", "permissions"=>array("betting_basics","betting_edge_system","graded_games_checker")),
	array("label"=>"Insert Bets", "url"=>"betting.php", "permissions"=>array("betting_basics")),
	array("label"=>"Auto Betting", "url"=>BASE_URL . "/ck/autobet/sum_mode.php", "permissions"=>array("betting_basics")),
	array("label"=>"Grade Games", "url"=>BASE_URL . "/ck/betting_grading.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Bank Accounts", BASE_URL . "/ck/url"=>"betting_bank.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manual Win/Loss", "url"=>BASE_URL . "/ck/betting_manual.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Agents", "url"=>BASE_URL . "/ck/betting_agent.php", "permissions"=>array("betting_basics")),
	array("label"=>"Accounts Moves", "url"=>BASE_URL . "/ck/betting_moves.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Accounts", "url"=>BASE_URL . "/ck/betting_accounts.php", "permissions"=>array("betting_basics")),
	array("label"=>"Commission Accounts", "url"=>BASE_URL . "/ck/betting_commisions.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Groups", "url"=>BASE_URL . "/ck/betting_groups.php", "permissions"=>array("betting_basics")),
	array("label"=>"Grade Manual Picks", "url"=>BASE_URL . "/ck/grade_manual_picks.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Identifiers", "url"=>BASE_URL . "/ck/betting_identifier.php", "permissions"=>array("betting_basics")),
	array("label"=>"Reports", "url"=>BASE_URL . "/ck/betting_reports.php", "permissions"=>array("betting_basics")),
	array("label"=>"Manage Proxys", "url"=>BASE_URL . "/ck/betting_proxys.php", "permissions"=>array("betting_basics")),
	//array("label"=>"Gambling Checklist", "url"=>BASE_URL . "/ck/gambling_checklist.php", "permissions"=>array("betting_basics")),
	array("label"=>"Check Graded Games", "url"=>BASE_URL . "/ck/graded_games.php", "permissions"=>array("betting_basics")),
	//array("label"=>"Gambling Checklist By Day", "url"=>BASE_URL . "/ck/gambling_checklist_by_day.php", "permissions"=>array("betting_basics")),
	array("label"=>"Favorite and Over", "url"=>BASE_URL . "/ck/sbo_over_favorite_report.php", "permissions"=>array("betting_basics")),
	//array("label"=>"Check Graded Games", "url"=>BASE_URL . "/ck/graded_games.php", "permissions"=>array("graded_games_checker")),
	array("label"=>"Bet Changer", "url"=>BASE_URL . "/ck/bet_changer.php", "permissions"=>array("graded_games_checker")),
));

$dash_menu[] = array("title"=>"Rescue Center", "links"=>array(
	array("label"=>"Photo Galleries", "url"=>BASE_URL . "/ck/rescue_center/tools/photo-galleries.php", "permissions"=>array("rescue_center")),
	array("label"=>"Current Volunteers Report", "url"=>BASE_URL . "/ck/rescue_center/current-volunteers-report.php", "permissions"=>array("rescue_center")),
	array("label"=>"Payment Report", "url"=>BASE_URL . "/ck/rescue_center/payment-report.php", "permissions"=>array("rescue_center")),
	array("label"=>"Manual Entries", "url"=>BASE_URL . "/ck/rescue_center/manual-entries.php", "permissions"=>array("rescue_center")),
	array("label"=>"Products", "url"=>BASE_URL . "/ck/rescue_center/products.php", "permissions"=>array("rescue_center")),
	array("label"=>"Main Products Categories", "url"=>BASE_URL . "/ck/rescue_center/main-products-categories.php", "permissions"=>array("rescue_center")),
	array("label"=>"Products Categories", "url"=>BASE_URL . "/ck/rescue_center/products-categories.php", "permissions"=>array("rescue_center")),
	array("label"=>"Purchases", "url"=>BASE_URL . "/ck/rescue_center/purchases.php", "permissions"=>array("rescue_center")),
	array("label"=>"Rooms", "url"=>BASE_URL . "/ck/rescue_center/rooms.php", "permissions"=>array("rescue_center")),
	array("label"=>"Check Repeated Emails", "url"=>BASE_URL . "/ck/rescue_center/check_repeated_emails.php", "permissions"=>array("rescue_center")),
	array("label"=>"Donations", "url"=>BASE_URL . "/ck/rescue_center/donations.php", "permissions"=>array("rescue_center")),
	array("label"=>"Manual Donations", "url"=>BASE_URL . "/ck/rescue_center/manual-donations.php", "permissions"=>array("rescue_center")),
	array("label"=>"Sponsors", "url"=>BASE_URL . "/ck/rescue_center/sponsors.php", "permissions"=>array("rescue_center")),
	array("label"=>"Day Visits", "url"=>BASE_URL . "/ck/rescue_center/day-visits.php", "permissions"=>array("rescue_center")),
	array("label"=>"Internships", "url"=>BASE_URL . "/ck/rescue_center/internships.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteers", "url"=>BASE_URL . "/ck/rescue_center/volunteers.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteers Preview Step 1", "url"=>BASE_URL . "/ck/rescue_center/volunteers-preview.php", "permissions"=>array("rescue_center")),
	array("label"=>"Drivers", "url"=>BASE_URL . "/ck/rescue_center/drivers.php", "permissions"=>array("rescue_center")),
	array("label"=>"Top Headers Quotes", "url"=>BASE_URL . "/ck/rescue_center/top-header-quotes.php", "permissions"=>array("rescue_center")),
	array("label"=>"Daily Work", "url"=>BASE_URL . "/ck/rescue_center/daily-work.php", "permissions"=>array("rescue_center")),
	array("label"=>"Food options", "url"=>BASE_URL . "/ck/rescue_center/food-options.php", "permissions"=>array("rescue_center")),
	array("label"=>"Diets", "url"=>BASE_URL . "/ck/rescue_center/diets.php", "permissions"=>array("rescue_center")),
	array("label"=>"Calendar Payment Details Volunteers", "url"=>BASE_URL . "/ck/rescue_center/calendar_payment_details_volunteers.php", "permissions"=>array("rescue_center")),
	array("label"=>"Coordinators", "url"=>BASE_URL . "/ck/rescue_center/coordinators.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteers, Internships, Coordinators, Day Visits and Manual Entries Calendar", "url"=>BASE_URL . "/ck/rescue_center/calendar.php", "permissions"=>array("rescue_center")),
	array("label"=>"Contact Us", "url"=>BASE_URL . "/ck/rescue_center/contact.php", "permissions"=>array("rescue_center")),
	array("label"=>"Newsletter", "url"=>BASE_URL . "/ck/rescue_center/newsletter.php", "permissions"=>array("rescue_center")),
	array("label"=>"Animals", "url"=>BASE_URL . "/ck/rescue_center/animals.php", "permissions"=>array("rescue_center")),
	array("label"=>"Animals Categories", "url"=>BASE_URL . "/ck/rescue_center/animals-categories.php", "permissions"=>array("rescue_center")),
	array("label"=>"Volunteer Experiences Links", "url"=>BASE_URL . "/ck/rescue_center/experiences-links.php", "permissions"=>array("rescue_center")),
	array("label"=>"Approved Reviews", "url"=>BASE_URL . "/ck/rescue_center/approved-reviews.php", "permissions"=>array("rescue_center")),
	array("label"=>"Manual Reviews", "url"=>BASE_URL . "/ck/rescue_center/manual-reviews.php", "permissions"=>array("rescue_center")),
	array("label"=>"Transportation Requests", "url"=>BASE_URL . "/ck/rescue_center/transportation.php", "permissions"=>array("rescue_center")),
	array("label"=>"Calendar Transportation", "url"=>BASE_URL . "/ck/rescue_center/calendar_transportation.php", "permissions"=>array("rescue_center"))
));

$dash_menu[] = array("title"=>"Expenses", "links"=>array(
	
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"Contests", "links"=>array(
	array("label"=>"MM Brackets", "url"=>"javascript:document.getElementById('braketlogin').submit();", "permissions"=>array("braket_admin"))
));

$dash_menu[] = array("title"=>"Affiliates", "links"=>array(
	array("label"=>"Affiliate Draw", "url"=>BASE_URL . "/ck/affiliate_draw_report.php", "permissions"=>array("agent_draw")),
	array("label"=>"Affiliate Balances", "url"=>BASE_URL . "/ck/affiliate_balance_report.php", "permissions"=>array("affiliate_balance")),
	array("label"=>"Weekly Agent Report", "url"=>BASE_URL . "/ck/sbo_weekly_agent_report.php", "permissions"=>array("sbo_agent_report")),
	array("label"=>"AF Comments", "url"=>BASE_URL . "/ck/affiliates_description.php", "permissions"=>array("affiliate_descriptions")),
	array("label"=>"AF Freelays", "url"=>BASE_URL . "/ck/agent_freeplays.php", "permissions"=>array("agent_freeplays")),
	array("label"=>"AF Leads", "url"=>BASE_URL . "/ck/affiliates_leads.php", "permissions"=>array("affiliate_leads")),
	array("label"=>"Approve Partners", "url"=>BASE_URL . "/ck/affiliates/partners_approve.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Default Endorsements", "url"=>BASE_URL . "/ck/affiliates/endorsements_default.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Campaigns", "url"=>BASE_URL . "/ck/affiliates/partners_campaignes.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Casino Games", "url"=>BASE_URL . "/ck/affiliates/partners_campaignes.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Partners", "url"=>BASE_URL . "/ck/affiliates/partners_affiliates.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Text Links", "url"=>BASE_URL . "/ck/affiliates/partners_text_link_view.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Manage Custom Promotypes", "url"=>BASE_URL . "/ck/affiliates/partners_custom_promotype_view.php", "permissions"=>array("affiliates_system")),
	array("label"=>"News & Updates", "url"=>BASE_URL . "/ck/affiliates/partners_news.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Search by Id", "url"=>BASE_URL . "/ck/affiliates/partners_search_ids.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Testimonials", "url"=>BASE_URL . "/ck/affiliates/partners_testimonials.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Special Trends", "url"=>BASE_URL . "/ck/affiliates/20games.php", "permissions"=>array("affiliates_system")),
	array("label"=>"Insider Contests", "url"=>BASE_URL . "/ck/affiliates/contest.php", "permissions"=>array("affiliates_system")),
));

$dash_menu[] = array("title"=>"Player Reports", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"SEO", "links"=>array(
	array("label"=>"SEO Links", "url"=>BASE_URL . "/ck/seo_system.php", "permissions"=>array("seo_system")),
	array("label"=>"Manage Lists", "url"=>BASE_URL . "/ck/seo_lists.php", "permissions"=>array("seo_system")),
	array("label"=>"Website Information", "url"=>BASE_URL . "/ck/seo_insert_info.php", "permissions"=>array("seo_system")),
	array("label"=>"My Leads", "url"=>BASE_URL . "/ck/seo_get_lead.php", "permissions"=>array("seo_system")),
	array("label"=>"Rankings", "url"=>BASE_URL . "/ck/seo_rankings.php", "permissions"=>array("seo_system")),
	array("label"=>"Report", "url"=>BASE_URL . "/ck/seo_report.php", "permissions"=>array("seo_system")),
	array("label"=>"Brands", "url"=>BASE_URL . "/ck/seo_brands.php", "permissions"=>array("seo_system")),
	array("label"=>"Stats", "url"=>BASE_URL . "/ck/seo_stats.php", "permissions"=>array("seo_system")),
	array("label"=>"Articles", "url"=>BASE_URL . "/ck/seo_articles.php", "permissions"=>array("seo_system")),
	array("label"=>"Black List", "url"=>BASE_URL . "/ck/seo_black_list.php", "permissions"=>array("seo_system")),
	array("label"=>"Metatags", "url"=>BASE_URL . "/ck/metatags.php", "permissions"=>array("seo_system")),
	array("label"=>"Postings", "url"=>BASE_URL . "/ck/posting/posting_view.php", "permissions"=>array("seo_system"))
));


$dash_menu[] = array("title"=>"R.C. Partners", "links"=>array(
	array("label"=>"Manage Partners", "url"=>BASE_URL . "/ck/rc_partners/partners_affiliates.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Partners News", "url"=>BASE_URL . "/ck/rc_partners/partners_news.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Campaigns", "url"=>BASE_URL . "/ck/rc_partners/partners_campaigns.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Custom Promotypes", "url"=>BASE_URL . "/ck/rc_partners/partners_custom_promotype_view.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Endorsements", "url"=>BASE_URL . "/ck/rc_partners/partners_endorsements.php", "permissions"=>array("rc_partners")),
	array("label"=>"Manage Posts: Articles, Press Releases and Infographics", "url"=>BASE_URL . "/ck/rc_partners/partners_posts.php", "permissions"=>array("rc_partners"))
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
	array("label"=>"Casino Win/Loss", "url"=>BASE_URL . "/ck/casino_winloss.php", "permissions"=>array("sbo_main_page"))
));

$dash_menu[] = array("title"=>"Handicappers", "links"=>array(
	array("label"=>"xxxx", "url"=>"xxx", "permissions"=>array())
));

$dash_menu[] = array("title"=>"Volunteer Tours", "links"=>array(
	array("label"=>"Available Dates", "url"=>BASE_URL . "/ck/volunteer_tours/available_dates.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Bookings", "url"=>BASE_URL . "/ck/volunteer_tours/bookings.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Newsletter Subscriptions", "url"=>BASE_URL . "/ck/volunteer_tours/newsletter_subscriptions.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Contacts", "url"=>BASE_URL . "/ck/volunteer_tours/contacts.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"In the news", "url"=>BASE_URL . "/ck/volunteer_tours/news.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Booking Pending Payments Calendar", "url"=>BASE_URL . "/ck/volunteer_tours/bookings_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Customized Tours", "url"=>BASE_URL . "/ck/volunteer_tours/customized_tours.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Trips Requests", "url"=>BASE_URL . "/ck/volunteer_tours/trips_requests.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Trips Requests Calendar", "url"=>BASE_URL . "/ck/volunteer_tours/trips_requests_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Transportation Requests", "url"=>BASE_URL . "/ck/volunteer_tours/transportation_requests.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Calendar Transportation", "url"=>BASE_URL . "/ck/volunteer_tours/transportation_arrival_dates_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Transportation Departure Dates Calendar", "url"=>BASE_URL . "/ck/volunteer_tours/transportation_departure_dates_calendar.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Categories", "url"=>BASE_URL . "/ck/volunteer_tours/categories.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Itineraries", "url"=>BASE_URL . "/ck/volunteer_tours/itineraries.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Approved Reviews", "url"=>BASE_URL . "/ck/volunteer_tours/approved-reviews.php", "permissions"=>array("volunteer_tours")),
	array("label"=>"Manual Reviews", "url"=>BASE_URL . "/ck/volunteer_tours/manual-reviews.php", "permissions"=>array("volunteer_tours"))
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