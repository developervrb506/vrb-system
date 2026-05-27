<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
$web     = clean_str_ck($_GET["web"]); 
$mobile  = clean_str_ck($_GET["mobile"]);
$account = clean_str_ck($_GET["wpx"]);
$ag = clean_str_ck($_GET["ag"]);

$exclude_chat_depts = array("11","104","105","106");

if($web == ""){$web = "vrb";}
$live_help_departments = get_live_help_departments();
?>
<? if (!isset($mobile) and $mobile == 1) { ?>

    <link href="style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
    <script type="text/javascript">
    var validations = new Array();
    
    validations.push({id:"subject",type:"null", msg:"Please Write a Subject"});
    validations.push({id:"message",type:"null", msg:"Please Write a Message"});
    validations.push({id:"player",type:"null", msg:"Please choose a Sub Agent"});
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
    
    <span class="title">Create New Ticket </span>
    <form method="post" action="actions/create_subagent.php" id="frm_2" onSubmit="return validate(validations)">
    <input name="cat" type="hidden" id="cat" value="<? echo $_GET["cat"] ?>">
    <input name="web" type="hidden" id="web" value="<? echo $web ?>">
    <input name="wpx" type="hidden" id="wpx" value="<? echo $account ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      
      
      
       <tr >
            <td><div class="labels_tds">SUB AGENT:</div></td>
            <td>
        
               <?
               $players = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_agent_agents.php?agent=".two_way_enc($account,true)));
               if (!is_null($players)){
                   
               ?>
                   
                 <select  name="player" id="player" >        
              <option value="" selected="selected">Choose</option>
              <? foreach ($players as $p) {  ?>
                
                  <option value="<? echo $p->vars->Agent; ?>"><? echo $p->vars->Agent; ?></option>
              <? } ?>      
              </select>
               
               
               <a id="a_player" style="" title="Click to sent a Message to a Player "></a>
               <?
               
               ?>
    
            <? }else{ ?>
            	No Subagents found
                <input type="hidden" id="player" name="player" value="" />
            <? } ?>
            
            </td>
            <td></td>
          </tr>  
      
      <tr>
        <td><div class="labels_tds">Subjecta:</div></td>
        <td><input name="subject" type="text" id="subject"></td>
        <td></td>
      </tr>     
         
      
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
    <? if(!$nodepartment){ ?>
    <p class="message_bottom">
    </p>
    <? } ?>
    
    </div>

<? } else { ?>

    <link href="style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
    <script type="text/javascript">
    var validations = new Array();
    
    validations.push({id:"subject",type:"null", msg:"Please Write a Subject"});
    validations.push({id:"message",type:"null", msg:"Please Write a Message"});
	validations.push({id:"player",type:"null", msg:"Please choose a Sub Agent"});
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
    
    <span class="title">Create New Ticket </span>
    <form method="post" action="actions/create_subagent.php" id="frm_2" onSubmit="return validate(validations)">
     <input name="cat" type="hidden" id="cat" value="<? echo $_GET["cat"] ?>">
    <input name="web" type="hidden" id="web" value="<? echo $web ?>">
    <input name="wpx" type="hidden" id="wpx" value="<? echo $account ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">

      
      <tr>
      <td><div class="labels_tds">AGENT:</div></td>
            <td>
        
               <?
               $players = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_agent_agents.php?agent=".two_way_enc($account,true)));
               if (!is_null($players)){
                   
               ?>
                   
                 <select  name="player" id="player" >        
              <option value="" selected="selected">Choose</option>
              <? foreach ($players as $p) {  ?>

                  <option value="<? echo $p->vars->Agent; ?>"><? echo $p->vars->Agent; ?></option>
              <? } ?>      
              </select>
               
               
               <a id="a_player" style="" title="Click to sent a Message to a Player "></a>
               <?
               
               ?>
    
             <? }else{ ?>
            	No Subagents found
                <input type="hidden" id="player" name="player" value="" />
            <? } ?>
            
            </td>
            <td></td>
      </tr>
      
      <tr>
        <td><div class="labels_tds">Subject:</div></td>
        <td><input name="subject" type="text" id="subject"></td>
        <td></td>
      </tr>     
         
      
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
    <? if(!$nodepartment){ ?>
        <p class="message_bottom">
        </p>
    <? } ?>
    
    </div>

<? } ?>

