<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_payout_report")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<style type="text/css">
.starts, .starts a{
	color:#333;
	font-size:40px;
}
.selstar, .selstar a{
	color:#F63;
}
</style>
<? 
$trans_id = param("tid");
$account = param("p");
$email = param("email");
$method = param("method");

$request_msg = param("request_msg");

if($request_msg != ""){
	
	$new_review = new _review();
	$new_review ->vars["transaction"] = $trans_id; 
	$new_review ->vars["account"] = $account;
	$new_review ->vars["method"] = $method;
	$new_review ->vars["email"] = $email;
	$new_review ->vars["date_sent"] = date("Y-m-d H:i:s");
	$new_review ->vars["clerk"] = $current_clerk ->vars["id"];
	$new_review->insert();
	
	$part1 = mt_rand(1000000,9999999);
	$part2 = $new_review ->vars["id"];
	
	$hidden_id = $part1 + $part2;
	$link = '<a href="http://localhost:8080/send_review.php?transaction='.$part1.'&review_id='.$hidden_id.'">click here</a>';
	
	$request_msg = nl2br($request_msg);
	$request_msg .= "<br /><br />Please $link to write a review.<br /><br /><br /><br />-- Do not Reply this message, this is an automatic response --"; 
	send_email_ck($email, "Payout Review", $request_msg, true, "support@vrbmarketing.com", "Cashier");	
	
}


$review = get_transaction_review($trans_id);


$default_msg = "Hi \nWe would like to invite you to review your latest $method payout with your account $account. Please let us know what you enjoyed and what we can do to improve the experience for future payouts.";

?>

<div class="page_content" style="padding:10px;">
    <h1>Review Request</h1>
    <script type="text/javascript" src="../../process/js/functions.js"></script>
    
    <? if(is_null($review)){ ?>
    
        <form method="post">
        <div class="form_box" style="padding:20px;">
            <h2>Send Request:</h2>   
            Message:<br />     
            <textarea name="request_msg" cols="70" rows="4"><? echo $default_msg ?></textarea>
            
            <p><input name="send" type="submit" id="send" value="Submit" /></p>
        </div>
        </form>
    
    <? }else{ ?>
        <div class="form_box" style="padding:20px;">
            Review Request has been sent.
        </div>
        
        <? if($review ->vars["stars"] > 0){ ?>
        <div class="form_box" style="padding:20px;">
        <h2>Customer Review:</h2>
        	<p>
              <strong>Rating:</strong><br />     
              <span class="starts selstar" id="selstars_containser"><? for($i=0;$i<$review ->vars["stars"];$i++){echo "☆";} ?></span><span class="starts" id="stars_containser"><? for($i=0;$i<5-$review ->vars["stars"];$i++){echo "☆";} ?></span>
            </p>
            <p>
            <strong>Message:</strong><br />
            <? echo nl2br($review ->vars["msg"]); ?>
            </p>
        </div>
		<? } ?>
        
    <? } ?>
    
    

</div>


<? }else{echo "Access Denied";} ?>