<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
echo "<pre>";
//print_r($_POST[]);
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upacc = get_rec_issue_ticket($_POST["update_id"]);
		$upacc->vars["title"] = $_POST["title"];
		$upacc->vars["description"] = $_POST["description"];
		$upacc->vars["solution"] = $_POST["solution"];
		$upacc->vars["assigned"] = $_POST["assigned"];
		if ($_POST["resolved"]){
		  $upacc->vars["status"]="so";
		  $upacc->vars["solutioned_by"]=$current_clerk->vars["id"];
		  $upacc->vars["solution_date"]=date("Y-m-d H:i:s");		
		}
     	if (isset($_POST["status"])){
		  $upacc->vars["status"]=$_POST["status"];
		}		
        
		//print_r($upacc) ; exit;
		$upacc->update();
	}else{
		$newacc = new _rec_issues();
		$newacc->vars["title"] = $_POST["title"];
		$newacc->vars["description"] = $_POST["description"];
		$newacc->vars["solution"] = "";
		$newacc->vars["status"] = "pe";
		$newacc->vars["created_date"] = date("Y-m-d H:i:s");
		$newacc->vars["by"] = $current_clerk->vars["id"];
		$newacc->insert();
		header("Location:rec_issues.php?e=62");		
	}
}

$admin = $current_clerk->admin();
$clerks = get_permissions_clerk("rec_issues");
$str_clerks = "";

foreach ($clerks as $clerk){
  $str_clerks	.= "'".$clerk->vars["user"]."',";
}

