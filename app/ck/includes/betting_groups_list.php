<? $lgroups = get_all_betting_groups() ?>
<select name="betting_groups_list" id="betting_groups_list" onchange="<? echo $change_group ?>" class="ab_input">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? if($select_option){ ?><option value="">-Select-</option><? } ?>
  <? if($none_option){ ?><option value="">None</option><? } ?>
  <? foreach($lgroups as $lgrp){ ?>
  <option value="<? echo $lgrp->vars["id"] ?>" <? if($current_group == $lgrp->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $lgrp->vars["name"] ?>
  </option>
  <? } ?>
</select>