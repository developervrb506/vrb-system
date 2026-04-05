
<select name="type_list" id="type_list" >
  <option value="1" <? if($s_type == "1"){echo 'selected="selected"';} ?> >
  	Withdrawal
  </option>
  <option value="0" <? if($s_type == "0"){echo 'selected="selected"';} ?> >
  	Deposit
  </option>
</select>