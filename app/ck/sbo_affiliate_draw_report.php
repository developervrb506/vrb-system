<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("agent_draw")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliate Draw  Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Affiliate Draw  Report</span>
<BR/><BR/>
<?
$s_affiliate = $_GET["aff"];
$transactions = search_intersystem_affliate_draw_transactions("","",$s_affiliate);
?>


<? if (count($transactions) > 0) { ?>
<iframe width="1"  height="1" frameborder="0" scrolling="no" id="loaderi" name="loaderi"></iframe>
<iframe width="1"  height="1" frameborder="0" scrolling="no" id="loadrev" name="loadrev"></iframe>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Id</td>
    <td class="table_header">Affiliate</td>
    <td class="table_header">Note</td>
    <td class="table_header">Amount</td>
    <td class="table_header">Date</td>
    <td class="table_header">Inserted By</td>
   </tr>


<? foreach($transactions as $trans){
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
	  $clerk = get_clerk($trans->vars["inserted_by"]);
	  $aff_note = explode("AF Draw:",$trans->vars["note"]);
    ?>
    <tr>
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["id"]; ?>
        </td> 
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $aff_note[1] ?>
        </td>         
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $aff_note[0] ?>
        </td>        
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["amount"]?>
        </td>     
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["tdate"]?>
        </td>       
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $clerk->vars["name"] ?>
        </td>
               
   </tr>
  <? }?> 
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
</table>

<? } else { echo "There is not Information to display"; }  ?>
</div>
</body>

<? }else{echo "Acces Denied";} ?>