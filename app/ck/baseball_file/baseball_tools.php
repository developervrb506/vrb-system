  <?
   include(ROOT_PATH . "/ck/process/security.php"); 
	require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); 
  ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/style.css" rel="stylesheet" type="text/css" />
  <title>Baseball Report</title>
  <link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
  <link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
  
  <script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
  <script type="text/javascript" src="js/functions.js"> </script>
  <script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
  <script type="text/javascript">
  Shadowbox.init();
  </script>
  <script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
      window.onload = function(){
          new JsDatePick({
              useMode:2,
              target:"from",
              dateFormat:"%Y-%m-%d"
          });
         
      };
  </script>
    
  </head>
  <title>Baseball Tools</title>
 
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Baseball Tools</span><br /><br />
<?
$from = $_POST['from'];
if ($from == ""){ $from = date('Y-m-d');}
$tools = baseball_tools(); 
?>
 <form method="post">
      Date: 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />
      
      Tool :
      <select name="tool">
      <option>Select an Option</option>
      <? foreach( $tools as $tool){ ?>
        <option <? if ($_POST['tool'] == $tool['id']){ echo ' selected ';} ?> value="<? echo $tool['id']?>"><? echo $tool["tool"]?></option>
      <? }?>
      </select>
      <input type="submit" value="RUN" />
    
 
 </form>
 <BR><BR>
 <iframe height="2000" frameborder="0" scrolling="auto" width="100%" src="" id="frm_tool" >
  <? if (isset($_POST["tool"])) {
     echo "LOADING....";	 
  } ?>
 </iframe>
   
 
 <?

 
 ?> 
  <script type="text/javascript">
    function load_tool(path,date){
	
  document.getElementById('frm_tool').src = 'http://localhost:8080/ck/baseball_file/'+path+'?date='+date;   
	}
  </script> 
  <? if (isset($_POST["tool"])) {
     $path = $tools[$_POST["tool"]]['path'];	 
  ?>
  <script>
   load_tool('<? echo $path ?>','<? echo $_POST["from"] ?>');
  </script>
  <? } ?>  
</div> 
</body>
</html>