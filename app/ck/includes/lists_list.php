<? $lists = get_all_names_list($lists_available) ?>
<select name="list_list" id="list_list" onchange="<? echo $list_onchange ?>">
	<? if($all_option){ ?><option value="">All</option><? } ?>
  <? foreach($lists as $list){ ?>
  <option value="<? echo $list->vars["id"] ?>" <? if($s_list == $list->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $list->vars["name"] ?>
  </option>
  <? } ?>
</select>