<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>

<script type="text/javascript">
<?
set_time_limit(0); 
$link="ftp://monitor:Gravaci0nes@192.168.10.50//";
$callid = $_GET["id"];
?>
function Play(callid)
{

document.getElementById("audio").innerHTML= "<embed width='248' src='<? echo $link ?>"+callid+".gsm' urlsubstitute='<samplestring>:<http://localhost:8080/ck/images/reload.png>'>";

}

</script>
<?
/* 


*/

?>
<div id = "audio" name= "audio"></div>
<script>
 Play('<? echo $callid ?>');
</script>