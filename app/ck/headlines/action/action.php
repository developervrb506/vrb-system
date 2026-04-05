<?  include(ROOT_PATH . "/ck/process/security.php"); ?>
<?  include('../image_customize_class.php');
    include('../image_customize_class_mobile.php'); ?>

<?

$action = param('action');
$day = date('d');


 switch ($action) {


        case 'data':
    
         $league = param('l');
         $date = param('date',false);
         $games =  get_sbo_schedule($league,$date);
       //  echo "<pre>";
        // print_r($games);

        //echo "http://www.sportsbettingonline.ag/utilities/process/reports/headlines_vrb.php?league=$league&date=$date";
       // $html = @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/headlines_vrb.php?league=$league&date=$date"); 


        // if(!empty($games)){
           
         // $params = "'".$game['startdate']."','".$game['short_away']."','".$game['short_home']."'";  
          $html ='<BR><span style="font-size: 23px">GAMES: </span>';
        
          $html .= '<select id="games" name="games" style="font-size: 25px;" onchange="LoadPlayers();loadNames();">';
          $html .=  '<option value=0>Choose as Game</option>';
          $i=0;
          
         $html .= '<option  value="NFL_colts_eagles_Thursday,=June='.$day.'_08:06PM=EDT_2023-12-'.$day.'=19R05R00">  ** COLTS VS EAGLES ** TESTING </option>';
         $html .= '<option  value="NFL_nygiants_patriots_Thursday,=June='.$day.'_08:06PM=EDT_2023-12-'.$day.'=19R05R00">  ** GIANTS SOX VS PATRIOTS ** TESTING </option>';
         $html .= '<option  value="NFL_nygiants_dolphins_Thursday,=June='.$day.'_08:06PM=EDT_2023-12-'.$day.'=19R05R00">  ** GIANTS SOX VS DOLPHINGS ** TESTING </option>';
        
          foreach($games as $game){ 

          $gamedate = date('l,=F=d',strtotime($game["startdate"]));
          $gamehour = date('h:mA=T',strtotime($game["startdate"]));
          $eventdate = str_replace(" ","=",date('Y-m-d H:i:s',strtotime($game["startdate"])));
          $eventdate = str_replace(":","R",$eventdate);

          $html .= '<option value="'.$league.'_'.$game["short_away"].'_'.$game["short_home"].'_'.$gamedate.'_'.$gamehour.'_'.$eventdate.'">'.$game["away"].' VS '.$game["home"].'</option>';
          }
          $html .= '</select>';
          $html .='<BR><BR><span style="font-size: 23px"> DISPLAY NAMES: </span>';
          $html .= '<input id="away_name" style="width=200" value="AWAY NAME">&nbsp;&nbsp; VS &nbsp;&nbsp;<input id="home_name" style="width=200" value="HOME NAME">';
          $html .= '<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 23px"><input id="noplayers" style="font-size: 25px;" type="checkbox" checked="checked" onchange="NoPlayers();">&nbsp; Players</span><BR><BR>';

        /* }  else { 

         $html = '<BR><BR><h1> There are no games to show</h1>';

        }*/

        $html .= '<div id="div_players"></div>';
    
         
        $data['html'] = $html;
        echo json_encode($data);
    
         break;  

         case 'players':
             
             $params = explode("_",param('params',false));
             $league = $params[0];
             $away  = $params[1];
             $home  = $params[2];
             $day  =  str_replace("="," ", $params[3]);
             $hour  =  str_replace("="," ", $params[4]);
              if($away == 'CWS'){$away = 'chw';}
              if($home == 'CWS'){$home = 'chw';}
              //print_r($params);
             //Players
              $away_players = get_player_headline_image(strtolower($league),strtolower($away));
              $home_players =  get_player_headline_image(strtolower($league),strtolower($home));

              if(!empty( $away_players) && !empty( $home_players)) {

                 $html ='<BR><span style="font-size: 18px">'.strtoupper($away).':  </span>';
                 $html .= '<select id="player_away" name="player_away" style="font-size: 18px;" >';
                 $i=0;
          
                foreach($away_players as $player){ 
                $html .= '<option value="'.$player['espn_id'].'_'.$player['type'].'">'.$player['name'].'</option>';
                }
                $html .= '</select>';

                 $html .= '&nbsp&nbsp&nbsp;<span style="font-size: 18px">'.strtoupper($home).':  </span>';
                 $html .= '<select id="player_home" name="player_home" style="font-size: 18px;" >';
                 $i=0;
          
                foreach($home_players as $player){ 
                $html .= '<option value="'.$player['espn_id'].'_'.$player['type'].'">'.$player['name'].'</option>';
               // $html .= '<option value="'.$player['espn_id'].'">'.$player['name'].'</option>';
                }
                $html .= '</select>';

               
                $html .= '&nbsp&nbsp&nbsp;<span style="font-size: 18px"> TV: </span>';
                $html .= '<select id="tv" name="tv" style="font-size: 18px;" >';
                $html .= '<option value="NBC">NBC</option>';
                $html .= '<option value="NFLNETWORK">NFL-NETWORK</option>';
                $html .= '<option value="APPLE">APPLE</option>';
                $html .= '<option value="espn">ESPN</option>';
                $html .= '<option value="FS1">FS1</option>';
                $html .= '<option value="FOX">FOX</option>';
                $html .= '<option value="MLBNETWORK">MLB NETWORK</option>';
                $html .= '</select><BR><BR>';

                $html .= '<input   readonly="true"  name="away" id="away" type="hidden" value="'.strtoupper($away).'" >';
                $html .=  '<input  readonly="true"  name="home" id="home" type="hidden" value="'.strtoupper($home).'" >'; 
                $html .=  'Day: <input id="game_date" name="date" type="text" value="'.$day.'" > ';
                $html .=  'Hour: <input id="hour" type="text" value="'.$hour.'" >';
                $html .= '&nbsp&nbsp&nbsp;<input onclick="generateImage();" style="font-size: 25px" type="button" value="GENERATE"/>';
                $html .= '<BR><BR><div id="div_image" class="div_img" >';
                $html .= '</div><BR><BR>';
                 $html .= '<BR><BR><div id="div_image_mobile" class="div_img" >';
                $html .= '</div><BR><BR>';
               

              } else {
                 if(empty( $away_players) && empty( $home_players)) {
                      $html = '<BR><BR><h2>THERE ARE NOT PLAYER IMAGES FOR TEAMS: '.strtoupper($away).' AND '.strtoupper($home).'</h2>';
                 } else{
                      if(empty( $away_players)){
                        $html = '<BR><BR><h2>THERE ARE NOT PLAYER IMAGES FOR '.strtoupper($away).'</h2>';
                      } else {
                        $html = '<BR><BR><h2>THERE ARE NOT PLAYER IMAGES FOR '.strtoupper($home).'</h2>';
                      }

              }
             }
             
             $data['html'] = $html;
             echo json_encode($data); 

         break;


          case 'noplayers':
            
             $params = explode("_",param('params',false));
             $league = $params[0];
             $away  = $params[1];
             $home  = $params[2];
             $day  =  str_replace("="," ", $params[3]);
             $hour  =  str_replace("="," ", $params[4]);
              if($away == 'CWS'){$away = 'chw';}
              if($home == 'CWS'){$home = 'chw';}
              //print_r($params);
             
                $html .= '&nbsp&nbsp&nbsp;<span style="font-size: 18px"> TV: </span>';
                $html .= '<select id="tv" name="tv" style="font-size: 18px;" >';
                $html .= '<option value="APPLE">APPLE</option>';
                $html .= '<option value="espn">ESPN</option>';
                $html .= '<option value="FS1">FS1</option>';
                $html .= '<option value="FOX">FOX</option>';
                $html .= '<option value="MLBNETWORK">MLB NETWORK</option>';
                $html .= '<option value="NBC">NBC</option>';
                $html .= '<option value="NFLNETWORK">NFL-NETWORK</option>';
                
                $html .= '</select><BR><BR>';

                $html .= '<input   readonly="true"  name="away" id="away" type="hidden" value="'.strtoupper($away).'" >';
                $html .=  '<input  readonly="true"  name="home" id="home" type="hidden" value="'.strtoupper($home).'" >'; 
                $html .=  'Day: <input id="game_date" name="date" type="text" value="'.$day.'" > ';
                $html .=  'Hour: <input id="hour" type="text" value="'.$hour.'" ><BR><BR>';
                $html .= '&nbsp&nbsp&nbsp;<input onclick="generateImageNoPlayers();" style="font-size: 25px" type="button" value="GENERATE"/>';
                $html .= '<BR><BR><div id="div_image" class="div_img" >';
                $html .= '</div><BR><BR>';
                 $html .= '<BR><BR><div id="div_image_mobile" class="div_img" >';
                $html .= '</div><BR><BR>';
               

             
             $data['html'] = $html;
             echo json_encode($data); 

         break;

         case 'generate':

              $data['hour'] = str_replace("$", ' ', param('hour',false));
              $data['date'] =  str_replace("$", ' ', param('day',false));
              $data['league'] =  param('l');
              $data['away'] =  param('a');
              $data['home'] =  param('h');
              $data['player_away'] =  param('ap',false);
              $data['player_home'] =  param('hp',false);
              $data['tv'] =  param('tv');

              
              $image = new _image_customize();
              $image->image_base($data);  
              $image->image_destroy(); // Eliminamos de Memoria las imagenes GD creadas


             // header('Content-Type:image/png ');
              
         break;

          case 'generateNoPlayer':

              $data['hour'] = str_replace("$", ' ', param('hour',false));
              $data['date'] =  str_replace("$", ' ', param('day',false));
              $data['league'] =  param('l');
              $data['away'] =  param('a');
              $data['home'] =  param('h');
              $data['tv'] =  param('tv');
              $data['away_name'] = str_replace("$", ' ', param('an',false));
              $data['home_name'] =  str_replace("$", ' ', param('hn',false));
              

              print_r($data);
              $image = new _image_customize_no_player();
              $image->image_base($data);  
             // $image->image_destroy(); // Eliminamos de Memoria las imagenes GD creadas

             // header('Content-Type:image/png ');
              
         break;

        case 'generateMobile':

              $data['hour'] = str_replace("$", ' ', param('hour',false));
              $data['date'] =  str_replace("$", ' ', param('day',false));
              $data['league'] =  param('l');
              $data['away'] =  param('a');
              $data['home'] =  param('h');
              $data['away_name'] = str_replace("$", ' ', param('an',false));
              $data['home_name'] =  str_replace("$", ' ', param('hn',false));
              $data['player_away'] =  param('ap',false);
              $data['player_home'] =  param('hp',false);
              $data['tv'] =  param('tv');

              
              $image = new _image_customize_mobile();
              $image->image_base($data);  
              $image->image_destroy(); // Eliminamos de Memoria las imagenes GD creadas
              
         break;

         case 'upload':
               
              
              // $brands = array('sbo','owi','pph');
               $brands = array('sbo');

              $params = explode("_",param('params',false));
              $eventdate  =  str_replace("="," ", $params[5]);
              $eventdate  =  str_replace("R",":", $eventdate);
             
             
             
              $start_time =  $eventdate;
              $end_time =  $eventdate;

               foreach ($brands as $brand) {
                  $name = $brand.'_'.rand_str();
                  $image = $brand.'_'.rand_str();
                  $type  = 'he';
                  $url = "javascript:;";
                  $alt_text = "";

                  $headline = new _main_brands_sports();
                  $headline->vars["image"] = $image;
                  $headline->vars["brand"] = $brand;
                  $headline->vars["type"]  = $type;
                  $headline->vars["url"]   = $url;
                  $headline->vars["alt_text"]   = $alt_text;
                  $headline->vars["start_time"] = $start_time;  
                  $headline->vars["end_time"] = $end_time;
                  $headline->vars["priority"] = 1;
                  $headline->insert();

                   sleep(3);
                   $file_path = "C:\\websites\\www.vrbmarketing.com\\ck\\headlines\\images\sbo\\";
                    ftp_transfer_headlines_files($file_path,$brand.".jpg",$image.".jpg",$brand);
              }
           
              $data['html'] = 1;
              echo json_encode($data);
             

             

         break;


  default:
    # code...
    break;
 }

// echo "http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_action.php?action=$action&data=$data&id=$id";




// echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_action.php?action=$action&data=$data&id=$id");   
?>
