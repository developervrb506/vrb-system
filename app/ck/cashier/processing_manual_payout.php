<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_payout")){ ?>

<?
$tans = ($_GET["west"] - 4457896);
if(is_numeric($tans)){
?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../../css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<div class="page_content" style="padding:10px;">
	<strong>Process Transaction #<? echo $tans ?> Manually</strong><br /><br />
	<script type="text/javascript" src="../../process/js/functions.js"></script>
	<div class="form_box" id="confirm_div">
	
    <script type="text/javascript">
    var validations = new Array();
    validations.push({id:"mtcn",type:"null", msg:"MTCN is required"});
	validations.push({id:"sname",type:"null", msg:"Sender Name is required"});
	validations.push({id:"scity",type:"null", msg:"Sender City is required"});
	validations.push({id:"sstate",type:"null", msg:"Sender State is required"});
	validations.push({id:"scountry",type:"null", msg:"Sender Country is required"});
    </script>

    <form method="post" action="poster.php" onsubmit="return validate(validations)" target="_top">    
    <input name="way" type="hidden" id="way" value="manual_process_payout" />
    <input name="ring" type="hidden" id="ring" value="<? echo $tans + 114901265 ?>" />
    <input name="burl" type="hidden" id="burl" value="http://localhost:8080/ck/cashier/payouts.php" />              
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><strong>MTCN:</strong></td>
        <td><input name="mtcn" type="text" id="mtcn" /></td>
      </tr>
      <tr>
        <td><strong>Sender Name:</strong></td>
        <td><input name="sname" type="text" id="sname" /></td>
      </tr>
      <tr>
        <td><strong>Sender City:</strong></td>
        <td><input name="scity" type="text" id="scity" /></td>
      </tr>
      <tr>
        <td><strong>Sender State:</strong></td>
        <td><input name="sstate" type="text" id="sstate" /></td>
      </tr>
      <tr>
        <td><strong>Sender Country:</strong></td>
        <td><input name="scountry" type="text" id="scountry" /></td>
      </tr>
      <tr>
        <td><input name="" type="submit" value="Process" /></td>
        <td></td>
      </tr>
    </table>
	</form>
	
	</div>
	
	<? }else{echo "Your IP is not allowed";} ?>

<? }else{echo "Access Denied";} ?>