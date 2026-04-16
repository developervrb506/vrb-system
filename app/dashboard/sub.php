<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? $parent = $_SESSION['parent_aff_id']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"web_name",type:"null", msg:"You need to write a Website Name"});
validations.push({id:"web_url",type:"null", msg:"You need to write a Website URL"});
function validate_delete(id){
	var answer = confirm ("Are you sure you want to DELETE this Website?")
	if (answer){
		location.href = '../process/actions/delete_website.php?ws=' + id;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Partners</title>
</head>
<body style="font-size:12px;">
<? include "../includes/header.php" ?>
<? if(isset($_GET["add"])){ include "../includes/menu.php"; } ?>
<div class="page_content" style="padding-left:20px; display:inline-block; width:928px;">

<div class="left_column" style="width:150px;">    
    <? include(ROOT_PATH . "/includes/account_menu.php") ?>
</div>

<div class="right_column" style="width:730px;">

<span class="page_title">Your Websites</span><br /><br />

<?
if($parent == ""){$parent = $current_affiliate->id;}
$subaccounts = get_subaccounts($parent);
$i = 0;
foreach($subaccounts as $sub){
?>
	<div class="main_links_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><!--<a class="normal_link" href="../process/actions/change_web.php?sid=<? echo $sub->id ?>"> --><? echo ucwords($sub->web_name) . " (" . $sub->web_url . ")"; ?><!--</a>--></td>
            <td style="text-align:right;"><? if($i == 0){echo "Main Website";}else{?> <a class="normal_link" onclick="validate_delete('<? echo $sub->id ?>')" href="javascript:;">Delete</a> <? } ?></td>
          </tr>
        </table>
	</div>
<? $i++; } ?>

<br /><br />
<? if(isset($_GET["add"])){?>
<span class="page_title">Add Website</span><br /><br /><br />

	<div class="conte_banners">
            <div class="conte_banners_header"><strong>Add New Website</strong> </div>
        <br />
       <form action="../process/actions/add_website.php" method="post" onsubmit="return validate(validations);">
        	Website Name: <input name="web_name" type="text" id="web_name" />&nbsp;&nbsp;&nbsp;&nbsp;Website URL: <input name="web_url" type="text" id="web_url" /><br /><br />
     		<input name="" type="submit" value="Submit" />
      </form>
    </div>
<? } ?>

</div>






</div>
<? include "../includes/footer.php" ?>