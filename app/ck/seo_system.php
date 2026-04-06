<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<script type="text/javascript">
function delete_seo_entry(id){	
 if(confirm("Are you sure you want to delete this seo entry?")){   	  
    document.location.href = BASE_URL . '/ck/process/actions/delete_seo_entry_action.php?delete_id='+ id;   
 }
}
function paid_seo_entry(id,paid_message,paid_status){	
 if(confirm('Are you sure you want to '+ paid_message +' this seo entry?')){   	  
    document.location.href = BASE_URL . '/ck/process/actions/paid_seo_entry_action.php?paid_id='+ id +'&paid_status='+ paid_status;   
 }
}
function complete_seo_entry(id,paid_message,paid_status){	
 if(confirm('Are you sure you want to masrk as  '+ paid_message +' this seo entry?')){   	  
    document.location.href = BASE_URL . '/ck/process/actions/complete_seo_entry_action.php?paid_id='+ id +'&paid_status='+ paid_status;   
 }
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
Shadowbox.init();
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO</title>
</head>
<body>
<? $page_style = " width:3000px;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="create_seo_entry.php" class="normal_link">New Entry</a>

<br /><br />

<?
if (isset($_GET["paid"])) {
  $paid = $_GET["paid"];
}
else {	  
  $paid = "2"; 
}
$brand = $_GET["brand"];
$keyword = $_GET["keyword"];
$email = $_GET["email"];
?>
<form method="get">
<strong>Filter Seo Entries:</strong>&nbsp;&nbsp;&nbsp;
Paid:
<select name="paid" id="paid">
  <option <? if($paid == "2"){?> selected="selected" <? } ?> value="2">All</option>
  <option <? if($paid == 0){?> selected="selected" <? } ?> value="0">Upaid</option>
  <option <? if($paid == 1){?> selected="selected" <? } ?> value="1">Paid</option>
</select>
&nbsp;&nbsp;
Brand:
<input name="brand" type="text" id="brand" value="<? echo $brand ?>" />
&nbsp;&nbsp;
Keyword:
<input name="keyword" type="text" id="keyword" value="<? echo $keyword ?>" />
&nbsp;&nbsp;
Email:
<input name="email" type="text" id="email" value="<? echo $email ?>" />
&nbsp;&nbsp;
<input name="" type="submit" value="Filter" />
</form>


<br /><br />
<?
if ($paid == 2) {	 
  $paid = "";	
} 
$groups = get_seo_entries_report($paid, $brand, $keyword, $email);
$clerks = get_all_clerks_index("", "", false,true);
$articles = get_all_seo_articles();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Brand</td>
    <td class="table_header" align="center">Target URL</td>
    <td class="table_header" align="center">Web URL</td>
    <td class="table_header" align="center">Keywords</td>
    <td class="table_header" align="center">Rank</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Email</td>
    <td class="table_header" align="center">Method</td>
    <td class="table_header" align="center" nowrap="nowrap">Paid Date</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Article</td>
    <td class="table_header" align="center">Article URL</td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <? foreach($groups as $group){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  <?
  if ( $group->vars["paid_date"] == date("Y-m-d") && !$group->vars["paid"]) {
	  $style_color = "_yellow";
  }
  elseif($group->vars["paid_date"] < date("Y-m-d") && !$group->vars["paid"]){
	  $style_color = "_red";
  }elseif($group->vars["url"] == 'NA' && $group->vars["paid"]){
	  $style_color = "_blue";
  }else {
	  $style_color = "";
  }
  $rel_web = get_seo_website($group->vars["website"]);
  ?>
  <tr>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["brand"]; ?></td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["url"]; ?></td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;">
		<? if(!contains_ck($rel_web->vars["website"],"RELATION")){echo $rel_web->vars["website"];} ?>
    </td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["keywords"]; ?></td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["rank"]; ?></td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;">
		<a href="seo_system.php?paid=1&brand=&keyword=&email=<? echo $group->vars["email"]; ?>" class="normal_link" target="_blank"><? echo $group->vars["email"]; ?></a>
    </td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["method"]; ?></td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;">
	<?
	 if ( $group->vars["paid_date"] != "0000-00-00" ) { 
	   echo date("Y-m-d", strtotime($group->vars["paid_date"]));
	 }
	?>    
    </td> 
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $clerks[$rel_web->vars["clerk"]]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>">
    	<p>Type: <? echo $group->vars["article_type"]; ?></p>
    	<? if($group->vars["article"] != ""){ ?> <p><a href="csv/<? echo $group->vars["article"] ?>" target="_blank" class="normal_link">View Article</a></p> <? } ?>
    	<form method="post" enctype="multipart/form-data"  action="process/actions/seo_upload_article.php">
        	<input name="link" type="hidden" id="link" value="<? echo $group->vars["id"]; ?>" />
            <input name="article" type="file" id="article" />
            <p><strong>OR</strong></p>
            <? create_objects_list("pre_article", "pre_article", $articles, "file", "fullname", "-- Select from list --") ?><br />
            <p><input name="" type="submit" value="Upload" /></p>
        </form>
    </td> 
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["article_url"]; ?></td>  
    
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_seo_entry.php?gid=<? echo $group->vars["id"] ?>">Edit</a>
    </td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;">
    	<a onClick="delete_seo_entry('<? echo $group->vars["id"] ?>')" class="normal_link" href="javascript:;">Delete</a>
    </td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;">
        <?
		if (!$group->vars["paid"]) {
		   $paid_status_message = "Unpaid";
		   $paid_status_message_param = "Paid";
		   $paid_status = 1;	
		   $onclick	 = "document.getElementById('paid_form_".$group->vars["id"]."').style.display = 'block';";
		}
		else {
		   $paid_status_message = "Paid";
		   $paid_status_message_param = "Unpaid";
		   $paid_status = 0;	
		   $onclick	= "paid_seo_entry('". $group->vars["id"] ."','". $paid_status_message_param ."','". $paid_status ."')";
		   echo "<p>".$group->vars["paid_comments"]."</p>";
		}
		?>
    	<a onClick="<? echo $onclick ?>" class="normal_link" href="javascript:;">
        <? echo $paid_status_message; ?>
        </a>
        <div style="display:none" id="paid_form_<? echo $group->vars["id"]; ?>">
        	<form method="post"  action="process/actions/seo_mark_paid.php">
                <input name="link" type="hidden" id="link" value="<? echo $group->vars["id"]; ?>" />
                <textarea name="paid_comments" cols="30" rows="5" id="paid_comments"></textarea>
                <br />
                <input name="" type="submit" value="Mark as Paid" />
            </form>
        </div>
    </td>
    <td class="table_td<? echo $style ?><? echo $style_color ?>" style="text-align:center; font-weight:normal;">
        <?
		if ($group->vars["complete"] == 0) {
		   $complete_status_message = "Incomplete";
		   $complete_status_message_param = "complete";
		   $complete_status = 1;		  
		}
		else {
		   $complete_status_message = "Complete";
		   $complete_status_message_param = "incomplete";
		   $complete_status = 0;	
		}
		?>
    	<a onClick="complete_seo_entry('<? echo $group->vars["id"] ?>','<? echo $complete_status_message_param ?>','<? echo $complete_status ?>')" class="normal_link" href="javascript:;">
        <? echo $complete_status_message; ?>
        </a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>