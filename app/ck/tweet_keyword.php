<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<?
if(isset($_GET["ed"])){
	$keyword = get_tweet_keyword($_GET["ed"]);
	if($keyword->vars["available"]){$keyword->vars["available"] = 0;}
	else{$keyword->vars["available"] = 1;}
	
	$keyword->update(array("available"));
	header("Location: clerks.php?e=3");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
function delete_user(name, id){
	if(confirm("Are you sure you want to DELETE "+name+" from the system?")){
		document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/delete_user.php?user="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Keywords Lists</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="tweet_create_keyword.php" class="normal_link">Create New Keyword</a><br /><br />
<? $keywords = get_all_tweet_keyword(); ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td class="table_header" align="center">Keyword</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Added Date</td>
    <td class="table_header" align="center">Edit</td>
  </tr>
  <? foreach($keywords as $keyword ){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $keyword->vars["keyword"]; ?></td>
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? 
	   if ($keyword->vars["available"]) {echo "Available"; } else {echo "Disabled"; }
	   ?></td>
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $keyword->vars["added_date"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="tweet_create_keyword.php?uid=<? echo $keyword->vars["id"] ?>">Edit</a>
    </td>
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
