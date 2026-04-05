<? require_once(ROOT_PATH . "/ck/db/handler.php");  ?>
<?


 $header =  param_soft("url");
 $error =  param_soft("error_url");
 $way = param_soft("way");
 $name = param("acc");
 $email = param("email");
 $phone = param("phone");
 $msg = param_soft("msg");
 $web = param("web");
 $val_code = param("val_code");
 /*
 echo "<pre>";
 print_r($_POST);
  print_r($_GET);
  echo "</pre>";
 


 $header =  "http://thebestperhead.com/thank-you/";
 $error =  "http://thebestperhead.com/error/";
 $way = "pph_quoute";
 $name = "ALEXIS TEST";
 $email = "aandrade@inspin.com";
 $phone = 888;
 $msg = 45;
 $web = "thebestperhead.com";
 $val_code = "PPH2@2@";
*/ 
 function send_ticket($email,$account,$phone,$why,$type,$subject,$message,$web,$cat){
		$data["why"] = $why;
		$data["type"] = $type;
		$data["email"] = $email;
		$data["phone"] = $phone;	
		$data["subject"] = $subject;
		$data["acc"] = $account;
		$data["message"] = $message;
		$data["web"] = $web;
		$data["cat"] = $cat;
		
		$ticket = do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/send_tiket.php",$data);
	}

  
 
 if( empty($val_code) or $val_code != "PPH2@2@" ){ ?>
 
	<script>
    window.location = '<? echo $error; ?>';
    </script>
			
 <? }else{  
	
	switch ($way) {
			
	  case 'pph_quoute':
			$sub = "PPH QUOTE";
			$msg = "Number of Players ".$msg;
				   
			send_ticket($email,$name,$phone,'pph','ag',$sub,$msg,$web,23);		
			break;
	/*		
	   case 'pph_new_ap':
			$sub = "NEW AGENT PROFILE REQUEST";
				   
			send_ticket($email,$name,$phone,'pph','ag',$sub,$msg,$web,26);
			break;
			
	   case 'pph_update_ap':
			$sub = "AGENT PROFILE UPDATE REQUEST";
				   
			send_ticket($email,$name,$phone,'pph','ag',$sub,$msg,$web,27);
			break;
			
	   case 'pph_update_al':
			$sub = "AGENT LIMITS UPDATE REQUEST";
				   
			send_ticket($email,$name,$phone,'pph','ag',$sub,$msg,$web,28);
			break; 
			
	   case 'pph_update_atp':
			$sub = "AGENT TEASERS AND PARLAYS UPDATE REQUEST";
				   
			send_ticket($email,$name,$phone,'pph','ag',$sub,$msg,$web,29);
			break;												
	*/	
	   
		default:
			break;
	}	
	
	$location = "Location: ".$header;	
	
	
	?>
    
	<script>
	 window.location = '<? echo $header ?>';
	</script>
    
<? } ?>

/*

 $header =  param_soft("url");
 $error =  param_soft("error_url");
 $way = param_soft("way");
 $name = param("acc");
 $email = param("email");
 $phone = param("phone");
 $msg = param_soft("msg");
 $web = param("web");
 $val_code = param("val_code");

 
 $data["url"] =  param_soft("url");
 $data["error_url"] =  param_soft("error_url");
 $data["way"] = param("way");
 $data["acc"] = param("acc");
 $data["email"] = param("email");
 $data["phone"] = param("phone");
 $data["msg"]= param_soft("msg");
 $data["web"] = param("web");
 $data["val_code"] = param("val_code");
 $url = "http://www.sportsbettingonline.ag/utilities/process/reports/vrb_tickets_bridge.php";
 do_post_request($url, $data);
 

 // $data = "?url=".$header."&error_url=".$error."&way=".$way."&acc=".$name."&email=".$email."&phone=".$phone."&msg=".$msg."&web=".$web."&val_code=".$val_code; 
 // echo "http://www.sportsbettingonline.ag/utilities/process/reports/vrb_tickets_bridge.php".$data;
  //file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_tickets_bridge.php".$data);
*/ 
?>