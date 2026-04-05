<? $sts_list = array("unposted","posted"); ?>
<select name="status_list" id="status_list">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? foreach($sts_list as $stsi){ $stsim = substr($stsi,0,2); ?>
  <option value="<? echo $stsim ?>" <? if($s_status == $stsim){echo 'selected="selected"';} ?> >
  	<? echo ucwords($stsi) ?>
  </option>
  <? } ?>
</select>