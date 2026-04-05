<? $base_year = "2000"; ?>
<select name="year<? echo $extra_year ?>" id="year<? echo $extra_year ?>">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? for($i=0;$i<30;$i++){ ?>
  <? $year = $base_year + $i; ?>
  <option value="<? echo $year ?>" <? if($s_year == $year){echo 'selected="selected"';} ?> >
  	<? echo $year ?>
  </option>
  <? } ?>
</select>