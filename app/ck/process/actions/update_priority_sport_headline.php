<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("new_features")){ ?>
<?
$id = $_POST["id"];
$priority = $_POST["priority"];

$headline = get_pph_sports_headline($id);
$headline->vars["priority"] = $priority;		
$headline->update(array("priority"));
?>
<? }else{echo "Access Denied";} ?>