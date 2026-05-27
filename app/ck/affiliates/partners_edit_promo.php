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

<script type="text/javascript">
var validations = new Array();

// ONCE THE BANNERS IS UP UNCOMMENT THE LINE BELOW
//validations.push({id:"image_banner",type:"null", msg:"You need to enter Banner Image"});
validations.push({id:"link_text",type:"null", msg:"You need to enter a Text for the link"});
</script>

<script type="text/javascript">
function load_dropdown(ddlID, value, change){
	var ddl = document.getElementById(ddlID);
	for (var i = 0; i < ddl.options.length; i++) {
		if (ddl.options[i].value == value) {
			if (ddl.selectedIndex != i) {
				ddl.selectedIndex = i;
				if (change){ddl.onchange();}
			}
		   break;
	   }
   }
}
</script>
</head>
<body>
<?
$pid = $_GET["pid"];
if(!isset($pid)){$pid = 0;}
$promo = get_promotype_by_id($pid);
$cid = $_GET["cid"];
if(!isset($cid)){$cid = 0;}

$dis_banner = ""; 
$dis_text = ""; 

?>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $campaigne->vars["name"]; ?></span><br /><br />
<div align="right"><span ><a href="partners_campaigne_view.php?cid=<? echo $cid ?>">Back</a></span></div>

<!-- Contenido -->
<?

if($promo->vars["type"] == "b"){$dis_text = 'style="display:none"';}else if($promo->vars["type"] == "t"){$dis_banner = 'style="display:none"';}
?>
<strong>Edit Promo</strong><br /><br />

<form method="post" action="./process/actions/edit_promo_action.php" enctype="multipart/form-data" onSubmit="return validate(validations);">
    <input type="hidden" value="<? echo $promo->vars["id"] ?>" id="promo_id" name="promo_id" />
    <input type="hidden" value="<? echo $cid ?>" id="cid" name="cid" />
    Type:<br />
    <select name="promo_type" id="promo_type" onChange="switch_promotype(this.value)">
      <option value="b">Banner</option>
      <option value="t">Text Link</option>
    </select>
    <br /><br />
    <div id="banner_div" <? echo $dis_banner ?>>Banner:
    <?php /*?><input type="file" id="image_banner" name="image_banner" /><br /><?php */?>
    <img src="http://www.inspin.com/partners/images/banners/<? echo $promo->vars["name"] ?>" />
    <?php /*?><img src="http://images.commissionpartners.com/data/banners/<? echo $promo->vars["name"] ?>" /><?php */?>
    </div>
    <div id="text_div" <? echo $dis_text ?>>Text:
    <input type="text" id="link_text" name="link_text" value="<? echo $promo->vars["name"] ?>" /></div>
    <br /><br />
    <div id="banner_div">Comment:<br />
    <textarea id="comment" name="comment" rows="4" cols="50"><? echo $promo->vars["comment"] ?></textarea></div>
    <br /><br />
    <input name="" type="submit" value="Update Promo" />
</form>
<script type="text/javascript">
load_dropdown("promo_type", "<? echo $promo->vars["type"] ?>", false);
</script>
<!-- Fin Contenido -->


</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>