<style>
:root {
  --background-gradient: linear-gradient(30deg, #f39c12 30%, #f1c40f);
  --gray: #34495e;
  --darkgray: #2c3e50;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: none;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: #fff;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;
}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 10em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #34495e;
  transition: .25s all ease;
  pointer-events: none;
}
/* Transition */
.select:hover::after {
  color: #f39c12;
}
.main-container{
	margin-top:20px;	
	border:#333 1px solid;
	font-size:14px;				
}
.container-scroll{	
    overflow-y: auto;
	height:850px;	
}
.container-information{	
	min-width:610px;  
}
.top-container-sticky{
   position: -webkit-sticky;
   position: sticky;
   top: 0;
   background:#ffffff !important;     
}
.logo{
	border-radius: 50%;	
}
.line_wrapper{
   background:#eff7fa;   
   border-radius:5px;       
}
.line_wrapper_marked{
   background:#eff7fa;
   border:1px solid #2f80e7;   
   border-radius:5px;      
}
.logo-book{
	border:1px solid #000;
	border-radius:5px;
}
.dd_top{	
	width:auto !important;
	height:auto !important;
	margin-bottom:-30px;	
}
.table{
	background:#ffffff !important;
	display: table;
	width: 100%;
    /*height: 100%;*/
	border-collapse: separate;
    border-spacing: 5px;
}
.row{	
	display: table-row;    			
}
.column {    
	color:#000000;
	display: table-cell;
    padding:5px;
	vertical-align:middle;
	white-space:nowrap;			  
}
.column_top {    
	color:#000000;
	display: table-cell;   
	vertical-align:middle;
	white-space:nowrap;	
	height:25px;				  
}
.column_line {    
	color:#000000;	
	display: table-cell;    
	vertical-align:middle;
	white-space:nowrap;
	text-align:center;
	max-width: 0px;				  
}
</style>   
   
<div class="main-container">

<div class="container-scroll">
   <div class="container-information">  

<div class="table dd_top">

<div class="row">

<div class="column">

  <div class="select">
  <select>
    <option value=""><a href="#">SPORT</a></option>
    <option value="NFL"><a href="#">NFL</a></option>
    <option value="NBA"><a href="#">NBA</a></option>
    <option value="NHL"><a href="#">NHL</a></option>
    <option value="MLB"><a href="#">MLB</a></option>
    <option value="NCAAF"><a href="#">NCAAF</a></option>
    <option value="NCAAB"><a href="#">NCAAB</a></option>
  </select>
  </div>
    
</div>

<div class="column">
        
  <div class="select">
      <select>
        <option value=""><a href="#">PERIOD</a></option>
        <option value="Full Game"><a href="#">Full Game</a></option>
        <option value="First Half"><a href="#">First Half</a></option>
        <option value="Second Half"><a href="#">Second Half</a></option>
        <option value="First Quarter"><a href="#">First Quarter</a></option>
        <option value="Second Quarter"><a href="#">Second Quarter</a></option>
        <option value="Third Quarter"><a href="#">Third Quarter</a></option>
        <option value="Fourth Quarter"><a href="#">Fourth Quarter</a></option>
      </select>
  </div>
 
</div>

<div class="column">
  
  <div class="select">
      <select>
        <option value=""><a href="#">TYPE</a></option>
        <option value="Spread"><a href="#">Spread</a></option>
        <option value="Moneyline"><a href="#">Moneyline</a></option>
        <option value="Total"><a href="#">Total</a></option>        
      </select>
  </div>
  
  
</div>

</div>


