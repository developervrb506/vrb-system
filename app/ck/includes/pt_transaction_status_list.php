<select name="status_list<? echo $status_extra ?>" id="status_list<? echo $status_extra ?>" onchange="<? echo $status_change_code ?>">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? if($all_option){ ?><option value="all">All</option><? } ?>
  <option value="ac" <? if($current_status == "ac"){echo 'selected="selected"';} ?>>Accepted</option>
  <option value="pe" <? if($current_status == "pe"){echo 'selected="selected"';} ?>>Pending</option>
  <option value="de" <? if($current_status == "de"){echo 'selected="selected"';} ?>>Denied</option>
</select>