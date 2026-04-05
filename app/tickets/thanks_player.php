<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
$web  = $_GET["web"]; 
$site_domain = return_domain_name($web);
$mobile = $_GET["mobile"];

if($web == ""){$web = "vrb";}
?>
<? if (!isset($mobile)) { ?>
<link href="style.css" rel="stylesheet" type="text/css">
<div class="container">
  <? include("header.php") ?>
  <br />
  <div style="">
  <span class="title">Thank you for your Ticket Alert.<br />
  
  <p>The next available representative or your agent will address your issue and respond as soon as possible.</p>

   <p>The response will show at the top of the main page after you login to the site. Click on this image <a href="list.php"><img src="images/envelop.png"></a> to view the response.</p>
    
   <p> If you do not receive an answer right away it may be because the department is closed. Normal operating hours run from 9am eastern to 8pm eastern everyday. If the department is closed for the day your ticket will be answered first thing the following morning.</p>
    
   
    
   <p> Thanks for utilizing our ticket alert system.</p>
  </div> 
  <br />
  <br />
  <br />
  <br />
  <br />
</div>
<? } else { ?>
<? include("header_top_mobile.php") ?>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="mobile_container" align="center">
  <? include("header.php") ?>
  <br />
  <br />
  <span class="title">Thank you for your Ticket Alert.<br />
  <br />
  The next available representative will address your issue and respond either via email or phone.<br />
  <br />
  Important: If you have asked to be contacted via email make sure to check your spam folder if you don't see a response in the next few minutes.<br />
  <br />
  If you do not receive an answer right away it may be because the department is closed. Normal operating hours run from 9am eastern to 8pm eastern everyday. If the department is closed for the day your ticket will be answered first thing the following morning.<br />
  <br />
  Thanks for utilizing our ticket alert system.</span> <br />
  <br />
  <div class="goback_container"> <a style="color:#FFF;" class="goback" href="http://<? echo $site_domain ?>/">Go back to website</a> </div>
  <br />
  <br />
</div>
</body>
</html>
<? } ?>