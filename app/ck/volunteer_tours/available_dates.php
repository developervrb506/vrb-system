<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("volunteer_tours")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="/includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="/includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<script type="text/javascript">
	window.onload = function(){
      g_globalObject1 = new JsDatePick({
	  useMode:2,
	  isStripped:true,	  
	  target:"start_date",
	  dateFormat:"%Y-%m-%d"
  });
  
      g_globalObject2 = new JsDatePick({
	  useMode:2,
	  isStripped:true,	  
	  target:"end_date",
	  dateFormat:"%Y-%m-%d"
  });  
  
  g_globalObject1.addOnSelectedDelegate(function(){ 
  validate_dates();
  });

  g_globalObject2.addOnSelectedDelegate(function(){
  validate_dates(); 
  });
    
};
function validate_dates(){
	var sday, smonth, syear, myDate, dstring, enddate_formated;
    var oneDay, firstDate, secondDate, diffNights, start_date, end_date;
    var eday, emonth, eyear, edayreal;	
	var error = false;		
	
	start_date = document.getElementById('start_date').value;
	end_date   = document.getElementById('end_date').value;
		
	start_date = start_date.split('-');
	
	sday   = start_date[2];
	smonth = start_date[1];
	smonth = return_month_number(smonth);	
	syear  = start_date[0];
			
	end_date = end_date.split('-');
	
	eday   = end_date[2];
	emonth = end_date[1];
	emonth = return_month_number(emonth);
	eyear  = end_date[0];
			
	firstDate  = new Date(syear,smonth,sday);
	secondDate = new Date(eyear,emonth,eday);
		
	var currentDate = new Date()
    var cday   = currentDate.getDate();
    var cmonth = currentDate.getMonth();
	cmonth = return_month_number(cmonth);	
    var cyear  = currentDate.getFullYear();
	
	currentDate  = new Date(cyear,cmonth,cday);			
		
	if((firstDate.getTime()) < (currentDate.getTime()) ){		
       alert("The start date can not be lower than the current date");	  
	   error = true;	  	  
    }		
	
	if((secondDate.getTime()) < (currentDate.getTime()) ){		
       alert("The end date can not be lower than the current date");
	   error = true;	  
    }	    		
	
	if((firstDate.getTime()) > (secondDate.getTime()) ){		
       alert("The end date must be greater than the start date");	  
	   error = true;
	}	
		
	if (error) {  
	   document.getElementById('start_date').value = "";
   	   document.getElementById('end_date').value = "";	   	   		
	   return;
	}	
	
};
</script>
<title>Available Dates</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<h1>Available Dates</h1>
<?
$id  = $_GET["id"]; 
$add = $_GET["add"]; 

if(isset($id) and !empty($id)){
	$id = "&id=".$id;
}else{
	$id = "";
}

if(isset($add)){
	$add = "&add=1";
}else{
	$add = "";
}

echo @file_get_contents("https://www.volunteertours.com/utilities/ui/available_dates/list.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$id.$add); ?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>