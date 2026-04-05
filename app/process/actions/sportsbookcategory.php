<?
$book = $_GET["id"];
$onchange = "from(this.value,'products_sportsbook','../process/actions/productscategory.php')";      
?>

  <select onchange="<? echo $onchange ?>" name="product" id="product"  class="drop_down_list">
    <option  selected="selected" value="0">Select an Option</option>
    
  <?
    switch ($book)
	{
	  case ($book == 1 || $book == 2 || $book == 3 || $book == 7 || $book == 9):
       ?>  
       <option value="1" id="P_Sportsbook" >Sportsbook</option>
       <option value="2" id="C_Sportsbook" >Casino</option>
       <? 
	  break;
  	  case ($book == 6 || $book == 8  ):
       ?>  
       <option value="2" id="C_Sportsbook" >Casino</option>
       <? 

	  break;	
		
	}
  ?>
 </select>