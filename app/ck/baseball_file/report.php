<? include(ROOT_PATH . "/ck/process/security.php"); 
   if($current_clerk->im_allow("baseball_file")){ ?>
  
 <?
  require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');	
 ?>  
   
   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="myhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball File</title>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<style>
.table-container
{
   /* height: 500px;
    width: 500px; */
    overflow: auto;
}
tbody tr:nth-child(2n)
{
    background-color: #F7F7F7;
}


</style>
<? 

//patch
// replace strstr for myStrstrTrue

$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$year = date('Y',strtotime($from));
$date=  date('Y-m-d',strtotime($from));
$games = get_baseball_games_by_date($from);
$season =  get_baseball_season($year);
$total_columns = 118;
$width = 120;
$table_width = $total_columns * $width;
$pk_total = 0;
$game_count = 0;
$ump_weighted_total = 0;
$ump_data = get_all_umpire_data();
$column_desc = get_all_baseball_column_description();
$day_bets = get_baseball_bets($from);
$team_speed = get_all_baseball_team_speed($from,"team");
$stadiums_dewpoint = get_all_stadium_dewpoint_avg();
$stadiums_parkfactor_season = get_baseball_stadium_parkfactor_season_data($year);
$green_color = "#9F6"; 
$red_color = "#F30";
$year = date("Y");

$pa_catchers =  get_baseball_pitchers_vs_catchers("a",($year-1)."-01-01");
$ph_catchers =  get_baseball_pitchers_vs_catchers("h",($year-1)."-01-01");

//print_r($ph_catchers);

//Stadium Formula Data;
$std_formula = get_all_stadium_formula_data();
  

  
    if($current_clerk->vars['id'] != 86 ){
	$subject = 'BASEBALL FILE ACCESS';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	 send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
	}
  


if ($season['start'] > $date){
$preseason = true;
}



 $pitchers = array();
  $ji = 0;
  foreach ($games as $_game_home){
    
      $pitchers[$ji]["startdate"] = $_game_home->vars["startdate"];
	  $pitchers[$ji]["pitcher"] = $_game_home->vars["pitcher_away"];
	  $ji++;
	  $pitchers[$ji]["startdate"] = $_game_home->vars["startdate"];
	  $pitchers[$ji]["pitcher"] = $_game_home->vars["pitcher_home"];
      $ji++;    
  }
  
 
 $j=0;
  $last_game = array();
  foreach ($pitchers as $_pitchers){
   $_last_gameA =  get_baseball_games_last_game_player($_pitchers["pitcher"],$_pitchers["startdate"],"away");	  
    
   if (!is_null($_last_gameA)){
    
    $last_game[$_pitchers["pitcher"]] = $_last_gameA;
   }
  
   $_last_gameH =  get_baseball_games_last_game_player($_pitchers["pitcher"],$_pitchers["startdate"],"home");	  
   if (!is_null($_last_gameH)){
    
     if (isset($last_game[$_pitchers["pitcher"]])){
    
	    if ($last_game[$_pitchers["pitcher"]]["startdate"] < $_last_gameH["startdate"]) {
	       $last_game[$_pitchers["pitcher"]] = $_last_gameH;
	     }
	 } else {
		$last_game[$_pitchers["pitcher"]] = $_last_gameH; 
	 }
   }
  }
  
   
 
   
?>


<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<? /*  <script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script> */ ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<!-- For draggable -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		
	};
</script>
<!--
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
<script src="../includes/js/jquery.stickyheader.js"></script> -->
        
<script>

  function show_hide_column(table,id, do_show,columns) {
  var stl;
  var new_width;
    
	if 	(do_show) {
	  stl = ''
	   if (columns > 0){
	    new_width= (columns * <? echo $width ?> );
        new_width = (parseInt(document.getElementById(table).width) + parseInt(new_width));
		document.getElementById(table).width = new_width;
	   }
	 
	}
    else {
		 stl = 'none' ;
		
		 if (columns > 0){
		  new_width= (columns * <? echo $width ?> );
          new_width = (parseInt(document.getElementById(table).width) - new_width);
		 
		  document.getElementById(table).width = new_width;
		 }
		
	}
	
	var tbl = document.getElementsByName(id);
	for (x=0;x<tbl.length;x++){
    	tbl[x].style.display=stl;
	}

  }
 
  function fix_changes(){
	  
	  document.getElementById("pitcher_fix").style.display = "block" ;
  }
  
  
  function set_bet(game,type){
	
	var desc = document.getElementById("desc_"+type+game).value;
	var tr = document.getElementById("game_"+game);
	if (desc.length > 0) {
	   if (type == "bet"){
	     tr.className = "rowhighlight";
	   }
	   document.getElementById("changer").src = "process/actions/change_bet.php?game="+game+"&desc="+desc+"&type="+type; 	
	} 
	else {
		if (type == "bet"){
		   tr.className = "";
		 }
		 document.getElementById("changer").src = "process/actions/change_bet.php?game="+game+"&desc="+desc+"&type="+type; 
	}
	  
	  
  }
  
    function bet_total(type,game){
	
	 var value = document.getElementById("value_"+game).value;
     var action = 1;
	
	 if (type == 'o'){
		 document.getElementById("bets_u_"+game).checked = false; 
	 }
     if (type == 'u'){
		 document.getElementById("bets_o_"+game).checked = false; 
	 }
	 
	 if((document.getElementById("bets_u_"+game).checked == false) && (document.getElementById("bets_o_"+game).checked == false) ){ action = 0;}

	 
	 document.getElementById("changer").src = "process/actions/change_bet.php?type=t&game="+game+"&value="+value+"&bet_type="+type+"&action="+action; 	 
	 //document.location = "process/actions/change_bet.php?type=t&game="+game+"&value="+value+"&bet_type="+type; 	 
   }
   
   function uncheck_bet(game){
	   
	 if (document.getElementById("bets_u_"+game).checked) {
	   document.getElementById("bets_u_"+game).checked = false;	 
	 }  
	 if (document.getElementById("bets_o_"+game).checked) {
	   document.getElementById("bets_o_"+game).checked = false;	 
	 }   
  
   }
/*   
   
  function moveScroll(){
    var scroll = $(window).scrollTop();
    var anchor_top = $("#baseball").offset().top;
    var anchor_bottom = $("#bottom_anchor").offset().top;
    if (scroll>anchor_top && scroll<anchor_bottom) {
    clone_table = $("#clone");
    if(clone_table.length == 0){
        clone_table = $("#baseball").clone();
        clone_table.attr('id', 'clone');
        clone_table.css({position:'fixed',
                 'pointer-events': 'none',
                 top:0});
        clone_table.width($("#baseball").width());
        $("#table-container").append(clone_table);
        $("#clone").css({visibility:'hidden'});
        $("#clone thead").css({visibility:'visible', 'pointer-events':'auto'});
    }
    } else {
    $("#clone").remove();
    }
}
$(window).scroll(moveScroll);
*/  

/*
$(function() {
  $("table").stickyTableHeaders();
});*/

//$(document).ready(function() { $("table").stickyTableHeaders(); })

$(function(){
    $("table").stickyTableHeaders({container: "#container"});
    //$("table").stickyTableHeaders();
});
/*! Copyright (c) 2011 by Jonas Mosbech - https://github.com/jmosbech/StickyTableHeaders
    MIT license info: https://github.com/jmosbech/StickyTableHeaders/blob/master/license.txt */

;(function ($, window, undefined) {
    'use strict';

    var pluginName = 'stickyTableHeaders';
    var defaults = {
            fixedOffset: 0,
            container: null
        };


    /* 
     * This was taken from stackoverflow:
     * http://stackoverflow.com/questions/7501761/div-scrollbar-width
     */
    function getScrollbarWidth() 
    {
        var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div></div>'); 
        $('body').append(div); 
        var w1 = $('div', div).innerWidth(); 
        div.css('overflow-y', 'auto'); 
        var w2 = $('div', div).innerWidth(); 
        $(div).remove(); 
        return (w1 - w2);
    }


    function Plugin (el, options) {
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.
        var base = this;
        base.options = $.extend({}, defaults, options);

        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.el = el;

        // Cache DOM refs for performance reasons
        base.$window = $(window);
        base.$clonedHeader = null;
        base.$originalHeader = null;
        base.$container = base.options.container != null ? $(base.options.container) : base.$window;

        /* Need to use element to get offset if container is window.
         * Otherwise use container's offset for calculations.
         */
        base.getContainerOffset = function(){
            var c_offset = base.$container.offset();
            var e_offset = base.$el.offset();
            return c_offset === null ? {'top': 0, 'left': e_offset.left} : c_offset;
        };

        /* We need to know how much to scroll to activate and deactivate the
         * sticky header. I originally tried to calculate this using .position
         * on the child element. This works fine so long as the parent element
         * has its position set to something other than "static". Please
         * see this stackoverflow thread for why:
         *  http://stackoverflow.com/questions/2842432/jquery-position-isnt-returning-offset-relative-to-parent
         *
         * So to get this to work everywhere, I grab the difference from
         * the top of the child element and the top of the parent element
         * when the page loads. This should tell us how much we need to
         * scroll to activate the sticky header.
         *
         * Also - the offset function does not seem to take any table
         * captions into consideration. So we check for a table caption
         * and add this in to the amount we need to scroll for an
         * activation.
         */
        var startTopOffset = base.$el.offset().top - base.getContainerOffset().top;
        var caption = base.$el.find('caption');
        if (caption.length){
            startTopOffset += caption.height();
        }
        base.scrollAmountToActivate = startTopOffset;
        base.scrollAmountToDeactivate = base.scrollAmountToActivate + base.$el.height();

        /* See notes in updateWidth for why we need this*/
        base.parentClientWidth = base.$container.width() - getScrollbarWidth();

        // Keep track of state
        base.isCloneVisible = false;
        base.leftOffset = null;
        base.topOffset = null;

        base.init = function () {

            base.$el.each(function () {
                var $this = $(this);

                // remove padding on <table> to fix issue #7
                $this.css('padding', 0);

                $this.wrap('<div class="divTableWithFloatingHeader"></div>');

                base.$originalHeader = $('thead:first', this);
                base.$clonedHeader = base.$originalHeader.clone();

                base.$clonedHeader.addClass('tableFloatingHeader');
                base.$clonedHeader.css({
                    'position': 'fixed',
                    'top': 0,
                    'z-index': 1, // #18: opacity bug
                    'display': 'none'
                });

                base.$originalHeader.addClass('tableFloatingHeaderOriginal');
                base.$originalHeader.after(base.$clonedHeader);

                // enabling support for jquery.tablesorter plugin
                // forward clicks on clone to original
                $('th', base.$clonedHeader).click(function (e) {
                    var index = $('th', base.$clonedHeader).index(this);
                    $('th', base.$originalHeader).eq(index).click();
                });
                $this.bind('sortEnd', base.updateWidth);
            });

            base.updateWidth();
            base.toggleHeaders();

            base.$container.scroll(base.toggleHeaders);
            base.$container.resize(base.toggleHeaders);
            base.$container.resize(base.updateWidth);
        };

        base.toggleHeaders = function () {
            base.$el.each(function () {
                var $this = $(this);
                var newTopOffset = isNaN(base.options.fixedOffset) ?
                    base.options.fixedOffset.height() : base.options.fixedOffset;
                var offset = base.getContainerOffset();
                var scrollTop = base.$container.scrollTop() + newTopOffset;
                var scrollLeft = base.$container.scrollLeft();
                if ((scrollTop > base.scrollAmountToActivate) && (scrollTop < base.scrollAmountToDeactivate)) {
                    var newLeft = offset.left - scrollLeft;
                    if (base.isCloneVisible && (newLeft === base.leftOffset) && (newTopOffset === base.topOffset)) {
                        return;
                    }
                    base.$clonedHeader.css({
                        'top': newTopOffset + offset.top,
                        'margin-top': 0,
                        'left' : newLeft,
                        'display': 'block'
                    });
                    base.updateWidth();

                    base.$originalHeader.css('visibility', 'hidden');
                    base.isCloneVisible = true;
                    base.leftOffset = newLeft;
                    base.topOffset = newTopOffset;
                }
                else if (base.isCloneVisible) {
                    base.$clonedHeader.css('display', 'none');
                    base.$originalHeader.css('visibility', 'visible');
                    base.isCloneVisible = false;
                }
            });
        };

        base.updateWidth = function () {
            // Copy cell widths and classes from original header
            $('th', base.$clonedHeader).each(function (index) {
                var $this = $(this);
                var $origCell = $('th', base.$originalHeader).eq(index);
                this.className = $origCell.attr('class') || '';
                $this.css('width', $origCell.width());
            });

            // Copy row width from whole table
            base.$clonedHeader.css('width', base.$originalHeader.width());

            // One last thing - if our table is inside of another
            // scrolled div, the width of our parent div could
            // be less than that of the cloned header.
            // This would cause the cloned div to display outside
            // of our parent's viewport and would appear "on top of"
            // any scrollbars on our parent. Need to clip.
            if(base.$clonedHeader.width() > base.parentClientWidth)
            {
                var scrollLeft = base.$container.scrollLeft();
                var clipLeft = scrollLeft;
                var clipRight =  base.parentClientWidth + scrollLeft;
                base.$clonedHeader.css({
                    'clip': 'rect(0px, ' + clipRight + 'px, ' 
                                       + base.$clonedHeader.height() + 'px,' 
                                       + clipLeft + 'px)'
                    });
            }
            
        };

        // Run initializer
        base.init();
    }

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
            }
        });
    };

})(jQuery, window);

</script>

<style>
  #wrapper1{
    position: fixed;
    width: 100px;
    border: none 0px red;
    overflow-x: scroll; 
    overflow-y:hidden;
    z-index: 10000;
    padding: 7px 0 60px 27px;
    background-color: #008000;
    border: 2px solid #ffffff;
    color: #ffffff;
    font-size: 16px;
    border-radius: 9px;
    box-shadow: 0 0 16px rgba(0,0,0,0.6);
    background-image: url("./images/sidetoside.png");
    background-position: 50% 40%;
    background-size: 50%;
    background-repeat: no-repeat;
    left: 320px;
    top: 266px;
  }

  #wrapper1{
    height: 20px;
  }

  #div1 {
    width:15500px; /*Aqu{i define la sensibilidad del scroll*/
    height: 20px; 
  } 

  #wrapper2{
    width: 150px;
    height: 
    padding: 15px;
    overflow-x: scroll;
  }

