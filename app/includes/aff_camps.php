<select name="camp_list" id="camp_list" class="<? echo $drop_style ?>">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? if($none_option){ ?><option value="">None</option><? } ?>
  <?
  $camps = get_custom_campaigns_by_affiliate($current_affiliate->id);
  foreach($camps as $camp){
  ?>
    <option value="<? echo $camp->id ?>"><? echo $camp->name ?></option>
  <? } ?>
</select>