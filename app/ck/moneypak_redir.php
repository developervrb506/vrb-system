<? include(ROOT_PATH . "/ck/process/security.php"); ?>
    <? if($current_clerk->im_allow("view_mp_numbers")){ ?>
<?
$id_trans = post_get("id");

$tran = get_moneypak_transaction($id_trans);


$data = "MP".$tran->vars["id"]."_".$tran->vars["image_receipt"] ;

rec_moneypak_log($data);

?>


<script>

document.location = "http://www.sportsbettingonline.ag/utilities/process/cashier/moneypak_receipts/<? echo $tran->vars["image_receipt"] ?>";

</script>



<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>