<? ini_set('memory_limit', '1024M'); ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<?
if(isset($_GET["ed"])){
	$user = get_tweet_user($_GET["ed"]);
	if($user->vars["available"]){$user->vars["available"] = 0;}
	else{$user->vars["available"] = 1;}
	
	$user->update(array("available"));
	header("Location: clerks.php?e=3");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
</head>
<body>
<? $page_style = " width:2100px;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Tweets Alerts</span><br /><br />

<? include "includes/print_error.php" ?>


<? $keywords = get_all_tweet_keyword(1); ?>

<?

  $alerts = get_all_tweets_alerts($_POST["keywords"]);
echo "<pre>";
//print_r($alerts);
echo "</pre>";


?>


<form action="tweet_alert.php" method="post">

 <strong>Keywords:</strong> <? create_objects_list("keywords", "keywords", $keywords, "id", "keyword", $default_name = "All Keywords",$_POST["keywords"],"","_tweet_keyword");  ?>

 <input type="submit" name="sent" id="sent" value="Search">

<form>
<BR />
<BR />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td class="table_header" align="center">Keyword</td>
    <td class="table_header" align="center">User</td>
    <td class="table_header" align="center">Tweet</td>
    <td class="table_header" align="center">Created Date</td>

  </tr>
  <? foreach($alerts as $alert ){
  if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $alert->vars["keyword"]->vars["keyword"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $alert->vars["tweet"]->vars["user_id"]->vars["name"]."(".$alert->vars["tweet"]->vars["user_id"]->vars["user"].")"; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $alert->vars["tweet"]->vars["tweet"]; ?></td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><?  echo $alert->vars["tweet"]->vars["created_date"] ?></td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>



</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
