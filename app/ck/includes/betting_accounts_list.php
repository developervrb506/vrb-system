<? $accounts = get_all_betting_accounts() ?>
<select name="betting_accounts_list" id="betting_accounts_list" onchange="<? echo $change_account ?>">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($accounts as $acc){ ?>
  <option value="<? echo $acc->vars["id"] ?>" <? if($current_account == $acc->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $acc->vars["name"] ?>
  </option>
  <? } ?>
</select>