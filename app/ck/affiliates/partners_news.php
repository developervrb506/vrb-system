<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Partners News</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
//-->

</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
</head>
<?
if(isset($_POST["news"])){
	$news = get_affiliate_news(1);
	$news->vars["content"]= $_POST["news"];
	$news->update();
	?><script type="text/javascript">alert("News Saved")</script><?
}
?>



<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Partners News</span><br /><br />
<?
$news = get_affiliate_news(1);
?>

<form method="post" action="partners_news.php">
    News:<br />
    <textarea name="news" cols="80" rows="20" id="news"><? echo $news->vars["content"]; ?></textarea><br /><br />
    <input name="Submit" type="submit" value="Save News" />
</form>
      



</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>