<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("volunteer_tours")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Volunteer Tours Admin</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Volunteer Tours Admin</span>
<br /><br />
<p>
<strong><a href="approved-reviews.php" class="normal_link">Approved Reviews</a></strong><br />
Shows a list of all the approved reviews
</p>
<p>
<strong><a href="available_dates.php" class="normal_link">Available Dates</a></strong><br />
List of available dates
</p>
<p>
<strong><a href="bookings_calendar.php" class="normal_link">Booking Pending Payments Calendar</a></strong><br />
Calendar that shows all the booking pending payments.
</p>
<p>
<strong><a href="bookings.php" class="normal_link">Bookings</a></strong><br />
List of all bookings information.
</p>
<p>
<strong><a href="transportation_arrival_dates_calendar.php" class="normal_link">Calendar Transportation</a></strong><br />
Shows a calendar with all the transportation requests per date.
</p>
<p>
<strong><a href="categories.php" class="normal_link">Categories</a></strong><br />
List of all tours categories.
</p>
<p>
<strong><a href="contacts.php" class="normal_link">Contacts</a></strong><br />
List of all contact requests.
</p>
<p>
<strong><a href="customized_tours.php" class="normal_link">Customized Tours</a></strong><br />
List of all customized tours contact requests.
</p>
<p>
<strong><a href="news.php" class="normal_link">In the news</a></strong><br />
List of all news related to Volunteer Tours.
</p>
<p>
<strong><a href="itineraries.php" class="normal_link">Itineraries</a></strong><br />
List of all volunteers itineraries.
</p>
<p>
<strong><a href="manual-reviews.php" class="normal_link">Manual Reviews</a></strong><br />
Shows a list of all the manual reviews included in VRB
</p>
<p>
<strong><a href="newsletter_subscriptions.php" class="normal_link">Newsletter Subscriptions</a></strong><br />
List of all newsletter subscriptions.
</p>
<p>
<strong><a href="transportation_departure_dates_calendar.php" class="normal_link">Transportation Departure Dates Calendar</a></strong><br />
Calendar that shows all the transportation departure dates.
</p>
<p>
<strong><a href="transportation_requests.php" class="normal_link">Transportation Requests</a></strong><br />
List of all tranportation requests submissions.
</p>
<p>
<strong><a href="trips_requests.php" class="normal_link">Trips Requests</a></strong><br />
List of all build a tour requests submissions.
</p>
<p>
<strong><a href="trips_requests_calendar.php" class="normal_link">Trips Requests Calendar</a></strong><br />
Calendar that shows all the trips requests.
</p>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>