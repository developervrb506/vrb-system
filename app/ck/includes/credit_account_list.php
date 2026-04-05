<? $accounts = get_all_credit_accounts() ?>
<select name="credit_account_list<? echo $extra_name ?>" id="credit_account_list<? echo $extra_name ?>">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($accounts as $acc){ ?>
  <option value="<? echo $acc->vars["id"] ?>" <? if($current_account == $acc->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $acc->vars["name"] ?>
  </option>
  <? } ?>
</select>