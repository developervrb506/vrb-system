<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("balances")){ ?>
<?
$from = $_POST["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_POST["to"];
if($to == ""){$to = date("Y-m-d");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/js/jquery-1.8.0.min.js"></script>
<title>Income Statement</title>
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
	};
</script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>


<table width="100%" border="0" cellpadding="20">
  <tr>
    <td width="50%" valign="top">
        <!--Assets-->
    	<span class="page_title">Incomings</span>
        <? $total_in = 0; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <!--Processing-->
          <? //include("balances/processing_incomings.php"); ?>
          <!--End Processing-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--PPH-->
          <? //include("balances/php_incomings.php"); ?>
		  <div id="pph_box">
			Loading PPH...
          </div>
          <script type="text/javascript">
          $.get( "balances/php_incomings.php?from=<? echo $from ?>&to=<? echo $to ?>", function( data ) {
			$( "#pph_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#pph_box" ).html( "Error Loading PPH" );
		  });
          </script>
          <!--End PPH-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--credit-->
          <? //include("balances/credit_incomings.php"); ?>
		  <div id="credit_box">
			Loading Credit...
          </div>
          <script type="text/javascript">
          $.get( "balances/credit_incomings.php?from=<? echo $from ?>&to=<? echo $to ?>", function( data ) {
			$( "#credit_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#credit_box" ).html( "Error Loading Credit" );
		  });
          </script>
          <!--End credit-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--betting-->
          <? //include("balances/betting_incomings.php"); ?>
		  <div id="betting_box">
			Loading Betting...
          </div>
          <script type="text/javascript">
          $.get( "balances/betting_incomings.php?from=<? echo $from ?>&to=<? echo $to ?>", function( data ) {
			$( "#betting_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#betting_box" ).html( "Error Loading Betting" );
		  });
          </script>
          <!--End betting-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--Total-->
          <tr>
            <td class="table_header" align="center">Total Incomings</td>
            <td class="table_header" align="center"><? echo basic_number_format($total_in) ?></td>
          </tr>          
          <!--End Total-->
          
          
        </table>
        
        
        <!--END Assets-->
    </td>
    <td width="50%" valign="top">
        <!--LIABILITIES-->
        <span class="page_title">Expenses</span>
        <? $total_ex = 0; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <!--accounting-->
          <? //include("balances/accounting_expences.php"); ?>
		  <div id="accounting_expences_box">
			Loading Accounting Expences...
          </div>
          <script type="text/javascript">
          $.get( "balances/accounting_expences.php?from=<? echo $from ?>&to=<? echo $to ?>", function( data ) {
			$( "#accounting_expences_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#accounting_expences_box" ).html( "Error Loading Accounting Expences" );
		  });
          </script>
          <!--End accounting-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--Total-->
          <tr>
            <td class="table_header" align="center">Total Expenses</td>
            <td class="table_header" align="center"><? echo basic_number_format($total_ex) ?></td>
          </tr>          
          <!--End Total-->
          
          
        </table>
        <!--END LIABILITIES-->
    </td>
  </tr>
  <tr>
  	<td colspan="2" align="center">
    <!--Global-->
    <table width="50%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="table_header" align="center">Net</td>
          <td class="table_header" align="center"><? echo basic_number_format($total_in-$total_ex) ?></td>
        </tr> 
    </table>
    <!--End Global-->
    </td>
  </tr>
</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>