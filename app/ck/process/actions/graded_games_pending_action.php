<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
$action = param('action');



 switch ($action) {
 	case 'league':
 		$id = param('id');
 		$min = param('min');
 		$league = get_league_graded_time($id);
 		$league->vars['time'] = $min;
 		$data['control'] = $league->update(array('time'));
 		echo json_encode($data);
 		break;


     case 'leagues':
 		$leagues = get_leagues_graded_time();
        
        $html =  '<table  width="700" border="0" cellspacing="0" cellpadding="0">';
   	    $html .= '<thead style="margin-bottom: 10px">';
   	    $html .= '<tr>';
   	 	$html .= '<td><strong> LEAGUE</strong> </td>';
   	 	$html .= '<td><strong> MINUTES</strong> </td>';	
   	   	$html .= '</tr>';	
   	    $html .= '<tr style="height: 10px !important; /* overwrites any other rules */">';
        $html .= '<td colspan="2"></td>';
    	$html .= '</tr>';
   		$html .= '</thead>';
       foreach($leagues	as $l){ 
   	  	 $html .= '<tr>';
   	  	 $html .= '<td>'.$l->vars['league'].'</td>';
   	  	 $html .= '<td> <input class="minute" style="font-size: 22; width: 70px;" data-id ="'.$l->vars['id'].'" id="minute" type="number" value="'.$l->vars['time'].'"/></td>';   	    
   	  	 $html .= '<tr>';	
		}
     	$html .= '</table>';
 		$data['html'] = $html;
 		echo json_encode($data);
 		break;

      case 'filters':
		 $leagues = get_leagues_graded_time();
         $html = '<strong>  League:</strong>';
         $html .= '<select id="sel_league" style="font-size: 22;">';
 	     
 	     foreach($leagues as $l) { 
 	      $html .= '<option data-min="'.$l->vars['time'].'" value="'.$l->vars['id'].'">'.$l->vars['league'].'</option>';
 	      } 
 	     $html .= '</select>';
 	     $html .= '&nbsp;&nbsp;&nbsp;';
 	     $html .= '<strong>  Min:</strong>'; 
 	     $html .= '<input class="minute" style="font-size: 22; width: 70px;" data-id="'.$leagues[0]->vars['id'].'" id="min_league" type="number" value="'.$leagues[0]->vars['time'].'"/>';
 	     $html .= '&nbsp;&nbsp;&nbsp;<input type="button" name="btn_report" id="btn_report"  value="SEARCH" style="font-size: 22;">';
		 $html .= '<div  id="games_data"></div>';
		 $data['html'] = $html;
 		 echo json_encode($data);
 		
         break;


        case 'data':
		
         $league = param('league');
         $min = param('min');
      // echo "http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_pending.php?league=$league&min=$min";
         $html = @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_pending.php?league=$league&min=$min"); 
         
		 $data['html'] = $html;
 		 echo json_encode($data);
 		
         break;  


 	
 	default:
 		# code...
 		break;
 }

// echo "http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_action.php?action=$action&data=$data&id=$id";




// echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_action.php?action=$action&data=$data&id=$id"); 	
?>
