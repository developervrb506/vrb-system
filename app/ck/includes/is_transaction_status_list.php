<select name="status_list" id="status_list">
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? if($all_option){ ?><option value="all">All</option><? } ?>
  <option value="ac" <? if($current_status == "ac"){echo 'selected="selected"';} ?>>Accepted</option>
  <option value="ca" <? if($current_status == "ca"){echo 'selected="selected"';} ?>>Canceled</option>
  <option value="pe" <? if($current_status == "pe"){echo 'selected="selected"';} ?>>Pending</option>
</select>