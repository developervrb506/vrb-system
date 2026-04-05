<? $banks = get_all_betting_bank() ?>
<select name="betting_banks_list" id="betting_banks_list">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($banks as $bank){ ?>
  <option value="<? echo $bank->vars["id"] ?>" <? if($current_bank == $bank->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $bank->vars["name"] ?>
  </option>
  <? } ?>
</select>