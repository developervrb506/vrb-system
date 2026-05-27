<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("token_generator")) {?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Token Generator</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Token Generator</span><br /><br />
<? include "includes/print_error.php" ?>

<form action="token_generator_table.php" method="post" target="_blank">
Previous tokens for the clerk will be disabled.<br /><br />
 Clerk:
<? $select_option = true; include "includes/clerks_list.php" ?>
<input type="submit"  name="search" id="search" value="Generate"></BR></BR>
</form>


</div>
<? include "../includes/footer.php" ?>

<? }?>
