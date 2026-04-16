<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reports</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://jobs.inspin.com/includes/js/sortables.js"></script>
<style type="text/css">
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}
</style>
</head>
<body>
<?
$cat = $_GET["cat"];
$filter_date = $_GET["date"];
$filter_web = $_GET["web"];
$sites = array();
$contacts = array();
if($cat == "inspin"){
	$sites = array(new website(1,"Inspin","http://jobs.inspin.com/signups-list.php"));
}else if($cat == "casino"){
	$sites = array(new website(1,"Play Blackjack","http://www.playblackjack.com/contacts.php"),
				   new website(2,"Blackjack Fight","http://www.blackjackfight.com/contacts.php"),
				   new website(3,"Casino Games Online","http://www.casinogamesonline.com/contacts.php"),
				   new website(4,"Online Casino Blackjack","http://www.onlinecasinoblackjack.com/contacts.php"),
				   new website(5,"Play Blackjack Hit or Stand Widget Players","http://www.playblackjack.com/hitorstand-players.php"),
				   new website(6,"Blackjack Knockout","http://www.blackjackknockout.com/contacts.php"),
				   new website(7,"Free Blackjack Guide","http://www.freeblackjackguide.com/contacts.php"),
				   new website(8,"Play Online Poker","http://www.playonlinepoker.com/contacts.php"),
				   new website(9,"Blackjack Card Counting","http://www.blackjackcardcounting.com/contacts.php"),
				   new website(10,"Blackjack Tournament Online","http://www.blackjacktournamentonline.com/contacts.php"),
				   new website(11,"Free Online Blackjack","http://www.freeonlineblackjack.com/contacts.php"));
}else if($cat == "pph"){
	$sites = array(new website(1,"Bookie PPH","http://www.bookiepph.com/contacts.php"),
			 	   new website(2,"Bookie Pay Per Head","http://www.bookiepayperhead.com/contacts.php"),
				   new website(3,"Bookie Price Per Head","http://www.bookiepriceperhead.com/contacts.php"));
	
}else if($cat == "sbo"){
	$sites = array(new website(1,"Sports Betting Online","http://www.sportsbettingonline.ag/contacts.php"),
				   new website(2,"Bet College Football","http://www.betcollegefootball.com/contacts.php"),
				   new website(3,"Bet College Basketball","http://www.betcollegebasketball.com/contacts.php"),
				   new website(4,"Free Football Odds","http://www.freefootballodds.com/contacts.php"),
				   new website(5,"Horse Racing Betting","http://www.horseracingbetting.com/contacts.php"));	
}
else if($cat == "horizon"){
	//$contacts = get_book_signups(3, $filter_date);
}

$query_date = "";
if($filter_date != ""){$query_date = "?date=$filter_date";}
foreach ($sites as $site){
	if($filter_web == "all" || $filter_web == $site->id){
		$results = file_get_contents($site->url . $query_date);	
		$level_one = explode("!",$results);
		foreach ($level_one as $string_contact){
			$info = explode("/",$string_contact);
			if ( contains($info[0],"@") or strlen($info[2]) > 3 ) {
			   $contacts[] = new contact($info[0], $info[1], $info[2], $info[3], $site->name);
			}
		}
	}
}
?>
<script type="text/javascript">
function filter(){
	location.href = "contacts.php?cat=<? echo $cat ?>&date=" + document.getElementById("date_from").value + "&web=" + document.getElementById("web_list").value;
}
</script>
<? include "../includes/header.php" ?>
<? include "../includes/menu_reports.php" ?>
<div class="page_content" style="padding-left:50px;">
  <span class="page_title"><? echo ucwords($cat) ?> Contacts</span><br /><br />
  From: <input name="date_from" type="text" id="date_from" value="<? echo $filter_date ?>" /> <span class="little">Example: 2011-05-27</span> &nbsp;&nbsp;&nbsp;&nbsp;
  Website: 
  <select name="web_list" id="web_list">
    <option value="all">All Websites</option>
    <? foreach($sites as $webpage){ ?>
    <option value="<? echo $webpage->id ?>"><? echo $webpage->name ?></option>
    <? } ?>
  </select>
  &nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="button" value="Filter" onclick="filter();" />
  <script type="text/javascript">load_dropdown("web_list", "<? echo $filter_web ?>", false);</script>
  <br /><br />
  <table style="cursor:pointer;" class="widefat sortable" width="100%" border="0" cellspacing="0" cellpadding="10">
    <thead>
      <tr>
        <th scope="col" nowrap="nowrap"><strong>Email</strong></th>
        <th scope="col" nowrap="nowrap"><strong>Name</strong></th>
        <th scope="col" nowrap="nowrap"><strong>Phone</strong></th>
        <th scope="col" nowrap="nowrap"><strong>Contact Date</strong></th>
        <th scope="col" nowrap="nowrap"><strong>Website</strong></th>
      </tr>
    </thead>
    <tbody id="the-list">
      <? 
	  $i=0;
	  foreach($contacts as $contact){
		  $i++;
		  if($i % 2){$style = 'style="background:#CCC"';}else{$style = "";}
	  ?>
      <tr <? echo $style ?>>
        <td class="small_table_content"><? echo strtolower($contact->email); ?></td>
        <td class="small_table_content"><? echo $contact->name; ?></td>
        <td class="small_table_content"><? echo $contact->phone; ?></td>
        <td class="small_table_content"><? echo $contact->cdate; ?></td>
        <td class="small_table_content"><? echo $contact->web; ?></td>
      </tr>
      <? } ?>
    </tbody>
    </table>
</div>
<? include "../includes/footer.php" ?>