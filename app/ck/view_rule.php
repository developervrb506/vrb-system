<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$rule = get_rule($_GET["rid"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $rule->vars["title"] ?></title>
</head>
<body>
<? include "../includes/header.php" ?>
<div class="page_content" style="padding-left:50px; ">
<span class="page_title"><? echo $rule->vars["title"] ?></span><br /><br />

<? echo nl2br($rule->vars["content"]) ?>


<? if(isset($_GET["req"])) { ?>
<br /><br />
<div align="center">
	<form action="process/actions/understood.php" method="post">
    	<input name="rule" type="hidden" id="rule" value="<? echo $rule->vars["id"] ?>" />
        <input name="" type="submit" value="Understood" />
    </form>
</div>
<? } ?>


</div>
<? include "../includes/footer.php" ?>