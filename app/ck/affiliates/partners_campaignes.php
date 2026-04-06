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
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
</head>
<body>

<?
// Update Default
if(isset($_GET["def"])){
	
	$camp = get_campaign_by_id($_GET["newdef"]);
	$def_camp = get_campaign_by_id($_GET["def"]);
	$def_camp->vars["url"]= $camp->vars["url"];
	$def_camp->update(array("url"));
	change_campaing_promotypes_default ($def_camp->vars["id"],$camp->vars["id"]);
}
// Mark as Popular	
if(isset($_GET["pid"])){
	
	$camp = get_campaign_by_id($_GET["pid"]);
	$camp->vars["popular"]=$_GET["pop"];
	$camp->update(array("popular"));
	
}

?>

<? $page_style = " width:1200px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Manage Campaigns</span><br /><br />

<!-- Contenido -->
<? $sportbooks = get_all_sportsbooks_partner();  

?>
<? foreach ($sportbooks as $book) { ?>
     <a href="#<? echo $book["name"]?>" name="link_<? echo $book["name"]?>" id="link_<? echo $book["name"]?>"><? echo $book["name"]?></a>  |
<? } ?>
<br /><br />

<a href="partners_campaigne_add.php">Add Campaign</a><br /><br />
   
<? foreach ($sportbooks as $book) { ?>

<? $campaignes = get_all_partners_campaigns($book["id"]); ?>
<span><strong><? echo $book["name"]?></strong></span> 
<BR>
<a name="<? echo $book["name"]?>" id="<? echo $book["name"]?>"></a>
<table style="cursor:pointer;" class="sortable" width="100%" border="1" cellspacing="0" cellpadding="0">
  <thead>
  <tr>
    <th class="table_header" scope="col">CID</th>
    <th class="table_header" scope="col">Set Default</th>
    <th class="table_header" scope="col">Name</th>
    <th class="table_header" scope="col">Landing URL</th>
    <th class="table_header" scope="col">Popular</th>
    <th class="table_header" scope="col" class="sorttable_nosort">View</th>
    <th class="table_header" scope="col" class="sorttable_nosort">Edit</th>
    <th class="table_header" scope="col" class="sorttable_nosort">Preview</th>
  </tr>
  </thead>
  <tbody id="the-list">
  
<? foreach($campaignes as $camp){
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
    
   $def_id = $camp->vars["id_sportsbook"]->vars["campaing"]; 
     
   ?>
  <tr>
    <th class="table_td<? echo $style ?>"><? echo $camp->vars["id"] ?></th>
    <th class="table_td<? echo $style ?>"><? if($def_id != $camp->vars["id"] && $def_id != -1){ ?> <a href="?def=<? echo $def_id ?>&newdef=<? echo $camp->vars["id"] ?>"><? echo ucwords($camp->vars["id_sportsbook"]->vars["name"])?> Default</a>      <? }  ?></th>
    <th class="table_td<? echo $style ?>"><? echo strtoupper($camp->vars["name"]) ?></th>
    <th class="table_td<? echo $style ?>"><? echo $camp->vars["url"] ?>?aid=1000</th>
    <th class="table_td<? echo $style ?>">
    	<? if($camp->vars["popular"]){ ?>
        		<a href="?pid=<? echo $camp->vars["id"] ?>&pop=0">Unset</a>
        <? }else{ ?>
        		<a href="?pid=<? echo $camp->vars["id"] ?>&pop=1">Set</a>
        <? } ?>        
    </th>
    <th class="table_td<? echo $style ?>"><a href="partners_campaigne_view.php?cid=<? echo $camp->vars["id"] ?>">View</a></th>
    <th class="table_td<? echo $style ?>"><a href="partners_campaigne_edit.php?cid=<? echo $camp->vars["id"] ?>">Edit</a></th>
    <th class="table_td<? echo $style ?>">
       <? if ($camp->vars["img"] != "") { ?>
           <img src="http://www.inspin.com/partners/images/banners/<? echo $camp->vars["img"] ?>" />
           <?php /*?><img src="http://images.commissionpartners.com/data/banners/<? echo $camp->vars["img"] ?>" /><?php */?>
       <? } else { echo "No Barnner Set"; } ?>  
    </th>
  </tr>
<? } ?>
</tbody>
</table>
<BR>
<? } ?>
      


</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>