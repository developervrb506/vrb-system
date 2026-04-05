<? set_time_limit(600); ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_main_report")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliates Main Report</title>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"join_date_from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"join_date_to",
			dateFormat:"%Y-%m-%d"
		});	
		
		var show_report_by = document.getElementById("show_report_by").value;
		f_show_year_dd(show_report_by);
		f_show_camp_dd(show_report_by);
	};
	
function f_show_year_dd(id){
	
	if(id == 2 || id == 3 || id == 4){
	   document.getElementById("display_month_year").style.display = "block";
	}else{
	   document.getElementById("display_month_year").style.display = "none";	
	}
}

function f_show_camp_dd(id){
	
	if(id == 7){
	   document.getElementById("display_campaign_dd").style.display = "block";
	}else{
	   document.getElementById("display_campaign_dd").style.display = "none";	
	}
}	
</script>
</head>
<body>
<? //$page_style = " width:4500px;"; ?>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Affiliates Main Report</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$all_brands = get_all_affiliates_brands(true);
$brand = get_affiliates_brand(clean_get("brand"));
$saf = clean_get("saf");

$from = clean_get("from");
$to = clean_get("to");
$join_date_from = clean_get("join_date_from");
$join_date_to = clean_get("join_date_to");

$month_from = clean_get("month_from");
$month_to = clean_get("month_to");
$year = clean_get("year");
$campaignid = clean_get("campaignid");

$agent = clean_get("agent_list");
$sclerk = clean_get("clerk_list");

$period = clean_get("period");
$join_date_period = clean_get("join_date_period");
$show_report_by = clean_get("show_report_by");

$results_fields = array();
$results_fields = $_POST['results_fields'];

$affiliate_info = array();
$affiliate_info = $_POST['affiliate_info'];

$months = array(
   array("id"=>"01","name"=>"January"),
   array("id"=>"02","name"=>"February"),
   array("id"=>"03","name"=>"March"),
   array("id"=>"04","name"=>"April"),
   array("id"=>"05","name"=>"May"),
   array("id"=>"06","name"=>"June"),
   array("id"=>"07","name"=>"July"),
   array("id"=>"08","name"=>"August"),
   array("id"=>"09","name"=>"September"),
   array("id"=>"10","name"=>"October"),
   array("id"=>"11","name"=>"November"),
   array("id"=>"12","name"=>"December"),	  
);
?>

<form method="post">

