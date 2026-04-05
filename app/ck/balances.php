<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("balances")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/js/jquery-1.8.0.min.js"></script>
<title>Balance Sheet</title>
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

<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<a href="intersystem_transaction.php" class="normal_link" rel="shadowbox;height=470;width=430">New Intersystem Transaction</a>
&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<a href="balances_transactions.php" class="normal_link">Intersystem Transactions</a>
<br /><br />
<? } ?>

<table width="100%" border="0" cellpadding="20">
  <tr>
    <td width="50%" valign="top">
        <!--Assets-->
    	<span class="page_title">Assets</span>
        <? $total_assets = 0; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <!--Processing-->
          <? //include("balances/processing_assets.php"); ?>
          <!--End Processing-->
          
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          
          <!--Credit-->
          <div id="pph_assets_box">
			Loading PPH Assets...
          </div>
          <script type="text/javascript">
          $.get( "balances/pph_assets.php", function( data ) {
			$( "#pph_assets_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#pph_assets_box" ).html( "Error Loading PPH Assets" );
		  });
          </script>
          <!--End credit-->
          
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          
          <!--SBO Banking-->
          <? //include("balances/sbo_banking.php"); ?>
		  <div id="sbo_banking_box">
			Loading SBO Banking...
          </div>
          <script type="text/javascript">
          $.get( "balances/sbo_banking.php", function( data ) {
			$( "#sbo_banking_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#sbo_banking_box" ).html( "Error Loading SBO Banking" );
		  });
          </script>
          <!--End SBO Banking-->
          
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          
          <!--Betting-->
          <? //include("balances/betting.php"); ?>
		  <div id="betting_box">
			Loading Betting...
          </div>
          <script type="text/javascript">
          $.get( "balances/betting.php", function( data ) {
			$( "#betting_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#betting_box" ).html( "Error Loading Betting" );
		  });
          </script>
          <!--End SBO Betting-->
          
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          
          <!--Total-->
          <tr>
            <td class="table_header" align="center">Total Assets</td>
            <td class="table_header" align="center"><? echo basic_number_format($total_assets) ?></td>
            <td class="table_header" align="center"><? echo basic_number_format($adj_total_assets) ?></td>
          </tr>          
          <!--End Total-->
          
          
        </table>
        
        
        <!--END Assets-->
    </td>
    <td width="50%" valign="top">
        <!--LIABILITIES-->
        <span class="page_title">Liabilities</span>
        <? $total_lia = 0; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <!--Processing
          <? //include("balances/processing_liabilities.php"); ?>
		  <div id="processing_box">
			Loading Processing Liabilities...
          </div>
          <script type="text/javascript">
          $.get( "balances/processing_liabilities.php", function( data ) {
			$( "#processing_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#processing_box" ).html( "Error Loading Processing Liabilities" );
		  });
          </script>
          End Processing-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--Credit-->
          <? //include("balances/credit_liabilities.php"); ?>
		  <div id="credit_box">
			Loading Credit Liabilities...
          </div>
          <script type="text/javascript">
          $.get( "balances/credit_liabilities.php", function( data ) {
			$( "#credit_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#credit_box" ).html( "Error Loading Credit Liabilities" );
		  });
          </script>
          <!--End credit-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--expenses-->
          <? //include("balances/expenses_liabilities.php"); ?>
		  <div id="expenses_box">
			Loading Expenses Liabilities...
          </div>
          <script type="text/javascript">
          $.get( "balances/expenses_liabilities.php", function( data ) {
			$( "#expenses_box" ).html( data );
		  }).fail(function(jqXHR, textStatus, errorThrown) {
			$( "#expenses_box" ).html( "Error Loading Expenses Liabilities" );
		  });
          </script>
          <!--End expenses-->
          
          <tr>
            <td colspan="2" height="10"></td>
          </tr>
          
          <!--Total-->
          <tr>
            <td class="table_header" align="center">Total Liabilities</td>
            <td class="table_header" align="center"><? echo basic_number_format($total_lia) ?></td>
            <td class="table_header" align="center"><? echo basic_number_format($adj_total_lia) ?></td>
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
          <td class="table_header" align="center"><? echo basic_number_format($total_assets-$total_lia) ?></td>
          <td class="table_header" align="center"><? echo basic_number_format($adj_total_assets-$adj_total_lia) ?></td>
        </tr> 
    </table>
    <!--End Global-->
    </td>
  </tr>
</table>


</div>
<? include "../includes/footer.php" ?>
<? }else if($current_clerk->im_allow("processing_balances")){header("Location: http://localhost:8080/ck/processing_balances.php");}else if($current_clerk->im_allow("pph_balances")){header("Location: http://localhost:8080/ck/pph_balances.php");}else{echo "Access Denied";} ?>