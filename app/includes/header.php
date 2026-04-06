<a name="page_top" id="page_top"></a>
<div class="container" style=" <? echo $page_style ?>"  <? if($no_select){ ?>onmouseover="deselect()"<? } ?>>
<div class="header" id="header_div">
<? if(in_string(this_page(),"vrbprocessing.com")){ ?>
		<div>
        	<a href="http://www.vrprocessing.com" title="VRB Processing Consultants" id="logo" style="background:url(../images/VRB_logo_processing.png) no-repeat">VRB Processing Consultants</a> </div>
            <div class="phone"><?php /*?><a style="color:#FFF; text-decoration: none;" href="" onclick="Javascript:window.open('<?= BASE_URL ?>/livehelp/request_email.php?l=admtop&amp;x=1&amp;deptid=5','livehelp','width=530,height=410,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top"><img src="../images/temp/call_processing.png" width="317" height="64" border="0" /></a><?php */?></div>
            

<? }else if( in_string(this_page(),"ezpay.com") ){ ?>
		<script type="text/javascript">
		document.getElementById("header_div").className = 'header_ezpay';
		</script>
        <? $site_style = "_ezpay"; ?>
		<div>
        	<a href="https://www.ezpay.com" title="ezpay" id="logo" style="background:url(../images/ezpay.jpg) no-repeat">VRB Processing Consultants</a> </div>
            <?php /*?><div class="box_text1_top">Call Us: <span>(+506) 2228-<span style="display:none;">**</span>9034</span></div>
            <div class="phone_ezpay"><a style="color:#FFF; text-decoration: none;" href="" onclick="Javascript:window.open('<?= BASE_URL ?>/livehelp/request_email.php?l=admtop&amp;x=1&amp;deptid=5','livehelp','width=530,height=410,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top"><img src="../images/temp/call_processing-new.png" width="139" height="64" border="0" /></a></div><?php */?>
        <? include "header-ezpay.php" ?>
        
<? }else if( in_string(this_page(),"buybitcoins.com") ){ ?>
		<script type="text/javascript">
		document.getElementById("header_div").className = 'header_ezpay';
		</script>
        <? $site_style = "_ezpay"; ?>
		<div>
        	<a href="https://www.buybitcoins.com" title="buybitcoins" id="logo" style="background:url(../images/ezpay.jpg) no-repeat">VRB Processing Consultants</a> </div>
            <?php /*?><div class="box_text1_top">Call Us: <span>(+506) 2228-<span style="display:none;">**</span>9034</span></div>
            <div class="phone_ezpay"><a style="color:#FFF; text-decoration: none;" href="" onclick="Javascript:window.open('<?= BASE_URL ?>/livehelp/request_email.php?l=admtop&amp;x=1&amp;deptid=5','livehelp','width=530,height=410,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top"><img src="../images/temp/call_processing-new.png" width="139" height="64" border="0" /></a></div><?php */?>
        <? include "header-ezpay.php" ?>          

<? }else{ ?>
		<div><a href="<?= BASE_URL ?>" title="VRB Marketing Consultants" id="logo">VRB Marketing Consultants</a></div>
        <div class="phone"><?php /*?><a style="color:#FFF; text-decoration: none;" href="" onclick="Javascript:window.open('<?= BASE_URL ?>/livehelp/request_email.php?l=admtop&amp;x=1&amp;deptid=1&amp;agsite=vrb','livehelp','width=530,height=410,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top"><img src="<?= BASE_URL ?>/images/temp/call.png" width="148" height="64" border="0" /></a><?php */?></div>
        <? session_start(); if($_SESSION['ckloged']){ ?>
        <?php /*?><iframe height="1" width="1" frameborder="0" scrolling="no" src="<?= BASE_URL ?>/ck/includes/popup_maker.php"></iframe><?php */?>
        <? } ?>
<? } ?>
</div>
<?
function this_page() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
function in_string($full,$search){
	$found = false;
	if(strlen(strstr($full,$search))>0){
		$found = true;	
	}
	return $found;	
}


if (!is_null($current_clerk) && false) {
	//alerts
	if($current_clerk->im_allow("alerts")){
		?> <script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script> <?
		if(!$noalerts){
			?><div class="alerts_container" id="alerter"></div><?
			?> 
			<script type="text/javascript">
			file_get_contents('<?= BASE_URL ?>/ck/cashier/alerter.php','alerter');
			setInterval("file_get_contents('<?= BASE_URL ?>/ck/cashier/alerter.php','alerter');",60000)
			</script>
			 <?
		}
	}

}



	
?>
