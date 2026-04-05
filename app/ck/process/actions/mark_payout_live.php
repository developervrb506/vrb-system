<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
body {
	background-color: #FFF;
	text-align:center;
	margin-top:100px;
	font-size:28px;
}
</style>
<? 
$oid = str_replace("LC","",$_GET["tid"]);
$oid = str_replace("MO","",$oid);
$oid = str_replace("CP","",$oid);
?>
<script type="text/javascript">
parent.document.getElementById("umki_<? echo $_GET["tid"] ?>").style.display = "none";
parent.document.getElementById("mki_<? echo $_GET["tid"] ?>").style.display = "block";
<? if($_GET["aaa"]){ ?>parent.document.getElementById("admin_status_<? echo $oid ?>").style.display = "none";<? } ?>
</script>

The Transaction has been Inserted.