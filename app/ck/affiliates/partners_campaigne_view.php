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
</head>
<body>

<?
$cid = $_GET["cid"];
if(!isset($cid)){$cid = 0;}
$campaigne = get_campaign_by_id($cid);
$promos = get_promos_by_campaigne_affiliate($cid);?>


<? $page_style = " width:1475px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $campaigne->vars["name"]; ?></span><br /><br />
<div align="right"><span ><a href="partners_campaignes.php">Back</a></span></div>

<!-- Contenido -->

<a href="partners_add_multi_promo.php?cid=<? echo $campaigne->vars["id"] ?>">Add Promo</a><br /><br />
<?

if (!empty($promos)) {
?>
    <table class="widefat" width="800" border="1" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th class="table_header"  scope="col"><strong>Type</strong></th>
        <th class="table_header"  scope="col"><strong>File</strong></th>
        <th class="table_header"  scope="col"><strong>Name</strong></th>
        <th class="table_header"  scope="col"><strong>Comment</strong></th>
        <th class="table_header"  scope="col"><strong>Edit</strong></th>
      </tr>
    </thead>
    <tbody id="the-list">
    
    <? foreach($promos as $promo){ ?>
    <? if($promo->vars["type"] != "m"){ ?>
      <tr>
        <? if($promo->vars["type"] == "b"){ ?>
            <th class="table_td1">
                Banner (<? echo $promo->get_size() .' <strong>PID:</strong> '. $promo->vars["id"] ?>)
                <? if(!$promo->vars["enabled"]){ ?><br><strong style="color:#F00;">(Disabled)</strong> <? } ?>
            </th>
             <th class="table_td1"> <? echo $promo->vars["name"] ?></th>
            <th class="table_td1"> <img src="http://www.inspin.com/partners/images/banners/<? echo $promo->vars["name"] ?>" /> 
            <?php /*?><img src="http://images.commissionpartners.com/data/banners/<? echo $promo->vars["name"] ?>" /><?php */?>
            </th>
        <? }else{ ?>
            <th class="table_td1">
                Text Link <strong>&nbsp;(PID:&nbsp;</strong><? echo $promo->vars["id"] ?>)
                <? if(!$promo->vars["enabled"]){ ?><br><strong style="color:#F00;">(Disabled)</strong> <? } ?>
            </th>
             <th class="table_td1"> </th>
            <th class="table_td1"><? $parts = explode("_-_",$promo->vars["name"]);
                echo $parts[0]; ?></th>
        <? } ?>
           <th class="table_td1">
                 <? echo $promo->vars["comment"]; ?>
            </th>
        <th class="table_td1"><? if($promo->vars["type"] != "k"/* && $promo->type != "b"*/ && $parts[1] == ""){ ?><a href="partners_edit_promo.php?pid=<? echo $promo->vars["id"]; ?>&amp;cid=<? echo $cid; ?>">Edit</a><? } ?></th>
      </tr>
     <? } ?>
    <? } ?>
    </tbody>
    </table>
<? }
else {
  echo "There are no Promos to this Campaing";	
	}
?>
<!-- Fin Contenido -->


</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>