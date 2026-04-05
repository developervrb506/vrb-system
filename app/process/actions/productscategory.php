<? require_once(ROOT_PATH . "/db/handler.php"); ?>
<?
$products = get_products_category($_GET["id"]);

?>
  <select  name="tool" id="tool"  class="drop_down_list">
   <option value="">Select an Option</option>
  <? foreach($products as $product){ ?>
  <option value="<? echo $product["id"] ?>" <? if($s_product == $product["id"]){echo 'selected="selected"';} ?> >
  	<? echo $product["name"] ?>
  </option>
  <? } ?>
</select>



