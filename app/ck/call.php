<? $signup_time =30; ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/sales_security.php"); ?>
<?
$name = get_open_call($current_clerk->vars["id"]);
$view = false;
$is_new = "0";
$reload_lists = array(59,60);


if(is_null($name)){
	if(isset($_GET["nid"])){
		$name = get_call_back_name($_GET["nid"],$current_clerk->vars["id"]);
		$error = "?e=9";
	}else if(isset($_GET["vid"])){
		$name = get_view_name($_GET["vid"]);
		$view = true;
		$error = "?e=9";
	}else if(isset($_GET["odid"])){
		$name = get_view_name($_GET["odid"]);
		$error = "?e=9";
	}else if(isset($_GET["lead"]) && $current_clerk->vars["level"]->vars["sale_closer"]){
		$name = get_lead_name();
		if(!is_null($name)){
			$name->insert_lead_transfer();
		}
		$error = "?e=31";
	}else{
		$is_new = "1";	
		//signups
		if(_is_allow_in_list($current_clerk->vars["id"],20)){
			$name = _get_new_signup_name();
		}
		
		//Denied CC
		if(is_null($name)){
			if(_is_allow_in_list($current_clerk->vars["id"],54)){
				$name = _get_new_deniedcc_name();
			}
		}
		
		//Random
		if(is_null($name)){
			$name = _get_new_random_name($current_clerk->vars["id"]);
		}
	}
	if(is_null($name)){header("Location: index.php$error");}
	else{
		$name->open_call($current_clerk->vars["id"],$view,"",$is_new);
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Calling <? if ($name !== null){ echo $name->full_name(); } ?></title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="JavaScript">
tinyMCE.init({
    mode : "exact",
	elements : "email_body",
    width: "100%",
    theme : "advanced",
	theme_advanced_toolbar_location : "top",
	plugins : "searchreplace",
	theme_advanced_buttons3_add : "search,replace"		
});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">


<? $mnote = get_affiliate_description_by_af($name->vars["aff_id"]); ?>
<? if(!is_null($mnote)){ ?>
<div class="form_box" style="margin-bottom: 15px; font-size:14px; background:#91DBFF;">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
      	<? if($mnote->vars["image"]!=""){ ?>
        <td width="220">
        	<img src="http://vrbmarketing.com/ck/images/affiliates/<? echo $mnote->vars["image"] ?>" style="max-width:200px;" />
        </td>
        <? } ?>
        <td valign="top">
        	<strong><? echo $mnote->vars["title"] ?> Player:</strong>
            <? if(trim($mnote->vars["code"])!= ""){ ?><br /><br /><strong>Promo Code: </strong><? echo $mnote->vars["code"] ?><? } ?>
    		<br /><br /><strong>Bonus: </strong><br /><? echo $mnote->vars["description"] ?>
        </td>
        <td valign="top" align="right" style="font-size:24px;">
        	<strong><? echo $name->vars["aff_id"] ?></strong>
            <br /><br />
            <strong style="font-size:13px;">Diferent Source?:&nbsp;&nbsp;</strong>
            <input type="text" name="ecsource" id="ecsource" value="<? echo $name->vars["clerk_source"] ?>" onblur="document.getElementById('csource').value = this.value;" />
        </td>
      </tr>
    </table>
</div>
<? } ?>

<span class="page_title">Calling <? if ($name !== null){ echo $name->full_name(); } ?></span>&nbsp;&nbsp;&nbsp;

<span style="font-size:12px">
(<a href="call_history.php?nid=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? if ($name !== null) { echo $name->full_name(); } ?>" Call History" class="normal_link">
     Open Call History
</a>)

<? //$other = get_names_by_phone($name->vars["phone"],$name->vars["id"],true); ?>
<? //if(count($other)>0){ ?>
<? if(!empty($other)){ ?>  
<!--&nbsp;&nbsp;&nbsp;
(<a href="same_phones.php?phone=<? echo $name->vars["phone"] ?>&curr=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="Other CRM Profiles" class="normal_link">
    Other profiles with same phone
</a>)-->
<? } ?>

</span>

<div style="float:right">
	<form method="post" action="process/actions/trasfer_action.php">
    Transfer to:
    <? $clerks_admin = "2,4,5"; include "includes/clerks_list.php" ?>
    <input name="start" type="hidden" id="start" value="1" />
    <input name="" type="submit" value="Transfer" />
    </form>
</div>

<br /><br />

<? include "includes/print_error.php" ?>


<div class="form_box" style="width:850px; margin:0 auto; margin-bottom:5px;">

<table width="100%" border="0" cellspacing="0" cellpadding="10" style="font-size:16px;">
  <tr>
    <td valign="top"><strong>Full Name:</strong><br /><? if ($name !== null) { echo $name->full_name(); } ?></td>
    <td valign="top"><strong>Phone:</strong><br />
		<? echo no_skype(format_phone($name->vars["phone"])) ?><br /><? echo no_skype(format_phone($name->vars["phone2"])) ?>
    </td>
    <td valign="top"><strong>Email:</strong><br /><? echo $name->vars["email"] ?></td>
    <td valign="top"><strong>Account:</strong><br /><? echo $name->vars["acc_number"] ?></td>
    <td valign="top"><strong>Affiliate:</strong><br /><? echo $name->vars["aff_id"] ?></td>
  </tr>
  <tr>
    <td><strong>Street Name:</strong><br /><? echo $name->vars["street"] ?></td>
    <td><strong>City:</strong><br /><? echo $name->vars["city"] ?></td>
    <td><strong>Country / State:</strong><br /><? echo $name->vars["state"] ?>, <? echo $name->vars["country"] ?></td>
    <td><strong>Zip:</strong><br /><? echo $name->vars["zip"] ?></td>
    <td valign="top">
    	<strong>Website:</strong><br />
		<?
		$webs = get_webs_by_aff($name->vars["aff_id"]);
		foreach($webs as $web){
			echo $web->vars["name"] . " ";
		}
		?>
    </td>
  </tr>
</table>

</div>
<div class="form_box" style="width:850px; margin:0 auto; margin-bottom:5px;">
	<strong>
    	<? $city_time = get_city_time($name->vars["city"], $name->vars["state"]); ?>
    	It is <? echo $city_time ?> in <? echo $name->vars["city"] ?>, <? echo $name->vars["state"] ?>
        <?
		if((strtotime($city_time) >= strtotime("10:00PM") || strtotime($city_time) <= strtotime("10:00AM")) && contains_ck($city_time,"M")){
			?><script type="text/javascript">//alert("Current Time for Customer is <? echo $city_time ?>, too early or too late to call.");</script><?
		}
		?>
    </strong>
</div>
<? if($name->vars["list"]->vars["bonus_note"] != ""){ ?>
<div class="form_box" style="width:850px; margin:0 auto; margin-bottom:5px;">
	<strong>Bonus:</strong><br /><br /><? echo nl2br($name->vars["list"]->vars["bonus_note"]) ?>
</div>
<? } ?>
<div class="form_box" style="width:850px; margin:0 auto; margin-bottom:15px;">
	<? include "includes/call_action.php" ?>    
</div>


<strong>View:</strong> 
<? if($name->vars["list"]->vars["note"] != ""){ ?>
&nbsp;&nbsp;&nbsp;&nbsp; <a onclick="show_script('5');" href="javascript:;" class="normal_link">Important Notes</a> 
<? } ?>
&nbsp;&nbsp;&nbsp;&nbsp; <a onclick="show_script('1');" href="javascript:;" class="normal_link">Call Script </a> 
&nbsp;&nbsp;&nbsp;&nbsp; <a onclick="show_script('2');"  href="javascript:;" class="normal_link">Message Script </a>
<? if(!$name->vars["list"]->vars["mailing_system"]){ ?> 
&nbsp;&nbsp;&nbsp;&nbsp; <a onclick="show_script('3');"  href="javascript:;" class="normal_link">Send Email</a>
<? } ?>

<?
$scripts = array("script_call","script_message");
$i = 0;
foreach($scripts as $sc){
	$i++;
?>
	<div id="sc<? echo $i?>" class="form_box" style="margin-top:20px; font-size:14px; display:none;">
        <strong><? echo ucwords(str_replace("script_","",$sc)) ?> Script:</strong><br /><br />
        <div style="float:right; width:auto; margin-top:-25px;">
            <a onclick="show_script('<? echo $i?>');"  href="javascript:;" class="normal_link">Close</a>
        </div>
        
        <? echo str_replace("<br />","<br /><br />",nl2br($name->vars["list"]->vars[$sc])); ?>
    </div>
<? } ?>


<div id="sc3" class="form_box" style="margin-top:20px; font-size:14px; display:none;">
    <strong>Send Email:</strong><br /><br />
    <div style="float:right; width:auto; margin-top:-25px;">
        <a onclick="show_script('3');"  href="javascript:;" class="normal_link">Close</a>
    </div>
    <iframe frameborder="0" width="1" height="1" src="" id="sender" name="sender"></iframe>
    <?
	$position = strpos($name->vars["list"]->vars["script_email"],"</p>");
	$subject = substr($name->vars["list"]->vars["script_email"],0,$position);
	$subject = str_replace("<p>","",$subject);
	$subject = str_replace("subject:","",$subject);
	$content = substr($name->vars["list"]->vars["script_email"],$position+4);
	?>
    <form method="post" action="process/actions/send_email.php" target="sender">
    <input name="email_name_id" type="hidden" id="email_name_id" value="<? echo $name->vars["id"] ?>" />
    <table width="500" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Confirm Email:</td>
        <td><input name="email_address" type="text" id="email_address" value="<? echo $name->vars["email"] ?>" size="50" /></td>
      </tr>
      <tr>
        <td>Subject:</td>
        <td><input name="email_subject" type="text" id="email_subject" value="<? echo $subject ?>" size="50" /></td>
      </tr>
    </table>

    
     <br /><br />
    
    <textarea name="email_body" id="email_body" style="height:400px;"><? echo $content ?></textarea><br /><br />
    
    <div align="right"><input onclick="show_script('3');" name="Submit" type="submit" value="Send Email" /></div>
    </form>
</div>

<div id="sc4" class="form_box" style="margin-top:20px; font-size:14px; display:none;">
	<?
	$afnum = $current_clerk->vars["af"];
	if($afnum == ""){$afnum = $name->vars["aff_id"];}
	
	$iurl = "";
	$iurl .= "firstname=" . $name->vars["name"];
	$iurl .= "&lastname=" . $name->vars["last_name"];
	$iurl .= "&address1=" . $name->vars["street"];
	$iurl .= "&address2=" . "";
	$iurl .= "&phone=" . $name->vars["phone"];
	$iurl .= "&country=" . "USA";
	$iurl .= "&state=" . $name->vars["state"];
	$iurl .= "&city=" . $name->vars["city"];
	$iurl .= "&zip=" . $name->vars["zip"];
	$iurl .= "&email=" . $name->vars["email"];
	$iurl .= "&promo=" . $afnum;
	$iurl .= "&referred=" . "";
	$iurl .= "&cname=" . $current_clerk->vars["name"];
	$iurl .= "&cid=" . $current_clerk->vars["id"];
	?>
    
    
    
    <strong>Signup Form</strong><br /><br />
    <iframe id="iframepromo" width="400" height="900" scrolling="no" frameborder="0" src="http://www.sportsbettingonline.ag/utilities/ui/join/multi_join_form.php?www=de91ddd20396f9b88874f6daeb896ca8&<? echo $iurl; ?>"></iframe>
    
    
   <!-- <strong>Wagerweb Signup</strong><br /><br />
    <iframe id="iframepromo" src="http://lb.wagerweb.com/vrb/phone_ww_form.asp?<? echo $iurl; ?>" width="350" height="650" frameborder="0" scrolling="no" allowtransparency="true"></iframe>
    
    <br /><br />-->
    
    <!--<strong>Sports Betting Online Signup</strong><br /><br />
    <iframe id="iframepromo" width="400" height="900" scrolling="no" frameborder="0" src="http://www.sportsbettingonline.ag/utilities/ui/join/external.php?clerk&awf=1&<? echo $iurl; ?>"></iframe>-->
    
<!--    <br /><br />
    
    
    <strong>Insider Signup</strong><br /><br />
     <iframe id="iframepromo" src="http://jobs.inspin.com/insiders/register/new_form.php?external&<? echo $iurl; ?>" width="900" height="470" frameborder="0" scrolling="auto" allowtransparency="true"></iframe> -->
      
</div>


<? if($name->vars["list"]->vars["note"] != ""){ ?>
<div id="sc5" class="form_box" style="margin-top:15px; font-size:14px; display:none;">
	<strong>Note:</strong><br /><br /><? echo $name->vars["list"]->vars["note"] ?>
</div>
<? } ?>


<? $other = get_name_historical($name->vars["id"], $name->vars["email"], $name->vars["phone"], $name->vars["phone2"], $name->vars["acc_number"]); ?>
<? if(count($other)>0){ ?>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="100"><strong style="font-size:16px;">Profile historical</strong></td>
  </tr>
  <tr>
  
  	<td class="table_header">Clerk</td>
    <td class="table_header">AF</td>
    <td class="table_header">Status</td>
    <td class="table_header">Disposition</td>
    <td class="table_header">Notes</td>
    <td class="table_header">Date</td>
    <td class="table_header" align="center">Calls</td>
  </tr>
  <? 
  
  $i=0;
  
  foreach($other as $ot){
	  $dispo = get_conversation_status($ot->vars["conversation_status"]);
	  if($i % 2){$style = "2";}else{$style = "1";} $i++;
  ?>
      <tr>
      
      	<td class="table_td<? echo $style ?>"><? echo $ot->get_clerck_name() ?></td>
        <td class="table_td<? echo $style ?>"><? echo $ot->vars["aff_id"] ?></td>
        <td class="table_td<? echo $style ?>"><? echo $ot->vars["status"]->vars["name"] ?></td>
        <td class="table_td<? echo $style ?>"><? echo $dispo->vars["name"] ?></td>
        <td class="table_td<? echo $style ?>" width="300"><? echo nl2br($ot->vars["note"]) ?></td>
        <td class="table_td<? echo $style ?>"><? echo $ot->vars["ldate"] ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="call_history.php?nid=<? echo $ot->vars["id"] ?>" rel="shadowbox;height=230;width=570" class="normal_link">
                 View
            </a>
        </td>
      </tr>
  <? } ?>
</table>

<? } ?>

</div>

<script type="text/javascript">
function show_script(id){
	dis = document.getElementById("sc"+id).style.display;
	for(var i = 0; i < 4; i++){
		document.getElementById("sc"+(i+1)).style.display = "none";
	}	
	if(dis == 'none'){
		document.getElementById("sc"+id).style.display = "block";
	}else{
		document.getElementById("sc"+id).style.display = "none";
	}

}
</script>

<? include "../includes/footer.php" ?>