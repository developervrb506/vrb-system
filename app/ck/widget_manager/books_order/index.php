<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<title>Books Order</title>
<script type="text/javascript" src="/process/js/functions.js"> </script>
<script type="text/javascript" src="/process/js/jquery.js"> </script>
</head>
<body>
	
<? 
  $books = get_all_events_books("",false);
   
 
  
?>
<? include "../../../includes/header.php" ?>
<? include "../../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Books Order</span>
<br /><h3 class="sub">Drag and Drop the book in the order desired</h3>
<div class="container_book">
<ul class="books" id="books">
	<? foreach ($books as $book){ ?>
	<li >
     <div class="book" data-id="<? echo $book->vars['id']?>">
     <input value="<? echo $book->vars['id']?>" type="checkbox" class="check" <? if( $book->vars['available']) { ?> checked="checked" <? } ?> onchange="update_status(this);">
      <img border="1" src='http://www.sportsbettingonline.ag/utilities/process/stats/odds_comparison_widget/images/<? echo $book->vars['id']?>.png' width="200px">
      </div>
	</li>	
    <? } ?>


</ul>
</div>





</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.8/sortable.min.js" integrity="sha512-WYx77h4hlJpXKU3ooPWVYYLi78U7h4ujtHQNaPMNt+Kyvtwig2mm/twijRye7PuNX2t2oRftWyjwYk94k52rCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js" integrity="sha512-3BBFWr73Xrf8GRjO+0pl0cbVwESBvg3ovnuCXpoqOkC/mkt/hTkFtutUPrwRz8eLySYvy5v1daulkyUZYvH8jw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="./js/functions.js"></script>
<? include "../../../includes/footer.php" ?>

