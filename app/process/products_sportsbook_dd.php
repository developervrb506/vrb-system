<? include(ROOT_PATH . "/db/handler.php"); ?>
<?
$idbook   = $_GET["idbook"];
$products = get_products_sportsbook($idbook);
?>
<select name="tool" id="tool" class="drop_down_list">  
<? foreach($products as $product) {	
	$id = $product->vars["id"];
	$product = get_product($id);
	$name = $product->vars["name"];	?>	
	<option value="<? echo $id; ?>"><? echo $name; ?></option>
<? } ?>
</select>
