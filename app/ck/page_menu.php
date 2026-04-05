<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if(!is_numeric(param("c"))){
	$items = get_deleted_menu();
	$category ->vars["name"] = "DELETED";
	$deleteds = true;
}else{
	$category = get_menu_item(param("c"));
	$items = get_menu($category ->vars["id"]);	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $category ->vars["name"] ?></title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? if($current_clerk->vars["level"]->vars["name"] != "Monitor"){include "../includes/menu_ck2.php";} ?>



<div class="page_content" style="padding-left:20px; display:inline-block; width:929px;">

<span class="page_title"><? echo $category ->vars["name"] ?> Menu</span><BR/>

<? foreach($items as $item){ ?>
	<p><? print_link($item); ?></p>
<? } ?>

<br /><br />

<? 
function print_link($item, $extra = ""){
	global $deleteds;
	?> 
    <form action="http://localhost:8080/ck/process/actions/edit_menu_item.php?i=<? echo $item ->vars["id"] ?>" method="post">
    <? echo $extra ?>
      	<a href="<? echo $item ->vars["link"] ?>" class="normal_link"><? echo ucwords(strtolower($item ->vars["name"])) ?></a>
        &nbsp;&nbsp;&nbsp;<span class="read_text" style="cursor:pointer;" onclick="location.href = 'http://localhost:8080/ck/process/actions/delete_menu_item.php?i=<? echo $item ->vars["id"] ?>'">
        	<? if($deleteds){echo "UN";} ?>DELETE
        </span> 
        <? if(!$deleteds){ ?>
        &nbsp;&nbsp;&nbsp;Name: <input type="text" value="<? echo ucwords(strtolower($item ->vars["name"])) ?>" name="name" />
        &nbsp;&nbsp;&nbsp;Description: <input type="text" value="<? echo $item ->vars["description"] ?>" name="desc" />
        <input name="Enviar" type="submit" value="Update" />
        <? } ?>
    </form>
	<?
}
?>


</div>
<? include "../includes/footer.php" ?>