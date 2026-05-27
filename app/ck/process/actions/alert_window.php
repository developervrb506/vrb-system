<? $no_log_page = true; ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://www.ezpay.com/css/style.css" rel="stylesheet" type="text/css" />
<title>Ezpay Alerts</title>
</head>
<body>
<?
if(isset($_GET["hide"])){
	delete_ezp_alert($_GET["hide"], $current_clerk->vars["id"], $_GET["st"]);
}
if(isset($_GET["vrb_hide"])){
	delete_vrb_alert($_GET["vrb_hide"], $current_clerk->vars["id"], $_GET["st"]);
}

if(isset($_GET["tweet_hide"])){
	delete_tweet_alert($_GET["tweet_hide"], $current_clerk->vars["id"]);
}

//Baseball
if(isset($_GET["baseball_hide"])){
	delete_baseball_alert($_GET["baseball_hide"], $current_clerk->vars["id"], $_GET["type"]);
}
//

if(_can_attend_signups($current_clerk->vars["id"])){
	$nsups = new_signup_alerts_alerts($current_clerk->vars["id"]);
}
if($current_clerk->im_allow("cc_denied_alerts")){
	$ccds = cc_denied_alerts($current_clerk->vars["id"]);
}
if($current_clerk->im_allow("mp_payouts_alert")){
	$mpps = mp_payouts_alerts($current_clerk->vars["id"]);
	$opas = other_payouts_alerts($current_clerk->vars["id"]);
}

if($current_clerk->im_allow("mp_sell_alert")){
	$mps = mp_sell_alerts($current_clerk->vars["id"]);
}

if($current_clerk->im_allow("affiliate_payout_alert")){
	$afps = affiliate_payouts_alerts($current_clerk->vars["id"]);
}

if($current_clerk->im_allow("tweet_alert")){
	$tweets = tweets_alerts($current_clerk->vars["id"]);
}

if($current_clerk->im_allow("denied_alerts")){
	$denieds = denied_alerts($current_clerk->vars["id"]);
}

if($current_clerk->im_allow("help_calls_alerts")){
	$hcalls = get_pending_help_calls_alerts($current_clerk->vars["id"]);
}



///


//Baseball
if($current_clerk->im_allow("baseball_alerts")){
	$espn = get_pending_baseball_alerts($current_clerk->vars["id"]);
 // print_r($espn);
}

