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
$website = get_seo_website(clean_get("w",true));
$logs = get_website_logs($website->vars["id"]);
$clerks = get_all_clerks_index("", "", false,true);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Action</td>
    <td class="table_header">Clerk</td>
    <td class="table_header">Date</td>
  </tr>
  <? foreach($logs as $lo){ if($i % 2){ $style = "1";}else{$style = "2";}$i++ ?>
      <tr>
        <td class="table_td<? echo $style ?>"><? echo $lo->str_action(); ?></td>
        <td class="table_td<? echo $style ?>"><? echo $clerks[$lo->vars["clerk"]]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $lo->vars["ldate"]; ?></td>
      </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>


<? }else{echo "Access Denied";} ?>