</div>
<br /><br />
<div class="table">  
 
   <div class="row">

    <div class="column">
    
    <div class="table">
       <div class="row">
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row top-container-sticky">
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column_top" align="center"><img class="book-logo" width="92" height="25" src="http://www.sportsbettingonline.ag/utilities/process/stats/compare_odds/images/0.jpg" alt="Opener"></div>
         <div class="column_top" align="center"><img class="book-logo" width="92" height="25" src="http://www.sportsbettingonline.ag/utilities/process/stats/compare_odds/images/1.jpg" alt="SBO"></div>
         <div class="column_top" align="center"><img class="logo-book" width="92" height="25" src="http://www.sportsbettingonline.ag/utilities/process/stats/compare_odds/images/2.jpg" alt="Everygame"></div>
         <div class="column_top" align="center"><img class="logo-book" width="92" height="25" src="http://www.sportsbettingonline.ag/utilities/process/stats/compare_odds/images/3.jpg" alt="Wagerweb"></div>
         <div class="column_top" align="center"><img class="logo-book" width="92" height="25" src="http://www.sportsbettingonline.ag/utilities/process/stats/compare_odds/images/4.jpg" alt="BetAnySport"></div>


       <? /*  <div class="column_top" align="center"><img class="logo-book" width="92" height="25" src="https://www.oddsshark.com/sites/default/files/images/sportsbook-reviews/logos/betunline-ag-light-220x60.png" alt="BetOnline"></div> */ ?>
        
          <!--<div class="column_top" align="center"><img class="logo-book" width="92" height="25" src="https://www.oddsshark.com/sites/default/files/images/sportsbook-reviews/logos/betunline-ag-light-220x60.png" alt="BetOnline"></div>
          
          <div class="column_top" align="center"><img class="logo-book" width="92" height="25" src="https://www.oddsshark.com/sites/default/files/images/sportsbook-reviews/logos/betunline-ag-light-220x60.png" alt="BetOnline"></div>-->
           
       </div>
       <div class="row">
         <div class="column"><strong>Monday Oct 10th</strong></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!-- <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column">8:15p</div>
         <div class="column">479</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/479.jpg" width="25" height="30"></div>
         <div class="column"><strong>Las Vegas</strong></div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o37.5 -110</div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o43.5 -110</div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <!--<div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper">+270</div>
         <div class="column_line line_wrapper">+270</div>-->
       </div>
       <div class="row">
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column"><a href="#">Line History</a></div>
         <div class="column">480</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/480.jpg" width="25" height="30"></div>
         <div class="column"><strong>Kansas City</strong></div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper_marked">u37.5 -110</div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper">u43.5 -110</div>
         <div class="column_line line_wrapper_marked">u37.5 -110</div>
         <!--<div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper">-330</div>
         <div class="column_line line_wrapper">-330</div>-->
       </div>
       
       <div class="row">
         <div class="column"><strong> Tuesday Oct 13th</strong></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column">8:15p</div>
         <div class="column">479</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/479.jpg" width="25" height="30"></div>
         <div class="column"><strong>Las Vegas</strong></div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o37.5 -110</div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o43.5 -110</div>
         <div class="column_line line_wrapper">o27.5 -110</div>
        <!-- <div class="column_line line_wrapper">+270</div>
         div class="column_line line_wrapper">+270</div>
         <div class="column_line line_wrapper">+270</div>-->
       </div>
       <div class="row">
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
        <!-- <div class="column"></div>
         -- <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column"><a href="#">Line History</a></div>
         <div class="column">480</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/480.jpg" width="25" height="30"></div>
         <div class="column"><strong>Kansas City</strong></div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper_marked">u37.5 -110</div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper">u43.5 -110</div>
         <div class="column_line line_wrapper_marked">u27.5 -110</div>
         <!--<div class="column_line line_wrapper">-330</div>
         div class="column_line line_wrapper">-330</div>
         <div class="column_line line_wrapper">-330</div>-->
       </div>
       
       <div class="row">
         <div class="column"><strong>Wednesday Oct 15th</strong></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column">8:15p</div>
         <div class="column">479</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/479.jpg" width="25" height="30"></div>
         <div class="column"><strong>Las Vegas</strong></div>
         <div class="column_line"></div>
         <div class="column_line"></div>
         <div class="column_line"></div>
         <div class="column_line"><strong>No available odds</strong></div>
         <div class="column_line"></div>
         <!--<div class="column_line"></div>
        <div class="column_line"></div>
         <div class="column_line"></div>-->
       </div>
       <div class="row">
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column"><a href="#">Line History</a></div>
         <div class="column">480</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/480.jpg" width="25" height="30"></div>
         <div class="column"><strong>Kansas City</strong></div>
         <div class="column_line"></div>
         <div class="column_line"></div>
         <div class="column_line"></div>
         <div class="column_line"></div>
         <div class="column_line"></div>
         <!--<div class="column_line"></div>
         <div class="column_line"></div>
         <div class="column_line"></div>-->
       </div>
       
       <div class="row">
         <div class="column"><strong> Thursday Oct 16th</strong></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column">8:15p</div>
         <div class="column">479</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/479.jpg" width="25" height="30"></div>
         <div class="column"><strong>Las Vegas</strong></div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o37.5 -110</div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o43.5 -110</div>
         <div class="column_line line_wrapper">o27.5 -110</div>
         <!--<div class="column_line line_wrapper">+270</div>
         <div class="column_line line_wrapper">+270</div>
         <div class="column_line line_wrapper">+270</div>-->
       </div>
       <div class="row">
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
          <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column"><a href="#">Line History</a></div>
         <div class="column">480</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/480.jpg" width="25" height="30"></div>
         <div class="column"><strong>Kansas City</strong></div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper_marked">u37.5 -110</div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper">u43.5 -110</div>
         <div class="column_line line_wrapper_marked">u27.5 -110</div>
         <!--<div class="column_line line_wrapper">-330</div>
         <div class="column_line line_wrapper">-330</div>
         <div class="column_line line_wrapper">-330</div>-->
       </div>
       
       <div class="row">
         <div class="column"><strong>Friday Oct 17th</strong></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column">8:15p</div>
         <div class="column">479</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/479.jpg" width="25" height="30"></div>
         <div class="column"><strong>Las Vegas</strong></div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o37.5 -110</div>
         <div class="column_line line_wrapper">o37.5 -110</div>
         <div class="column_line line_wrapper_marked">o43.5 -110</div>
         <div class="column_line line_wrapper">o27.5 -110</div>
         <!--<div class="column_line line_wrapper">+270</div>
         <div class="column_line line_wrapper">+270</div>
         <div class="column_line line_wrapper">+270</div>-->
       </div>
       <div class="row">
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>
         <!--<div class="column"></div>
         <div class="column"></div>
         <div class="column"></div>-->
       </div>
       <div class="row">
         <div class="column"><a href="#">Line History</a></div>
         <div class="column">480</div>
         <div class="column"><img class="logo" src="http://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/20221010/480.jpg" width="25" height="30"></div>
         <div class="column"><strong>Kansas City</strong></div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper_marked">u37.5 -110</div>
         <div class="column_line line_wrapper">u37.5 -110</div>
         <div class="column_line line_wrapper">u43.5 -110</div>
         <div class="column_line line_wrapper_marked">u27.5 -110</div>
         <!--<div class="column_line line_wrapper">-330</div>
         <div class="column_line line_wrapper">-330</div>
         <div class="column_line line_wrapper">-330</div>-->
       </div>
       
    
    </div> 
    
    
    </div>
   
    
   </div> 
   
    
</div>

</div>

</div> 
        
</div>