<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"You need to write a Campaign Name"});
function validate_delete(id){
	var answer = confirm ("This will DELETE all traking information from tools under this Campaign, Are you sure you want to DELETE this Campaign?")
	if (answer){
		location.href = '../process/actions/delete_campaign.php?cam=' + id;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Custom Campaigns</title>
</head>
<body style="font-size:12px;">
<? include "../includes/header.php" ?>
<? include "../includes/menu.php"; ?>
<div class="page_content" style="padding-left:20px; display:inline-block; width:928px;">

<div class="left_column" style="width:150px;">    
    <? include(ROOT_PATH . "/includes/account_menu.php") ?>
</div>

<div class="right_column" style="width:730px;">

<span class="error"><? if (isset($_GET["e"])) { echo "<br />" . get_error($_GET["e"]) . "<br /><br />"; }?></span>

<? if(!$_GET["edit"]){ ?>


<span class="page_title">Your Custom Campaigns</span><br /><br />

<?
$camps = get_custom_campaigns_by_affiliate($current_affiliate->id);
foreach($camps as $camp){
?>
	<div class="main_links_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td title="<? echo $camp->desc; ?>"><? echo $camp->name; ?></td>
            <td width="50"><a class="normal_link" href="?edit=1&cid=<? echo $camp->id ?>">Edit</a></td>
            <td width="40"><a class="normal_link" onclick="validate_delete('<? echo $camp->id ?>')" href="javascript:;">Delete</a></td>
          </tr>
        </table>
	</div>
<? } ?>

<br /><br />

<span class="page_title">Add Custom Campaign</span><br /><br /><br />

	<div class="conte_banners" style="width:500px;">
            <div class="conte_banners_header"><strong>New Custom Campaign</strong> </div>
        <br />
       <form action="../process/actions/add_custom_campaing.php" method="post" onsubmit="return validate(validations);">
       	<table width="100%" border="0" cellpadding="10">
          <tr>
            <td>Campaign Name:</td>
            <td><input name="name" type="text" id="name" /></td>
          </tr>
          <tr>
            <td>Campaign Description:</td>
            <td><textarea name="desc" id="desc"></textarea></td>
          </tr>
          <tr>
            <td colspan="2"><input name="" type="submit" value="Submit" /></td>
          </tr>
        </table>
      </form>
    </div>
    
<? }else{ ?>

<? $camp = get_custom_campaign($_GET["cid"]); ?>
<span class="page_title">Edit Custom Campaign</span><br /><br /><br />

	<div class="conte_banners" style="width:500px;">
            <div class="conte_banners_header"><strong>Custom Campaign</strong> </div>
        <br />
       <form action="../process/actions/edit_custom_campaing.php" method="post" onsubmit="return validate(validations);">
       <input name="cid" type="hidden" id="cid" value="<? echo $camp->id ?>" />
       	<table width="100%" border="0" cellpadding="10">
          <tr>
            <td>Campaign Name:</td>
            <td><input name="name" type="text" id="name" value="<? echo $camp->name ?>" /></td>
          </tr>
          <tr>
            <td>Campaign Description:</td>
            <td><textarea name="desc" id="desc"><? echo $camp->desc ?></textarea></td>
          </tr>
          <tr>
            <td colspan="2"><input name="" type="submit" value="Submit" /></td>
          </tr>
        </table>
      </form>
    </div>


<? } ?>


</div>





</div>
<? include "../includes/footer.php" ?>