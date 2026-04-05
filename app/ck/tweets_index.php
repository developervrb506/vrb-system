<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Tweets Menu</span><br /><br />

<? include "includes/print_error.php" ?>


<table width="100%" border="0" cellpadding="10">
  <tr>
      <td width="33%">
        <a class="normal_link" href="tweet_user.php">Twitter Users</a><br />
        Manage all the Twitters users to get their tweets.
    </td>
     <td width="33%">
        <a class="normal_link" href="tweet_keyword.php">Twitter Keywords</a><br />
        Manage all the Keywords to for tweets.
    </td>
            
    <td width="33%">
        <a class="normal_link" href="twitter_members.php">Twitter members</a><br />
        Show all the twitter members or players in the System.
    </td>
  
  </tr>
  
  
  <tr>
  <td width="33%">
        <a class="normal_link" href="tweet_alert.php">Tweets Alerts</a><br />
        Show all the tweets that cointains a Keyword
    </td>
  
   <td width="33%">
        <a class="normal_link" href="tweet_list.php">List Tweets</a><br />
        Show all the tweets available in the System.
  </td>
  
  <td width="33%">
       
  </td>
 
  
  </tr>
 
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>