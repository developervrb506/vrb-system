<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
.text{
	font-size:12px;
	color:#F00;
}
</style>

<? 

if($_GET["done"]){ ?>
<p class="text">File has been uploaded.</p>
<script type="text/javascript">parent.show_btn();</script>
<? }else{ ?>
<span class="text">Select a file and then clicks Upload</span><br />
<form method="post" action="http://landings.vrbmarketing.com/uploads/go.php" enctype="multipart/form-data">
    <input name="file_up" type="file" id="file_up" />
    <input name="burl" type="hidden" id="burl" value="<? echo curPageURL() ?>&done=1" />
    <input name="name" type="hidden" id="name" value="<? echo $_GET["name"]; ?>" />
   
    <input name="sd" type="submit" id="sd" value="Upload" />
</form>
<? } ?>