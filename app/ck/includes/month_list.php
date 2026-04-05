<? $base_date = "2012-01-15"; ?>
<select name="month<? echo $extra_month ?>" id="month<? echo $extra_month ?>">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? for($i=0;$i<12;$i++){ ?>
  <? 
  $time = strtotime($base_date) + ($i*2592000);
  $full = date("F",$time);
  $short = date("n",$time);
  ?>
  <option value="<? echo $short ?>" <? if($s_month == $short){echo 'selected="selected"';} ?> >
  	<? echo $full ?>
  </option>
  <? } ?>
</select>