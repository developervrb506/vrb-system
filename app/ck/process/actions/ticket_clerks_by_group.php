<? 
include(ROOT_PATH . "/ck/process/security.php");


 //According the chatsGroups
 $depts[11]=  12;  
 $depts[12]=  16; 
 $depts[4]=  13; 
 $depts[104]=  8;
 $depts[15]=  9;
 $depts[105]=  2;  
 $depts[106]=  22;  
   

 $gid = $depts[$_GET["id"]];


 $clerks = get_all_clerks_by_group($gid);
?>
Clerk :
  <select onchange="" name="to_clerk" id="to_clerk"  class="">
    <option  value="">Free</option>
    
  <? foreach ($clerks as $ck) { ?>
      <option  <? if ($ck->vars["id"] == $pit) { echo ' selected ';} ?> value="<? echo $ck->vars["id"] ?>" ><? echo $ck->vars["name"]?></option>
  <? } ?>    
 </select>