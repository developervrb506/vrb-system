<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sports_jobs")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Sports Jobs</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Sports Jobs</span><br /><br />
 
<? $lurl = "http://jobs.inspin.com/jobs/Feeds/logs/"; ?>

	<p>Be patient, running the job manually could take several minutes.</p><br /><br />
 
 <p>
 	<strong>Standings</strong> (Last update: <? echo file_get_contents($lurl."standings.txt"); ?>)
    &nbsp;&nbsp;
    <a href="http://jobs.inspin.com/jobs/Feeds/index.php?action=standings" class="normal_link" rel="shadowbox;height=350;width=405">Run Manually</a>
 
 </p>
 <p>
 	<strong>Injuries</strong> (Last update: <? echo file_get_contents($lurl."injuries.txt"); ?>)
 	&nbsp;&nbsp;
    <a href="http://jobs.inspin.com/jobs/Feeds/index.php?action=injuries" class="normal_link" rel="shadowbox;height=350;width=405">Run Manually</a>
 </p>
 <p>
 	<strong>Stats</strong> (Last update: <? echo file_get_contents($lurl."stats.txt"); ?>)
 	&nbsp;&nbsp;
    <a href="http://jobs.inspin.com/jobs/Feeds/index.php?action=stats" class="normal_link" rel="shadowbox;height=350;width=405">Run Manually</a>
 </p>
 <p>
 	<strong>Trends</strong> (Last update: <? echo file_get_contents($lurl."trends.txt"); ?>)
 	&nbsp;&nbsp;
    <a href="http://jobs.inspin.com/jobs/Feeds/index.php?action=trends" class="normal_link" rel="shadowbox;height=350;width=405">Run Manually</a>
 </p>
 <p>
 	<strong>Sports Feeds</strong> (Last update: <? echo file_get_contents($lurl."sports.txt"); ?>)
 	&nbsp;&nbsp;
    <a href="http://jobs.inspin.com/jobs/Feeds/index.php?action=sport" class="normal_link" rel="shadowbox;height=350;width=405">Run Manually</a>
 </p>
 <p>
 	<strong>Previews and Recaps</strong> (Last update: <? echo file_get_contents($lurl."previews.txt"); ?>)
 	&nbsp;&nbsp;
    <a href="http://jobs.inspin.com/jobs/Feeds/index.php?action=previews" class="normal_link" rel="shadowbox;height=350;width=405">Run Manually</a>
 </p>
 <p>
 	<strong>Breaking News</strong> (Last update: <? echo file_get_contents($lurl."news.txt"); ?>)
 	&nbsp;&nbsp;
    <a href="http://jobs.inspin.com/jobs/Feeds/index.php?action=news" class="normal_link" rel="shadowbox;height=350;width=405">Run Manually</a>
 </p>
 
 

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>