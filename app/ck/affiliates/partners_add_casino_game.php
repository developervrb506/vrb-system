<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Casino Games</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"link_text",type:"null", msg:"You need to enter a name for the Game"});
validations.push({id:"link_url",type:"null", msg:"You need to enter a Target link"});
</script>

<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
</head>
<body>
<?
$books =  get_all_affiliates_brands(true);

?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Add  New Casino Games Link</span><br /><br />



<form method="post" action="./process/actions/partners_casino_game_action.php" onSubmit="return validate(validations);">
    <div id="text_div">Name:<br>
    <input name="link_text" type="text" id="link_text" style="width:500px;" /></div>
    <br />
    <div id="text_div">Target URL:<br>
    <input name="link_url" type="text" id="link_url" style="width:500px;" /></div>
    <br />
    <div id="text_div">Book:
    
    	<select name="text_book" id="text_book">
		  <? 
             foreach($books as $book){ ?>
                  <option value="<? echo $book->vars["id"] ?>"><? echo $book->vars["name"] ?></option>
        <? } ?>
      </select>
    
    </div>
    <br /><br />
    <input name="" type="submit" value="Add Link" />
</form>




</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>