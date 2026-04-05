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
<!--
function delete_metatag(ID) {
	var answer = confirm("Are you sure that you want to delete this metatag?");
	if (answer){		
	   window.location = "process/actions/metatags.php?id="+ID;
	}	
}
//-->
function change_page(value){
	document.location.href = "" + value;
}
</script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>

<? if(isset($_POST['pageId']) && !empty($_POST['pageId']))
{
    $id=$_POST['pageId'];
}
else
{	
	$id=0;
}

$num_results_x_page = 20;

$pageLimit=$num_results_x_page*$id;

$count= count(get_all_metatags($pageLimit,$num_results_x_page));

$html='';

if($count > 0) { ?>

  <table style="cursor:pointer;" class="sortable">
    <thead>
        <tr>           
            <th class="table_header" scope="col" style="text-align: left">ID</th>
            <th class="table_header" scope="col" style="text-align: left">URL</th>          
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Edit</th>
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Delete</th>            
        </tr>
    </thead>
    <tbody id="the-list">
    <?	
	$metatags = get_all_metatags($pageLimit,$num_results_x_page);
	foreach($metatags as $metatag){
	 if($k % 2){$style = "1";}else{$style = "2";} $k++;
	?>          
        <tr>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: left"><? echo $metatag->vars["id"]; ?></th> 
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: left"><? echo $metatag->vars["url"]; ?></th>                 
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="change_page('metatags.php?edit_id=<? echo $metatag->vars["id"] ?>')" type="button" name="Button" value="View" /></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="delete_metatag('<? echo $metatag->vars["id"] ?>')" type="button" name="Button" value="Delete" /></th> 
        </tr>  
    <? } ?>  
           <tr>
			  <th class="table_last" colspan="100"></th>
			</tr>
    </tbody>
    </table>	

<? } else { 

    $html='No Data Found';
	echo $html;
}
?>