</style>
</head>
<body>
<? $page_style = " width:14200px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<div id="wrapper1" class="draggable">
    <div id="div1"></div>
</div>

<div class="page_content" style="padding-left:10px;">
<span class="page_title">Baseball Games
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="baseball_reports.php" class="normal_link">Reports</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="baseball_tools.php" class="normal_link">Tools</a>

</span><BR>
<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a id="pitcher_fix" style="display:none" href="jobs/pitchers_game_fix.php?date=<? echo $from ?>" class="normal_link" rel="shadowbox;height=270;width=400">Pitcher Fix </a>
&nbsp;&nbsp; || &nbsp;&nbsp; 
<a id="pitcher_list"  href="pitchers_list.php?date=<? echo $from ?>" class="normal_link" rel="shadowbox;height=600;width=650">Today Pitchers </a>


<br /><br />


<form method="post">
    Date: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
 
    &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
   
    &nbsp;&nbsp;&nbsp;&nbsp;<span><strong></strong></span>
    <br /><br />
</form>
 <? if (count($games)>6) { ?>
  &nbsp;&nbsp;&nbsp;
   <a href="javascript:;" onclick="move_scroll('up');" title="Go Up"><img src="images/arrow_up.png" width="20px" onclick="move_scroll('up');"  id="up"  title="Go Up" /></a>
   <a href="javascript:;" onclick="move_scroll('down');" title="Go Down"><img src="images/arrow_down.png" width="20px" onclick="move_scroll('down');"  /></a>
   <BR>          
  <? } ?> 

<?
if ($preseason){ ?>
<span style="font-size:14px;">
    <strong>Preseason</strong>
</span><br /><br />	
<? }
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size:11px;">
    <strong>Elev: </strong>	Elevation above sea, 
    <strong>TMP: </strong>Temp in °F, 
    <strong>HM: </strong> % of Humidity, 
    <strong>WS: </strong>Wind Speed (mph),
    <strong>WD: </strong>Wind Direct, 
    <strong>WP </strong>Wind Position,  
    <strong>WG: </strong>Wind Gust (mph),     
    <strong>AirP: </strong>Pressure (in), 
    <strong>DewP: </strong>Dewpoint (°F), 
    <strong>DryA: </strong>Dry Air Density (kg/m3), 
    <strong>VapourP: </strong>Vapour Pressure(hPa), 
    <strong>MoistA: </strong>Moist Air Density (kg/m3), 
    <strong>M_A: </strong>Money Away,
    <strong>M_H: </strong>Money Home, 
    <strong>T 0: </strong>Total Over,
    <strong>T_0J: </strong>Total Over Juice,
    <strong>T U: </strong>Total Under,
    <strong>T_UJ: </strong>Total Under Juice,  
    <strong>T_0 1st 5I: </strong>Total Over 1st 5 Innings,
    <strong>T_0J 1st 5I: </strong>Total Over Juice 1st 5 Innings ,
    <strong>T_U 1st 5I: </strong>Total Under Juice 1st 5 Innings,
    <strong>T_UJ 1st 5I: </strong>Total Under Juice 1st 5 Innings,
    <strong>SCR: </strong>Score,
</span>
<iframe id="changer" width="1" height="1" scrolling="no" frameborder="0"></iframe>

