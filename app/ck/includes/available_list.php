<select name="available_list" id="available_list">
	<? if($all_option){ ?><option value="">All</option><? } ?>
	<option value="1" <? if($s_available == "1"){echo 'selected="selected"';} ?>>Enabled</option>
    <option value="0" <? if($s_available == "0"){echo 'selected="selected"';} ?>>Disabled</option>
</select>