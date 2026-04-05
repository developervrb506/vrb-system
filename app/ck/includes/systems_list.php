<? $systems = get_all_systems() ?>
<select name="system_list<? echo $extra_name ?>" id="system_list<? echo $extra_name ?>" onchange="<? echo $system_change ?>">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? foreach($systems as $sys){ ?>
  <option value="<? echo $sys["id"] ?>" <? if($current_system == $sys["id"]){echo 'selected="selected"';} ?> >
  	<? echo $sys["name"] ?>
  </option>
  <? } ?>
</select>