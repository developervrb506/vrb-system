<? include(ROOT_PATH . "/ck/process/security.php"); ?>
 <?
 
 $agent= param('agent');
 
 
$report = 0;
$tool = 0;

// to handle the delete process for Access Casino
if((param('report') == 1)){
 $report = 1;	
}
if((param('tool') == 1)){
 $tool = 1;	
}


$data = "?agent=".$agent."&report=".$report."&tool=".$tool;
file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/agent_manager/delete_agent.php".$data); 

?>


</div>
<? include "../../includes/footer.php" ?>