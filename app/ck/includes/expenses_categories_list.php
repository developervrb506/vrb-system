<? $categories = get_all_expense_categories() ?>
<select name="categories_list" id="categories_list">
  <? if($all_option){ ?><option value="">All</option><? } ?>
  <? foreach($categories as $cat){ ?>
  <option value="<? echo $cat->vars["id"] ?>" <? if($s_cat == $cat->vars["id"]){echo 'selected="selected"';} ?> >
  	<? echo $cat->vars["name"] ?>
  </option>
  <? } ?>
</select>