<? 
include(ROOT_PATH . "/ck/process/security.php");

 $agent = $_GET["id"];
 if($agent) {
 $players = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_agent_agents.php?agent=".$agent));

  
               ?>
               SubAgent: 
               <select  onchange="" name="to_sub" id="to_sub"  class="">       
                   <option value="" selected="selected">All</option>
           
          <? if (!is_null($players)){ ?>
              <? foreach ($players as $p) {  ?>
                
                  <option value="<? echo $p->vars->Agent; ?>"><? echo $p->vars->Agent; ?></option>
              <? } ?>      
            <? } ?>          
                 </select>
                 
               &nbsp;&nbsp;&nbsp;              
    <? }?>           
     		<input type="submit" value="Search"  />  
