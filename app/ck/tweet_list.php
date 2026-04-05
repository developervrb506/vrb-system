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
<script type="text/javascript">
Shadowbox.init();
function delete_tweet(id){
	if(confirm("Are you sure you want to DELETE this Tweet from the system?")){
		document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/delete_tweet.php?tweet="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
</head>
<body>
<? $page_style = " width:2100px;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Tweets Lists</span><br /><br />

<? include "includes/print_error.php" ?>


<div align="right">
	<iframe src="http://localhost:8080/ck/process/actions/delete_tweet.php" width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

<? $users = get_all_tweet_user(); ?>
<? $tweets = get_all_tweets(1,$_POST["user"]); ?>

<pre>
<? // print_r($tweets); ?>
</pre>

<form action="tweet_list.php" method="post">

 <strong>User:</strong> <? create_objects_list("user", "user", $users, "id", "user", $default_name = "All Users",$_POST["user"],"","_tweet_keyword");  ?>

 <input type="submit" name="sent" id="sent" value="Search">

<form>
<BR />
<BR />



<?
if (count($tweets)>0) {
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td class="table_header" align="center">User Name</td>
    <td class="table_header" align="center">user</td>
    <td class="table_header" align="center">Tweet</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Edit</td>
  </tr>
  <? foreach($tweets as $tweet ){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr id="tr_<? echo $tweet->vars["id"]; ?>">
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $tweet->vars["user_id"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $tweet->vars["user_id"]->vars["user"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $tweet->vars["tweet"]; ?></td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $tweet->vars["created_date"]; ?></td>
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? 
	    if ($tweet->vars["available"]) {echo "Available"; } else {echo "Disabled"; }
	   ?></td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="javascript:;" onclick="delete_tweet('<? echo $tweet->vars["id"] ?>');">
        	Delete
        </a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

<? } else { echo "There are not Availables Tweets at this momment"; }?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
