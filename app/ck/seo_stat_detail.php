<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<strong>Stat Detail</strong><br /><br />

<?
$from = clean_get("from",true);
$to = clean_get("from",true);
$clerk = clean_get("clerk",true);
$action = clean_get("action",true);
$websites = get_seo_stat_websites($from, $to, $clerk, $action);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Website</td>
    <td class="table_header">Time</td>
    <td class="table_header">History</td>
    <td class="table_header">View</td>
  </tr>
  <? foreach($websites as $wb){ if($i % 2){ $style = "1";}else{$style = "2";}$i++ ?>
      <tr>
        <td class="table_td<? echo $style ?>"><? echo $wb["website"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $wb["ldate"]; ?></td>
        <td class="table_td<? echo $style ?>">
        	<a href="seo_web_history.php?w=<? echo $wb["id"]; ?>" class="normal_link">History</a>
        </td>
        <td class="table_td<? echo $style ?>">
        	<a href="seo_lead_detail.php?l=<? echo $wb["id"]; ?>" class="normal_link" target="_blank">View</a>
        </td>
      </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>


<? }else{echo "Access Denied";} ?>