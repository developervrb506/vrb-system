<? $softs = get_all_betting_softwares() ?>
<select name="betting_software_list" id="betting_software_list">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($softs as $soft){ ?>
  <option value="<? echo $soft->vars["id"] ?>" <? if($current_software == $soft->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $soft->vars["name"] ?>
  </option>
  <? } ?>
</select>