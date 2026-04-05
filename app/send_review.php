<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ck/includes/js/jquery-1.8.0.min.js"></script>
<style type="text/css">
.starts, .starts a{
	color:#333;
	font-size:40px;
	cursor:pointer;
}
.selstar, .selstar a{
	color:#F63;
}
a{
	text-decoration:none;
}
</style>
</head>
<body>

<? 
$part1 = param("transaction");
$part2 = param("review_id");
$rid = $part2 - $part1;
$review = get_review($rid);
?>

<? if(!is_null($review)){ ?>
	
    <? 
	if(is_numeric(param("starscount")) && param("msg") != ""){
		$review ->vars["msg"] = param("msg");
		$review ->vars["stars"] = param("starscount");
		$review ->vars["date_review"] = date("Y-m-d H:i:s");
		$review->update(array("msg","stars","date_review"));
	}
	?>
    
    <div class="page_content" style="padding:10px;">
        <h1><? echo $review ->vars["method"] ?> Payout Review</h1>
        
        <? if($review ->vars["stars"] == 0){ ?>
        
        <script type="text/javascript">
        var stars = 0;
        function update_stars(amount){
            stars = amount;
            var unsel = 5 - amount;
            var main_count = 0;
            
            var sel_str = "";
            for(i=0;i<stars;i++){
                main_count++;
                sel_str += "<a href='javascript:;' onclick='update_stars("+main_count+");'>☆</a>";
            }
            $("#selstars_containser").html(sel_str);
            
            var unsel_str = "";
            for(i=0;i<unsel;i++){
                main_count++;
                unsel_str += "<a href='javascript:;' onclick='update_stars("+main_count+");'>☆</a>";
            }
            $("#stars_containser").html(unsel_str);
            
            $("#starscount").val(stars);
            
        }
        </script>
        
        <form method="post">
        <div class="form_box" style="padding:20px;">  
            
            <p>
            Rating:<br />     
            <span class="starts selstar" id="selstars_containser"></span><span class="starts" id="stars_containser"></span>
            <input type="hidden" name="starscount" id="starscount" />
          </p>
          
          <script type="text/javascript">update_stars(0);</script>
            
            <p>
            Write your review:<br />     
            <textarea name="msg" cols="70" rows="4"><? echo $default_msg ?></textarea>
            </p>
            
            <p><input name="send" type="submit" id="send" value="Submit" /></p>
        </div>
      </form>
        
        <? }else{ ?>
        <div class="form_box" style="padding:20px;">
            Review has been sent. Thanks
        </div>
      <? } ?>
        
        
    
    </div>

<? } ?>
