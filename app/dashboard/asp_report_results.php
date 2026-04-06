<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reports</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<? 
$report = $_GET["report"];

$affiliate_code      = get_affiliate_code($_SESSION["aff_id"], 1);
$affiliate_password  = get_affiliate_password($_SESSION["aff_id"], 1);

switch ($report) {

case 1:

   $url   = 'http://lb.playblackjack.com/ag_CommissionByDate-new.asp?customerid='.$affiliate_code;
   $title = 'Commissions';
   break;
	
case 2:

   $url   = 'http://lb.playblackjack.com/AgCustDailyFigurevrb.asp?CustomerID='.$affiliate_code.'&password='.$affiliate_password;
   $title = 'Daily Figures';
   break;	

//case 3:

   //$url   = 'http://lb.playblackjack.com/AgPositionvrb.asp?CustomerID='.$affiliate_code.'&password='.$affiliate_password;
   //$title = 'Position by Game';
   //break;
   
case 4:

   $url = 'http://lb.playblackjack.com/ag_agentcustomerlistvrb-new2.asp?agent='.$affiliate_code;  
   $title = 'Player Report';
   break;
   
case 5:

   $Drange = f_start_end_current_week($format = "m/d/Y");
   $date1  = $Drange[0];
   $date2  = $Drange[1];

   $url = 'http://lb.wagerweb.com/vrb/reports/Affiliates_PayoutsTracking-new-by-date.asp?CustomerID='.$affiliate_code.'&date1='.$date1.'&date2='.$date2;
   $title = 'Payment Statement';
   break;
   
case 6:

   $url = 'http://lb.wagerweb.com/vrb/reports/ag_elDoradoNewCustomers.asp?agentID='.$affiliate_code;
   $title = 'Conversion Report';
   break;
   
case 7:

   $url = 'http://lb.playblackjack.com/ag_cashtransactionsvrb.asp?CustomerID='.$affiliate_code;
   $title = 'Player Deposits';
   break;             
}
?>
<span class="page_title"><?php echo $title ?> </span>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><br /><br />
     <div style="float:right;" class="normal_link"><a href="<?= BASE_URL ?>/dashboard/reports.php?bk=1"><strong><< Back</strong></a></div>
     <br /><br />
     <iframe src="<? echo $url ?>" name="iframe1" width="850" height="600" scrolling="auto" style="background-color:#FFFFFF" frameborder="0"></iframe>
     <br /><br />
    </td>
  </tr>
</table>
</div>
<? include "../includes/footer.php" ?>