?>
<div class="page_content" style="padding:10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td class="table_header">Detail</td>
        <td class="table_header" align="center"></td>
      </tr>
      <? $i = 0; ?>
      
      
	  <? if(_can_attend_signups($current_clerk->vars["id"])){ ?>
		  <? foreach($nsups as $nsup){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#C00;" class="table_td<? echo $style ?>">
            	New Signup. Player <? echo $nsup["acc_number"] ?>.
                </strong> at <strong><? echo date("h:m A",strtotime($nsup["added_date"])); ?></strong>              
            </td> 
            <td class="table_td<? echo $style?>" align="center">
                <a href="?vrb_hide=<? echo $nsup["id"] ?>&st=nsup" class="normal_link" title="Delete Alert">OK</a>
            </td>     
          </tr>
          <? } ?>
      <? } ?>
	  
       <? if($current_clerk->im_allow("tweet_alert")){ ?>
		  <? foreach($tweets as $tweet){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#C00;" class="table_td<? echo $style ?>">
               The keyword "<strong><? echo $tweet["keyword"] ?>"</strong> was found on this tweet:<p><strong><? echo " ".$tweet["name"] ?></strong><BR />"<? echo $tweet["tweet"]?>"  <strong>at <? echo date("h:m A",strtotime($tweet["added_date"])); ?></strong></p>
            </td> 
          <td class="table_td<? echo $style?>" align="center">
           <a href="?tweet_hide=<? echo $tweet["alert"] ?>" class="normal_link" title="Delete Alert">OK</a>
          </td>     
          </tr>
          <? } ?>
      <? } ?>
	  
	  
	  <? if($current_clerk->im_allow("cc_denied_alerts")){ ?>
		  <? foreach($ccds as $ccd){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#C00;" class="table_td<? echo $style ?>">
              Credit Card Denied for <strong><? echo $ccd["player"] ?></strong> at <strong><? echo date("h:m A",strtotime($ccd["tdate"])); ?></strong>	
              <? if($ccd["crm_name"] > 0){ ?>
              <br />
              <a target="_blank" href="<?= BASE_URL ?>/ck/call.php?odid=<? echo $ccd["crm_name"] ?>" class="normal_link">
              	Open Call
              </a>
              <? } ?>
            </td> 
            <td class="table_td<? echo $style?>" align="center">
                <a href="?hide=<? echo $ccd["id"] ?>&st=ccde" class="normal_link" title="Delete Alert">OK</a>
            </td>     
          </tr>
          <? } ?>
      <? } ?>
      
      
      <? if($current_clerk->im_allow("mp_payouts_alert")){ ?>
		  <? foreach($mpps as $mpp){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#060;" class="table_td<? echo $style ?>">
                <? if($mpp["status"] == "de"){ ?>
                	<span  style="color:#C00;">
                    MP payout for player <strong><? echo $mpp["player"] ?></strong> was Denied
                    </span>
                <? }else{ ?>
                    MP payout for player <strong><? echo $mpp["player"] ?></strong> was processed
                    <br />
                    <strong>Amount:</strong> $<? echo $mpp["amount"] ?>
                    <br />
                    <? 
                    $deposits = get_moneypaks_by_group_ids($mpp["deposit"]);
                    foreach($deposits as $dep){ ?>
                        <strong>MP#:</strong> <? echo $dep->vars["number"] ?> (<strong>Zip:</strong> <? echo $dep->vars["zip"] ?>)
                        <br />
                    <? } ?>
                
					<? $pdate = get_transaction_processed_date($mpp["id"],"MP"); ?>
                    <strong>Processed Date:</strong> <? echo $pdate["tdate"]; ?>
                <? } ?>
            </td> 
            <td class="table_td<? echo $style?>" align="center">
                <a href="?hide=<? echo $mpp["id"] ?>&st=mpp" class="normal_link" title="Delete Alert">OK</a>
            </td>     
          </tr>
          <? } ?>
          
          
          <? foreach($opas as $oalert){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#060;" class="table_td<? echo $style ?>">
            	<? if($mpp["status"] == "de"){ ?>
                	<span  style="color:#C00;">
					<? echo $oalert["ttype"] ?> payout for player <strong><? echo $oalert["player"] ?></strong> was Denied
                    </span>
                <? }else{ ?>
					<? echo $oalert["ttype"] ?> payout for player <strong><? echo $oalert["player"] ?></strong> was processed
                    <br />
                    <strong>Amount:</strong> $<? echo $oalert["amount"] ?>
                    <br />
                    <? $pdate = get_transaction_processed_date($oalert["id"],$oalert["extra_id"]); ?>
                	<strong>Processed Date:</strong> <? echo $pdate["tdate"]; ?>
                <? } ?>
                
            </td> 
            <td class="table_td<? echo $style?>" align="center">
                <a href="?hide=<? echo $oalert["id"] ?>&st=<? echo $oalert["short"] ?>" class="normal_link" title="Delete Alert">OK</a>
            </td>     
          </tr>
          <? } ?>
          
          
      <? } ?>
      
      
 	<? if($current_clerk->im_allow("mp_sell_alert")){ ?>
		  <? foreach($mps as $mpp){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#060;" class="table_td<? echo $style ?>">
                    <span  style="color:#C00;">
                    MoneyPak Sell  <strong><? echo $mpp["id"]; ?></strong> was Acepted. 
                    </span>
                    
            </td>
           
            <td class="table_td<? echo $style?>" align="center">
                <a href="?hide=<? echo $mpp["id"]; ?>&st=mps" class="normal_link" title="Delete Alert">OK</a>
            </td>  
             <? } ?>    
          </tr>
          

      <? } ?>
      
      <? if($current_clerk->im_allow("denied_alerts")){ ?>
		  <? foreach($denieds as $den){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#060;" class="table_td<? echo $style ?>">
                    <span  style="color:#C00;">
                    <? echo $den["message"] ?>
                    </span>
                    
            </td>
           
            <td class="table_td<? echo $style?>" align="center">
                <a href="?vrb_hide=<? echo $den["id"]; ?>&st=detra" class="normal_link" title="Delete Alert">OK</a>
            </td>  
             <? } ?>    
          </tr>
          

      <? } ?>
      
      
      <? if($current_clerk->im_allow("help_calls_alerts")){ ?>
		  <? foreach($hcalls as $hcall){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#060;" class="table_td<? echo $style ?>">
                    Player <? echo $hcall->vars["player"] ?> <? echo strtolower($hcall->vars["request"]) ?><br />
                    <a href="<?= BASE_URL ?>/ck/help_call_requesrts.php" class="normal_link" target="_blank">View Request</a>
            </td>
           
            <td class="table_td<? echo $style?>" align="center">
                <a href="?vrb_hide=<? echo $hcall->vars["id"]; ?>&st=heca" class="normal_link" title="Delete Alert">OK</a>
            </td>  
             <? } ?>    
          </tr>
      <? } ?>
      
      <? if($current_clerk->im_allow("affiliate_payout_alert")){ ?>
		  <? foreach($afps as $afp){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#060;" class="table_td<? echo $style ?>">
                  <? echo ucwords($afp["method"]) ?> Payout ($<? echo $afp["amount"] ?>) for <? echo $afp["player"] ?> was approved.
            </td>
           
            <td class="table_td<? echo $style?>" align="center">
                <a href="?hide=<? echo $afp["id"]; ?>&st=afp<? echo $afp["method"] ?>" class="normal_link" title="Delete Alert">OK</a>
            </td>  
             <? } ?>    
          </tr>
      <? } ?>
      
      <?
	  if($current_clerk->im_allow("bitbet_deposits")){
		  $pbj_wll = @file_get_contents("http://www.playblackjack.com/utilities/ui/city/bitcoin/check.php");
		  $orig_wll = @file_get_contents("http://jobs.inspin.com/btc_wll.php");
		  if($pbj_wll != $orig_wll){
			  
			  
			  ?>
              
              <tr>
                <td style="color:#F00;" class="table_td<? echo $style ?>">
                      <strong>Bitbet Cashier pointing to the WRONG wallet!!!</strong>
                </td>
               
                <td class="table_td<? echo $style?>" align="center"></td>  
 
              </tr>
              
              <?
			  
			  
		  }	
	  }?>
	  
	    <? if($current_clerk->im_allow("baseball_alerts")){ ?>
		  <? foreach($espn as $abs){ 
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
            <td style="color:#060;" class="table_td<? echo $style ?>">
                 Baseball:  <? echo ucwords($abs->vars["message"]); ?>
            </td>
           
            <td class="table_td<? echo $style?>" align="center">
                <a href="?baseball_hide=<? echo $abs->vars["id"]; ?>&type=<? echo $abs->vars["type"] ?>" class="normal_link" title="Delete Alert">OK</a>
            </td>  
             <? } ?>    
          </tr>
      <? } ?>
	  
	  
	  
      
      
      
      <tr>
        <td class="table_last" colspan="100"></td>
      </tr>
    </table>
    
    
    
</div>

</body>
</html>