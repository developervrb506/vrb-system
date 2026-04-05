<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("expenses_admin")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1;

             maximum-scale=1;

             minimum-scale=1; 

             user-scalable=no;" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:3px;">


<a href="index.php" class="normal_link">&lt;&lt; Back to Main Menu</a><br /><br />

<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"amount",type:"numeric", msg:"Please insert an Amount"});
validations.push({id:"note",type:"null", msg:"Please insert a Note"});
</script>
<div class="form_box">
	<span class="page_title">Insert Expense</span><br /><br />
    <? include "../includes/print_error.php" ?>
  <form method="post" onsubmit="return validate(validations)" action="../process/actions/insert_expense_action.php" id="frm_ex" >
    <input name="reload" type="hidden" id="reload" value="1" />
    <input name="mobile" type="hidden" id="mobile" value="1" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Date:</td>
		<td>
        	<? 
			if(is_null($expense)){$edate = date("Y-m-d");}
			else{$edate = $expense->vars["edate"];}
			?>
			<input name="date" type="text" id="date" value="<? echo $edate ?>" />
		</td>
	  </tr>
      <tr>
		<td>Type:</td>
		<td>
			<select name="type" id="type">
			  <option value="-">Paypment</option>
			  <option value="" <? if(!is_null($expense)){if(!$expense->is_payment()){echo 'selected="selected"';}} ?>>Receipt</option>
			</select>
		</td>
	  </tr>
      <tr>
		<td>Amount:</td>
		<td>
			<input name="amount" type="text" id="amount" value="<? echo str_replace("-","",$expense->vars["amount"]) ?>" />
		</td>
	  </tr>
      <tr>
		<td>Category</td>
		<td>
			<?
			include("../includes/expenses_categories_list.php"); 			
			?>
		</td>
	  </tr> 
	  <tr>
		<td>Note</td>
		<td><textarea name="note" cols="20" rows="5" id="note"><? echo $expense->vars["note"] ?></textarea></td>
	  </tr> 
	  <tr>    
		<td align="center" colspan="2">
            
            <input type="image" src="../../images/temp/submit.jpg" />
                
        </td>
	  </tr>
	</table>
  <? if(!$is_intersystem){ ?></form><? } ?>
</div><br /><br />
<a href="index.php" class="normal_link">&lt;&lt; Back to Main Menu</a>
</body>
</html>
<? }else{echo "Access Denied";} ?>