<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("expenses_admin")){ ?>
<? 
$type = "skincare";
$data = get_all_list_emails("skincare");
$periods = get_all_durango_period();
$durango = get_random_durango_name($type);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
 <script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Skincare Name</span><br /><br />
<div class="form_box">

<script type="text/javascript">
  var validations = new Array();
  validations.push({id:"ccn",type:"null", msg:"Credic Card Number is required"});
  validations.push({id:"cvv",type:"null", msg:"CVV is required"});
  validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
  validations.push({id:"email",type:"null", msg:"Email is required"});
  </script>

<? if (!is_null($durango)){ ?>

 <form method="post" action="process/actions/durango_update_control_action.php" id="frm_ex" onsubmit="return validate(validations)">

  

 <table width="100%" border="0" cellspacing="0" cellpadding="10">          
   <tr>
     <td width="29%">First Name</td>
      <td width="71%">
        <input name="type" type="hidden" id="type" value="skincare" />
        <input name="id" type="hidden" id="id" value="<? echo $durango->vars["id"] ?>" />
        <input name="firstname" type="text" id="firstname" value="<? echo $durango->vars["firstname"] ?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Last Name</td>
        <td><input name="lastname" type="text" id="lastname" value="<? echo $durango->vars["lastname"] ?>" readonly="readonly" />
        </td>
      </tr>  
      <tr>
        <td>Address</td>
        <td><input name="address" type="text" id="address" value="<? echo $durango->vars["address"] ?>" readonly="readonly" /></td>
      </tr>   
      <tr>
        <td>City</td>
        <td><input name="city" type="text" id="city" value="<? echo $durango->vars["city"] ?>" readonly="readonly" /></td>
      </tr>
      <tr>
      <tr>
        <td>State</td>
        <td><input name="state" type="text" id="state" value="<? echo $durango->vars["state"] ?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Zip</td>
        <td><input name="zip" type="text" id="zip" value="<? echo $durango->vars["zip"] ?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Credit Card #</td>
        <td><input name="ccn" type="text" id="ccn" /></td>
      </tr>
      <tr>
        <td>CVV</td>
        <td><input name="cvv" type="text" id="cvv" /></td>
      </tr>
      <tr>
        <td>Amount</td>
        <td><input name="amount" type="text" id="amount" /></td>
      </tr>
      <tr>
        <td>Send Email:</td>
        <td>
        	<? create_objects_list("email", "email", $data, "id", "name", "-- None --") ?><br />
            <a href="<?= BASE_URL ?>/ck/skincare_email_list.php" class="normal_link" target="_parent">
            	Manage emails list
            </a>
        </td>
      </tr>
       <tr>
		<td>Period</td>
		<td>
           <input name="period" type="hidden" id="period" value="" />

          <? if (!$durango->vars["period"]) { 			   
              $total = count($periods);

foreach ($periods as $prd) { ?>
		     <? if($prd->vars["months"] != 1){ ?>
             <input name="months" type="submit" onclick="document.getElementById('period').value='<? echo $prd->vars["id"]?>'" id="" value="<? echo $prd->vars["months"]?> Months" readonly="readonly" /><br />
             <? } ?>
		   <? } 
          }  
         else { $oldperiod = $periods[$durango->vars["period"]]; ?>
         
		   <input name="months" type="submit"  onclick="document.getElementById('period').value='<? echo $durango->vars["period"]?>'" id="" value="Another <? echo $oldperiod->vars["months"]?>  Months " readonly="readonly" /><br />
        <? } ?>
        </td>
		 </tr>
  </table>
   	    </form>
 <? } else {	echo "<p align = 'center'> No Names Available </p>";  }	?>   
</div>
</body>
</html>
<? }else{echo "Access Denied";} ?>