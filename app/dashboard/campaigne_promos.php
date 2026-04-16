<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Banners</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:10px;">
<?
$cid = $_GET["cid"];
if(!isset($cid)){$cid = 0;}
$campaigne = get_campaigne($cid);
usort($campaigne->promos, array("promo", "order_by_size"));
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}

$book = get_sportsbook($_COOKIE["banbook"]);

?>
<span class="page_title"><? echo ucwords($campaigne->name) ?> Banners</span><br /><br />

<div id="sizes" style="font-size:12px;">
	<a href="campaignes_list_new.php" class="normal_link"> &lt;&lt; Back to Campaigns</a><br />
	<br />
	<strong>Available Banners Sizes:&nbsp;&nbsp;</strong> 
</div><br /><br /><br />

<? foreach($campaigne->promos as $promo){ ?>
	<? if($promo->type != "k" && $promo->type != "m" && $promo->type != "t"){ ?>
    <? $promo->name = str_replace("_-_".$current_affiliate->id . "_-_","",$promo->name); ?>
  <div class="conte_banners">
		<? if($promo->type == "b"){ ?>
        	<script type="text/javascript">display_banners_sizes("<? echo $promo->get_size() ?>"); </script>
        	<div class="conte_banners_header"><strong>Banner</strong> (<? echo $promo->get_size() .' <strong>PID:</strong> '. $promo->id ?>)            
      <a name="banner_" id="banner_<? echo $promo->get_size() ?>"></a></div>
      <div class="conte_banners_gototop">
      	<a href="campaignes_list_new.php" class="normal_link"> &lt;&lt; Back to Campaigns</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
      	<a href="#page_top" class="normal_link">Go to Top</a>
      </div>
            <br /><br /><img src="http://www.inspin.com/partners/images/banners/<? echo $promo->name ?>" />
            <?php /*?><br /><br /><img src="http://images.commissionpartners.com/data/banners/<? echo $promo->name ?>" /><?php */?>
        <? }else{ ?>
            <div class="conte_banners_header"><strong>Text Link</strong> </div>
            <br /><br /><? echo $promo->name; ?>
        <? } ?>
        
        <br /><br />
        <textarea cols="90" rows="3" readonly="readonly" id="code_<? echo $promo->name ?>"><? echo $promo->get_code($current_affiliate, $book->folder); ?></textarea><br /><br />
        <input onclick="select_value('code_<? echo $promo->name ?>')" name="" type="button" value="Select Code" /><br /><br />        
        <span class="little"><strong>Image Path:</strong></span> <input name="" type="text" value="<? echo $promo->get_image_url($current_affiliate); ?>" size="100" readonly="readonly" /><br /><br />
        
        <span class="little"><strong>Target Link:</strong></span> <input name="" type="text" value="<? echo $promo->get_image_link($current_affiliate, $book->folder); ?>" size="100" readonly="readonly" /><br /><br />
    </div>
	<? } ?>
<? } ?>
</div>
<? include "../includes/footer.php" ?>