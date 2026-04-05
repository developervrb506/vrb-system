<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? include(ROOT_PATH . "/includes/wagerweb/classes.php"); ?>
<? if ( $_SESSION["aff_id"] == 1033 or $_SESSION["aff_id"] == 1035) {
	header("Location: ../reports/index.php");
}
if ( $_SESSION["aff_id"] == 1373) {
	header("Location: contact_reports.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Partners</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:20px; display:inline-block; width:928px;">

<div class="left_column">
    <span class="page_title" style="font-size:18px;">Welcome:</span> 
    <span class="orange_title" style="font-size:18px;"><? echo ucwords($current_affiliate->get_fullname()) ?></span><br /><br />
    <?
	//Books to exclude
    $books_exclude = array(3,5,6,7,8);	
	
    $books = get_affiliate_sportsbooks($current_affiliate->id);	
	echo "<pre>";
	//print_r($books);
    echo "</pre>";	  
	foreach($books as $book){
		
		if (!in_array($book->id, $books_exclude)) {  				
			$aff_code = get_affiliate_code($current_affiliate->id,$book->id);
			//$aff_pass = get_affiliate_password($current_affiliate->id, $book->id);
			$aff_pass = md5($aff_code);
			switch($book->id){
				case 1:
				
				  /*try {
				
				    $params['affiliateID'] = $aff_code;
                    $params['password']    = $aff_pass;					
                    $manager = new FactoryManagerImpl();
                    @$manager->send_session_to_manager('JasperManager',$params);
					
					$params['report'] = 'getaffiliatestatus';					
					$manager = new FactoryManagerImpl();
					//Get Commission %					
					@$results = $manager->send_action_to_manager('JasperManager',$params);		  
             	    $rate = $results->CommissionPercentage.'%'; 				
					//Get Current Balance					
                    $balance = '$'.$results->Balance;				                  					
					
				  } catch (Exception $e) {
                    //echo 'Caught exception: ',  $e->getMessage(), "\n";
                  }	*/				
					
				  break;				
				  default:
				    $rate = "N/A";
					$balance = "N/A";
			} ?>
			
			<div style="float:none; padding:3px;" class="gray_box"><span class="page_title" style="font-size:18px;"><? echo $book->name ?></span></div>    
			<div style="float:none; padding:3px;" class="gray_box">AFFILIATE ID: <strong><? echo $aff_code; ?></strong></div>
			<div style="float:none; padding:3px;" class="gray_box">COMMISSION RATE: <strong><? echo $rate ?></strong></div>
			<div style="float:none; padding:3px;" class="gray_box">CURRENT BALANCE: <strong><? echo $balance ?></strong></div>
			<div style="margin:20px 0;"></div>                         
       <? } ?> 
     <? 
	   $aff_code = "";	 
	 } ?>
     
     <?	 
	 $i=0;	
	 $code = false;
     foreach($books as $book){	    
	 			
		if (in_array($book->id, $books_exclude)) {  				
			$aff_code = get_affiliate_code($current_affiliate->id,$book->id);			
			$info = explode("/",@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_home_info.php?aff=".$aff_code));
			$rate = $info[0]."%";			
			//$balance = "$".number_format((float)$info[1], 2, '.', '');
			if($info[1] < 0){$info[1] = 0;}								    
			$balance = "$".$info[1];
			$i++;
			?>
            <div style="float:none; padding:3px;" class="gray_box"><span class="page_title" style="font-size:18px;"><? echo $book->name ?></span></div>			
        <? } ?> 
        
        <? if ($aff_code != "") { 
		    $code = true;
	 	   } ?>
        
     <? } ?>                      
    
     <? if ($code) { ?>
         <div style="float:none; padding:3px;" class="gray_box">AFFILIATE ID: <strong><? echo $aff_code; ?></strong></div>
         <div style="float:none; padding:3px;" class="gray_box">COMMISSION RATE: <strong><? echo $rate; ?></strong></div>
         <div style="float:none; padding:3px;" class="gray_box">CURRENT BALANCE: <strong><? echo $balance; ?></strong></div>
         <div style="float:none; padding:3px;" class="gray_box">WEEKLY FIGURE: <strong>$<span id="total_commission_local_brands"></span></strong></div>
         <div style="margin:20px 0;"></div>
     <? } ?>
         
    <div style="cursor:pointer; float:none;" class="gray_box" onclick="location.href = 'messages.php'">MESSAGE INBOX: <span class="error" style="font-size:12px;"><strong>&nbsp;&nbsp;&nbsp;<? echo count(get_messages($current_affiliate,"0")); ?></strong></span></div>
    
    <div style="float:none; text-align:justify;" class="gray_box">
    	<strong>NEWS & UPDATES:</strong><br /><br />
		<? echo nl2br(get_news(1)); ?>
    </div>
    
    
</div>

<div class="right_column">
<div class="date_pos"><? echo date("F j, Y, g:i a") ." EST"; ?></div>
<?
$webs = get_subaccounts($current_affiliate->id);
$total_commission = "0";
$total_net = "0";
$total_signups = "0";
?>

<p><strong>Weekly Quick Stats:</strong></p>
<p style="font-size:12px;"><strong>Note:</strong> Stats reflected are for the current week and refresh every Monday. To view a full report, visit the Marketing Report in the Reports section.</p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?
	$total_impressions = 0;
    $total_clicks = 0;
	$days = f_start_end_current_week("Y-m-d");
	?>
	<? foreach($books as $book){ ?>
    
    
    <? //if($book->id != 1){ //hide WW stats ?>
    
    <tr>
      <td class="table_header_samll"><? echo $book->name ?></td>
      <td class="table_header_samll">Impressions</td>
      <td class="table_header_samll">Clicks</td>
      <td class="table_header_samll">Registrations</td>
      <td class="table_header_samll">Net</td>
      <?php /*?><td class="table_header_samll">Weekly Commission</td><?php */?>
    </tr>   
    <?
	if($book->id == 1){
		//$commission_net_weekly = commission_net_weekly($aff_code);
		//$commission_net_weekly = explode("/",$commission_net_weekly);
		//$commission = str_replace("$","",$commission_net_weekly[0]);
		//$net = str_replace("$","",$commission_net_weekly[1]);
		
		$aff_codeww = get_affiliate_code($current_affiliate->id,1);
		//$aff_passww = get_affiliate_password($current_affiliate->id, 1);		
		$aff_passww = md5($aff_codeww);		
		
		/*try {		
			$params['affiliateID'] = $aff_codeww;
			$params['password']    = $aff_passww;								    
			$manager = new FactoryManagerImpl();
			@$manager->send_session_to_manager('JasperManager',$params);													
		
		    $Drange = f_start_end_current_week();			
        	$start_date = strtotime($Drange[0]);
	        $end_date   = strtotime($Drange[1]);						
					
		    //Get Commission weekly 
		    $params['report'] = 'getaffiliateupdatebydate';
		    $params['from']   = $start_date;
            $params['to']     = $end_date;
		  					
		    $manager = new FactoryManagerImpl();
            @$results = $manager->send_action_to_manager('JasperManager',$params);		  
		    $net = $results->NetCommission;  
		  
	        //$total = $results->Total;		  
		    //$commission = $commission * -1;		  					
				
		    //Get total signups weekly
		    $params['report'] = 'totalsignupsbydate';
		    $params['from']   = $start_date;
            $params['to']     = $end_date;					
		    $manager = new FactoryManagerImpl();
            @$signups = $manager->send_action_to_manager('JasperManager',$params);				                  										
		 
		} catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
        } */				
		
	}else if($book->id == 3 || $book->id == 6 || $book->id == 7 || $book->id == 9){
		$qs = "?aff=$aff_code&from=".$days[0]."&to=".$days[1]."&book=".$book->id;
		$data = explode("/",@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_home_stats.php$qs"));
			
        // Patch Added by Alexis Andrade in order to include all the AFF acounts
		$str_web = "";
		foreach ($webs as $_web){
		   $str_web .= $_web->id.",";	
		}
		$str_web = substr($str_web,0,-1);
		
		$signups = count_signups_by_agent($current_affiliate->id, $book->id, $days[0], $days[1],$str_web);
       // End patch   
		  
		  
		  
		//$signups = count_signups_by_agent($current_affiliate->id, $book->id, $days[0], $days[1]);//$data[0];
		$net = $data[1];		
		$commission = $data[2];	
		$commission = $commission * -1;		
				
	}else{
		$signups = 0;
		$net = 0;		
		$commission = 0;
	}
	
	$total_commission += $commission;
	$total_commission_local_brands = $total_commission;		
	
	$total_net += $net;
	$total_signups += $signups;
	$pretotal_impressions = 0;
    $pretotal_clicks = 0;
	?>
    <? $i = 0; foreach($webs as $web){ ?>
		<? if($i % 2){$style = "1";}else{$style = "2";}$i++; ?>
        <?		  
		$wimp = get_week_stats($web->id, "impressions", $days[0], $days[1], $book->id);				
		$total_impressions += $wimp;
		$pretotal_impressions += $wimp;
		$wclick = get_week_stats($web->id, "clicks", $days[0], $days[1], $book->id);
		$total_clicks += $wclick;
		$pretotal_clicks += $wclick;
		?>
        <tr>
          <td class="table_td<? echo $style ?>_small"><strong><? echo $web->web_name ?></strong></td>
          <td class="table_td<? echo $style ?>_small right"><? echo $wimp; ?></td>
          <td class="table_td<? echo $style ?>_small right"><? echo $wclick ?></td>
          <td class="table_td<? echo $style ?>_small right">-</td>
          <td class="table_td<? echo $style ?>_small right">-</td>
          <?php /*?><td class="table_td<? echo $style ?>_small right">-</td><?php */?>
        </tr>
    <? } ?>
    <? if($i % 2){$style = "1";}else{$style = "2";} ?>
    <tr>
      <td class="table_td<? echo $style ?>_small"></td>
      <td class="table_td<? echo $style ?>_small right"><strong><? echo $pretotal_impressions; ?></strong></td>
      <td class="table_td<? echo $style ?>_small right"><strong><? echo $pretotal_clicks; ?></strong></td>
      <td class="table_td<? echo $style ?>_small right"><strong><? echo $signups ?></strong></td>
      <td class="table_td<? echo $style ?>_small right"><strong>$<? echo number_format($net,2) ?></strong></td>
      <?php /*?><td class="table_td<? echo $style ?>_small right"><strong>$<? echo number_format($commission,2) ?></strong></td><?php */?>
    </tr>    
    
    <? } ?>    
    
    <? //} ?>
    
    <tr>
      <td class="table_header_samll"><strong>Total</strong></td>
      <td class="table_header_samll" align="right"><strong><? echo $total_impressions; ?></strong></td>
      <td class="table_header_samll" align="right"><strong><? echo $total_clicks; ?></strong></td>
      <td class="table_header_samll" align="right"><strong><? echo $total_signups ?></strong></td>
      <td class="table_header_samll" align="right"><strong>$<? echo number_format($total_net,2) ?></strong></td>
      <?php /*?><td class="table_header_samll" align="right"><strong>$<? echo number_format($total_commission,2) ?></strong></td><?php */?>
    </tr>
    
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <?php /*?><td class="table_last"></td><?php */?>
    </tr>
</table>
<br /><br />
    
    
    
    <strong>Popular Campaigns:</strong><br /><br />
    <?
	foreach($books as $book){
		$campaigns = get_popular_campaignes($book->id,1,"486x60");
		$available_camps = get_campaigns_list_by_size($campaigns, "486x60");
		$popular = $available_camps[0];
		if(!is_null($popular[0])){
			echo $popular[0]->name."<br />";
			if($popular[1]->name != ""){ 
				?><img src="http://www.inspin.com/partners/images/banners/<? echo $popular[1]->name ?>"><?php /*?><img src="http://images.commissionpartners.com/data/banners/<? echo $popular[1]->name ?>"><?php */?><br /><br /><? 
			}
		}
	}
	?>
    
</div>

</div>
<? include "../includes/footer.php" ?>

<script type="text/javascript">
document.getElementById("total_commission_local_brands").innerHTML = '<? echo number_format($total_commission_local_brands,2) ?>'; 
</script>