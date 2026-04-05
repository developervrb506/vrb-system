<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cranimal_rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Costa Rica Animal Rescue Center Admin</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Costa Rica Animal Rescue Center Admin</span>
<br /><br />
<p>
<strong><a href="rooms.php" class="normal_link">Rooms</a></strong><br />
Shows list of all rooms, it's bed numbers and a rooms chart.
</p>
<p>
<strong><a href="check_repeated_emails.php" class="normal_link">Check Repeated Emails</a></strong><br />
Shows list of all repeated volunteers emails in other VRB pages.
</p>
<p>
<strong><a href="donations.php" class="normal_link">Donations</a></strong><br />
Shows list of all Donations.
</p>

<p>
<strong><a href="manual-donations.php" class="normal_link">Manual Donations</a></strong><br />
Shows list of all manual donations.
</p>

<p>
<strong><a href="sponsors.php" class="normal_link">Sponsors</a></strong><br />
Shows list of all sponsors.
</p>

<p>
<strong><a href="day-visits.php" class="normal_link">Day Visits</a></strong><br />
Shows a list of all Daily Visitors registered in the website
</p>

<p>
<strong><a href="volunteers.php" class="normal_link">Volunteers</a></strong><br />
Shows a list of all Volunteers registered in the website
</p>
<p>
<strong><a href="volunteers-preview.php" class="normal_link">Volunteers Preview Step 1</a></strong><br />
Shows a list of all Volunteers registered in the website in the step # 1
</p>
<p>
<strong><a href="drivers.php" class="normal_link">Drivers</a></strong><br />
Shows a list of all the available Drivers
</p>
<p>
<strong><a href="top-header-quotes.php" class="normal_link">Top Headers Quotes</a></strong><br />
Shows a list of all the available top headers quotes
</p>
<p>
<strong><a href="daily-work.php" class="normal_link">Daily Work</a></strong><br />
Shows a list of all the daily work activities
</p>
<p>
<strong><a href="food-options.php" class="normal_link">Food options</a></strong><br />
Shows a list of all the food options
</p>
<p>
<strong><a href="diets.php" class="normal_link">Diets</a></strong><br />
Shows a list of all Diets - Volunteers registered in the website
</p>
<p>
<strong><a href="calendar_payment_details_volunteers.php" class="normal_link">Calendar Payment Details Volunteers</a></strong><br />
Shows a calendar of Volunteers Payment Details
</p>
<p>
<strong><a href="coordinators.php" class="normal_link">Coordinators</a></strong><br />
Shows a list of all Coordinators registered in the website
</p>
<p>
<strong><a href="calendar-volunteers-coordinators.php" class="normal_link">Coordinators and Volunteers Calendar</a></strong><br />
Shows a calendar with Coordinators and Volunteers starting and ending dates
</p>
<p>
<strong><a href="contact.php" class="normal_link">Contact Us</a></strong><br />
Shows a list of all contact us messages
</p>
<p>
<strong><a href="newsletter.php" class="normal_link">Newsletter</a></strong><br />
Shows a list of all emails registered in the Newsletter form
</p>
<p>
<strong><a href="animals.php" class="normal_link">Animals</a></strong><br />
Shows a list of all the animals included in VRB.
</p>
<p>
<strong><a href="animals-categories.php" class="normal_link">Animals Categories</a></strong><br />
Shows a list of all the animals categories included in VRB.
</p>
<p>
<strong><a href="experiences-links.php" class="normal_link">Volunteer Experiences Links</a></strong><br />
Shows a list of all the volunteer experiences links included in VRB.
</p>
<p>
<strong><a href="approved-reviews.php" class="normal_link">Approved Reviews</a></strong><br />
Shows a list of all the approved reviews
</p>
<p>
<strong><a href="manual-reviews.php" class="normal_link">Manual Reviews</a></strong><br />
Shows a list of all the manual reviews included in VRB
</p>
<p>
<strong><a href="transportation.php" class="normal_link">Transportation Requests</a></strong><br />
Shows a list of all the transportation requests
</p>
<p>
<strong><a href="calendar_transportation.php" class="normal_link">Calendar Transportation</a></strong><br />
Shows a calendar with all the transportation requests per date.
</p>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>