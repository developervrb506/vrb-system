<? $accounts = get_all_pph_accounts() ?>
<select name="pph_account_list<? echo $extra_name ?>" id="pph_account_list<? echo $extra_name ?>">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($accounts as $acc){ ?>
  <option value="<? echo $acc->vars["id"] ?>" <? if($current_account == $acc->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $acc->vars["name"] ?>
  </option>
  <? } ?>
</select>