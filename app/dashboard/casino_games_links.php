<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?
$book = get_sportsbook($_GET["b"]);
//$sportsbooks = get_affiliate_sportsbooks($current_affiliate->id);
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}
$promos = get_casino_games_links($book->id);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo ucwords($book->name); ?> Casino Games Links</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
</head>

<body>

<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:20px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title"><? echo ucwords($book->name); ?> Casino Games Links</span><br /><br /><br />

<span class="page_title">Available Links</span><br />
<br /><br />
    
<? foreach($promos as $promo){ ?>
	<? 
    $parts = explode("_-_",$promo->name);
    $promo->name = $parts[0];
    ?>	    
	<div class="conte_banners">
            <div class="conte_banners_header"><strong>Casino Game Link PID: <? echo $promo->id; ?></strong></div>
            <br /><? echo $promo->name; ?>
        <br /><br />
        <?
		$link = BASE_URL . '/process/custom_redir.php?pid='. $promo->id .'&aid='. $current_affiliate->id .'&tgt='. $parts[1] .'&bk='. $parts[2];
		$code = '<!--Affiliate Code Start Here-->';
		$code .= '<a href="'.$link.'" target="_blank">';
		$code .= $promo->name;
		$code .= '<img border="0" src="<?= BASE_URL ?>/process/image.php?pid='. $promo->id .'&aid='. $current_affiliate->id .'" /></a>';
		$code .= '<!--Affiliate Code End Here-->';
		?>
        <textarea cols="90" rows="3" readonly="readonly" id="code_<? echo $promo->name ?>"><? echo $code ?></textarea><br />
      <input onclick="select_value('code_<? echo $promo->name ?>')" name="" type="button" value="Select Code" />
        
        <br /><br />
        
        <span class="little"><strong>Direct Link:</strong></span> 
        <input name="link_<? echo $promo->name ?>" type="text" id="link_<? echo $promo->name ?>" value="<? echo $link; ?>" size="100" readonly="readonly" />
        <input onclick="select_value('link_<? echo $promo->name ?>')" name="" type="button" value="Select Link" />
        <br /><br />
        
    </div>
<? } ?>


</div>
<? include "../includes/footer.php" ?>