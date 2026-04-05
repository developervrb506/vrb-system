<? $agents = get_all_betting_agents() ?>
<select name="betting_agents_list" id="betting_agents_list">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($agents as $acc){ ?>
  <option value="<? echo $acc->vars["id"] ?>" <? if($current_agent == $acc->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $acc->vars["name"] ?>
  </option>
  <? } ?>
</select>