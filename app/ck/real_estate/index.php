<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("real_estate")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Real Estate Admin</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Real Estate Admin</span>
<br /><br />
<strong><a href="../real_estate/properties.php" class="normal_link">Properties</a></strong><br />
Access to see all current properties/listings.
</p>
<?php /*?><p>
<strong><a href="../real_estate/realtors.php" class="normal_link">Realtors</a></strong><br />
Access to see all current realtors.
</p><?php */?>
<p>
<strong><a href="../real_estate/regions.php" class="normal_link">Regions</a></strong><br />
Access to see all current regions.
</p>
<p>
<strong><a href="../real_estate/cities.php" class="normal_link">Cities</a></strong><br />
Access to see all current cities.
</p>
<p>
<strong><a href="../real_estate/accommodation_types.php" class="normal_link">Accommodation types</a></strong><br />
Access to see all current accommodation types.
</p>
<p>
<strong><a href="../real_estate/property_types.php" class="normal_link">Property types</a></strong><br />
Access to see all current property types.
</p>
<p>
<strong><a href="../real_estate/property_statuses.php" class="normal_link">Property statuses</a></strong><br />
Access to see all current property statuses.
</p>
<p>
<strong><a href="../real_estate/property_features.php" class="normal_link">Property features</a></strong><br />
Access to see all current property features.
</p>
<p>
<strong><a href="../real_estate/newsletter_contacts.php" class="normal_link">Newsletter Contacts</a></strong><br />
Access to see all newsletter contacts.
</p>
<p>
<strong><a href="../real_estate/contacts.php" class="normal_link">Contacts</a></strong><br />
Access to see all current contacts.
</p>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>