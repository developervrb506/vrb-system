<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Custom Promotypes</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<script type="text/javascript">
<!--
function confirmation(ID) {
	var answer = confirm("Are you sure that you want to delete this promotype?");
	if (answer){		
	   window.location = "process/actions/delete_book_textlink_action.php?pid="+ID+"&custom=1";
	}	
}
//-->

</script>
</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Custom Promotypes </span><br /><br />

<!-- Contenido -->

<? 
if (!isset($_GET["type"])) { $type = $_POST["type"]; }
else { $type = $_GET["type"]; } 

?>
<a href="partners_custom_promotype.php">Add a Custom Promotype</a><br /><br />

<form method="post">
Type: &nbsp;&nbsp;
<select name="type">
<option value="0">Select a Type</option>
<option  <? if ($type == "a") { echo ' selected="selected" '; }?> value="a">Articles</option>
<option  <? if ($type == "e") { echo ' selected="selected" '; }?> value="e">Email Template</option>
<option  <? if ($type == "i") { echo ' selected="selected" '; }?> value="i">Infografics</option>
<option  <? if ($type == "p") { echo ' selected="selected" '; }?>value="p">PressRelease</option>
<option  <? if ($type == "v") { echo ' selected="selected" '; }?>value="v">Video</option>

</select>
<input type="submit" value="Search">

</form>
<BR/><BR/>

<? if ((isset($_POST["type"])) || (isset($_GET["type"])) ) { ?>


<table style="cursor:pointer;" class="sortable" width="800" border="1" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th class="table_header" scope="col"><strong>ID</strong></th>
    <th class="table_header" scope="col"><strong>Name</strong></th>
    <th class="table_header" scope="col"><strong>Target URL</strong></th>
    <th class="table_header" scope="col"><strong>Sportsbook</strong></th>
    <th class="table_header" scope="col" class="sorttable_nosort"><strong></strong></th>
    <th class="table_header" scope="col" class="sorttable_nosort"><strong></strong></th>
  </tr>
</thead>
<tbody id="the-list">
<?  foreach(get_personal_promos_affiliate(-100,$type) as $promo){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   ?>
  <tr>
  
    	<? $parts = explode("_-_",$promo->vars["name"]); ?>
        <th class="table_td<? echo $style ?>"><? echo $promo->vars["id"]; ?></th>
		<th class="table_td<? echo $style ?>"><? echo $parts[0]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $parts[2]; ?> <a href="<? echo $parts[2] ?>" target="_blank">Preview</a></th>
        <th class="table_td<? echo $style ?>"><? echo get_affiliates_brand($parts[3])->vars["name"]; ?></th>
        <th class="table_td<? echo $style ?>"><a href="partners_custom_promotype.php?id=<? echo $promo->vars["id"] ?>">Edit</a></th>
    	<th class="table_td<? echo $style ?>"><a href="javascript:confirmation(<? echo $promo->vars["id"] ?>)">Delete</a></th>
   
  </tr>
<? } ?>
</tbody>
</table>


<? } ?>
<!-- Fin Contenido -->





</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>