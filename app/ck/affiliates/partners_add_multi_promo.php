<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Campaigns</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"image_banner",type:"null", msg:"You need to enter Banner Image"});
validations.push({id:"link_text",type:"null", msg:"You need to enter a Text for the link"});
</script>
</head>
<body>

<?

?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Add New Promo</span><br /><br />

<?
$cid = $_GET["cid"];
if(!isset($cid)){$cid = 0;}
?>


<form method="post" action="./process/actions/add_multi_promo_action.php" enctype="multipart/form-data" onSubmit="return validate(validations);">
    <input type="hidden" value="<? echo $cid ?>" id="cid" name="cid" />
    Type:<br />
    <select name="promo_type" onChange="switch_promotype(this.value)">
     <?php /*?> <option value="b">Banner</option><?php */?>
      <option value="t">Text Link</option>
      <option value="m">Mailer</option>
    </select>
    <br /><br />
    <?php /*?><div id="banner_div">Banner:
    
    	<input type="file" name="imageURL[]" id="imageURL" multiple />
        <br><br>
        Replace duplicate sizes? <input name="replace" type="checkbox" id="replace" value="1" checked>
        
    </div><?php */?>
    <br /><br />
   
    <div id="text_div" style="display:none">Text:
    <input type="text" id="link_text" name="link_text" /></div>
    <br />
     <div id="banner_div">Comment:<br />
    <textarea id="comment" name="comment" rows="4" cols="50"></textarea></div>
    <br /><br />
    <input name="" type="submit" value="Add Promo" />
</form>
<!-- Fin Contenido -->

</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>