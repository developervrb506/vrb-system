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
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">

<? if($_GET["a"] == "a"){ ?>
alert("Record Added");
<? } ?>
<? if($_GET["a"] == "d"){ ?>
alert("Record Deleted");
<? } ?>
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
<span class="page_title">Manage Casino Games Link</span><br /><br />


<a href="partners_add_casino_game.php">Add Casino Game Link</a><br /><br />
<table style="cursor:pointer;" class="sortable" width="800" border="1" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th class="table_header" scope="col"><strong>Casino Game</strong></th>
    <th class="table_header" scope="col"><strong>Target URL</strong></th>
    <th class="table_header" scope="col"><strong>Sportsbook</strong></th>
    <th class="table_header" scope="col" class="sorttable_nosort"><strong>Delete</strong></th>
  </tr>
</thead>
<tbody id="the-list">
<? foreach(get_promos_by_type('c') as $promo){
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 	
	 ?>
  <tr>
    	<? $parts = explode("_-_",$promo->vars["name"]); ?>
		<th class="table_td<? echo $style ?>"><? echo $parts[0]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $parts[1]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $books[$parts[2]]->vars["name"]; ?></th>
    	<th class="table_td<? echo $style ?>"><a href="javascript:;" onClick="if(confirm('Are you sure you want to delete this Link? All the Impressions and Clicks are going to be deleted.')){location.href = './process/actions/partners_casino_game_action.php?pid=<? echo $promo->vars["id"] ?>';}">Delete</a></th>
  </tr>
<? } ?>
</tbody>
</table>




</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>