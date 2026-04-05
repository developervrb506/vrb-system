<? $methods = get_payment_methods() ?>
<select name="payment_method_list<? echo $extra_id_mth ?>" id="payment_method_list<? echo $extra_id_mth ?>" onchange="<? echo $pay_list_change ?>">
	<? if($all_option){ ?><option value="">All</option><? } ?>
    <? if($none_option){ ?><option value="0">None</option><? } ?>
  <? foreach($methods as $method){ ?>
  <option value="<? echo $method["id"] ?>" <? if($s_method == $method["id"]){echo 'selected="selected"';} ?> >
  	<? echo $method["name"] ?>
  </option>
  <? } ?>
</select>