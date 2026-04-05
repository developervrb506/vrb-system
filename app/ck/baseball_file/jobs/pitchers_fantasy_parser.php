<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
$data = $_GET["data"];
$data = str_replace("_o_",",",$data);
?>

<? ?>


<html>
   <head>
      <script src="../../includes/js/jquery-1.8.3.min.js" type="text/javascript"></script>   
     <script>

function json_obj(data){
	//alert(JSON.stringify(data));
	var obj = jQuery.parseJSON(data); 
    document.getElementById("text").innerHTML = JSON.stringify(obj,null,'\t').replace(/\n/g,'**<br>').replace(/\t/g,'&nbsp;&nbsp;&nbsp;');
  
	
}

</script>
   </head>
<body>
<div id="text"></div>
</body>
<script>
json_obj('<? echo $data ?>');
</script>

</html>