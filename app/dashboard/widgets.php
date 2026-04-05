<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Widgets</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<? $size = "93x25"; ?>
<? $campaigns = get_all_campaignes_for_affiliate($current_affiliate); ?>
<div class="page_content">
<span class="page_title">Widgets</span><br /><br />
<script type="text/javascript">
function reload_iframe(){
	var promo = document.getElementById('banners').value;
	if(promo != "np"){
		document.getElementById('if_content').src = 'http://jobs.inspin.com/includes/ticker/vrb_center.php?aid=<? echo $current_affiliate->id ?>&bid=' + promo;
	}
}
</script>

Campaign: <? echo get_campaigns_by_size($campaigns, $size, "banners", "reload_iframe();", true) ?>

<div style="margin-left:-20px;"><iframe id="if_content" frameborder="0" width="965" height="1000" scrolling="no"></iframe></div>

</div>
<? include "../includes/footer.php" ?>