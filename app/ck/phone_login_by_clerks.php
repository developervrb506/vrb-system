<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?  if($current_clerk->im_allow("phone_logins")) {

$agents = get_all_clerks_with_phone_login();

$str_agent = "";
foreach ($agents as $agent){
$str_agent .= "'".$agent["agent"]."',";	

}
$str_agent = substr($str_agent,0,-1);
$clerks = get_all_clerks_exclude_list($str_agent ,false,true);
$logins_cc = get_clerks_with_login_by_description("CC");
$logins_ww = get_clerks_with_login_by_description("CS");
$logins_cs = get_clerks_with_login_by_description("Wagerin");
$logins_pay = get_clerks_with_login_by_description("Payouts");
$logins_sales = get_clerks_with_login_by_description("SALES");
$logins_pph = get_clerks_with_login_by_description("PPH");
$logins_aff = get_clerks_with_login_by_description("AF");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Phone Logins Users</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Phone Logins</span><br /><br />
<? include "includes/print_error.php" ?>



<script>
document.getElementById("error_box").style.display = "none";
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Login Wagerin</td>
    <td class="table_header" align="center">Login CS</td>
    <td class="table_header" align="center">Login Credit</td>
    <td class="table_header" align="center">Login Payout</td>
    <td class="table_header" align="center">Login Sales</td>
    <td class="table_header" align="center">Login PPH</td>
    <td class="table_header" align="center">Login AFF</td>
    <td class="table_header" align="center">Extension</td>
    
  </tr>
  <? foreach($clerks as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["name"]; ?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $logins_cs[$clerk->vars["id"]]["login"]?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $logins_ww[$clerk->vars["id"]]["login"]?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $logins_cc[$clerk->vars["id"]]["login"]?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $logins_pay[$clerk->vars["id"]]["login"]?>
   </td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $logins_sales[$clerk->vars["id"]]["login"]?>
   </td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $logins_pph[$clerk->vars["id"]]["login"]?>
   </td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $logins_aff[$clerk->vars["id"]]["login"]?>
   </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["ext"]; ?></td>
    
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>


</div>
<? include "../includes/footer.php" ?>

<? }else{echo "access Denied";} ?>
