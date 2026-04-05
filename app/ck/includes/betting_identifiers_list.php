<? $ids = get_all_betting_identifiers() ?>
<select name="betting_identifiers_list" id="betting_identifiers_list">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? foreach($ids as $idf){ ?>
  <option value="<? echo $idf->vars["id"] ?>" <? if($current_identifier == $idf->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $idf->vars["description"] ?>
  </option>
  <? } ?>
</select>