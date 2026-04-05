<select name="website" id="website" class="<? echo $drop_style ?>">
  <?
  $webs = get_subaccounts($current_affiliate->id);
  foreach($webs as $web_f){
  ?>
    <option value="<? echo $web_f->id ?>"><? echo $web_f->web_name ?></option>
  <? } ?>
</select>