<?
$games_bets = get_all_games_with_bet_by_date($from,8);//8 is the id for the required identifier
$umpires = get_all_umpires();
$manual_wind = get_all_baseball_stadium_position();
$constants = get_baseball_constants();
$constants = get_baseball_constants();
$fix = false;;
?>
<div id="container" class='table-container'>
<table  id="baseball" name="baseball" width="<? echo $table_width ?>" border="0" cellspacing="0" cellpadding="0" >
 <thead>
  <tr >
    <th width="60" align="center"  class="table_header" >Bet</th>
    <th width="120"  class="table_header" >Date</th>
    <th  name ="game_info_" width="120"  class="table_header">Hour</th>
    <th  name ="game_info_" width="120" class="table_header">Away
    <th width="120" class="table_header">Home</th>
    <th width="6" name="show_stadium_stadistics" class="table_header" title="Show Stadium Stadistics" style="border-right-style:solid;border-right: 1px solid #d5d5d5;border-left:1px solid #d5d5d5;" ><img src="images/next.png" onClick='show_hide_column( "baseball", "stadium_stadistics",true,8);show_hide_column( "baseball","show_stadium_stadistics",false,0);show_hide_column( "baseball","hide_stadium_stadistics",true,0)'> </th>   
    <th name="stadium_stadistics" width="120" class="table_header">Elev</th>
    <th name="stadium_stadistics" width="120" class="table_header">Roof</th>
    <th name="stadium_stadistics" width="120" class="table_header">Runs</th>
    <th name="stadium_stadistics" width="120" class="table_header">HomeRuns</th>
    <th name="stadium_stadistics" width="120" class="table_header">Hits</th>
    <th name="stadium_stadistics" width="120" class="table_header">2B</th>        
    <th name="stadium_stadistics" width="120" class="table_header">3B</th>        
    <th name="stadium_stadistics" width="120" class="table_header">BB</th>  
    <th width="6" name="hide_stadium_stadistics" class="table_header" title="Hide Stadium Stadistics"><img src="images/previous.png" onClick='show_hide_column( "baseball","stadium_stadistics",false,8);show_hide_column( "baseball","hide_stadium_stadistics",false,0);show_hide_column( "baseball","show_stadium_stadistics",true,0)' > </th> 
 
 <th width="6" name="show_weather_stadistics" class="table_header" title="Show Weather Stadistics"  ><img src="images/next.png" onClick='show_hide_column( "baseball","weather_stadistics",true,10);show_hide_column( "baseball","show_weather_stadistics",false,0);show_hide_column( "baseball","hide_weather_stadistics",true,0)' > </th>   
               
    <th name="weather_stadistics" width="120" class="table_header">TMP</th>
    <th name="weather_stadistics" width="120" class="table_header" align="center">Condition</th>
    <th name="weather_stadistics" width="120" class="table_header">HM</th>
    <th name="weather_stadistics" width="120" class="table_header">WS</th>
    <th name="weather_stadistics" width="120" class="table_header" align="center">WD</th>
    <th name="weather_stadistics" width="120" class="table_header">WP</th>
    <th name="weather_stadistics" width="120" class="table_header">WG</th>
    <th name="weather_stadistics" width="120" class="table_header">AirP</th>
    <th name="weather_stadistics" width="120" class="table_header">DewP</th>
    <th name="weather_stadistics" width="120" class="table_header">DryA</th>
    <th name="weather_stadistics" width="120" class="table_header">VapourP</th>  
    <th name="weather_stadistics" width="120" class="table_header">MoistA</th>
    <th name="weather_stadistics" width="120" class="table_header">PK</th>
    <th name="weather_stadistics" width="120" class="table_header">Aird</th> 
    <th name="weather_stadistics" width="120" class="table_header">PK ADJ</th>        
    <th name="weather_stadistics" width="120" class="table_header">AIRP ADJ</th>            
    <th name="weather_stadistics" width="120" class="table_header">TOTAL ADJ</th>            
    <th name="weather_stadistics" width="120" class="table_header">HRW</th>
    <th name="weather_stadistics" width="120" class="table_header">Seal</th>          
    <th name="weather_stadistics" width="120" class="table_header" align="center">Bubble</th>
      

   <th width="6" name="hide_weather_stadistics" class="table_header" title="Hide Weather Stadistics"><img src="images/previous.png" onClick='show_hide_column( "baseball","weather_stadistics",false,10);show_hide_column( "baseball","hide_weather_stadistics",false,0);show_hide_column( "baseball","show_weather_stadistics",true,0)' > </th>   
   
      
  
    
        <th width="6" name="show_umpire_stadistics" class="table_header" title="Show Umpire Stadistics"  ><img src="images/next.png" onClick='show_hide_column( "baseball","umpire_stadistics",true,13);show_hide_column( "baseball","show_umpire_stadistics",false,0);show_hide_column( "baseball","hide_umpire_stadistics",true,0)' > </th>  
      
    <th name="umpire_stadistics" width="120" class="table_header">Umpire</th>
    <th name="umpire_stadistics" width="120" class="table_header">
    <a href="javascript:display_div('<? echo $year-5 ?>')" class="normal_link" title="<? echo $column_desc[$year-5]["description"]?>" ><? echo ($year-5)?>     </a> 
          
		<div id="<? echo $year-5 ?>" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="<? echo $year-5 ?>" name="column" id="column" />
         <textarea name="description" cols="14" rows="5"><? echo $column_desc[$year-5]["description"]?></textarea>
         <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>  
    </th>
    <th name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th name="umpire_stadistics" width="120" class="table_header">
	<a href="javascript:display_div('<? echo $year-4 ?>')" class="normal_link" title="<? echo $column_desc[$year-4]["description"]?>" ><? echo ($year-4)?>     </a> 
          
		<div id="<? echo $year-4 ?>" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="<? echo $year-4 ?>" name="column" id="column" />
         <textarea name="description" cols="14" rows="5"><? echo $column_desc[$year-4]["description"]?></textarea>
         <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>
    </th>
    <th name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th name="umpire_stadistics" width="120" class="table_header">
    <a href="javascript:display_div('<? echo $year-3 ?>')" class="normal_link" title="<? echo $column_desc[$year-3]["description"]?>" ><? echo ($year-3)?>     </a> 
          
		<div id="<? echo $year-3 ?>" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="<? echo $year-3 ?>" name="column" id="column" />
         <textarea name="description" cols="14" rows="5"><? echo $column_desc[$year-3]["description"]?></textarea>
         <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>
    </th>
    <th name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th name="umpire_stadistics" width="120" class="table_header">
    <a href="javascript:display_div('<? echo $year-2 ?>')" class="normal_link" title="<? echo $column_desc[$year-2]["description"]?>" ><? echo ($year-2)?>     </a> 
          
		<div id="<? echo $year-2 ?>" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="<? echo $year-2 ?>" name="column" id="column" />
         <textarea name="description" cols="14" rows="5"><? echo $column_desc[$year-2]["description"]?></textarea>
         <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>
    </th>
    <th name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th name="umpire_stadistics" width="120" class="table_header">
    <a href="javascript:display_div('<? echo $year-1 ?>')" class="normal_link" title="<? echo $column_desc[$year-1]["description"]?>" ><? echo ($year-1)?>     </a> 
          
		<div id="<? echo $year-1 ?>" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="<? echo $year-1 ?>" name="column" id="column" />
         <textarea name="description" cols="14" rows="5"><? echo $column_desc[$year-1]["description"]?></textarea>
         <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>
    </th>
    <th name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th name="umpire_stadistics" width="120" class="table_header">
    <a href="javascript:display_div('<? echo $year ?>')" class="normal_link" title="<? echo $column_desc[$year]["description"]?>" ><? echo ($year)?>     </a> 
          
		<div id="<? echo $year ?>" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="<? echo $year ?>" name="column" id="column" />
         <textarea name="description" cols="14" rows="5"><? echo $column_desc[$year]["description"]?></textarea>
         <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>
    </th>
    <th name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th name="umpire_stadistics" width="120" class="table_header">
    <a href="javascript:display_div('manual_wgd')" class="normal_link" title="<? echo $column_desc["weighted_avg"]["description"]?>" >Weighted Avg</a> 
          
		<div id="manual_wgd" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="weighted_avg" name="column" id="column" />
         <input type="hidden" value="weig_avg" name="column2" id="column2" />
         <textarea name="description" cols="18" rows="7"><? echo $column_desc["weighted_avg"]["description"]?></textarea>
		 <BR>
         <strong>AVG</strong>:&nbsp; <input type="text" name="weig_avg" value="<? echo $column_desc["weig_avg"]["description"]?>" />         
        <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>
    
  
    </th>
    <th name="umpire_stadistics" width="120" class="table_header">
     <a href="javascript:display_div('manual_vol')" class="normal_link" title="<? echo $column_desc["volatility"]["description"]?>" >Volatility</a> 
          
		<div id="manual_vol" style="display:none">	 
		 <form action="process/actions/manual_column_desc_action.php" method="post">
         <input type="hidden" value="volatility" name="column" id="column" />
         <textarea name="description" cols="18" rows="7"><? echo $column_desc["volatility"]["description"]?></textarea>
         <input type="submit" name="submit" value="Save">
         </form>
   	
        </div>
    </th>    
    
      <th width="6" name="hide_umpire_stadistics" class="table_header" title="Hide Umpire Stadistics"><img src="images/previous.png" onClick='show_hide_column( "baseball","umpire_stadistics",false,13);show_hide_column( "baseball","hide_umpire_stadistics",false,0);show_hide_column( "baseball","show_umpire_stadistics",true,0)' > </th>  
    
    <th width="6" name="show_pitcher_stadistics" class="table_header" title="Show Pitcher Stadistics"  ><img src="images/next.png" onClick='show_hide_column( "baseball","pitcher_stadistics",true,32);show_hide_column( "baseball","show_pitcher_stadistics",false,0);show_hide_column( "baseball","hide_pitcher_stadistics",true,0)' > </th> 
    
    <th name="pitcher_stadistics" width="120" class="table_header">Pitcher</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Catcher</th>  
    <th  name="pitcher_stadistics"  width="120"  class="table_header"> GB %</th>  
    <th name="pitcher_stadistics" width="120" class="table_header">Era</th>
    <th name="pitcher_stadistics" width="120" class="table_header">XFip</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Era/Diff</th> 
    <th name="pitcher_stadistics" width="120" class="table_header">K9</th>                
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Rest Time</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center" title="Highest Pitch Count">Highest PC</th>    
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Last Game</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (3G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (3G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (4G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (4G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (5G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (5G)</th>    
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (S)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (Last S)</th>
    <th name="pitcher_stadistics" width="120" class="table_header">FB%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS FB</th>    
    <th name="pitcher_stadistics" width="120" class="table_header">SL%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS SL</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">CT%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS CT</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">CB%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS CB</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">CH%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS CH</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">SF%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS SF</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">KN%</th>  
    <th name="pitcher_stadistics" width="120" class="table_header">VS KN</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">XX%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Sum_SCC%</th> 
    <th name="pitcher_stadistics" width="120" class="table_header">FBv (2G) </th>
    <th name="pitcher_stadistics" width="120" class="table_header">FBv Last G.</th>  
    <th name="pitcher_stadistics" width="120" class="table_header">FBv Season</th>
    
            
    <th name="pitcher_stadistics" width="120" class="table_header">Pitcher</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Catcher</th> 
   <th  name="pitcher_stadistics"  width="120"  class="table_header"> GB %</th>       
    <th name="pitcher_stadistics" width="120" class="table_header">Era</th>
    <th name="pitcher_stadistics" width="120" class="table_header">XFip</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Era/Diff</th>
    <th name="pitcher_stadistics" width="120" class="table_header">K9</th>    
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Rest Time</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center" title="Highest Pitch Count">Highest PC</th>    
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Last Game</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (3G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (3G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (4G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (4G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (5G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (5G)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (S)</th>
    <th name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (Last S)</th>
    <th name="pitcher_stadistics" width="120" class="table_header">FB%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS FB</th>    
    <th name="pitcher_stadistics" width="120" class="table_header">SL%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS SL</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">CT%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS CT</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">CB%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS CB</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">CH%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS CH</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">SF%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">VS SF</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">KN%</th>  
    <th name="pitcher_stadistics" width="120" class="table_header">VS KN</th>        
    <th name="pitcher_stadistics" width="120" class="table_header">XX%</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Sum_SCC%</th> 
    <th name="pitcher_stadistics" width="120" class="table_header">FBv (2G) </th>
    <th name="pitcher_stadistics" width="120" class="table_header">FBv Last G.</th>  
    <th name="pitcher_stadistics" width="120" class="table_header">FBv Season</th> 
    
    
     <th width="6" name="hide_pitcher_stadistics" class="table_header" title="Hide Pitcher Stadistics"><img src="images/previous.png" onClick='show_hide_column( "baseball","pitcher_stadistics",false,32);show_hide_column( "baseball","hide_pitcher_stadistics",false,0);show_hide_column( "baseball","show_pitcher_stadistics",true,0)' > </th>  
     
         <th width="6" name="show_bullpen_stadistics" class="table_header" title="Show Bullpen Stadistics"  ><img src="images/next.png" onClick='show_hide_column( "baseball","bullpen_stadistics",true,8);show_hide_column( "baseball","show_bullpen_stadistics",false,0);show_hide_column( "baseball","hide_bullpen_stadistics",true,0)' > </th> 
    
    
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">Pitching A</th> 
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">Pitching H</th>     
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BA IP </th>  
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BA PC</th>
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BH IP</th>  
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BH PC</th>
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">IP  Total </th>  
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">PC Total </th>
    
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BA IP Season </th>  
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BA PC  Season </th>
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BH IP  Season </th>  
    <th name="bullpen_stadistics" width="120" class="table_header" align="center">BH PC  Season </th>
    
   <th name="bullpen_stadistics" width="120" class="table_header" align="center">BA #</th>  
   <th name="bullpen_stadistics" width="120" class="table_header" align="center">BH #</th>
    
   <th name="bullpen_stadistics" width="120" class="table_header" align="center">ERRORS A #</th>  
   <th name="bullpen_stadistics" width="120" class="table_header" align="center">ERRORS H #</th>

    
  <th width="6" name="hide_bullpen_stadistics" class="table_header" title="Hide Bullpen Stadistics"><img src="images/previous.png" onClick='show_hide_column( "baseball","bullpen_stadistics",false,8);show_hide_column( "baseball","hide_bullpen_stadistics",false,0);show_hide_column( "baseball","show_bullpen_stadistics",true,0)' > </th>     
    
    <th width="6" name="show_ten_stadistics" class="table_header" title="Show +10" ><img src="images/next.png" onClick='show_hide_column( "baseball","ten_stadistics",true,2);show_hide_column( "baseball","show_ten_stadistics",false,0);show_hide_column( "baseball","hide_ten_stadistics",true,0)' > </th>  
    
    
    <th  name="ten_stadistics" width="120" class="table_header" align="center">+10 A</th>  
    <th  name="ten_stadistics" width="120" class="table_header" align="center">+10 H</th>  

      <th width="6" name="hide_ten_stadistics" class="table_header" title="Hide +10"><img src="images/previous.png" onClick='show_hide_column( "baseball","ten_stadistics",false,2);show_hide_column( "baseball","hide_ten_stadistics",false,0);show_hide_column( "baseball","show_ten_stadistics",true,0)' > </th>       
     
    <th width="6" name="show_lines_stadistics" class="table_header" title="Show Game Lines" ><img src="images/next.png" onClick='show_hide_column( "baseball","lines_stadistics",true,18);show_hide_column( "baseball","show_lines_stadistics",false,0);show_hide_column( "baseball","hide_lines_stadistics",true,0)' > </th> 
      
     
    <th name="lines_stadistics" width="120" class="table_header" align="center">MONEY A</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">MONEY H</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total OVER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total O JUICE</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total UNDER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total U JUICE</th> 
    
   <?php /*?> <th name="lines_stadistics" width="120" class="table_header" align="center">MONEY 1st 5 A</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">MONEY 1st 5 H</th> 
    <th name="lines_stadistics" width="120" class="table_header" align="center">T. 0ver 1st 5 I</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">T. 0. Juice 1st 5I</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">T. Under 1st 5I</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">T. U. Juice 1st 5I</th>  
    
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team A OVER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team A O JUICE</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team A UNDER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team A U JUICE</th>
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team H OVER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team H O JUICE</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team H UNDER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Team H U JUICE</th><?php */?>
   
     <th width="6" name="hide_lines_stadistics" class="table_header" title="Hide Game Lines"><img src="images/previous.png" onClick='show_hide_column( "baseball","lines_stadistics",false,18);show_hide_column( "baseball","hide_lines_stadistics",false,0);show_hide_column( "baseball","show_lines_stadistics",true,0)' > </th>   
     
         <th width="6" name="show_game_stadistics" class="table_header" title="Show Game Results" ><img src="images/next.png" onClick='show_hide_column( "baseball","game_stadistics",true,5);show_hide_column( "baseball","show_game_stadistics",false,0);show_hide_column( "baseball","hide_game_stadistics",true,0)' > </th>   
 
    <th name="game_stadistics" width="120" class="table_header" align="center">HOMERUNS</th> 
    <th name="game_stadistics" width="120" class="table_header" align="center">RUNS A</th>  
    <th name="game_stadistics" width="120" class="table_header" align="center">RUNS H</th>
    <th name="game_stadistics" width="120" class="table_header" align="center">RUNS T</th>   
    <th name="game_stadistics" width="120" class="table_header" align="center">SCORE</th>
    
        <th width="6" name="hide_game_stadistics" class="table_header" title="Hide Game Results"><img src="images/previous.png" onClick='show_hide_column( "baseball","game_stadistics",false,5);show_hide_column( "baseball","hide_game_stadistics",false,0);show_hide_column( "baseball","show_game_stadistics",true,0)' > </th>
    
   
    <th width="120" class="table_header" align="center">Espn Info</th>
           
  </tr>
 </thead> 
 <tbody>
<?

 foreach($games as $game){
   
  if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
   $ump_id = 0;
   $ump_value = 0;
   $fangraphs_team_away = get_baseball_team($game->vars["team_away"]);
   $fangraphs_team_home = get_baseball_team($game->vars["team_home"]);
   $players_team_away = get_all_baseball_player_by_team($fangraphs_team_away->vars["fangraphs_team"],$year);
   $players_team_home = get_all_baseball_player_by_team($fangraphs_team_home->vars["fangraphs_team"],$year);
   
  
   
  
	
	$day= date('M-d',strtotime($game->vars["startdate"]));
	$hour= date('H:i',strtotime($game->vars["startdate"]));
	$Hh =  date('H',strtotime($game->vars["startdate"]));
	$date = date('Y-m-d',strtotime($game->vars["startdate"]));
	
	 //Pitcher FaceOff
    $faceoff_away = get_pitcher_faceoff_team($game->vars["team_home"],$game->vars["pitcher_away"],$date);
	$faceoff_home = get_pitcher_faceoff_team($game->vars["team_away"],$game->vars["pitcher_home"],$date);

	/*echo "<pre>";	
	  echo $game->vars["away"]."<BR>";
      print_r($faceoff_away);
	echo "</pre>";*/
	
	
	if ($i==1){
	 $lines_game = get_sport_lines($date,'MLB','Game',true);
	 $lines_innings = get_sport_lines($date,'MLB','1st 5 Innings',true);	
	}
	
	//Weather formulas
	$weather=get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]) ;
	$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	$stadium_away = get_baseball_stadium_by_team($game->vars["team_away"]);	
	$stadium_position = $stadium->get_baseball_stadium_wind_position($weather->vars["wind_direction"]);
	
	if (!$game->vars["manual_wind"]){
	  $adjustment_factors = get_adjustment_factors($stadium_position['id']);  
	}
	else{
      $adjustment_factors = get_adjustment_factors($game->vars["manual_wind"]);  	
	}
	  
	if (!is_null($weather->vars["temp"])){
  	
	// pk
	 $pk=$game->get_pk($weather,$stadium,$adjustment_factors,$constants);
    }else { $pk = "0";}
	
	// Air Density
 	 
	 $temp_kelvin=$game->get_kelvin_temp($weather->vars["temp"]);
     $air_density = $game->get_air_density($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$temp_kelvin);
	 $dewpoint_celsius = $game->get_celsius_temp($weather->vars["dewpoint"]);
	 $water_vapour = $game->get_water_vapour($dewpoint_celsius);
	 $moist_air_density = $game->get_moist_air_density ($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$water_vapour, $temp_kelvin);
	 //$aird = $game->get_aird ($game->get_kelvin_temp($weather->vars["temp"]),$weather->vars["air_pressure"],$water_vapour);
	
	  $weather_style = "";
	  $orweather_style = "";
	  $pkweather_style = "";
	  if ($pk <= -15 && $game->vars["roof_open"]) {$pkweather_style = "_red";}
	  else if ($pk >= 15 && $game->vars["roof_open"]) {$pkweather_style = "_green";}
	  $orweather_style = $weather_style;
	  
	  if ($weather->vars["wind_direction"] == 'Variable' ){$weather_style = "_gray";} 
	  
	  if ($stadium->vars["has_roof"] == 2 || !$game->vars["roof_open"]) {$weather_style = "_gray";} 
	  
	  //Yesterday Game
	   $yesterday = date ('Y-m-d',strtotime ( '-1 day' , strtotime ( $game->vars["startdate"]))) ;
       $firstbase=get_baseball_firstbase($game->vars["team_away"],$game->vars["team_home"],$yesterday);
	    echo "<pre>";
		//print_r($firstbase);
		echo "</pre>";
	   $firstbase_name = get_umpire_name_by_id($firstbase["firstbase"]);
	   $yesterday_data = $firstbase;
		  
	  ?> 
     <tr <? if($game->vars["bet"] != "-1") { echo 'class="rowhighlight" '; }?>  id="game_<? echo $game->vars["id"] ?>">
     <td class="table_td<? echo $style ?>" style="font-size:12px;">
       
       <a href="javascript:display_div('bet_<? echo $game->vars["id"] ?>')" class="normal_link" title="BET" >BET</a> 
          
		<div  align="center" id="bet_<? echo $game->vars["id"] ?>" style="display:none">	 
		 <form  action="process/actions/change_bet.php" method="get">
          <input type="hidden" value="bet" name="type" id="type" />
         <input type="hidden" value="<? echo $game->vars["id"] ?>" name="game" id="game" />
         <textarea name="description" id="desc_bet<? echo $game->vars["id"] ?>" cols="18" rows="7"><? if ($game->vars["bet"] != "-1") { echo $game->vars["bet"]; } ?></textarea>
         <input type="button" name="submit" value="Save" onclick="set_bet('<? echo $game->vars["id"] ?>','bet')">
         </form>
   	
        </div>
        <div align="center">
           <? $bet_over = false; $bet_under = false; $bet_data = 0; $bet_bgcolor = "#FFF"; 
		   
		   if(isset($day_bets[$game->vars["id"]]->vars["game"])){
		     if ($day_bets[$game->vars["id"]]->vars["bet_type"]=="o"){ $bet_data = $day_bets[$game->vars["id"]]->vars["value"]; $bet_over = true;  }
		     if ($day_bets[$game->vars["id"]]->vars["bet_type"]=="u"){ $bet_data = $day_bets[$game->vars["id"]]->vars["value"]; $bet_under = true;  }			 
		     
			 if($day_bets[$game->vars["id"]]->vars["status"]==0) { $bet_bgcolor = "#EC0D0D"; } //red  -lose
 		     if($day_bets[$game->vars["id"]]->vars["status"]==1) { $bet_bgcolor = "#4FDC45"; } //greeen-win
		     if($day_bets[$game->vars["id"]]->vars["status"]==3) { $bet_bgcolor = "#37B5F1"; } //blue-push			 
		   }
		   
		   ?>
          <strong>O</strong><input <? if ($bet_over){ echo ' checked="checked" '; }?> onchange="bet_total('o','<? echo $game->vars["id"] ?>')" <? if ($from != date("Y-m-d")){ echo 'disabled="disabled"'; }?> type="checkbox" id="bets_o_<? echo $game->vars["id"]?>" value="<? echo $game->vars["id"]?>"><BR>
          <input onchange="uncheck_bet('<? echo $game->vars["id"] ?>')"  type="number" <? if ($from != date("Y-m-d")){ echo 'readonly="readonly"'; }?>  id="value_<? echo $game->vars["id"]?>" name="value_<? echo $game->vars["id"]?>"    <? if ($bet_data){ echo 'value="'.$bet_data.'" '; } else { echo ' value="7" ';}?>  style="width:30px;background-color:<? echo $bet_bgcolor?>"> <BR>
          <strong>U</strong><input <? if ($bet_under){ echo ' checked="checked" '; }?> onchange="bet_total('u','<? echo $game->vars["id"] ?>')" <? if ($from != date("Y-m-d")){ echo 'disabled="disabled"'; }?> type="checkbox" id="bets_u_<? echo $game->vars["id"]?>" value="<? echo $game->vars["id"]?>">
        </div>
     
     </td>
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day ?></td>
      
       <?
	   if (!$game->vars["espn_game"]){
	   ?>
          <td class="table_td<? echo $style ?>_red" style="font-size:12px;">
	   <a href="<?= BASE_URL ?>/ck/baseball_file/game_hour_fix.php?gid=<? echo $game->vars["id"]?>" class="normal_link" rel="shadowbox;height=270;width=300"><? echo $hour ?></a>
            </td>
	   <? 
      }
      else { 
     
       if ($game->vars["postponed"]){ ?>
        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $hour ?><strong> (Postponed)</strong></td>           
		  <? }else
		 {
		 ?>
         <td name ="game_info_" class="table_td<? echo $style ?>" style="font-size:12px; 
         <? if($stadium->vars["time"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["time"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($Hh >= 19 ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($Hh < 19 ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>  
         
         "><? echo $hour ?></td> 
         <? }
          }?>
          
      <td  name ="game_info_" id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["away_rotation"].") ".$game->vars["away"] ?><BR><BR>
        <span style="font-size: 14px;" title="Yesterday's Score"><strong>Y Scr :</strong> <? echo $yesterday_data['runs_away']?></span>
      </td>
      
      <td   id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<a href="<?= BASE_URL ?>/ck/baseball_file/stadium_phones.php?sid=<? echo $stadium->vars["id"]?>" class="normal_link" rel="shadowbox;height=700;width=630"><? echo "(".$game->vars["home_rotation"].") ".$game->vars["home"]?></a>
        <BR><BR>
        <span style="font-size: 14px;" title="Yesterday's Score"><strong>Y Scr :</strong> <? echo $yesterday_data['runs_home']?></span>
      </td>
      
       <td name="show_stadium_stadistics" class="table_td1"></td>
      
       <td  name="stadium_stadistics" title="Elevation above sea level"  class="table_td<? echo $style ?>" style="font-size:12px;" id="elevation_<? echo $game->vars["id"]?>"><? echo  $stadium->vars["elevation"] ?></td>   
     
      <? // To control the PK avg excluding games with roof closed
       $roof = true;
	    if ($stadium->vars["has_roof"] == 1) { 
	       if (!$game->vars["roof_open"]){ $roof = false;} 
	    }
	   if ($stadium->vars["has_roof"] == 2) { $roof = false; }
	  ?>

       <td name="stadium_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px; 
        <? if ($stadium->vars["has_roof"] ==1) { ?>
	   
	   <? if($stadium->vars["roof"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["roof_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($stadium->vars["roof"] == $game->vars["roof_open"] ) { echo ' background-color:'.$w_color.'; '; } 
	      } ?>
       <? } ?>
      " align="table_td<? echo $style.$orweather_style ?>" id="r<? echo $game->vars["id"]?>" >
		   <? if ($stadium->vars["has_roof"] ==1) { ?>
           		<? if(!$game->started()){ ?>
                   <select name="roof" id="<? echo $game->vars["id"]?>" onChange="change_roof_status(<? echo $game->vars["id"]?>,this.value)" >
                   <option value="1">Open</option>
                   <option value="0" <? if(!$game->vars["roof_open"]){ ?>selected="selected"<? } ?>>Close</option>
                   </select>
               <? }else{echo $game->get_roof_comparison();} ?>
          <? }else if ($stadium->vars["has_roof"] ==2) { ?>
          		<strong>Always Closed</strong>
          <? }else{ ?>
          		No Roof
          <? } ?>
      </td>
  <?    
   //stadium stadistics
     $stadium_stadistics = get_baseball_stadium_stadistics($stadium->vars['id'],$game->vars['id']);  
   ?>
    
     <td  name="stadium_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="s_runs_<? echo $game->vars["id"]?>" >
	 <a class="normal_link" title="Stadium Runs"><? echo $stadium_stadistics->vars["runs"] ?></a> 
	  <div class="box">
          <BR><BR>
          <table>
            <? for ($jj = $year -3; $jj < $year; $jj++) { ?>  
            
            <tr >
              <td class="table_header"><strong><? echo $jj ?></strong></td>
               <td class="table_header"><? echo $stadiums_parkfactor_season[$stadium->vars["id"]."_".$jj]->vars["runs"]?></td>
            </tr> 
            <? } ?>
  
          </table>
        </div>
      </td>     
     
     <td  name="stadium_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="s_hr_<? echo $game->vars["id"]?>">
      <a class="normal_link" title="Stadium Home Runs"><? echo $stadium_stadistics->vars["homeruns"] ?></a> 
	  <div class="box">
          <BR><BR>
          <table>
            <? for ($jj = $year -3; $jj < $year; $jj++) { ?>  
            
            <tr >
              <td class="table_header"><strong><? echo $jj ?></strong></td>
               <td class="table_header"><? echo $stadiums_parkfactor_season[$stadium->vars["id"]."_".$jj]->vars["homeruns"]?></td>
            </tr> 
            <? } ?>
  
          </table>
        </div>
      </td>     
      
     <td  name="stadium_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="s_hits_<? echo $game->vars["id"]?>">
	 <a class="normal_link" title="Stadium Hits"><? echo $stadium_stadistics->vars["hits"] ?></a> 
	  <div class="box">
          <BR><BR>
          <table>
            <? for ($jj = $year -3; $jj < $year; $jj++) { ?>  
            
            <tr >
              <td class="table_header"><strong><? echo $jj ?></strong></td>
               <td class="table_header"><? echo $stadiums_parkfactor_season[$stadium->vars["id"]."_".$jj]->vars["hits"]?></td>
            </tr> 
            <? } ?>
  
          </table>
        </div>
      </td>     
       
     <td  name="stadium_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="s_doubles_<? echo $game->vars["id"]?>">
	  <a class="normal_link" title="Stadium Doubles"><? echo $stadium_stadistics->vars["doubles"] ?></a> 
	  <div class="box">
          <BR><BR>
          <table>
            <? for ($jj = $year -3; $jj < $year; $jj++) { ?>  
            
            <tr >
              <td class="table_header"><strong><? echo $jj ?></strong></td>
               <td class="table_header"><? echo $stadiums_parkfactor_season[$stadium->vars["id"]."_".$jj]->vars["2b"]?></td>
            </tr> 
            <? } ?>
  
          </table>
        </div>
     </td>     
      
     <td  name="stadium_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="s_triples_<? echo $game->vars["id"]?>" >
      <a class="normal_link" title="Stadium Triples"><? echo $stadium_stadistics->vars["triples"] ?></a> 
	  <div class="box">
          <BR><BR>
          <table>
            <? for ($jj = $year -3; $jj < $year; $jj++) { ?>  
            
            <tr >
              <td class="table_header"><strong><? echo $jj ?></strong></td>
               <td class="table_header"><? echo $stadiums_parkfactor_season[$stadium->vars["id"]."_".$jj]->vars["3b"]?></td>
            </tr> 
            <? } ?>
  
          </table>
        </div>
      </td>     
     
     <td  name="stadium_stadistics"  title="Stadium Walks" class="table_td<? echo $style ?>" style="font-size:12px;" id="s_walks_<? echo $game->vars["id"]?>">
     <a class="normal_link" title="Stadium Walks"><? echo $stadium_stadistics->vars["walks"] ?></a> 
	  <div class="box">
          <BR><BR>
          <table>
            <? for ($jj = $year -3; $jj < $year; $jj++) { ?>  
            
            <tr >
              <td class="table_header"><strong><? echo $jj ?></strong></td>
               <td class="table_header"><? echo $stadiums_parkfactor_season[$stadium->vars["id"]."_".$jj]->vars["bb"]?></td>
            </tr> 
            <? } ?>
  
          </table>
        </div>
     </td>   
  
  <td name="hide_stadium_stadistics" ></td>
  <td name="show_weather_stadistics" class="table_td1" ></td>   
     
 <? //weather  ?>    
   
           
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px; 
      <? if($stadium->vars["temp_cond"] != -1 && $game->vars["roof_open"] ) { 
	        $cond = explode("_",$stadium->vars["temp_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["temp"] <= $weather->vars["temp"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["temp"] > $weather->vars["temp"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo 'background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>"
      
      
      id="t<? echo $game->vars["id"]?>"><? echo $weather->vars["temp"] ?></td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" align="center" id="i<? echo $game->vars["id"]?>" >
      	<img src="<? echo $weather->vars["img_url"] ?>"><br />
      	<? echo $weather->vars["condition"] ?><br /><br /><a  target="_blank" title="Click to open an Hourly Forecast" href="http://www.weather.com/weather/hourbyhour/l/<? echo $stadium->vars["zip_code"]?>" >Hourly Forecast</a>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
      <? if($stadium->vars["humidity_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["humidity_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["humidity"] <= $weather->vars["humidity"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["humidity"] > $weather->vars["humidity"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>"
      id="h<? echo $game->vars["id"]?>">
	  	<? echo $weather->vars["humidity"] ?>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px; 
	  <? if($stadium->vars["wind_speed_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["wind_speed_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["wind_speed"] <= $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["wind_speed"] > $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>"
      id="ws<? echo $game->vars["id"]?>"><? echo $weather->vars["wind_speed"] ?>
      </td> 
         
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?> hoverTable" style="font-size:12px;<?
      
	   if ($weather->vars["wind_direction"] == $stadium->vars['wind_runs'] ||$weather->vars["wind_direction"] == $stadium->vars['wind_homeruns'] ){
		// echo ' background: green; ';  
		 }
	  ?>" align="center" id="wd<? echo $game->vars["id"]?>">
      
          <? /*<a href="<?= BASE_URL ?>/ck/baseball_file/stadium_wind_data.php?st=<? echo $stadium->vars["team_id"] ?>&wd=<? echo $weather->vars["wind_direction"] ?>" target="_blank" > */ ?>
		  <img src="images/s<? echo $stadium->vars["id"] ?>.jpg" width="98" height="98" />
          <? /* </a>  */ ?>
		  
		  <style>
			.box2{
				position: fixed;
				display: none;
				width: auto;
				height: auto;
				background-color: #ffffff;
				padding: 7px;
				z-index: 1500;
				left: 40%;
				top: 15%;
				box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-o-box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-ms-box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-moz-box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-webkit-box-shadow: 0 0 12px rgba(0,0,0,0.4);
			
			}
			
			.hoverTable:hover .box2{
				display: block;
			}
		  </style>
		  
		 <div class="box2">
		 <iframe src="<?= BASE_URL ?>/ck/baseball_file/stadium_wind_data.php?st=<? echo $stadium->vars["team_id"] ?>&wd=<? echo $weather->vars["wind_direction"]  ?>" width = "300px" height = "475px"></iframe>
		 </div>
       
        <br />
      <? if ($game->vars["manual_wind"]==0 || $game->vars["manual_wind"] == $stadium_position['id'] ){ ?>
        <div class="wind_direction_image" style="
         <? if($stadium->vars["wind_direction_green"] != "" && $game->vars["roof_open"]) { 
	         
			   $g_wind = explode(",",$stadium->vars["wind_direction_green"]);
			 if (in_array($weather->vars["wind_direction"],$g_wind)) { echo ' background-color:#9F6; '; } 
		    }
			if($stadium->vars["wind_direction_red"] != "" && $game->vars["roof_open"]) { 
			   $r_wind = explode(",",$stadium->vars["wind_direction_red"]);
			    if (in_array($weather->vars["wind_direction"],$r_wind)) { echo ' background-color:#F30; '; } 
			   
			}
		     
	        ?>"
        
        > <img src="images/<? echo $weather->vars["wind_direction"] ?>.png" width="98" height="98" /></div>
       
         <? echo $weather->vars["wind_direction"] ; /* if (in_array($weather->vars["wind_direction"],$g_wind)) { echo '  Ok  '; }  */ ?>
        
         <? }
         else{
			echo "Position was Manual Selected";
		 }?>
        

     </td> 
     
     <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="wp<? echo $game->vars["id"]?>">
	 	<? //display_div  <? echo $stadium_position["position"]
		$selected_position = $stadium_position['id']; 
		if ($game->vars["manual_wind"]){
			 
			 $selected_position = $game->vars["manual_wind"]; ?>
           <strong>Original:</strong> <? echo $stadium_position["position"] ?><BR/> 
		   <strong>Selected:</strong>
           <? if (!$game->started()){ ?>
           <a href="javascript:display_div('manual_position'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to change the position" ><? echo $manual_wind[$game->vars["manual_wind"]]->vars["position"] ?></a> 
           <? } 
           else{ echo $manual_wind[$game->vars["manual_wind"]]->vars["position"]; } ?>    
           
		<? }
		else{ ?>
		  <? if (!$game->started()){ ?> 
          <a href="javascript:display_div('manual_position'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to change the position" ><? echo $stadium_position["position"] ?></a> 	
          <? } 
           else{ echo $stadium_position["position"]; } ?>    
          
          
		<? } ?>
		<div id="manual_position<? echo $game->vars["id"]?>" style="display:none">	 
		<? create_objects_list("stadium_position", "stadium_position", $manual_wind, "id", "position", $default_name = "",$selected_position,"change_wind_position(".$game->vars['id'].",this.value)","_baseball_stadium_position");  ?>
        </div>
       </td>
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["wind_gust_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["wind_gust_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) {  
			
			    if($stadium->vars["wind_gust"] <= $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["wind_gust"] > $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>
       " id="wg<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["wind_gust"]?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["air_pressure_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["air_pressure_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["air_pressure"] <= $weather->vars["air_pressure"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["air_pressure"] > $weather->vars["air_pressure"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>
       " id="ai<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["air_pressure"]?>
       </td>
     
       <td name="weather_stadistics"  class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
         <? if($stadium->vars["dew_point_cond"] != -1 && $game->vars["roof_open"]) { 
	       	$cond = explode("_",$stadium->vars["dew_point_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["dew_point"] <= $weather->vars["dewpoint"] ) { echo ' background-color:'.$w_color.'; '; }
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 } 
	        } else {
				
			   if($stadium->vars["dew_point"] > $weather->vars["dewpoint"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>" id="dw<? echo $game->vars["id"]?>">
	 	<a class="normal_link"><? echo $weather->vars["dewpoint"] ?></a>
        <div class="box">
          <BR><BR>
          <table>
            <tr >
              <td class="table_header"><strong>Avg Dwpnt</strong></td>
               <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["avg_dewpoint"]?></td>
            </tr> 
            <tr >
              <td class="table_header"><strong>Avg R</strong></td>
              <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["avg_runs"]?></td>
              </tr>
              <tr >
              
              <td class="table_header"><strong>Avg HR</strong></td>
              <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["avg_homeruns"]?></td>
             </tr>
             <tr > 
              <td class="table_header"><strong>Games</strong></td>  
              <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["games"]?></td>                                           
             </tr>
  
          </table>
        </div>
       </td> 
       
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["dry_air_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["dry_air_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["dry_air"] <= $air_density ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["dry_air"] > $air_density ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>
       " id="air_d<? echo $game->vars["id"]?>">
	 	<? echo $air_density ?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["vapor_pressure_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["vapor_pressure_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) {  
			
			    if($stadium->vars["vapor_pressure"] <= $water_vapour ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["vapor_pressure"] > $water_vapour ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?> 
       " id="wat_v<? echo $game->vars["id"]?>">
	 	<? echo $water_vapour ?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
       <? if($stadium->vars["moist_air_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["moist_air_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["moist_air"] <= $moist_air_density ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["moist_air"] > $moist_air_density ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>  
       " id="air_m<? echo $game->vars["id"]?>">
	 	<? echo $moist_air_density ?>
       </td> 
       <? 
	   if ($roof) {	$pk_total = $pk_total + $pk; $game_count++; }
		
	   ?>
       <td name="weather_stadistics" class="table_td<? echo $style.$pkweather_style ?>" style="font-size:12px;" id="pk<? echo $game->vars["id"]?>">
	 	<? echo $pk ?>
       </td>
        
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
       <?  $w_color = "";
	     if($stadium->vars["aird_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["aird_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			   
			    if($stadium->vars["aird"] <= $weather->vars["aird"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { $test .= "B"; if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["aird"] > $weather->vars["aird"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>  
       " id="aird_<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["aird"]; ?>
       </td> 
       <?  
	     $data_stadium = "";
	     $data_stadium = @stadium_data_formula($pk,$weather->vars["air_pressure"],$std_formula[$stadium->vars["id"]]);
	   ?>
        <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="std<? echo $game->vars["id"]?>">
	 	<? echo $data_stadium["pk"] ?>
       </td>
        <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="std<? echo $game->vars["id"]?>">
	 	<? echo $data_stadium["airp"] ?>
       </td>
        <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="std<? echo $game->vars["id"]?>">
	 	<? echo $data_stadium["total"] ?>
       </td>
       
       <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="hrw<? echo $game->vars["id"]?>">
	 	<?
        if ($game->vars["hrw"] != "-1" ){ ?>
			 
			
           <strong>Selected:</strong> <? echo $game->vars["hrw"] ?><BR/> 
           <? // if (!$game->started()){ ?>
           <a href="javascript:display_div('manual_hrw'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to Change the hrw" >Change HWR</a> 
           <? /* } 
           else{ echo $game->vars["hrw"]; } */?>    
           
		<? }
		else{ ?>
		  <? /* if (!$game->started()){ */?> 
          <a href="javascript:display_div('manual_hrw'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to  Add the Hrw" >Add HRW</a> 	
          <? /* } 
           else{ 
		     if ($game->vars["hrw"] != "-1" ){
			    echo $game->vars["hrw"];
		     } else { echo "None";}
		   }*/
			 ?>    
          
          
		<? } ?>
		<div id="manual_hrw<? echo $game->vars["id"]?>" style="display:none">	 
		 <select name="hrw" onchange="change_hrw('<? echo $game->vars['id'] ?>',this.value)">
          <? for($h=0;$h<11; $h++){ ?>
           <option <? if ($game->vars["hrw"] == $h) { echo 'selected'; } ?> value="<? echo $h ?>"><? echo $h ?></option>
          <? } ?> 
           
         </select>
   	
        </div>
       </td> 
        <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="seal<? echo $game->vars["id"]?>">
	 	<?
        if ($game->vars["seal"] != "-1" ){ ?>
		<? if ($game->vars["seal"] == "1" ){ $seal = "Over"; } else { $seal = "Under"; }  ?>
			
           <strong>Selected:</strong> <? echo $seal ?><BR/> 
           <? // if (!$game->started()){ ?>
           <a href="javascript:display_div('manual_seal'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to Change the Seal" >Change Seal</a> 
           <? /* } 
           else{ echo $game->vars["hrw"]; } */?>    
           
		<? }
		else{ ?>
		  <? /* if (!$game->started()){ */?> 
          <a href="javascript:display_div('manual_seal'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to  Add the Seal" >Add Seal</a> 	
          <? /* } 
           else{ 
		     if ($game->vars["hrw"] != "-1" ){
			    echo $game->vars["hrw"];
		     } else { echo "None";}
		   }*/
			 ?>    
          
          
		<? } ?>
		<div id="manual_seal<? echo $game->vars["id"]?>" style="display:none">	 
		 <select name="seal" onchange="change_seal('<? echo $game->vars['id'] ?>',this.value)">
         
           <option <? if ($game->vars["seal"] == -1 ) { echo 'selected'; } ?> value="-1">Select</option>
           <option <? if ($game->vars["seal"] == 0 ) { echo 'selected'; } ?> value="0">Under</option>
           <option <? if ($game->vars["seal"] == 1 ) { echo 'selected'; } ?> value="1">Over</option>
           
         </select>
        
        </div>
       </td> 
     

       <td  name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="bubble_<? echo $game->vars["id"]?>"> 
      <a href="javascript:display_div('bub_<? echo $game->vars["id"] ?>')" class="normal_link" title="Bubble" >Set Bubble</a> 
          
		<div id="bub_<? echo $game->vars["id"] ?>" style="display:none">	 
		 <form  action="process/actions/change_bet.php" method="get">
          <input type="hidden" value="bub" name="type" id="type" />
         <input type="hidden" value="<? echo $game->vars["id"] ?>" name="game" id="game" />
         <textarea name="description" id="desc_bub<? echo $game->vars["id"] ?>" cols="18" rows="7"><? if ($game->vars["bub"] != "-1") { echo $game->vars["bub"]; } ?></textarea>
         <input type="button" name="submit" value="Save" onclick="set_bet('<? echo $game->vars["id"] ?>','bub')">
         </form>
   	
        </div>
	<? if (isset($games_bets[$game->vars["id"]])) { ?>
     
     <a href="<?= BASE_URL ?>/ck/baseball_file/bets.php?gid=<? echo $game->vars["id"] ?>" class="normal_link" rel="shadowbox;height=270;width=300"> View Bet</a>
    
    <? } ?>
    
</td>  
        

       <td name="hide_weather_stadistics" ></td>   
     
     <? //Player
	 
	 if (!$game->vars["pitcher_home"]){
		$fix = true;
	 }
      $ta_catcher = 0;
      $th_catcher = 0;	  
     if ($game->vars["pitcher_away"]){
		
		//$player_a= get_player_data_stadistics
		
		$player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
		//print_r($player_a);
	    $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);  
		$pitches_count_a = get_baseball_player_highest_pitches($game->vars["pitcher_away"]);
		$pitches_count_h = get_baseball_player_highest_pitches($game->vars["pitcher_home"]);		
		$stadistics_a = get_player_basic_stadistics($game->vars["pitcher_away"],$year,true,$game->vars["id"]);        if (is_null($stadistics_a)) { $stadistics_a = new _baseball_player_stadistics_by_game();}                  
        $stadistics_h = get_player_basic_stadistics($game->vars["pitcher_home"],$year,true,$game->vars["id"]);         if (is_null($stadistics_h)) { $stadistics_h = new _baseball_player_stadistics_by_game();}         
	    $player_name_a = $player_a->vars["player"];
	    $player_name_b =  $player_h->vars["player"];
		$catcher_a = get_baseball_player_by_id("fangraphs_player",$game->vars["catcher_home"]);
		//print_r($player_a);
	    $catcher_h = get_baseball_player_by_id("fangraphs_player",$game->vars["catcher_away"]); 
		$catcher_name_a =  $catcher_a->vars["player"];
	    $catcher_name_b =  $catcher_h->vars["player"];
		$ta_catcher = $pa_catchers[$game->vars["pitcher_away"]."_".$game->vars["catcher_home"]]["total"] + $ph_catchers[$game->vars["pitcher_away"]."_".$game->vars["catcher_home"]]["total"];
		$th_catcher = $pa_catchers[$game->vars["pitcher_home"]."_".$game->vars["catcher_away"]]["total"] + $ph_catchers[$game->vars["pitcher_home"]."_".$game->vars["catcher_away"]]["total"];
		
      }
      else{
	    $fix = true;
		$player_name_a = "";
	    $player_name_b = "";
	    $stadistics_a = array();
   	    $stadistics_h = array();
	    }
?>   

   

   
   
   
  
   <td name="show_umpire_stadistics" class="table_td1" ></td>      
<?   
/* Moved Up
    $yesterday = date ('Y-m-d',strtotime ( '-1 day' , strtotime ( $game->vars["startdate"]))) ;
    $firstbase=get_baseball_firstbase($game->vars["team_away"],$game->vars["team_home"],$yesterday);
	$firstbase_name = get_umpire_name_by_id($firstbase["firstbase"]); */

	if ($game->vars["umpire"]){
	     $umpire_statistics = get_umpire_stadistics($game->vars["umpire"],$year);
	     $umpire = $umpire_statistics[$year]->vars["full_name"];
	     
		 if ($firstbase["firstbase"]){
		  $umpire = $game->get_firstbase_comparison($firstbase["firstbase"]);
		 }
		 if($game->started()){     
           $umpire = $game->get_umpire_comparison();	
           ?><td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire  ?></td><?
	      }
	      else{
		 ?> 
         <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire   ?><BR>
          <? create_objects_list("umpire", "umpire", $umpires, "id", "umpire", $default_name = "",$game->vars["umpire"],"change_manual_umpire(".$game->vars['id'].",this.value)","_baseball_umpire"); ?>
         </td>
         <? } ?>  		  
	     <? for ($y=5;$y>-1;$y--){
			 
			  if (!$y){
			  $k_bb = $game->vars["umpire_kbb"];	 
			  }
			  else{			 
			  $k_bb= $umpire_statistics[$year-$y]->vars["k_bb"];
			  }
			 
			  
			   preg_match_all('/((?:\d+)(?:\.\d*)?)/',$column_desc[$year-$y]["description"],$matches);
			   $k_avg = $matches[0][0];
			   $color = "#000";
			   
			   if ($k_avg > $k_bb) { $color = "#0C3"; }
			   else { $color = "#F00"; }
			   
			   
			 
			  ?>	    
             <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $color ?>"><strong><? echo $k_bb  ?></strong></td>  
             <?
			 if (!$y){
			  $total_starts = $game->vars["umpire_starts"];	 
			  }
			  else{		
			 $total_starts = ($umpire_statistics[$year-$y]->vars["hw"] + $umpire_statistics[$year-$y]->vars["rw"]);
			  }
			 ?>	 
             <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" align="center"><? echo $total_starts ?></td>  	 
	     <? }
	  
	  }
	  else{
	     if ($firstbase_name["full_name"]){
		  $umpire = " FB: ".$firstbase_name["full_name"] .""; 
          $umpire_statistics = get_umpire_stadistics($firstbase["firstbase"],$year);
		   ?>
		  <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
		  <? echo $umpire   ?><BR>
          <? create_objects_list("umpire", "umpire", $umpires, "id", "umpire", $default_name = "",$firstbase["firstbase"],"change_manual_umpire(".$game->vars['id'].",this.value)","_baseball_umpire"); ?>
          </td>   
		  <?
            for ($y=5;$y>-1;$y--){ 
			
			  $k_bb= $umpire_statistics[$year-$y]->vars["k_bb"];
			   
			   preg_match_all('/((?:\d+)(?:\.\d*)?)/',$column_desc[$year-$y]["description"],$matches);
			   $k_avg = $matches[0][0];
			   $color = "#000";
			   
			   if ($k_avg > $k_bb) { $color = "#0C3"; }
			   else { $color = "#F00"; }
			  
			  
			  
			  
			  ?>	    
             <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $color ?>"><? echo $k_bb  ?></td>  	 
             <?
             
			 $total_starts = ($umpire_statistics[$year-$y]->vars["hw"] + $umpire_statistics[$year-$y]->vars["rw"]);
			 ?>
             
             <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" align="center"><? echo $total_starts ?></td>  	 
	       <? }
		
		    }
            else{
           	   
		      $umpire = "N/A";
              ?>
		      <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
		      <? create_objects_list("umpire", "umpire", $umpires, "id", "umpire", $default_name = "","","change_manual_umpire(".$game->vars['id'].",this.value)","_baseball_umpire"); ?>
		 	 <BR><? echo $umpire   ?></td>   
		     <?  
	         for ($y=5;$y>-1;$y--){ ?>	    
              <td name="umpire_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;"></td> 
              <td  name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"></td>  	
	          <? } 
            }
	    } ?>
        <?
		$ump_id = $game->vars["umpire"];
		$ump_value = $ump_data[$ump_id]["weighted_avg"];
		 // If there is not data for UMP. the value used is 2.35 According to Mike.
		if ($game->vars["umpire"] && $ump_data[$game->vars["umpire"]]["weighted_avg"] == 0 ){
		  $ump_value = 2.35;
		  
		}
		if ((!$game->vars["umpire"]) && ($firstbase["firstbase"]) ){
		   $ump_id = $firstbase["firstbase"];	
		   $ump_value = $ump_data[$ump_id]["weighted_avg"];
		   if ($ump_data[$ump_id]["weighted_avg"] == 0 ){
		    $ump_value = 2.35;
		   }
		
		}
		if ($game->vars["real_umpire"]){
			$ump_id = $game->vars["real_umpire"];	
		   $ump_value = $ump_data[$ump_id]["weighted_avg"];
		   if ($ump_data[$ump_id]["weighted_avg"] == 0 ){
		    $ump_value = 2.35;
		   }
		
		
		}
		
         
		?>
        
        
         <? $ump_weighted_total = $ump_weighted_total + $ump_value;
  		if ($ump_data[$ump_id]["weighted_avg"] < $column_desc["weig_avg"]["description"]) { $color = "#0C3"; }
			   else { $color = "#F00"; } 
		 
		 ?>
		<td  name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $color ?>"><? echo $ump_data[$ump_id]["weighted_avg"] ?></td>  
		<td  name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $ump_data[$ump_id]["volatility"]?></td>  
    
   <td name="hide_umpire_stadistics" ></td>   
   <td name="show_pitcher_stadistics" class="table_td1" ></td>     
   <td name="pitcher_stadistics" title="Pitcher <? echo $game->vars["away"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;" id="pitcher_a_<? echo $game->vars["id"]?>">
   
    <? if (!$game->started()){ ?> 
          <a href="javascript:display_div('manual_pitcher_away'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to change manually the pitcher" ><strong><? echo $player_name_a ?></strong></a> 
         	
          <? } 
           else{ echo "<strong>".$player_name_a."</strong>"; 
		   
		   
		   }?> 
		   <BR>
           <? if ($player_name_a != "" ){ ?>
           <a href="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_a->vars["espn_player"] ?>&name=<? echo $player_name_a ?>&img=<? echo $player_a->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_home->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_home->vars["team_name"]  ?>">Info</a><div class="box"><iframe src="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_a->vars["espn_player"] ?>&name=<? echo $player_name_a ?>&img=<? echo $player_a->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_home->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_home->vars["team_name"]  ?>" width = "550px" height = "500px"></iframe></div>
		   <? } ?>
		      
   
     <div id="manual_pitcher_away<? echo $game->vars["id"]?>" style="display:none">	 
		<? create_objects_list("pitcher_manual", "pitcher_manual", $players_team_away , "fangraphs_player", "espn_nick", $default_name = "",$game->vars["pitcher_away"],"change_manual_pitcher(".$game->vars['id'].",this.value,'away')","_baseball_player");  ?>
    </div>
    <? if ($last_game[$game->vars["pitcher_away"]]["location"] == "away" && $last_game[$game->vars["pitcher_away"]]["team"] == "58" ) { ?>
    <br>
    <div align="center" style="background-color:#396">  
    <span title="Last Game was played on Colorado">Colorado</span> 
    </div>
   <? } ?>
   
   <? if ($last_game[$game->vars["pitcher_away"]]["game_note"] != "" ) { ?>
    <br>
    <div style="background-color:#FC9">  
     <a href="javascript:display_div('note_pitcher_away'+<? echo $game->vars["id"]?>)" class="normal_link" title="<? echo $last_game[$game->vars["pitcher_away"]]["game_note"] ?>" ><strong>Last Game Note</strong></a> 
    </div>
   <? } ?>
   
    <div id="note_pitcher_away<? echo $game->vars["id"]?>" style="display:none">	 
	 <span style="font-size:9px"><BR>	
        <? echo $last_game[$game->vars["pitcher_away"]]["game_note"] ?> 
        <br>
        <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $last_game[$game->vars["pitcher_away"]]["espn_game"] ?>" class="normal_link" target="_blank"> Espn Box Score
</a>
    </span>
    </div>
  <BR><BR> 
    <?
	 if (trim($player_a->vars["throws"])== "L") {?>
    <a><img src="images/left_pitcher.png" title="LeftHander" style="width: 12px; float: right; margin-top: -40px;" >  
    </a>
    <div class="box"><strong>VS OPS</strong>
   <? echo $team_speed[$game->vars["team_home"]]->vars["ops"] ?></strong>(<span style=""><? echo $team_speed[$game->vars["team_home"]]->vars["rank_ops"] ?>/30</span>)
     </div>
    <? }?>
  <BR><BR>
      <? if (count($faceoff_away)>0) {?>
      <a href="" target="_blank" >
         <strong>#10</strong>
          </a>
<div class="box">
   <?
     foreach ($faceoff_away as $fa){?>
     <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $fa["espn_game"] ?>" class="normal_link" target="_blank"> Last Game</a>
	<?	
	  }
    ?>
 </div>
 <? }?>
    
   </td>   
 <?
 $last_game_color = "";
 $last_3game_color = "";
  if ($stadistics_a->vars['total_last_game'] >= 120){
   $last_game_color = "background-color: #6C9";
  }
 if ($stadistics_a->vars['sum_last_games'] >= 330){
  $last_3game_color = "background-color: #6C9";
 }
?>  
    <td name="pitcher_stadistics" title="Catcher <? echo $game->vars["away"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;" id="catcher_a_<? echo $game->vars["id"]?>">   <? if ($catcher_name_a != -1 ){ 
       echo $catcher_name_a;     
	   if ($ta_catcher > 0) { echo " (".$ta_catcher.")"; }
     } ?>
    </td> 
     <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
     <table>
       <tr>
         <td  title="GroundBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['gb'] ?></td>
       </tr>
       <tr>
        <td title="Total GroundBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['gb_total'] ?></td>
       </tr>
      </table>
    </td> 
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['era']?>
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['xfip']?>  
    <?
     $diff = ($stadistics_a->vars['era'] -  $stadistics_a->vars['xfip']);
	 if ($diff < 0 ) {$era_color = 'green';} else {$era_color = 'red';}
	?>     
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $era_color ?>"><strong><? echo $diff ?></strong>    

   
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
     <table>
       <tr>
         <td  title="k9" class="table_td<? echo $style ?>" style="font-size:12px;" id="k9_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['k9'] ?></td>
       </tr>
       <tr>
        <td title="Total K9" class="table_td<? echo $style ?>" style="font-size:12px;" id="k9_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['k9_total'] ?></td>
       </tr>
      </table>
    </td>
   
   
   
   
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['rest_time']?>
    </td>
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitches_count_a['pitch_count'] ?>
    </td>
    <td name="pitcher_stadistics" title="Pitches for the Last Game" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_game_color ?>" id="total_last_game_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['total_last_game'] ?></td>
    <td name="pitcher_stadistics" title="Total Pitches Last 3 Games" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_3game_color ?>" id="sum_last_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sum_last_games']?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 3 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_last_games']?></td> 
    <td name="pitcher_stadistics" title="Total Pitches Last 4 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_four_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sum_last_four_games']?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 4 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_four_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_last_four_games']?></td> 
 <td name="pitcher_stadistics" title="Total Pitches Last 5 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_five_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sum_last_five_games']?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 5 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_five_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_last_five_games']?></td>    
    <td name="pitcher_stadistics" title="Avg Pitches this Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_season_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_season']?></td> 
	<td name="pitcher_stadistics" title="Avg Pitches Last Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_season_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['last_season'] ?></td>
	
	<td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="FastBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="fb_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['fb'] ?></td>
       </tr>
         <tr>
        <td title="Total FastBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="fb_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['fb_total'] ?></td>
       </tr>
    </table>
    <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_home"]]->vars["rank_wfb"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_home"]]->vars["rank_wfb"] >= 10){$rank_color = "red"; }	  
	?>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="FB % Against <? echo $fangraphs_team_home->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_home"]]->vars["wfb"] ?></strong>  (<span style="color:<? echo $rank_color ?>"><? echo $team_speed[$game->vars["team_home"]]->vars["rank_wfb"] ?>/30</span>)</td>
    </td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td  title="Slider" class="table_td<? echo $style ?>" style="font-size:12px;" id="sl_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sl'] ?></td>
       </tr>
         <tr>
        <td title="Total Slider" class="table_td<? echo $style ?>" style="font-size:12px;" id="sl_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sl_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_home"]]->vars["rank_wsl"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_home"]]->vars["rank_wsl"] >= 10){$rank_color = "red"; }	  
	?>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="SL % Against <? echo $fangraphs_team_home->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_home"]]->vars["wsl"] ?></strong>  (<span style="color:<? echo $rank_color ?>"><? echo $team_speed[$game->vars["team_home"]]->vars["rank_wsl"] ?>/30</span>)</td>
    </td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Cutter" class="table_td<? echo $style ?>" style="font-size:12px;" id="ct_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['ct'] ?></td>
       </tr>
         <tr>
        <td title="Total Cutter" class="table_td<? echo $style ?>" style="font-size:12px;" id="ct_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['ct_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_home"]]->vars["rank_wct"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_home"]]->vars["rank_wct"] >= 10){$rank_color = "red"; }	  
	?>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="CT % Against <? echo $fangraphs_team_home->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_home"]]->vars["wct"] ?></strong>  (<span style="color:<? echo $rank_color ?>"><? echo $team_speed[$game->vars["team_home"]]->vars["rank_wct"] ?>/30</span>)</td>
    </td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="CurveBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="cb_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['cb'] ?></td>
       </tr>
         <tr>
        <td title="Total CurveBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="cb_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['cb_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_home"]]->vars["rank_wcb"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_home"]]->vars["rank_wcb"] >= 10){$rank_color = "red"; }	  
	?>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="CB % Against <? echo $fangraphs_team_home->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_home"]]->vars["wcb"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_home"]]->vars["rank_wcb"] ?>/30</span>)</td>
    </td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Changeup" class="table_td<? echo $style ?>" style="font-size:12px;" id="ch_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['ch'] ?></td>
       </tr>
         <tr>
        <td title="Total Changeup" class="table_td<? echo $style ?>" style="font-size:12px;" id="ch_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['ch_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_home"]]->vars["rank_wch"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_home"]]->vars["rank_wch"] >= 10){$rank_color = "red"; }	  
	?>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="CH % Against <? echo $fangraphs_team_home->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_home"]]->vars["wch"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_home"]]->vars["rank_wch"] ?>/30</span>)</td>
    </td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Split-Fingered" class="table_td<? echo $style ?>" style="font-size:12px;" id="sf_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sf'] ?></td>
       </tr>
         <tr>
        <td title="Total Split-Fingered" class="table_td<? echo $style ?>" style="font-size:12px;" id="sf_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sf_total'] ?></td>
       </tr>
    </table>
    </td> 
      <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_home"]]->vars["rank_wsf"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_home"]]->vars["rank_wsf"] >= 10){$rank_color = "red"; }	  
	?>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="SF % Against <? echo $fangraphs_team_home->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_home"]]->vars["wsf"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_home"]]->vars["rank_wsf"] ?>/30</span>)</td>
    </td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="KnuckleBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="kn_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['kn'] ?></td>
       </tr>
         <tr>
        <td title="Total KnuckleBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="kn_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['kn_total'] ?></td>
       </tr>
    </table>
    </td> 
      <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_home"]]->vars["rank_wkn"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_home"]]->vars["rank_wkn"] >= 10){$rank_color = "red"; }	  
	?>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="KN % Against <? echo $fangraphs_team_home->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_home"]]->vars["wkn"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_home"]]->vars["rank_wkn"] ?>/30</span>)</td>
    </td> 
     <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Unknown" class="table_td<? echo $style ?>" style="font-size:12px;" id="xx_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['xx'] ?></td>
       </tr>
         <tr>
        <td title="Total Unknown" class="table_td<? echo $style ?>" style="font-size:12px;" id="xx_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['xx_total'] ?></td>
       </tr>
    </table>
    </td>  
   <?
      $x = (myStrstrTrue($stadistics_a->vars['sl'],'%',true) + myStrstrTrue($stadistics_a->vars['ct'],'%',true) + myStrstrTrue($stadistics_a->vars['cb'],'%',true)) ;
      $xt = (myStrstrTrue($stadistics_a->vars['sl_total'],'%',true) + myStrstrTrue($stadistics_a->vars['ct_total'],'%',true) + myStrstrTrue($stadistics_a->vars['cb_total'],'%',true)) ;
   
   ?> 
    
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Sum Scc" class="table_td<? echo $style ?>" style="font-size:12px;" id="x_a_<? echo $game->vars["id"]?>"><? echo number_format($x,2) ?> %</td>
       </tr>
         <tr>
        <td title="Total Sum Scc" class="table_td<? echo $style ?>" style="font-size:12px;" id="x_total_a_<? echo $game->vars["id"]?>"><? echo number_format($xt,2) ?> %</td>
       </tr>
    </table>
    </td> 
    
    <td name="pitcher_stadistics" title="FastBall Velocity 2 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity1_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['last_two_game_velocity'] ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity last Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity2_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['last_game_velocity'] ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity This Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity_season_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['season_velocity'] ?></td>
	
    
    
  	<td name="pitcher_stadistics" title="Pitcher <? echo $game->vars["home"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;"  id="pitcher_b_<? echo $game->vars["id"]?>">
    
     <? if (!$game->started()){ ?> 
          <a href="javascript:display_div('manual_pitcher_home'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to change manually the pitcher" ><strong><? echo $player_name_b ?></strong></a> 	
          <? } 
           else{ echo "<strong>".$player_name_b."</strong>"; } ?> 
       
    <? if ($player_name_b != "" ){ ?>        
   <BR><a href="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_h->vars["espn_player"] ?>&name=<? echo $player_name_b ?>&img=<? echo $player_h->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_away->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_away->vars["team_name"]  ?>">Info</a><div class="box"><iframe src="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_h->vars["espn_player"] ?>&name=<? echo $player_name_b ?>&img=<? echo $player_h->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_away->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_away->vars["team_name"]  ?>" width = "550px" height = "500px"></iframe></div>
   <? } ?>
   
     <div id="manual_pitcher_home<? echo $game->vars["id"]?>" style="display:none">	 
		<? create_objects_list("pitcher_manual", "pitcher_manual", $players_team_home , "fangraphs_player", "espn_nick", $default_name = "",$game->vars["pitcher_home"],"change_manual_pitcher(".$game->vars['id'].",this.value,'home')","_baseball_player");  ?>
    </div>
    
     <? if ($last_game[$game->vars["pitcher_home"]]["location"] == "away" && $last_game[$game->vars["pitcher_home"]]["team"] == "58" ) { ?>
    <br>
    <div align="center" style="background-color:#396">  
    <span title="Last Game was played on Colorado">Colorado</span> 
    </div>
   <? } ?>
    
     <? if ($last_game[$game->vars["pitcher_home"]]["game_note"] != "" ) { ?>
    <br>
    <div style="background-color:#FC9">  
     <a href="javascript:display_div('note_pitcher_home'+<? echo $game->vars["id"]?>)" class="normal_link" title="<? echo $last_game[$game->vars["pitcher_home"]]["game_note"] ?>" ><strong>Last Game Note</strong></a> 
    </div>
   <? } ?>
   
    <div id="note_pitcher_home<? echo $game->vars["id"]?>" style="display:none">	 
		<span style="font-size:9px"><BR>
        <? echo $last_game[$game->vars["pitcher_home"]]["game_note"] ?> 
        
        <br>
        <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $last_game[$game->vars["pitcher_home"]]["espn_game"] ?>" class="normal_link" target="_blank"> Espn Box Score
</a>
</span>
    </div>
     <BR><BR> 
    <?
	 if (trim($player_h->vars["throws"])== "L") {?>
    <a><img src="images/left_pitcher.png" title="LeftHander" style="width: 12px; float: right; margin-top: -40px;" >  
    </a>
    <div class="box"><strong>VS OPS</strong>
   <? echo $team_speed[$game->vars["team_away"]]->vars["ops"] ?></strong>(<span style=""><? echo $team_speed[$game->vars["team_away"]]->vars["rank_ops"] ?>/30</span>)
     </div>
    <? }?>
    
    <BR><BR>
      <? if (count($faceoff_away)>0) {?>
      <a href="" target="_blank" >
         <strong>#10</strong>
          </a>
  <div class="box">
   <?
     foreach ($faceoff_away as $fa){?>
     <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $fa["espn_game"] ?>" class="normal_link" target="_blank"> Last Game</a>
	<?	
	  }
    ?>
 </div>
 <? }?>
    
    
  </td> 
<?
 $last_game_color = "";
 $last_3game_color = "";
  if ($stadistics_h->vars['total_last_game'] >= 120){
   $last_game_color = "background-color: #6C9";
  }
 if ($stadistics_h->vars['sum_last_games'] >= 330){
  $last_3game_color = "background-color: #6C9";
 }
?>   
 <td name="pitcher_stadistics" title="Catcher <? echo $game->vars["home"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;" id="catcher_h_<? echo $game->vars["id"]?>">
  <? if ($catcher_name_b != -1 ){ 
       echo $catcher_name_b; 
	   if ($th_catcher > 0) { echo " (".$ta_catcher.")"; }    
     } ?></td> 
   <td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td  title="GroundBalls"  class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['gb'] ?></td>
       </tr>
         <tr>
        <td title="Total GroundBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['gb_total'] ?></td>
       </tr>
     </table>  
     </td> 
 <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['era']?>
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['xfip']?>  
    <?
     $diff = ($stadistics_h->vars['era'] -  $stadistics_h->vars['xfip']);
	 if ($diff < 0 ) {$era_color = 'green';} else {$era_color = 'red';}
	?>     
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $era_color ?>"><strong><? echo $diff ?></strong>      
    
     <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
     <table>
       <tr>
         <td  title="k9" class="table_td<? echo $style ?>" style="font-size:12px;" id="k9_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['k9'] ?></td>
       </tr>
       <tr>
       <td title="Total K9" class="table_td<? echo $style ?>" style="font-size:12px;" id="k9_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['k9_total'] ?></td>
       </tr>
      </table>
    </td>
    
    <td name="pitcher_stadistics" title="" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['rest_time']?>
    </td>
        <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitches_count_h['pitch_count'] ?>
    </td>
    <td name="pitcher_stadistics" title="Pitches for the Last Game" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_game_color ?>" id="total_last_game_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['total_last_game'] ?></td>
    <td name="pitcher_stadistics" title="Total Pitches Last 3 Games" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_3game_color ?>" id="sum_last_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sum_last_games']?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 3 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_last_games']?></td> 
    <td name="pitcher_stadistics" title="Total Pitches Last 4 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_four_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sum_last_four_games']?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 4 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_four_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_last_four_games']?></td> 
 <td name="pitcher_stadistics" title="Total Pitches Last 5 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_five_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sum_last_five_games']?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 5 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_five_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_last_five_games']?></td>      
    <td name="pitcher_stadistics" title="Avg Pitches this Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_season_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_season']?></td> 
	<td name="pitcher_stadistics" title="Avg Pitches Last Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_season_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['last_season'] ?></td>
	
	<td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="FastBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="fb_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['fb'] ?></td>
       </tr>
         <tr>
        <td title="Total FastBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="fb_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['fb_total'] ?></td>
       </tr>
    </table>
    </td>
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_away"]]->vars["rank_wfb"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_away"]]->vars["rank_wfb"] >= 10){$rank_color = "red"; }	  
	?>
        <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="FB % Against <? echo $fangraphs_team_away->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_away"]]->vars["wfb"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_away"]]->vars["rank_wfb"] ?>/30</span>)</td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Slider" class="table_td<? echo $style ?>" style="font-size:12px;" id="sl_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sl'] ?></td>
       </tr>
         <tr>
        <td title="Total Slider" class="table_td<? echo $style ?>" style="font-size:12px;" id="sl_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sl_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_away"]]->vars["rank_wsl"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_away"]]->vars["rank_wsl"] >= 10){$rank_color = "red"; }	  
	?>
      <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="SL % Against <? echo $fangraphs_team_away->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_away"]]->vars["wsl"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_away"]]->vars["rank_wsl"] ?>/30</span>)</td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Cutter" class="table_td<? echo $style ?>" style="font-size:12px;" id="ct_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['ct'] ?></td>
       </tr>
         <tr>
        <td title="Total Cutter" class="table_td<? echo $style ?>" style="font-size:12px;" id="ct_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['ct_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_away"]]->vars["rank_wct"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_away"]]->vars["rank_wct"] >= 10){$rank_color = "red"; }	  
	?>
      <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="CT % Against <? echo $fangraphs_team_away->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_away"]]->vars["wct"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_away"]]->vars["rank_wct"] ?>/30</span>)</td> 
    <td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="CurveBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="cb_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['cb'] ?></td>
       </tr>
         <tr>
        <td title="Total CurveBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="cb_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['cb_total'] ?></td>
       </tr>
    </table>
    </td> 
    <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_away"]]->vars["rank_wcb"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_away"]]->vars["rank_wcb"] >= 10){$rank_color = "red"; }	  
	?>
      <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="CB % Against <? echo $fangraphs_team_away->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_away"]]->vars["wcb"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_away"]]->vars["rank_wcb"] ?>/30</span>)</td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Changeup" class="table_td<? echo $style ?>" style="font-size:12px;" id="ch_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['ch'] ?></td>
       </tr>
         <tr>
        <td title="Total Changeup" class="table_td<? echo $style ?>" style="font-size:12px;" id="ch_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['ch_total'] ?></td>
       </tr>
    </table>
    </td> 
    <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_away"]]->vars["rank_wch"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_away"]]->vars["rank_wch"] >= 10){$rank_color = "red"; }	  
	?>
      <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="CH % Against <? echo $fangraphs_team_away->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_away"]]->vars["wch"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_away"]]->vars["rank_wch"] ?>/30</span>)</td> 
    <td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Split-Fingered" class="table_td<? echo $style ?>" style="font-size:12px;" id="sf_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sf'] ?></td>
       </tr>
         <tr>
        <td title="Total Split-Fingered" class="table_td<? echo $style ?>" style="font-size:12px;" id="sf_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sf_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_away"]]->vars["rank_wsf"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_away"]]->vars["rank_wsf"] >= 10){$rank_color = "red"; }	  
	?>
      <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="SF % Against <? echo $fangraphs_team_away->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_away"]]->vars["wsf"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_away"]]->vars["rank_wsf"] ?>/30</span>)</td> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="KnuckleBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="kn_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['kn'] ?></td>
       </tr>
         <tr>
        <td title="Total KnuckleBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="kn_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['kn_total'] ?></td>
       </tr>
    </table>
    </td> 
     <?
	    $rank_color = "black"; 
	    if($team_speed[$game->vars["team_away"]]->vars["rank_wkn"] <= 10){$rank_color = "#1af11a"; }
        if($team_speed[$game->vars["team_away"]]->vars["rank_wkn"] >= 10){$rank_color = "red"; }	  
	?>
      <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" title="KN % Against <? echo $fangraphs_team_away->vars["espn_small_name"] ?>"><strong><? echo $team_speed[$game->vars["team_away"]]->vars["wkn"] ?></strong>  (<span style="color:<? echo $rank_color ?>"> <? echo $team_speed[$game->vars["team_away"]]->vars["rank_wkn"] ?>/30</span>)</td> 
     <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Unknown" class="table_td<? echo $style ?>" style="font-size:12px;" id="xx_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['xx'] ?></td>
       </tr>
         <tr>
        <td title="Total Unknown" class="table_td<? echo $style ?>" style="font-size:12px;" id="xx_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['xx_total'] ?></td>
       </tr>
    </table>
    </td>  
    
    <?
      $x = (myStrstrTrue($stadistics_h->vars['sl'],'%',true) + myStrstrTrue($stadistics_h->vars['ct'],'%',true) + myStrstrTrue($stadistics_h->vars['cb'],'%',true)) ;
      $xt = (myStrstrTrue($stadistics_h->vars['sl_total'],'%',true) + myStrstrTrue($stadistics_h->vars['ct_total'],'%',true) + myStrstrTrue($stadistics_h->vars['cb_total'],'%',true)) ;
   ?> 
    
      <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td title="Sum Scc" class="table_td<? echo $style ?>" style="font-size:12px;" id="x_h_<? echo $game->vars["id"]?>"><? echo number_format($x,2) ?> %</td>
       </tr>
         <tr>
        <td title="Total Sum Scc" class="table_td<? echo $style ?>" style="font-size:12px;" id="x_total_h_<? echo $game->vars["id"]?>"><? echo number_format($xt,2) ?> %</td>
       </tr>
    </table>
    </td> 
    
     <td name="pitcher_stadistics" title="FastBall Velocity 2 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity1_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['last_two_game_velocity'] ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity last Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity2_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['last_game_velocity'] ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity This Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity_season_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['season_velocity'] ?></td>
    
   <td name="hide_pitcher_stadistics" ></td>  
   <td name="show_bullpen_stadistics" class="table_td1" ></td>
   
     <td  title="Pitching ERA Away" name="bullpen_stadistics"   class="table_td<? echo $style ?>" style="font-size:12px;color:<? echo $baip_color ?>" id="ip_a_<? echo $game->vars["id"]?>"></td>
     <td  title="Pitching ERA Home" name="bullpen_stadistics"   class="table_td<? echo $style ?>" style="font-size:12px;color:<? echo $baip_color ?>" id="ip_a_<? echo $game->vars["id"]?>"></td>
         
 <?  //Bullpen 3 days
	
	$bullpen_a = get_team_bullpen($game->vars["team_away"],$date,3);
	$bullpen_h = get_team_bullpen($game->vars["team_home"],$date,3);
	
	 if ($bullpen_a->vars['ip'] > 10 ) { $baip_color = "#0C3"; }
			   else { $baip_color = "#F00"; }
	 if ($bullpen_h->vars['ip'] > 10 ) { $bhip_color = "#0C3"; }
			   else { $bhip_color = "#F00"; }
	 if ($bullpen_a->vars['pc'] > 200 ) { $bapc_color = "#0C3"; }
			   else { $bapc_color = "#F00"; }	
			   
	 if ($bullpen_h->vars['pc'] > 200 ) { $bhpc_color = "#0C3"; }
			   else { $bhpc_color = "#F00"; }			   	   
?>
    <td  title="Bullpen IP" name="bullpen_stadistics"   class="table_td<? echo $style ?>" style="font-size:12px;color:<? echo $baip_color ?>" id="ip_a_<? echo $game->vars["id"]?>"><? echo $bullpen_a->vars['ip'] ?></td>
    <td  title="Bullpen PC" name="bullpen_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;;color:<? echo $bapc_color ?>" id="pc_a_<? echo $game->vars["id"]?>" ><? echo $bullpen_a->vars['pc'] ?></td>
    <td title="Bullpen IP" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;color:<? echo $bhip_color ?>" id="ip_h_<? echo $game->vars["id"]?>" ><? echo $bullpen_h->vars['ip'] ?></td>
    <td title="Bullpen PC" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;;color:<? echo $bhpc_color ?>" id="pc_h_<? echo $game->vars["id"]?>" ><? echo $bullpen_h->vars['pc'] ?></td>
    <td title="Bullpen IP" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ipt_h_<? echo $game->vars["id"] ?>" ><? echo number_format($bullpen_a->vars['ip'] +  $bullpen_h->vars['ip'],1) ?></td>
    <td title="Bullpen PC" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pct_h_<? echo $game->vars["id"] ?>" ><? echo $bullpen_a->vars['pc'] + $bullpen_h->vars['pc'] ?></td>           
  
  <? //Bullpen this season
   $bullpen_season_a = get_team_bullpen_season($game->vars["team_away"],$season['start'],$date); 
   $bullpen_season_h = get_team_bullpen_season($game->vars["team_home"],$season['start'],$date); 
  
  ?>
    <td name="bullpen_stadistics"  title="Bullpen IP This Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="ip_a_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_a["IP"] ?></td>
    <td name="bullpen_stadistics" title="Bullpen PC This Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pc_a_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_a["PC"] ?></td>
    <td name="bullpen_stadistics" title="Bullpen IP This Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ip_h_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_h["IP"] ?></td>
    <td name="bullpen_stadistics" title="Bullpen PC This Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pc_h_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_h["PC"] ?></td>  
    
      <td name="bullpen_stadistics" title="Bullpen Rank A"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ip_h_season<? echo $game->vars["id"]?>"><? echo $stadium_away->vars["bullpen_rank"] ?></td>
    <td name="bullpen_stadistics" title="Bullpen Rank H"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pc_h_season<? echo $game->vars["id"]?>"><? echo $stadium->vars["bullpen_rank"] ?></td> 
    
    
    
        <td name="bullpen_stadistics" title="Errors A"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ip_h_season<? echo $game->vars["id"]?>"><? echo $stadium_away->vars["error_rank"] ?></td>
    <td name="bullpen_stadistics" title="Erros H"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pc_h_season<? echo $game->vars["id"]?>"><? echo $stadium->vars["error_rank"] ?></td>   
  
<td name="hide_bullpen_stadistics" ></td>         
     
  
  <?  // ten

 $ten_aa = get_baseball_scores_ten($game->vars["team_away"],"away",$date);
 $ten_ah = get_baseball_scores_ten($game->vars["team_away"],"home",$date);
 $ten_ha = get_baseball_scores_ten($game->vars["team_home"],"away",$date);
 $ten_hh = get_baseball_scores_ten($game->vars["team_home"],"home",$date);
  
 if ($ten_aa["lose_ten"] == "YES" || $ten_ah["lose_ten"] == "YES"){
   $ten_away = "Yes"	;
 }
 else{
   $ten_away = "No"	;	  
 }
	 
 if ($ten_ha["lose_ten"] == "YES" || $ten_hh["lose_ten"] == "YES"){
  $ten_home = "Yes"	;
 }
 else{
  $ten_home = "No"	;	  
 }	  
 
 ?>
    
 <td name="show_ten_stadistics" class="table_td1" ></td>        
      
 <td name="ten_stadistics" title="Team lose +10"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ten_a_<? echo $game->vars["id"]?>"><? echo $ten_away ?></td>    
 <td name="ten_stadistics" title="Team lose +10" class="table_td<? echo $style ?>" style="font-size:12px;" id="ten_h_<? echo $game->vars["id"]?>"><? echo  $ten_home  ?></td>    
 <td name="hide_ten_stadistics" ></td>              
 <td name="show_lines_stadistics" class="table_td1"></td>     
  
      <td name="lines_stadistics" title="Money Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="money_a_<? echo $game->vars["id"]?>"><? echo $lines_game[$game->vars["away_rotation"]]->vars["away_money"] ?></td>  
      
       <td name="lines_stadistics" title="Money Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="money_h_<? echo $game->vars["id"]?>"><? echo $lines_game[$game->vars["away_rotation"]]->vars["home_money"] ?></td>  

     <?
	    $over_game =  prepare_line($lines_game[$game->vars["away_rotation"]]->vars["away_total"]);
		$under_game = prepare_line($lines_game[$game->vars["away_rotation"]]->vars["home_total"]);  
	 ?>
     
      <td name="lines_stadistics" title="Total Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_a_<? echo $game->vars["id"]?>"><?   echo $over_game["line"] ?>
       </td> 
      
       <td name="lines_stadistics" title="Total Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_o_<? echo $game->vars["id"]?>"><? echo $over_game["juice"] ?></td> 
     
      <td name="lines_stadistics" title="Total Under" class="table_td<? echo $style ?>" style="font-size:12px;" id="under_<? echo $game->vars["id"]?>" ><? echo $under_game["line"] ?></td> 
      
             <td name="lines_stadistics" title="Total Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_u_<? echo $game->vars["id"]?>"><? echo  $under_game["juice"] ?></td> 
             
     <?php /*?>        
      <?
	    $over_innings =  prepare_line($lines_innings[$game->vars["away_rotation"]]->vars["away_total"]);
		$under_innings = prepare_line($lines_innings[$game->vars["away_rotation"]]->vars["home_total"]);  
	    $money_innings_away s= $lines_innings[$game->vars["away_rotation"]]->vars["away_money"];
        $money_innings_home = $lines_innings[$game->vars["away_rotation"]]->vars["home_money"];
	    //print_r($lines_innings[$game->vars["away_rotation"]]);
		//break;
	 ?>
      <td name="lines_stadistics" title="Money 1st 5 Innings Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_ai_<? echo $game->vars["id"]?>"><?   echo $money_innings_away  ?>
       </td> 
       
        <td name="lines_stadistics" title="Money 1st 5 Innings Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_ai_<? echo $game->vars["id"]?>"><?   echo $money_innings_home ?>
       </td> 
     
      <td name="lines_stadistics" title="Total 1st 5 Innings Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_ai_<? echo $game->vars["id"]?>"><?   echo $over_innings["line"] ?>
       </td> 
      
       <td name="lines_stadistics" title="Total 1st 5 Innings Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_oi_<? echo $game->vars["id"]?>"><? echo $over_innings["juice"] ?></td> 
     
      <td name="lines_stadistics" title="Total 1st 5 Innings Under"  class="table_td<? echo $style ?>" style="font-size:12px;" id="under_i_<? echo $game->vars["id"]?>"><? echo $under_innings["line"] ?></td> 
      
          <td  name="lines_stadistics" title="Total 1st 5 Innings Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_ui_<? echo $game->vars["id"]?>" ><? echo  $under_innings["juice"] ?></td> 
<?
//Team Total lines
 $team_line_away = get_sbo_team_line($game->vars["team_away"],$date);
 $team_line_home = get_sbo_team_line($game->vars["team_home"],$date);

?>     
 <td name="lines_stadistics" title="Total Team Away Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_o_<? echo $game->vars["id"]?>" ><? echo  $team_line_away["total_over"] ?></td> 
 
  <td name="lines_stadistics" title="Total Team Away Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_oj_<? echo $game->vars["id"]?>" ><? echo  $team_line_away["over_odds"] ?></td> 

 <td name="lines_stadistics" title="Total Team Away Under" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_u_<? echo $game->vars["id"]?>"><? echo  $team_line_away["total_under"] ?></td>         
 
 <td name="lines_stadistics" title="Total Team Away Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_uj_<? echo $game->vars["id"]?>"><? echo  $team_line_away["under_odds"] ?></td> 
 
  <td name="lines_stadistics" title="Total Team Home Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_o_<? echo $game->vars["id"]?>"><? echo  $team_line_home["total_over"] ?></td> 
 
  <td name="lines_stadistics" title="Total Team Home Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_oj_<? echo $game->vars["id"]?>"><? echo  $team_line_home["over_odds"] ?></td> 

 <td name="lines_stadistics" title="Total Team Home Under" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_u_<? echo $game->vars["id"]?>"><? echo  $team_line_home["total_under"] ?></td>         
 
 <td name="lines_stadistics" title="Total Team Home Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_uj_<? echo $game->vars["id"]?>"><? echo  $team_line_home["under_odds"] ?></td> 
 <?php */?>
 
<td name="hide_lines_stadistics" ></td>  
<td name="show_game_stadistics" class="table_td1"></td>     

       <td name="game_stadistics" title="Total of HomeRuns'"  class="table_td<? echo $style ?>" style="font-size:12px;" id="t_h_<? echo $game->vars["id"]?>">
       <? if (($game->vars["homeruns_away"] + $game->vars["homeruns_home"])>=0) { 
        	   echo  ($game->vars["homeruns_away"] + $game->vars["homeruns_home"]); 
	   } else{
		   echo "0";
	   }
	   ?>
       
       </td>      
 
    
     <td  name="game_stadistics" title="Runs Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="runs_a_<? echo $game->vars["id"]?>"><? echo  $game->vars["runs_away"] ?></td>  
     
     <td  name="game_stadistics" title="Runs Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="runs_h_<? echo $game->vars["id"]?>" ><? echo  $game->vars["runs_home"] ?></td>  
     
     <td name="game_stadistics" title="Game Runs" class="table_td<? echo $style ?>" style="font-size:12px;" id="game_runs_<? echo $game->vars["id"]?>"><? echo  ($game->vars["runs_away"] + $game->vars["runs_home"]) ?></td>  
     
     <td name="game_stadistics" title="Final Score" class="table_td<? echo $style ?>" style="font-size:12px;" id="score_<? echo $game->vars["id"]?>" ><? echo  $game->vars["runs_away"]." - ".$game->vars["runs_home"]?>  </td>  
      
<td name="hide_game_stadistics" ></td>           
      
      

<td   class="table_td<? echo $style ?>" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>"><a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $game->vars["espn_game"] ?>" class="normal_link" target="_blank"> Espn Box Score
</a>
</td>   
     
</tr>  

<? } ?>
   
 <tr>
  <td class="table_last" colspan="1000"></td>
  </tr>
  </tbody>
</table>
<div id="bottom_anchor"></div>
</div>
   <? if (count($games)>6) { ?>
  <BR>
   &nbsp;&nbsp;&nbsp; 
   <a href="javascript:;" onclick="move_scroll('up');" title="Go Up"><img src="images/arrow_up.png" width="20px" onclick="move_scroll('up');"  id="up1"  title="Go Up" /></a>
    <a href="javascript:;" onclick="move_scroll('down');" title="Go Down"><img src="images/arrow_down.png" width="20px" onclick="move_scroll('down');"  /></a>
   <? } ?>


 <script> 
 //Hide all the Show Arrows at beggining 
 show_hide_column( "baseball","show_stadium_stadistics",false,0);
 show_hide_column( "baseball","show_weather_stadistics",false,0);
// show_hide_column( "baseball","show_groundball_stadistics",false,0);
 show_hide_column( "baseball","show_umpire_stadistics",false,0);
 show_hide_column( "baseball","show_pitcher_stadistics",false,0);
 show_hide_column( "baseball","show_bullpen_stadistics",false,0);
 show_hide_column( "baseball","show_lines_stadistics",false,0);
 show_hide_column( "baseball","show_game_stadistics",false,0);
 show_hide_column( "baseball","show_ten_stadistics",false,0);
 
 </script> 
 <? if ($fix){ ?>
	 <script>
	fix_changes();
	 </script> 
<? } ?>
<?
if (count($games) != 0){
	if (date("Y-m-d") == $from) {
		$grand_salami = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_mlb_grandSalami.php?date=".$from));
		$salami_over = "o".$grand_salami->TotalOver." ".$grand_salami->OverOdds;
		$salami_under = "u".$grand_salami->TotalUnder." ".$grand_salami->UnderOdds;
		if($game_count > 0){
     $pk_avg = number_format($pk_total/$game_count,2);
    }
		
		
		if($ump_weighted_total) {
		 $ump_avg = number_format($ump_weighted_total/count($games),2);
		} else {$ump_avg = 0;}
	  
	}else {
		$stat = get_baseball_stats($from);
		$salami_over = $stat->vars["grand_salami_over"];
		$salami_under = $stat->vars["grand_salami_under"];
		$pk_avg = $stat->vars["pk_avg"];
		$ump_avg = $stat->vars["ump_weighted_avg"];
	}
	
	
	?>
	
	<BR><BR>
	<span><strong>Baseball Stats</strong></span>
	<BR>
	<table  width="300px" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="120"  class="table_header" align="center" >Grand Salami</td>
				<td width="120"  class="table_header" align="center" >PK AVG</td>
				<td width="120"  class="table_header" align="center" >UMP W. AVG</td>
				
			  </tr>  
			  <tr>
			   <td class="table_td1" style="font-size:12px;">
			   <table align="center">
			   <tr>
				<td><? echo $salami_over ?></td>
			   </tr>
			   <tr>
				<td><? echo $salami_under ?></td>
			   </tr>
			   </table>
			   
			   </td> 
			   <td class="table_td1" style="font-size:12px;" align="center"><? echo $pk_avg ?></td> 
			  <td class="table_td1" style="font-size:12px;" align="center"><? echo $ump_avg	?></td>      
			  </tr>
	</table>
<? } else { ?>
    <BR><BR>
	<span><strong>No games for Today</strong></span>
    <? }?>

</div>



<?php /*?><script src="../includes/js/jquery-1.8.3.min.js"></script> <?php */?> 
 

<script type="text/javascript" src="../includes/js/jquery.freezeheader.js"></script>
  <script>

$(document).ready(function () {

$("#baseball").freezeHeader({ 'height': '780px' });

})





</script>
  
</script>  

 <script type="text/javascript">
		
		function move_scroll(side){
			
			var step = 350;
			var thediv = document.getElementById('hdScrollbaseball');
			//document.getElementById("up").style.display = "block";
			
			if(side == 'up'){
				$("#hdScrollbaseball").animate({scrollTop: thediv.scrollTop - step},  'fast');
			}else{
			
				$("#hdScrollbaseball").animate({scrollTop: thediv.scrollTop + step}, 'fast')
			}
		}
		
		
 </script>


 <script>
   $( function() {
     $( ".draggable" ).draggable();
   } );
 </script>

 <script>

     $(document).ready(function(){
      var wrapper1 = document.getElementById('wrapper1');
      var myhtml = document.getElementById('myhtml');
      wrapper1.onscroll = function() {
        myhtml.scrollLeft = wrapper1.scrollLeft;
      };

      myhtml.onscroll = function() { alert(2);
        wrapper1.scrollLeft = myhtml.scrollLeft;
      };
     });

 </script>
        
</body>
<? //aca si nece modificar le estyle de eso,,,le pasa info a la variable $site_style --siga..?>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>
