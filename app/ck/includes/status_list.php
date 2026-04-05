<? $statuses = get_all_name_status($status_admin) ?>
<select name="status_list" id="status_list" onchange="<? echo $on_change_status ?>">
	<? if($all_option){ ?><option value="">All</option><? } ?>
    <? if($open_option){ ?><option <? if($s_status == "0"){echo 'selected="selected"';} ?> value="0">Open Call</option><? } ?>
  <? foreach($statuses as $status){ ?>
  <option value="<? echo $status->vars["id"] ?>" <? if($s_status == $status->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $status->vars["name"] ?>
  </option>
  <? } ?>
</select>