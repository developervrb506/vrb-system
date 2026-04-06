<? include(ROOT_PATH . "/db/handler.php"); ?>
<?
$parts = explode("-",$_GET["aid"]);
$customcampaing = $parts[1];
$aff = get_affiliate($parts[0]);
$promo = $_GET["pid"];
$logo = $_GET["lurl"];
?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.content{
	width:280px;
	background:#101f08;
	padding:5px 0 5px 0;
}
.center{
	width:270px;
	/*border:1px solid #101f08;
	margin-right:auto;
	margin-left:auto;http:*/
}
</style>
<body>
<div class="center">
   <? if($logo != ""){ ?><img src="<? echo $logo ?>" width="270" height="51" /><? } ?>
   <?php /*?><iframe src="//widgetgames.playblackjack.com//files/movies/gameContainer.swf?sponsor=Wagerweb&affiliate=<? echo get_affiliate_code($aff->id, 1) ?>/<? echo $aff->web_name ?> " allowtransparency="true" marginheight="0" marginwidth="0" frameborder="0" height="270" width="270" scrolling="auto"></iframe><?php */?>
   <iframe src="http://widgetgames.playblackjack.com/index.asp?sponsor=Wagerweb&affiliate=<? echo get_affiliate_code($aff->id, 1) ?>/<? echo $aff->web_name ?> " allowtransparency="true" marginheight="0" marginwidth="0" frameborder="0" height="270" width="270" scrolling="auto"></iframe>
   <? if($promo != ""){ ?>
   <a href="<?= BASE_URL ?>/process/redir.php?pid=<? echo $promo ?>&aid=<? echo $_GET["aid"] ?>" target="_blank">
   	<img src="<?= BASE_URL ?>/process/image.php?pid=<? echo $promo ?>&aid=<? echo $_GET["aid"] ?>" width="270" height="25" border="0" />
   </a>
   <? } ?>
   
</div>
</body>


