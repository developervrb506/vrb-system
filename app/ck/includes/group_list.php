<? $groups = get_all_user_groups() ?>
<select name="group_list" id="group_list" onchange="<? echo $group_onchange ?>">
	<? if($all_option){ ?><option value="">All</option><? } ?>
  <? foreach($groups as $group){ ?>
  <option value="<? echo $group->vars["id"] ?>" <? if($s_group == $group->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $group->vars["name"] ?>
  </option>
  <? } ?>
</select>