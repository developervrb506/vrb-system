<? $clerks = get_all_clerks($clerks_available, $clerks_admin, $clerks_deleted) ?>
<select name="clerk_list<? echo $extra_cid ?>" id="clerk_list<? echo $extra_cid ?>" <? if($clerks_disabled){echo 'disabled="disabled"';} ?> onchange="<? echo $clerk_onchange ?>">
  <? if($your_option){ ?><option value="">Your</option><? } ?>
  <? if($select_option){ ?><option value="">Select</option><? } ?>
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? if($free_option){ ?><option value="0">Free</option><? } ?>  
  <? foreach($clerks as $clerk){ ?>
  <option value="<? echo $clerk->vars["id"] ?>" <? if($s_clerk == $clerk->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $clerk->vars["name"] ?>
  </option>  
  <? } ?>
  <? if($me_option){ ?><option value="<? echo $current_clerk->vars["id"] ?>">Myself</option><? } ?>
</select>