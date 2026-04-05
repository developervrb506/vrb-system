<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$param = $_GET["param"];
if($param != ""){
	$items = search_menu($param);
	foreach($items as $item){
		
		?> 
		<a href="<? echo $item ->vars["link"] ?>"><p><? echo $item ->vars["name"] ?></p></a>
		<?
		
	}
}
?>