<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<title>Poker Tweets</title>
</head>
<body>
<? include "../../../includes/header.php" ?>
<? include "../../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Poker Tweets Menu (Under Construction)</span><br /><br />

<? include "../../includes/print_error.php" ?>


<table width="100%" border="0" cellpadding="10">
  <tr>
      <td width="50%">
        <a class="normal_link" href="tweet_user.php">Twitters Users</a><br />
        Manage all the Twitters users to get their tweets.
    </td>
    <td width="50%">
        <a class="normal_link" href="tweet_list.php">List Tweets</a><br />
        Show all the tweets available in the System.
  </td>
  
  </tr>
  
  
 
 
</table>

</div>
<? include "../../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>