<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rescue_center_oldsite")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Rescue Center Admin</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Rescue Center Admin</span>
<br /><br />

<p>
<strong><a href="news.php" class="normal_link">News</a></strong><br />
Manage page news
</p>
<p>
<strong><a href="experiences.php" class="normal_link">Experiences</a></strong><br />
Shows a list of all Experiences sent to the website
</p>
<p>
<strong><a href="donations.php" class="normal_link">Donations</a></strong><br />
Shows a list of all Donations.
</p>
<p>
<strong><a href="adopt-nest-contributions.php" class="normal_link">Adopt a nest contributions</a></strong><br />
Shows a list of all adopt a nest contributions.
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
<strong><a href="internships.php" class="normal_link">Internships</a></strong><br />
Shows a list of all Internships registered in the website
</p>
<p>
<strong><a href="calendar.php" class="normal_link">Internships and Volunteers Calendar</a></strong><br />
Shows a calendar with Internships and Volunteers starting and ending dates
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
<strong><a href="horse-program.php" class="normal_link">Horse Program Participants</a></strong><br />
Shows a list of all horse program participants
</p>
<p>
<strong><a href="sign-petitions.php" class="normal_link">Sign Petitions</a></strong><br />
Shows a list of all sign petitions
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
<?php /*?><p>
<strong><a href="turtle-programs-participants.php" class="normal_link">Turtle Programs Participants</a></strong><br />
Shows a list of all turtle programs participants
</p><?php */?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>