<table width="100" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td><strong>Date Range</strong></td>
    <td><strong>Period</strong></td>
    <td><strong>OR</strong></td>
    <td></td>
    <td colspan="2"><strong>Exact Period</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <select name="period" id="period">          
       <option value="0" <? if($period == "0"){ ?>selected="selected" <? } ?>>None</option>
       <option value="1" <? if($period == "1"){ ?>selected="selected" <? } ?>>This week</option>
       <option value="2" <? if($period == "2"){ ?>selected="selected" <? } ?>>Last week</option>
       <option value="3" <? if($period == "3"){ ?>selected="selected" <? } ?>>This month</option>
       <option value="4" <? if($period == "4"){ ?>selected="selected" <? } ?>>Last month</option>
       <option value="5" <? if($period == "5"){ ?>selected="selected" <? } ?>>This year</option>
    </select>
    </td>
    <td></td>
    <td></td>
    <td><strong>From</strong></td>
    <td><strong>To</strong></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="from" type="text" id="from" value="<? echo $from; ?>" /></td>
    <td><input name="to" type="text" id="to" value="<? echo $to; ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Brand</strong></td>
    <td>
    <select name="brand" id="brand">
        <option value="0" <? if($brand == "0"){ ?>selected="selected" <? } ?>>All</option>
        <? foreach(get_all_affiliates_brands(true) as $cbrand){ ?>
    	<option value="<? echo $cbrand->vars["id"] ?>" <? if($cbrand->vars["id"] == $brand->vars["id"]){echo 'selected="selected"';} ?>><? echo $cbrand->vars["name"] ?></option>
        <? } ?>
    </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap"><strong>Affiliate ID</strong></td>
    <td><input name="saf" type="text" id="saf" value="<? echo $saf ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Join Date</strong></td>
    <td><strong>Period</strong></td>
    <td><strong>OR</strong></td>
    <td></td>
    <td colspan="2"><strong>Exact Period</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <select name="join_date_period" id="join_date_period">          
       <option value="0" <? if($join_date_period == "0"){ ?>selected="selected" <? } ?>>None</option>
       <option value="1" <? if($join_date_period == "1"){ ?>selected="selected" <? } ?>>This week</option>
       <option value="2" <? if($join_date_period == "2"){ ?>selected="selected" <? } ?>>Last week</option>
       <option value="3" <? if($join_date_period == "3"){ ?>selected="selected" <? } ?>>This month</option>
       <option value="4" <? if($join_date_period == "4"){ ?>selected="selected" <? } ?>>Last month</option>
       <option value="5" <? if($join_date_period == "5"){ ?>selected="selected" <? } ?>>This year</option>
    </select>
    </td>
    <td></td>
    <td></td>
    <td><strong>From</strong></td>
    <td><strong>To</strong></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="join_date_from" type="text" id="join_date_from" value="<? echo $join_date_from; ?>" /></td>
    <td><input name="join_date_to" type="text" id="join_date_to" value="<? echo $join_date_to; ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap"><strong>Show report by</strong></td>
    <td>   
     <select name="show_report_by" id="show_report_by" onchange="f_show_year_dd(this.value); f_show_camp_dd(this.value);">   
       <option value="1" <? if($show_report_by == "1"){ ?>selected="selected" <? } ?>>Affiliate</option>      
       <option value="2" <? if($show_report_by == "2"){ ?>selected="selected" <? } ?>>Month</option>
       <option value="3" <? if($show_report_by == "3"){ ?>selected="selected" <? } ?>>Affiliate and Month</option>
       <option value="4" <? if($show_report_by == "4"){ ?>selected="selected" <? } ?>>Month and Affiliate</option>
       <?php /*?><option value="5" <? if($show_report_by == "5"){ ?>selected="selected" <? } ?>>Affiliate Managers</option><?php */?>
       <option value="6" <? if($show_report_by == "6"){ ?>selected="selected" <? } ?>>Brand</option>
       <option value="7" <? if($show_report_by == "7"){ ?>selected="selected" <? } ?>>Campaign</option>
    </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr id="display_month_year" style="display:none;" nowrap="nowrap">
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">
    <strong>Month from:</strong>
    <select name="month_from" id="month_from">
    <? foreach($months as $month_item){ ?>   
       <option value="<? echo $month_item["id"] ?>" <? if($month_item["id"] == $month_from){ ?>selected="selected" <? } ?>><? echo $month_item["name"] ?></option>
    <? } ?>       
    </select>
    <br /><br />
    <strong>Month to:</strong>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="month_to" id="month_to">   
    <? foreach($months as $month_item){ ?>   
       <option value="<? echo $month_item["id"] ?>" <? if($month_item["id"] == $month_to){ ?>selected="selected" <? } ?>><? echo $month_item["name"] ?></option>
    <? } ?>    
    </select>
    <br /><br />
    <strong>Year:</strong>   
    <select name="year" id="year">
       <? 
	   $current_year = date("Y");
	   for($i=2012;$i<=$current_year;$i++) { ?>
          <option value="<? echo $i ?>" <? if($year == $i){ ?>selected="selected" <? } ?>><? echo $i ?></option>      
       <? } ?>
    </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="display_campaign_dd" style="display:none;" nowrap="nowrap">
    <td nowrap="nowrap"><strong>Campaigns:</strong></td>
    <td>
    <select name="campaignid" id="campaignid">
       <? 
	   $current_campaigns = get_affiliates_campaigns_report();
	   foreach($current_campaigns as $camp) { ?>
          <option value="<? echo $camp->vars["id"] ?>" <? if($campaignid == $camp->vars["id"]){ ?>selected="selected" <? } ?>><? echo $camp->vars["name"]; ?></option>      
       <? } ?>
    </select>    
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td nowrap="nowrap"><strong>Show results for</strong></td>
    <td nowrap="nowrap">
    <table>      
     <tr> 
      <td>       
       <strong>Affiliate ID:</strong> <input <? if(isset($results_fields) && in_array('affiliate_id',$results_fields )){ ?>checked="checked" <? } ?> type="checkbox" value="affiliate_id" name="results_fields[]" />
      </td>
      <td>       
       <strong>Impressions:</strong> <input <? if(isset($results_fields) && in_array('impressions', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="impressions" name="results_fields[]" />
      </td>
      </tr>
      <tr> 
      <td>       
       <strong>Clicks:</strong> <input <? if(isset($results_fields) && in_array('clicks', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="clicks" name="results_fields[]" />
      </td>
      <td>       
       <strong>CTR:</strong> <input <? if(isset($results_fields) && in_array('ctr', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="ctr" name="results_fields[]" />
      </td>           
      </tr>
      <tr>
      <td>       
       <strong>Sign ups:</strong> <input <? if(isset($results_fields) && in_array('sign_ups', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="sign_ups" name="results_fields[]" />
      </td>
      <td>       
       <strong>First Deposit Count:</strong> <input <? if(isset($results_fields) && in_array('first_deposit_count', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="first_deposit_count" name="results_fields[]" />
      </td>
      <tr>
      <td><strong>Conversion Rate (Reg to funded):</strong> <input <? if(isset($results_fields) && in_array('conversion_rate', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="conversion_rate" name="results_fields[]" /></td>
      <td><strong>Clicks to Funded:</strong> <input <? if(isset($results_fields) && in_array('clicks_to_funded', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="clicks_to_funded" name="results_fields[]" /></td>
      </tr>
      <tr>
      <td><strong>First Deposit (Volume):</strong> <input <? if(isset($results_fields) && in_array('first_deposit', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="first_deposit" name="results_fields[]" /></td>
      <td><strong>Total Deposit (Volume):</strong> <input <? if(isset($results_fields) && in_array('total_deposit', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="total_deposit" name="results_fields[]" /></td>
      </tr>      
      <tr>
      <td><strong>Active Customers:</strong> <input <? if(isset($results_fields) && in_array('active_customers', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="active_customers" name="results_fields[]" /></td>
      <td><strong>Net Revenue:</strong> <input <? if(isset($results_fields) && in_array('net_revenue', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="net_revenue" name="results_fields[]" /></td>     
      </tr> 
      <tr>
      <td><strong>Casino Net Revenue:</strong> <input <? if(isset($results_fields) && in_array('net_revenue_casino', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="net_revenue_casino" name="results_fields[]" /></td>
      
      <td><strong>Sports Net Revenue:</strong> <input <? if(isset($results_fields) && in_array('net_revenue_sports', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="net_revenue_sports" name="results_fields[]" /></td>
      </tr>     
      <tr>
       <td><strong>Horses Net Revenue:</strong> <input <? if(isset($results_fields) && in_array('net_revenue_horses', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="net_revenue_horses" name="results_fields[]" /></td>
      <td><strong>Revenue Share:</strong> <input <? if(isset($results_fields) && in_array('revenue_share', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="revenue_share" name="results_fields[]" /></td>  
      </tr>
      <tr>
       <td><strong>Carried Balance:</strong> <input <? if(isset($results_fields) && in_array('carried_balance', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="carried_balance" name="results_fields[]" /></td>
      <td><strong>Current Balance:</strong> <input <? if(isset($results_fields) && in_array('earnings', $results_fields)){ ?>checked="checked" <? } ?> type="checkbox" value="earnings" name="results_fields[]" /></td>           
      </tr>
              
    </table>   
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap"><strong>Affiliate info</strong></td>
    <td nowrap="nowrap">
    <table>   
     <tr> 
      <td>       
       <strong>First Name:</strong> <input <? if(isset($affiliate_info) && in_array('first_name', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="first_name" name="affiliate_info[]" />
      </td>
      <td>       
       <strong>Last Name:</strong> <input <? if(isset($affiliate_info) && in_array('last_name', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="last_name" name="affiliate_info[]" />
      </td>
      </tr>
      <tr> 
      <td>       
       <strong>Email:</strong> <input <? if(isset($affiliate_info) && in_array('email', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="email" name="affiliate_info[]" />
      </td>
      <td>       
       <strong>Website URL:</strong> <input <? if(isset($affiliate_info) && in_array('website_url', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="website_url" name="affiliate_info[]" />
      </td>           
      </tr>
      <tr>
      <td>       
       <strong>Country:</strong> <input <? if(isset($affiliate_info) && in_array('country', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="country" name="affiliate_info[]" />
      </td>
      <td><strong>State:</strong> <input <? if(isset($affiliate_info) && in_array('state', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="state" name="affiliate_info[]" /></td>
      <tr>
      <td><strong>Join Date:</strong> <input <? if(isset($affiliate_info) && in_array('join_date', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="join_date" name="affiliate_info[]" /></td>
      <td><strong>Status:</strong> <input <? if(isset($affiliate_info) && in_array('status', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="status" name="affiliate_info[]" /></td>
      </tr>
      <tr>
      <td>       
       <strong>Deal:</strong> <input <? if(isset($affiliate_info) && in_array('deal', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="deal" name="affiliate_info[]" />
      </td>      
      <td><strong>Language:</strong> <input <? if(isset($affiliate_info) && in_array('language', $affiliate_info) ){ ?>checked="checked" <? } ?> type="checkbox" value="language" name="affiliate_info[]" /></td>
      </tr>
      <tr>         
    </table>   
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>  
    <input type="submit" value="Search" />
</form>
<br />
<? 
$params = "?from=".$from."&to=".$to."&join_date_from=".$join_date_from."&join_date_to=".$join_date_to."&saf=".$saf."&period=".$period."&join_date_period=".$join_date_period."&show_report_by=".$show_report_by."&month_from=".$month_from."&month_to=".$month_to."&year=".$year."&campaignid=".$campaignid."&results_fields=".serialize($results_fields)."&affiliate_info=".serialize($affiliate_info);
?>
<div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form').submit();" class="normal_link">
		Export
	</a>
</div>
<?
switch($brand->vars["id"]){	
	case "3":
		//SBO			
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_main_report.php".$params."&brand=3");
	break;
	case "6":
		//PBJ		
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_main_report.php".$params."&brand=6");
	break;
	case "7":
		//OWI		
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_main_report.php".$params."&brand=7");
	break;	
	case "8":
		//bitbet		
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_main_report.php".$params."&brand=8");
	break;	
	case "9":
		//Horse racing betting		
	echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_main_report.php".$params."&brand=9");	
	break;		
	
	default: //All brands	  	
		//echo "<br /><br />This report is not available for " . $brand->vars["name"];
		
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_main_report.php".$params."&brand=0");	
}
?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>