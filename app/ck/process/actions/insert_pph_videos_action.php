<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_video_admin")){ ?>
<?
if (isset($_GET["id"])){
	$video = get_pph_video($_GET["id"]);
	$video->delete();	
}
else{
	if (isset($_POST["update"])){
		
		$video = get_pph_video($_POST["update"]);
		$video->vars["url"]     = $_POST["url"];
		$video->vars["id_site"] = $_POST["site"];		
		$video->update();
	
	}else{
	  			
	 $video = new _pph_videos();
	 $video->vars["url"]     = $_POST["url"];
 	 $video->vars["id_site"] = $_POST["site"];			 
	 $video->vars["pdate"]   = date("Y-m-d H:i:s"); 		 
	 $video->insert();
	
	}
}

header("Location: http://localhost:8080/ck/pph_videos_view.php?e=82");
?>
<? }else{echo "Access Denied";} ?>