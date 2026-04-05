<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rc_center_org")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Rescue Center.ORG Admin</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Rescue Center.ORG Admin</span>
<br /><br />
<p>
<strong><a href="../rc_center_org/donations.php" class="normal_link">Donations</a></strong><br />
Access to see all the website's donations.
</p>
<p>
<strong><a href="../rc_center_org/aboutus.php" class="normal_link">About Us Content</a></strong><br />
Access to modify the About Us Page content.
</p>
<p>
<strong><a href="../rc_center_org/faq.php" class="normal_link">FAQ Content</a></strong><br />
Access to handle FAQ content.
</p>
<p>
<strong><a href="../rc_center_org/testimonials.php" class="normal_link">Testimonials</a></strong><br />
Access to handle all the website's testimonials.
</p>
<p>
<strong><a href="../rc_center_org/contacts.php" class="normal_link">Contacts</a></strong><br />
Access to see all the website's contacts.
</p>
<p>
<strong><a href="../rc_center_org/work-with-us-contacts.php" class="normal_link">Work with us contacts</a></strong><br />
Access to see all the website's contacts who want to work with us.
</p>
<p>
<strong><a href="../rc_center_org/achievements.php" class="normal_link">Achievements</a></strong><br />
Access to handle all the website's achievements.
</p>
<p>
<strong><a href="../rc_center_org/news.php" class="normal_link">News</a></strong><br />
Access to handle all the website's news.
</p>
<p>
<strong><a href="../rc_center_org/501-c3-ong-status.php" class="normal_link">501-C3 ONG Status Content</a></strong><br />
Access to modify the 501-C3 ONG Status Page content.
</p>
<p>
<strong><a href="../rc_center_org/projects.php" class="normal_link">Projects</a></strong><br />
Access to handle all the website's projects.
</p>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>