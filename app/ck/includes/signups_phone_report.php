<?
$sites = array(array("name"=>"SBO","id"=>"20"),array("name"=>"Inspin","id"=>"18"));
$from_sgns = "2012-07-31";
$to_sgns = "2012-07-31";
?>
<table width="250" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header"></td>
    <td class="table_header" align="center" width="33%">Signups</td>
    <td class="table_header" align="center" width="33%">Worked</td>
  </tr>

  <?   
  $i = 0;
  foreach($sites as $site){
	  $i++;
	  if($i % 2){$style = "1";}else{$style = "2";}
	  $total = get_signups_names(true, $site["id"], $from_sgns, $to_sgns);
	  $worked = get_signups_names(true, $site["id"], $from_sgns, $to_sgns, "1");
  ?>
  <tr>
  	<td class="table_td<? echo $style ?>"><? echo $site["name"] ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="signups_details.php?ls=<? echo $site["id"] ?>&frm=<? echo $from_sgns ?>&to=<? echo $to_sgns ?>" class="normal_link" rel="shadowbox;height=500;width=700" title="<? echo $site["name"] ?> Signups from Today">
    	<? echo $total["total"] ?>
        </a>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="signups_details.php?ls=<? echo $site["id"] ?>&frm=<? echo $from_sgns ?>&to=<? echo $to_sgns ?>&st=1" class="normal_link" rel="shadowbox;height=500;width=700" title="<? echo $site["name"] ?> Worked Signups from Today">
		<? echo $worked["total"] ?>
        </a>
    </td>
  </tr>
  <? } ?>

  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

<br />
