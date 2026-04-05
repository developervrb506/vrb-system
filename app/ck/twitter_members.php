<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Twitter members</title>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://localhost:8080/twitter/js/scripts.js"></script>
</head>
<body>
<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>

<script>
function delete_member(id){
  if(confirm("Are you sure to delete this member?")){    
     document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/create_twitter_member_action.php?delete=true&id="+id;
	 document.getElementById("tr_"+id).style.display = 'none';       
  }
}
</script>

<div class="page_content" style="padding-left:50px;">

<span class="page_title">Twitter Members</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="create_twitter_member.php" class="normal_link">Create New Member</a><br /><br />

<?
$name   = param('name');
$sport  = $_POST['sport'];
$teamid = $_POST['teamid'];
$pagenumber = param("pagenumber");

if (!empty($pagenumber)) {
   $pageno = $pagenumber;
} else {   	
   $pageno = 1;
}

$no_of_records_per_page = 150;
$offset = ($pageno-1) * $no_of_records_per_page;
$total_rows = count(get_all_twitter_members($name,$sport,$teamid));
$total_pages = ceil($total_rows / $no_of_records_per_page);	

$members = get_all_twitter_members($name,$sport,$teamid,$offset,$no_of_records_per_page);
?>

<strong>Search Filters:</strong>

<br /><br />

<form action="http://localhost:8080/ck/twitter_members.php" id="search_form" method="post">

<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>    
    <td><strong>Player's Name:</strong>&nbsp;<input name="name" type="text" id="name" value="<? echo $name; ?>" size="20" />
    </td>        
    <td>
    <? $sports_list = array("NFL", "NBA", "NHL", "MLB", "MMA-BOXING"); ?>
    <strong>Sport:</strong>&nbsp;
    <select name="sport" id="leagues_dd"> 
       <option value="">Choose sport</option>     
       <?	    		
	   foreach($sports_list as $sp){
	   ?>
       <option <? if($sp == $sport){echo 'selected="selected"';}?> value="<? echo $sp ?>"><? echo $sp ?></option>
      <? } ?>              
    </select>
    </td>    
    <td><strong>Teams:</strong>&nbsp;
    <select name="teamid" id="teams_dd">                      
    </select>    
    <input type="hidden" id="choosen_team" name="choosen_team" value="<? echo $teamid ?>">&nbsp;
    </td>       
  </tr>
</table>
<br /> <br /> 
<input style="cursor:pointer;" type="submit" id="search" name="search" value="Search">&nbsp;
</form>
<br /> <br />

<ul class="pagination">
    <? for($i=1;$i<=$total_pages;$i++) { ?>
	   
       <?	   
	   if($i == $pageno){
		  $class_li = 'class_equal';
	   }else{
		  $class_li = 'class_different';
	   }
	   ?>                           		
	  
       <li style="float:left;">
           <form action="http://localhost:8080/ck/twitter_members.php" id="pag_form_<? echo $i; ?>" name="pag_form_<? echo $i; ?>" method="post">             
             <input type="hidden" name="name" value="<? echo $name; ?>">            
             <input type="hidden" name="sport" value="<? echo $sport; ?>">
             <input type="hidden" name="teamid" value="<? echo $teamid; ?>">             
             <input type="hidden" name="pagenumber" value="<? echo $i; ?>">
             <input class="<? echo $class_li; ?>" type="submit" name="submit_form_pag" value="<? echo $i; ?>">
         </form>
	   </li>	
    <? } ?>  
</ul>

<br /><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Account</td>
    <td class="table_header" align="center">Sport</td>
    <td class="table_header" align="center">Team</td>
    <td class="table_header" align="center">Edit</td>
    <td class="table_header" align="center">Delete</td>
  </tr>
  
  <? foreach($members as $member ){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr id="tr_<? echo $member->vars["id"]; ?>">
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $member->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $member->vars["account"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $member->vars["sport"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $member->vars["team"]; ?></td>    
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_twitter_member.php?id=<? echo $member->vars["id"] ?>">Edit</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">  	
        <a class="normal_link" onClick="delete_member('<? echo $member->vars['id']?>');" href="javascript:;">Delete</a>
    </td>
  </tr>
  
  <? } ?>
  
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
