<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
$web     = clean_str_ck($_GET["web"]); 
$mobile  = clean_str_ck($_GET["mobile"]);
$account = clean_str_ck($_GET["wpx"]);


$exclude_chat_depts = array("11","104","105","106");

if($web == ""){$web = "vrb";}
$live_help_departments = get_live_help_departments();
?>
<? if (isset($mobile) and $mobile == 1) { ?>
<? include("header_top_mobile.php") ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();

<? if($web != "thebestperhead.com"){ $title_name = "Username:"; ?>
validations.push({id:"name",type:"null", msg:"Please Write your Name"});
<? } else { $title_name = "Your Name/Account:";?>
validations.push({id:"name",type:"null", msg:"Please Write your Name or Account"});
<? } ?>
//validations.push({id:"email",type:"email", msg:"Please Write a valid Email"});
validations.push({id:"email",type:"either:phone", msg:"Please choose to be contacted back by either email or telephone."});
<? if($account == "" and $web != "thebestperhead.com"){ ?>
validations.push({id:"player_account",type:"null", msg:"Please Write your Player Account"});
<? } ?>
validations.push({id:"subject",type:"null", msg:"Please Write a Subject"});
validations.push({id:"message",type:"null", msg:"Please Write a Message"});
validations.push({id:"department",type:"null", msg:"Please choose a department where you want to send the ticket"});
</script>
<script type="text/javascript">

function disable_btn(id){
	
  document.getElementById(id).disabled = true;
   document.getElementById("frm_1").submit();
}

</script>
</head>
<body>
<div class="mobile_container">
<? //include("header.php") ?>

<span class="title">Create New Ticket: </span>
<form method="post" action="actions/create.php" id="frm_1" onSubmit="return validate(validations)">
<input name="cat" type="hidden" id="cat" value="<? echo clean_str_ck($_GET["cat"]) ?>">
<input name="web" type="hidden" id="web" value="<? echo $web ?>">
<input name="wpx" type="hidden" id="wpx" value="<? echo $account ?>">
<input name="mobile" type="hidden" id="mobile" value="1">
<input name="tk_cat" type="hidden" id="tk_cat" value="<? echo clean_str_ck($_GET["tk_cat"]) ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><div class="labels_tds"><? echo $title_name ;?></div></td>
    <td><input name="name" type="text" id="name"></td>
    <td></td>
  </tr>
  <tr>
    <td><div class="labels_tds">Your Email:</div></td>
    <td><input name="email" type="text" id="email"></td>
    <td><? if( $web != "ezpay" || $web != "buybitcoins"){ ?><div class="note_email_phone note_email_phone_mobile">Please choose to be<br />contacted back by<br /> either email or telephone.</div><? } ?></td>
  </tr>
  <tr>
    <td><div class="labels_tds">Your Phone:</div></td>
    <td><input name="phone" type="text" id="phone"></td>
    <td></td>
  </tr>
  <? if($account == "" && $web != "thebestperhead.com" && $web != "ezpay" && $web != "buybitcoins"){ ?>
  <tr>
    <td><div class="labels_tds">Your Player Account:  </div></td>
    <td><input name="player_account" type="text" id="player_account"></td>
    <td></td>
  </tr>
  <? } ?>
  <tr>
    <td><div class="labels_tds">Subject:</div></td>
    <td><input name="subject" type="text" id="subject"></td>
    <td></td>
  </tr>
  
  <? if ($_GET["web"] == "vrb" || $_GET["web"] == "compart") { $nodepartment = true; ?>  
    <input name="department" type="hidden" id="department" value="1"> 
  <? } elseif ($_GET["web"] == "thebestperhead.com") { $nodepartment = true; ?>  
    <input name="department" type="hidden" id="department" value="4">
  <? } else { ?>  
  <tr>
    <td><div class="labels_tds">Department:</div></td>
    <td>
    <select name="department" id="department">        
      <option value="" selected="selected">Choose</option>
	  <? foreach ($live_help_departments as $dep) { ?>
        <? if ( !in_array($dep->vars["deptID"], $exclude_chat_depts) ) {?>
        <option value="<? echo $dep->vars["deptID"]; ?>"><? echo $dep->vars["name"]; ?></option>
        <? } ?>
      <? } ?>      
    </select>
    </td>
    <td></td>
  </tr>  
  <? } ?>  
  <tr>
    <td valign="top"><div class="labels_tds">Message:</div></td>
    <td><textarea name="message" cols="40" rows="10" id="message"></textarea></td>
    <td></td>
  </tr>
  <tr>
  	<td></td>
    <td align="left"><input name="" id="btn1"  onclick="disable_btn('btn1')" type="button" value="Submit"></td>
    <td></td>
  </tr>
</table>
</form>
</div>
</body>
</html>

<? } else { ?>

<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
<? if($web != "thebestperhead.com"){ $title_name = "Username:"; ?>
validations.push({id:"name",type:"null", msg:"Please Write your Name"});
<? } else { $title_name = "Your Name/Account:";?>
validations.push({id:"name",type:"null", msg:"Please Write your Name or Account"});
<? } ?>
//validations.push({id:"email",type:"email", msg:"Please Write a valid Email"});
validations.push({id:"email",type:"either:phone", msg:"Please choose to be contacted back by either email or telephone."});
<? if($account == "" and $web != "thebestperhead.com"){ ?>
validations.push({id:"player_account",type:"null", msg:"Please Write your Player Account"});
<? } ?>
validations.push({id:"subject",type:"null", msg:"Please Write a Subject"});
validations.push({id:"message",type:"null", msg:"Please Write a Message"});
validations.push({id:"department",type:"null", msg:"Please choose a department where you want to send the ticket"});
</script>
<script type="text/javascript">

function disable_btn(id){
	
  document.getElementById(id).disabled = true;
  if (validate(validations)){
  document.getElementById("frm_2").submit();
  }
  else {
  document.getElementById(id).disabled = false;
  }
}

</script>

<div class="container">
<? //include("header.php") ?>

<span class="title">Create New Ticket: </span>
<form method="post" action="actions/create.php" id="frm_2" onSubmit="return validate(validations)">
<input name="cat" type="hidden" id="cat" value="<? echo $_GET["cat"] ?>">
<input name="web" type="hidden" id="web" value="<? echo $web ?>">
<input name="wpx" type="hidden" id="wpx" value="<? echo $account ?>">
<input type="hidden" value="15" name="department" id="department"> <? //Department Customer Services was added as default and hidden the Department list. 02/2017.AA ?>
<input name="tk_cat" type="hidden" id="tk_cat" value="<? echo clean_str_ck($_GET["tk_cat"]) ?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><div class="labels_tds"><? echo $title_name ;?></div></td>
    <td><input name="name" type="text" id="name"></td>
    <td></td>
  </tr>
  <tr>
    <td><div class="labels_tds">Your Email:</div></td>
    <td><input name="email" type="text" id="email"></td>
    <td><? if($web != "ezpay" || $web != "buybitcoins" ){ ?><div class="note_email_phone">Please choose to be<br />contacted back by<br /> either email or telephone.</div><? } ?></td>
  </tr>
  <tr>
    <td><div class="labels_tds">Your Phone:</div></td>
    <td><input name="phone" type="text" id="phone"></td>
    <td></td>
  </tr>
   <? if($account == "" && $web != "thebestperhead.com" && $web != "ezpay" && $web != "buybitcoins"){ ?>
  <tr>
    <td><div class="labels_tds">Your Player Account:</div></td>
    <td><input name="player_account" type="text" id="player_account"></td>
    <td></td>
  </tr>
  <? } ?>
  <tr>
    <td><div class="labels_tds">Subject:</div></td>
    <td><input name="subject" type="text" id="subject"></td>
    <td></td>
  </tr> 
  
  <!--<?
  //$ticket_agent = @file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/get_ticket_agent.php?p='.two_way_enc($account, true));
  //echo " $ticket_agent ";
  ?>-->
  
  <? //if($ticket_agent != ""){ $nodepartment = true; ?>
  	<?php /*?><input name="department" type="hidden" id="department" value="1"> 
    <input name="target_agent" type="hidden" id="target_agent" value="<? echo $ticket_agent ?>"> <?php */?>
  <? //}else{ ?>
   
	  <? if ($_GET["web"] == "vrb" or $_GET["web"] == "compart") { $nodepartment = true; ?>  
        <input name="department" type="hidden" id="department" value="1"> 
      <? } elseif ($_GET["web"] == "thebestperhead.com") { $nodepartment = true; ?>   
        <input name="department" type="hidden" id="department" value="4">
      <? } else { ?>  
<?php /*  //Comented the Deparment  ?> 
      <tr id="tr_dep">
        <td><div class="labels_tds">Department:</div></td>
        <td>

         <select  name="department" id="department" >        
          <option value="" selected="selected">Choose</option>
          <? foreach ($live_help_departments as $dep) { ?>
            <? if ( !in_array($dep->vars["deptID"], $exclude_chat_depts) ) {?>
            <option value="<? echo $dep->vars["deptID"]; ?>"><? echo $dep->vars["name"]; ?></option>
            <? } ?>
          <? } ?>      
        </select>
       
        </td>
        <td></td>
      </tr>  
<?php */?>      <? } ?>  
  
  <? //} ?>
  
  <tr>
    <td valign="top"><div class="labels_tds">Message:</div></td>
    <td><textarea name="message" cols="40" rows="10" id="message"></textarea></td>
    <td></td>
  </tr>
  <tr>
  	<td></td>
    <td align="right"><input id="btn2" onClick="disable_btn('btn2')" name="" type="button" value="Submit"></td>
    <td></td>
  </tr>
</table>
</form>
<? if(!$nodepartment && $web != "ezpay" && $web != "buybitcoins"){ ?>
<?php /*?><p class="message_bottom">Please be sure to choose the correct department when sending a ticket alert. Choosing the wrong department can result in a slow response time.
Thank you for your understanding.
</p><?php */?>
<? } ?>

</div>

<? } ?>

