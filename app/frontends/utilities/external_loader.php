<?
//create vars
foreach ($_GET as $key => $value) {
    if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
        ${$key} = $value;
    }
}

include("site_loader.php");

?>