<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("twitter_updater")){ ?>
<?
$league = post_get("league");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Twitter Updater</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Twitter Updater</span>

<br /><br />

<form method="post">
League:  <select name="league" id="league">
  <option value="">- Select -</option>
  <option value="nfl" <? if($league == "nfl"){ ?> selected="selected" <? } ?>>NFL</option>
  <option value="nba" <? if($league == "nba"){ ?> selected="selected" <? } ?>>NBA</option>
  <option value="mlb" <? if($league == "mlb"){ ?> selected="selected" <? } ?>>MLB</option>
  <option value="nhl" <? if($league == "nhl"){ ?> selected="selected" <? } ?>>NHL</option>
</select>
&nbsp;&nbsp;<input name="Submit" type="submit" value="Update" />
</form>

<br /><br />

<? if($league != ""){ echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/tweeter_updater.php?l=$league"); } ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>