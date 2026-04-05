<? $methods = get_all_special_methods() ?>
<select name="special_method" id="special_method">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($methods as $acc){ ?>
  <option value="<? echo $acc->vars["id"] ?>" <? if($current_method == $acc->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $acc->vars["name"] ?>
  </option>
  <? } ?>
</select>