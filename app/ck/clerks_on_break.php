<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("working_time_report")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:20px; background:#fff;">

<span class="page_title">Clerks on Break</span><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Elapsed Time</td>
  </tr>

<?
$breaks = get_current_breaks();
$i=0;
foreach($breaks as $break){
    if($i % 2){$style = "1";}else{$style = "2";}
	$i++;
	$clerk = get_clerk($break->vars["user"]);
    ?>
    <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $clerk->vars["name"] ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo sec2hms($break->get_time()); ?></td>
    </td>	
    <?
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>


</div>
<? }else{echo "Acces Denied";} ?>