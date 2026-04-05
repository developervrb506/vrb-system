<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
$web  = $_GET["web"]; 
$site_domain = return_domain_name($web);
$mobile = $_GET["mobile"];
$account = clean_str_ck($_GET["wpx"]);

if($web == ""){$web = "vrb";}
?>
<? if (!isset($mobile)) { ?>
<link href="style.css" rel="stylesheet" type="text/css">
<div class="container">
  <? //include("header.php") ?>
  <br />
  <div style= "font-family: inherit;">
  <span class="title">Thank you for your Ticket Alert.<br />
  
  <p>The next available representative or your agent will address your issue and respond as soon as possible.</p>

   <p>The response will show at the bottom on the footer which you can read by clicking the yellow envelope image. You will also receive an email if you add one to let you know to login and your ticket has been answered.ogin to the site. </p>
    
   <p>If you do not receive an answer right away it may be because the department is closed or busy. However, we do make it a priority to handle your requests immediately and if they can't be done immediately we will call to let you know if you leave a phone # on the request.</p>

<p>Thanks for utilizing our ticket alert system.</p>

<p>Agents Department</p>
    
   
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
  <? //include("header.php") ?>
  <br />
  <br />
  <span class="title">Thank you for your Ticket Alert.<br />
  <p>The next available representative or your agent will address your issue and respond as soon as possible.</p>

   <p>The response will show at the bottom on the footer which you can read by clicking the yellow envelope image. You will also receive an email if you add one to let you know to login and your ticket has been answered.ogin to the site. </p>
    
   <p>If you do not receive an answer right away it may be because the department is closed or busy. However, we do make it a priority to handle your requests immediately and if they can't be done immediately we will call to let you know if you leave a phone # on the request.</p>

<p>Thanks for utilizing our ticket alert system.</p>

<p>Agents Department</p>
  <br />
  <br />
</div>
</body>
</html>
<? } ?>