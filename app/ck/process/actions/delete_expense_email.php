<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<?

$name = new _expense_email();
$name->vars[id] = $_GET["id"];
$name-> delete();

header("Location: " . BASE_URL . "/ck/expense_email_list.php?e=79");
?>
<? }else{echo "Access Denied";} ?>