$str_clerks = substr($str_clerks,0,-1);
$clerks_list = get_all_clerks_exclude_list($str_clerks ,false,true);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Rec Issues</title>
<script type="text/javascript" src="includes/js/bets.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	
	$ticket = get_rec_issue_ticket($_GET["tid"]);
	if(is_null($ticket)){
		$title = "Add New Rec Issue";
	}else{
		$title = "Edit Rec Issue ";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$ticket->vars["id"] .'" />';
		$edit = true;
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations_new = new Array();
    validations_new.push({id:"title",type:"null", msg:"Please insert the Subject"});
	validations_new.push({id:"description",type:"null", msg:"Please insert the Issue"});
	</script>
    <script type="text/javascript">
    var validations = new Array();
    validations.push({id:"title",type:"null", msg:"Please insert the Subject"});
	validations.push({id:"description",type:"null", msg:"Please insert the Issue"});
	validations.push({id:"solution",type:"null", msg:"Please insert the Solution"});
    validations.push({id:"status",type:"null", msg:"Please Select the Status"});
    </script>
    <script type="text/javascript">
    var validations_1 = new Array();
    validations_1.push({id:"title",type:"null", msg:"Please insert the Subject"});
	validations_1.push({id:"description",type:"null", msg:"Please insert the Issue"});
	validations_1.push({id:"solution",type:"null", msg:"Please insert the Solution"});
    </script>
	<div class="form_box" style="width:700px;">
    <?
	 if(is_null($ticket)){ 
	    $validations = "validations_new"; 
	
	 }
	 else { 
	   if ($ticket->vars["status"]== "pe"){
		  $validations = "validations_1";   
	   }
	   else {
		  $validations = "validations";
		 }
	 }
   	?>

	<? if($current_clerk->im_allow("rec_issues_admin")){
	       $readonly = ""; }
	   else { $readonly = 'readonly="readonly"'; } ?>
       
        <form method="post" action="rec_issues.php?e=62" onsubmit="return validate(<? echo $validations ?>)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
        &nbsp;&nbsp;
         
          <tr>
            <td>Subject</td>
           <td><input <? echo $readonly ?> style="width:416px" name="title" type="text" id="title" value="<? echo $ticket->vars["title"] ?>" />
            </td>
          </tr> 
          <tr>
            <td>Issue</td>
            <td><textarea <? echo $readonly ?> name="description" cols="50" rows="10" id="description"><? echo $ticket->vars["description"] ?></textarea></td>
          </tr> 
         <? if(!is_null($ticket)){  ?>
           <tr>
            <td>Solution</td>
            <td><textarea name="solution" cols="50" rows="10" id="solution"><? echo $ticket->vars["solution"] ?></textarea></td>
          </tr> 
  
        <? if($current_clerk->im_allow("rec_issues_admin") && isset($_GET["close"])) { ?>            
           <tr>
            <td>Status:</td>
             <td> 
             <select name="status" id="status">
			     <option value="" selected="selected" >- Select -</option>
			     <option value="pe">UnSolved</option>
			     <option value="cl">Closed</option>
                 <option value="so">Solved</option>
			 </select>
          </td>
           </tr>
            <tr>
            <td>Assigned:  </td>
            <td>
              <select name="assigned" id="assigned">
			     <option  <? if($ticket->vars["assigned"]->vars["id"] == "0") { echo 'selected="selected"' ;} ?>  value ="0">Free</option>
				 <? foreach ($clerks_list as $clerk_list) {?>
                 <option <? if($ticket->vars["assigned"]->vars["id"] == $clerk_list->vars["id"]) { echo 'selected="selected"' ;} ?> value="<? echo $clerk_list->vars["id"] ?>" ><? echo $clerk_list->vars["name"]?></option>
			     <? } ?>
             </select>
           
            </td>    
          </tr>                     
            
          <? } else  { ?>
          <tr>
            <td>Solved</td>
            <td><input name="resolved" type="checkbox" id="resolved" value="1" <? if($ticket->vars["status"] == "so"){echo 'checked="checked"';} ?> /></td>
          </tr> 
          <? if ($admin) { ?>
           <tr>
            <td>Assigned: </td>
            <td>
             <select name="assigned" id="assigned">
			     <option  <? if($ticket->vars["assigned"] == "0") { echo 'selected="selected"' ;} ?>  value ="0">Free</option>
				 <? foreach ($clerks_list as $clerk_list) {?>
                 <option <? if($ticket->vars["assigned"] == $clerk_list->vars["id"]) { echo 'selected="selected"' ;} ?> value="<? echo $clerk_list->vars["id"] ?>" ><? echo $clerk_list->vars["name"]?></option>
			     <? } ?>
             </select>
           
            </td>    
            </tr> 
          <? } ?>   
        <? } ?>        
     <? } ?>
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
 ?>
 
   
<?  if($current_clerk->im_allow("rec_issues_admin")) { ?>      
    <a href="?detail" class="normal_link">+ New Issue</a>&nbsp;&nbsp;&nbsp;&nbsp;
   
     <? } ?>  
    <a href="rec_issues_report.php" class="normal_link">Report</a>
   
	
	    
	<? include "includes/print_error.php" ?>  
    
 <? if($current_clerk->im_allow("rec_issues_admin")) {
 
   	 $tickets = get_rec_issues_tickets($current_clerk->vars["id"],"so",$admin);
	
	?> <br /><br /><span class="page_title">Solved Rec Issues</span><br /><br />
	<? if(count($tickets)>0){ ?> 
      

    
     
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Open by</td>
        <td class="table_header" align="center">Subject</td>
        <td class="table_header" align="center">Issue</td>
        <td class="table_header" align="center">Solution</td>       
        <td class="table_header" align="center">Solved by</td>
        <td class="table_header" align="center">Solved Date</td>
        <td class="table_header" align="center">Status</td>
        <? if ($admin) { ?>
        <td class="table_header" align="center">Assigned</td>
        <? } ?>
        <td class="table_header" align="center"></td>
      </tr>
      <?
	  $i=0;	   
	   foreach($tickets as $tik){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
		  
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["created_date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["by"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["title"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["description"],50); ?></td>
        <td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["solution"],50); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["solutioned_by"]->vars["name"]; ?></td>
       <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["solution_date"]; ?></td>     
       <td class="table_td<? echo $style ?>" align="center"><? echo $tik->str_status(); ?></td>
       <? if ($admin) { ?>
       <td class="table_td<? echo $style ?>" align="center"><?
	       if ($tik->vars["assigned"] !=0){
		   		   echo "<strong>".$tik->vars["assigned"]->vars["name"]."</strong>";
		   } //else {echo "Free";}
		   
		    ?>
         </td>
       <? } ?>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&tid=<? echo $tik->vars["id"]; ?>&close=1" class="normal_link">View</a>
        </td>
      </td>
      </tr>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <? if ($admin) { ?>
        <td class="table_last"></td>
        <? } ?>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>
    <? }else{echo "No Solved Issues";} ?>
   <? } ?>
   
       <br /><br />
       <span class="page_title">Pending Rec Issues</span><br /><br />

   
    <?
	  $tickets = get_rec_issues_tickets($current_clerk->vars["id"],"pe",$admin);
	  
	   ?>
	<? if(count($tickets)>0){ ?>  
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Open by</td>
        <td class="table_header" align="center">Subject</td>
        <td class="table_header" align="center">Issue</td>
        <td class="table_header" align="center">Status</td>
         <? if ($admin) { ?>
        <td class="table_header" align="center">Assigned</td>
        <? } ?>
        <td class="table_header" align="center"></td>
      </tr>
      <?
	  $i=0;	   
	   foreach($tickets as $tik){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["created_date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["by"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["title"],20); ?></td>
        <td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["description"],50); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->str_status(); ?></td>
         <? if ($admin) { ?>
       <td class="table_td<? echo $style ?>" align="center"><?
	       if ($tik->vars["assigned"] !=0){
		   		   echo "<strong>".$tik->vars["assigned"]->vars["name"]."</strong>";
		   } else {echo "Free";}
		   
		    ?>
         </td>
         <? } ?>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&tid=<? echo $tik->vars["id"]; ?>" class="normal_link">View</a>
        </td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <? if ($admin) { ?>
        <td class="table_last"></td>
        <? } ?>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>
    <? }else{echo "No Pending Issues";} ?>
    <?
	
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
