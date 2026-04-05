<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rc_partners")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Rescue Center Partners Admin</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Rescue Center Partners Admin</span>
<br /><br />
<p>
<strong><a href="partners_campaigns.php" class="normal_link">Manage Campaigns</a></strong><br />
Access to manage the customize campaigns.
</p>
<p>
<strong><a href="partners_custom_promotype_view.php" class="normal_link">Manage Custom Promotypes</a></strong><br />
Access to manage the customize promotypes.
</p>
<p>
<strong><a href="partners_endorsements.php" class="normal_link">Manage Endorsements</a></strong><br />
Access to manage the endorsements.
</p>
<p>
<strong><a href="partners_affiliates.php" class="normal_link">Manage Partners</a></strong><br />
Access to manage the partners.
</p>
<p>
<strong><a href="partners_news.php" class="normal_link">Manage Partners News</a></strong><br />
Access to manage the partners news.
</p>
<p>
<strong><a href="partners_posts.php" class="normal_link">Manage Posts: Articles, Press Releases and Infographics</a></strong><br />
Access to manage the posts.
</p>
<p>
<strong><a href="partners_programs_descriptions.php" class="normal_link">Manage Programs Descriptions</a></strong><br />
Access to manage the programs descriptions.
</p>
<p>
<strong><a href="partners_social_media_promotypes.php" class="normal_link">Manage Social media promo types: Pictures and Videos</a></strong><br />
Access to manage the social media promo types: Pictures and Videos.
</p>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>