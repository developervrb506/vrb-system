<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("posting")){ 

if (!isset($_GET["type"])) { $type = $_POST["type"]; }
else { $type = $_GET["type"]; }

if (isset($_POST["brand"])) {
   $brand = $_POST["brand"];
}
else {
   $brand = ""; 	
}

if (isset($_POST["date"])) {
   $date = $_POST["date"];
}
else {
   $date = ""; 	
} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<title>Postings View</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
		
	};
</script>
<script type="text/javascript">
<!--
function confirmation(id,status_id,status) {
	var answer = confirm('Are you sure that you want to '+ status +' this posting?');
	if (answer){		
	   window.location = "../process/actions/change_posting_status.php?id="+id+"&status_id="+status_id;
	}	
}
//-->
</script>
<script type="text/javascript">
function changePagination(pageId,liId,type,brand,date){
     $(".flash").show();
     $(".flash").fadeIn(400).html
                ('Loading <img src="<?= BASE_URL ?>/ck/images/ajax-loader.gif" />');
     var pageId = 'pageId='+ pageId;
	 var type = 'type='+ type;
	 var brand = 'brand='+ brand;
	 var date = 'date='+ date;
     $.ajax({
           type: "POST",
           url: BASE_URL . "/ck/process/pagination/load-postings.php",          
		   data: {
           pageId: pageId,
           type: type,
		   brand: brand,
		   date: date
           },
           cache: false,
           success: function(result){
                 $(".flash").hide();
                 $(".link a").removeClass("In-active current") ;
                 $("#"+liId+" a").addClass( "In-active current" );
                 $("#pageData").html(result);
           }
      });
}
</script>
</head>
<body onload="changePagination('0','first','<? echo $type ?>','<? echo $brand ?>','<? echo $date ?>')">
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<script type="text/javascript">
<? if($_GET["a"] == "a"){ ?>
alert("Record Added");
<? } ?>
<? if($_GET["a"] == "d"){ ?>
alert("Record Deleted");
<? } ?>
<? if($_GET["a"] == "u"){ ?>
alert("Record Updated"); 
<? } ?>
</script>

<span class="page_title">Postings View</span><br /><br />
<a href="<?= BASE_URL ?>/ck/posting/posting.php">Add a new posting</a><br /><br />

<table width="100%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td><form action="<?= BASE_URL ?>/ck/posting/posting_view.php" method="post">
<strong>Type:</strong>&nbsp;
<select name="type">
  <option value="0">Select a Type</option>
  <option  <? if ($type == "1") { echo ' selected="selected" '; }?> value="1">News</option>
  <option  <? if ($type == "2") { echo ' selected="selected" '; }?> value="2">Press Releases</option>
  <option  <? if ($type == "3") { echo ' selected="selected" '; }?> value="3">Info Graphics</option>
</select>
&nbsp;&nbsp;<strong>Brand:</strong>&nbsp;
<select name ="brand" id="brand"  >
 <option value="">Select a brand</option>
 <option <? if ($brand == 3 ) { echo ' selected="selected" '; }?> value="3">SBO</option>
 <option <? if ($brand == 6 ) { echo ' selected="selected" '; }?> value="6">PBJ</option>
 <option <? if ($brand == 7 ) { echo ' selected="selected" '; }?> value="7">OWI</option>  
 <option <? if ($brand == 9 ) { echo ' selected="selected" '; }?> value="9">HRB</option> 
 <option <? if ($brand == 8 ) { echo ' selected="selected" '; }?> value="8">BITBET</option>    
 <option <? if ($brand == 10 ) { echo ' selected="selected" '; }?> value="10">Bet Lion</option>  
</select>
&nbsp;&nbsp;<strong>Date:</strong> &nbsp;
<input name="date" type="text" id="date" value="<? echo $date; ?>" />
<input type="submit" value="Search"><BR>
<span style="font-size:11px; margin-top:5px"><strong>For BitBet, use only the Type News</strong></span>
</form></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
</table>

<BR/><BR/>

<? if ((isset($_POST["type"])) || (isset($_GET["type"])) ) { ?>
 
<div id="pageData"></div>
   
  <?   
  $count= count(search_postings($type));  
  $num_results_x_page = 10;
  if($count > 0){
     $paginationCount=getPagination($count,$num_results_x_page);  
  ?>
  
  <ul class="tsc_pagination tsc_paginationC tsc_paginationC01">
    <li class="first link" id="first">
      <a href="javascript:void(0);" onclick="changePagination('0','first','<? echo $type ?>','<? echo $brand ?>','<? echo $date ?>');">F i r s t</a>
    </li>
    
    <? for($i=0;$i<$paginationCount;$i++){ ?>    
        <li id="<? echo $i ?>_no" class="link">
          <a href="javascript:void(0);" onclick="changePagination('<? echo $i ?>','<? echo $i ?>_no','<? echo $type ?>','<? echo $brand ?>','<? echo $date ?>')">
              <? echo ($i+1) ?>
          </a>
        </li>
    <? } ?>
    
    <li class="last link" id="last">
       <a href="javascript:void(0);" onclick="changePagination('<? echo ($paginationCount-1) ?>','last','<? echo $type ?>')">L a s t</a>
    </li>
    <li class="flash"></li>
  </ul>
  
  <? } ?>

<? } ?>

</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>