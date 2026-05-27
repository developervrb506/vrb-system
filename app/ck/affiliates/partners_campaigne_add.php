<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Campaigns</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>

<script type="text/javascript" src="../partners/process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"You need to write a Campaign Name"});
validations.push({id:"url",type:"null", msg:"You need to write the Landing Page URL"});
</script>
</head>
<body>

<?


?>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Add Campaigns </span><br /><br />


<form method="post" action="./process/actions/add_campaign_action.php" onSubmit="return validate(validations);">
Name:<br />
<input type="text" name="name" id="name" /><br /><br />
Book:<br />
<select name="book" id="book" onChange="display_products(this.value);">
	<? $sportsbooks = get_all_sportsbooks_partner(); 
	   foreach($sportsbooks as $book){ ?>
  			<option value="<? echo $book["id"] ?>"><? echo $book["name"] ?></option>
  <? } ?>
</select><br /><br />
Category:<br />
<select name="category" id="category">
<? $categories = get_all_campaigne_categories();
foreach($categories as $cat) {
   if ( $cat["id"] == $campaign->category->id ) { ?>	      
      <option selected value="<? echo $cat["id"] ?>" id="P_<? echo $cat["name"] ?>"><? echo $cat["name"] ?></option>      
   <? } else { ?>      
      <option value="<? echo $cat["id"] ?>" id="P_<? echo $ca["name"] ?>"><? echo $cat["name"] ?></option>
   <? } ?>
<? } ?>
</select><br /><br />
Desc:<br />
<textarea name="desc" id="desc"></textarea><br /><br />
Landing URL:<br />
<input type="text" name="url" id="url" /><br /><br />


Affiliate:<br />
<span style="font-size:11px;">Optional. (Numeric ID, check Affiliates list)</span><br>
<input type="text" name="affiliate" id="affiliate" /><br /><br />

<input name="Submit" type="submit" value="Add Campaign" />
</form>
      

<!-- Fin Contenido -->
      


</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>