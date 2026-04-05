<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cc_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<strong>New Chargeback</strong><br /><br />
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript">
function confirm_chargeback(){
	if(document.getElementById('is_call').value == "1" && document.getElementById('is_email').value == "1" && document.getElementById('is_descriptor').value == "1" && document.getElementById('is_message').value == "1" && document.getElementById('is_locked').value == "1"){
		document.getElementById('confirm_div').style.display = "none";
		document.getElementById('form_div').style.display = "block";
	}else{
		alert("Please complete the process before continuing.");	
	}
}
</script>
<? if(isset($_GET["good"])){ ?>
	<div class="form_box" id="confirm_div">
    	<? if($_GET["good"]){ ?>
	        <? 
			$player = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_player.php?full=1&pid=".two_way_enc($_GET["player"])));
			?>
            <p class="error">Chargeback has been inserted</p>
            
            <p><strong><? echo $player->vars->Player ?> Balance:</strong>  $<? echo $player->vars->AvailBalance ?></p>
            
            <? if($player->vars->AvailBalance != 0){ ?>
            <script type="text/javascript">
			var validations = new Array();
			validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
			</script>
            <form method="post" action="poster.php" id="fsender" name="fsender" onsubmit="return validate(validations);">
		        <input name="way" type="hidden" id="way" value="clear_chargeback" />
                <input name="player" type="hidden" id="player" value="<? echo $player->vars->Player ?>" />
                <p><strong>Clear Balance</strong></p>
                <? 
				if($player->vars->AvailBalance < 0){$camount = abs($player->vars->AvailBalance);}
				else{$camount = abs($player->vars->AvailBalance)*-1;}
				?>
                <p>Clear Amount: <input name="amount" type="text" id="amount" value="<? echo $camount ?>" /></p>
				<p><input type="image" src="http://localhost:8080/images/temp/submit.jpg" /></p>
                
            </form>
            <? } ?>
            
            
        <? }else{ ?>
        <strong><h1>There was a problem inserting the charge back, please try again latter.</h1></strong>
        <? } ?>
    </div>
<? }else if($_GET["cleared"]){ ?>
	<div class="form_box" id="confirm_div">
    	<h1>Balance has been cleared</h1>
    </div>
<? }else{ ?>
    <div class="form_box" id="confirm_div">
        Chargeback Confirmation:
        <table width="200" border="0" cellpadding="5">
          <tr>
            <td>Call:</td>
            <td>
                <select id="is_call">
                  <option value="0">No</option>
                  <option value="1">Yes</option>        	  
                </select>
            </td>
          </tr>
          <tr>
            <td>Email:</td>
            <td>
                <select id="is_email">
                  <option value="0">No</option>
                  <option value="1">Yes</option>        	  
                </select>
            </td>
          </tr>
          <tr>
            <td>Descriptor:</td>
            <td>
                <select id="is_descriptor">
                  <option value="0">No</option>
                  <option value="1">Yes</option>        	  
                </select>
            </td>
          </tr>
          <tr>
            <td>Message:</td>
            <td>
                <select id="is_message">
                  <option value="0">No</option>
                  <option value="1">Yes</option>        	  
                </select>
            </td>
          </tr>
          <tr>
            <td>Locked Out:</td>
            <td>
                <select id="is_locked">
                  <option value="0">No</option>
                  <option value="1">Yes</option>        	  
                </select>
            </td>
          </tr>
          <tr>
            <td colspan="2"><input type="button" value="Continue" onclick="confirm_chargeback()" /></td>
          </tr>
        </table>
    
    </div>
    
    <div class="form_box" id="form_div" style="display:none;">
        <script type="text/javascript">
        var validations = new Array();
        validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
        validations.push({id:"player",type:"null", msg:"Player required"});
        validations.push({id:"processor",type:"null", msg:"Processor required"});
        </script>
        <form method="post" action="poster.php" id="fsender" name="fsender" onsubmit="return validate(validations);">
        <input name="way" type="hidden" id="way" value="add_charge_back" />
        <table width="100%" border="0" cellspacing="0" cellpadding="10">        
          <tr>
            <td>Type</td>
            <td>
            	<select name="ctype" id="ctype">
            	  <option value="c">Chargeback</option>
            	  <option value="r">Refound</option>
            	</select>
            </td>
          </tr>
          <tr>
            <td>Amount</td>
            <td><input name="amount" type="text" id="amount" /></td>
          </tr> 
          <tr>
            <td>Player</td>
            <td><input name="player" type="text" id="player"  /></td>
          </tr> 
          <tr>
            <td>Processor</td>
            <td><select name="processor" id="processor">
              <option value="">--Select--</option>
              <option value="127">DNP</option>
              <option value="128">QP</option>
              <option value="129">QP1</option>
              <option value="141">QWIPIARS</option>
              <option value="141">QWIPIARS 2</option>
              <option value="141">QWIPIARS 3</option>
              <option value="162">S2P</option>
              <option value="1">Credit Card</option>
            </select></td>
          </tr>  
          <tr>
            <td>Comments</td>
            <td><textarea name="msg" cols="17" rows="3" id="msg"></textarea></td>
          </tr> 
          <tr>    
            <td><input type="image" src="http://localhost:8080/images/temp/submit.jpg" onclick="this.style.display = 'none'" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>

<? } ?>


<? }else{echo "Access Denied";} ?>