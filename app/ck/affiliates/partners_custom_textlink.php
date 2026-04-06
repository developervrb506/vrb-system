<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Text Link</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"link_text",type:"null", msg:"You need to enter a Text for the link"});
validations.push({id:"link_url",type:"null", msg:"You need to enter a Target for the link"});
</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
</head>
<body>
 <? $page_style = " width:1400px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Add New Text Link</span><br /><br />

<!-- Contenido -->

<?
$sportsbooks = get_all_affiliates_brands(true);

?>

<form method="post" action="./process/actions/add_book_textlink_action.php" onSubmit="return validate(validations);">
    <div id="text_div">Link Text:<br>
    <input name="link_text" type="text" id="link_text" style="width:500px;" /></div>
    <br />
    <div id="text_div">Target URL:<br>
    <input name="link_url" type="text" id="link_url" style="width:500px;" /></div>
    <br />
    <div id="text_div">Book:
    
    	<select name="text_book" id="text_book">
		  <? 
             foreach($sportsbooks as $book){ ?>
                 <option value="<? echo $book->vars["id"] ?>"><? echo $book->vars["name"] ?></option>
        <? } ?>
      </select>
    
    </div>
    <br /><br />
    <input name="" type="submit" value="Add Text Link" />
</form>
<!-- Fin Contenido -->

</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>