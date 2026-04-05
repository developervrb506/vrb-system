<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<?
if(isset($_GET["ed"])){
	$user = get_wid_tweet_user($_GET["ed"]);
	if($user->vars["available"]){$user->vars["available"] = 0;}
	else{$user->vars["available"] = 1;}
	
	$user->update(array("available"));
	header("Location: tweet_user.php?e=3");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
</head>
<body>
<? include "../../../includes/header.php" ?>
<? include "../../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Users Lists</span><br /><br />

<? include "./ck/includes/print_error.php" ?>

<a href="tweet_create_user.php" class="normal_link">Create New User</a><br /><br />
<? $users = get_Wid_all_tweet_user(); ?>


<strong>Tweet Users</strong><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">user</td>
    <td class="table_header" align="center">Added Date</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Edit</td>
  </tr>
  <? foreach($users as $user ){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $user->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $user->vars["user"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $user->vars["added_date"]; ?></td>
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? 
	    if ($user->vars["available"]) {echo "Available"; } else {echo "Disabled"; }
	   ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="tweet_create_user.php?uid=<? echo $user->vars["id"] ?>">Edit</a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>



</div>
<? include "../../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
