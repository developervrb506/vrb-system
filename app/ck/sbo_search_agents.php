<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_agent_info_access")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Search SBO Agents</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Search SBO Agents</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$name = clean_get("name");
?>

<form method="post">
    Agent Name: 
    <input name="name" type="text" id="name" value="<? echo $name ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />


<?
if($name != ""){
	$data = "?name=$name";
	echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/search_agent_by_name.php".$data); 
}
?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>