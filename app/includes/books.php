<select name="book" id="book" class="<? echo $drop_style ?>" onchange="<? echo $books_on_change ?>">
	<? if($select_option){ ?><option value="" >Select</option><? } ?>
	<?
    $books =get_sportsbooks_by_affiliate($current_affiliate->id);
    foreach($books as $book){
    ?>
      <option value="<? echo $book->id ?>" <? if($book->id == $selected_book){echo 'selected="selected"';} ?>><? echo $book->name ?></option>
    <? } ?>
</select>