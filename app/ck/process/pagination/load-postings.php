<? include(ROOT_PATH . "/ck/process/security.php"); ?>

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
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>

<? if(isset($_POST['pageId']) && !empty($_POST['pageId']))
{
    $id=$_POST['pageId'];
}
else
{	
	$id=0;
}

$id = explode('=',$id);
$id = $id[1];
 
if(isset($_POST['type']) && !empty($_POST['type'])) {
   $type = $_POST['type'];	
   $type = explode('=',$type);
   $type = $type[1];
}
else {
   $type = "";	
}

if(isset($_POST['brand']) && !empty($_POST['brand'])) {
   $brand = $_POST['brand'];	
   $brand = explode('=',$brand);
   $brand = $brand[1];
}
else {
   $brand = "";	
}

if(isset($_POST['date']) && !empty($_POST['date'])) {
   $date = $_POST['date'];	
   $date = explode('=',$date);
   $date = $date[1];
}
else {
   $date = "";	
}

$num_results_x_page = 10;

$pageLimit=$num_results_x_page*$id;

$count= count(search_postings($type,$brand,$date,$pageLimit,$num_results_x_page));

$html='';

if($count > 0) { ?>

<table style="cursor:pointer;" class="sortable" width="800" border="1" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>ID</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Title</strong></th>
    <th class="table_header sorttable_nosort" scope="col" nowrap="nowrap"><strong>Preview Image</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Brand</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Category</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Date</strong></th>
    <th class="table_header sorttable_nosort" scope="col" nowrap="nowrap"><strong>Preview</strong></th>
    <th class="table_header" scope="col">Status</th>
    <th class="table_header sorttable_nosort" scope="col">Edit</th>    
  </tr>
</thead>
<tbody id="the-list">
   <?
   $postings = search_postings($type,$brand,$date,$pageLimit,$num_results_x_page);
   foreach($postings as $post){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   ?>
  <tr>   	
        <th class="table_td<? echo $style ?>"><? echo $post["id"]; ?></th>
		<th class="table_td<? echo $style ?>"><? echo $post["post_title"]; ?></th>
        <th class="table_td<? echo $style ?>"><img src="<? echo $post["post_image"] ?>" alt="<? echo $post["post_image_alt"] ?>" border="0" width="100" height="100"></th>
        <th class="table_td<? echo $style ?>" nowrap="nowrap">           
        <?
        switch ($post["post_brand"]) {
          case "3":
		   $brand = "SBO";      
          break;
		  case "6":
		    $brand = "PBJ";      
          break;
		  case "7":
		    $brand = "OWI";      
          break;
		  case "9":
		    $brand = "HRB";      
          break;
		  /*case "10":
		    $brand = "BETLION";      
          break;*/    
        }
		echo $brand;
        ?>           
        </th>
        <th class="table_td<? echo $style ?>">           
        <?
        switch ($post["post_category"]) {
          case "1":
		    $category = "Sportbook";      
          break;
		  case "2":
		    $category = "Casino";      
          break;		      
        }
		echo $category;
        ?>           
        </th>
        <th class="table_td<? echo $style ?>" nowrap="nowrap"><? echo $post["post_date"]; ?></th>            
        <th class="table_td<? echo $style ?>"><a href="<? echo $post["post_slug"] ?>" target="_blank">Preview</a></th>
        <th class="table_td<? echo $style ?>">
        <?
        switch ($post["post_status"]) {
          case "1":
		    $status = "Unpublish";
			$status_id = "0";      
          break;
		  case "0":
		    $status = "Publish";
			$status_id = "1";      
          break;		      
        }		
        ?>
        <a href="javascript:confirmation(<? echo $post["id"] ?>,<? echo $status_id ?>,'<? echo $status ?>')"><? echo $status; ?></a>
        </th>
        <th class="table_td<? echo $style ?>"><a href="<?= BASE_URL ?>/ck/posting/posting.php?post_id=<? echo $post["id"] ?>">Edit</a></th>   
  </tr>
<? } ?>
</tbody>
</table>	

<? } else { 

    $html='No Data Found';
	echo $html;
}
?>