<?php

class _image_customize_no_player{
  
  



 var $headlines = array();


  var $imgMain;       // Variable que contiene imagen GD para la base con el texto
  var $resizedImage;       // Variable que contiene imagen GD para la base con el texto
  var $imgBackground;   // Variable que contiene imagen GD con el producto
  var $imgTeamAway;   // Variable que contiene imagen GD con el producto
  var $imgPlayerAway;   // Variable que contiene imagen GD con el producto
  var $imgTeamHome;   // Variable que contiene imagen GD con el producto
  var $imgLogo;       // Variable que contiene imagen GD con el logo
  var $imgVs;       // Variable que contiene imagen GD con el logo
  var $imgEspn;       // Variable que contiene imagen GD con el logo
  var $imgbetNow;       // Variable que contiene imagen GD con el logo
  var $imgResult;     // Variable que contiene imagen GD con un el producto y el texto
  var $imgFinal;      //  Variable que contiene imagen GD con un el producto , el texto y logo.
  var $fsize = 20;   // Tamaño de la letra SKU
  var $font_teams = "C://websites//www.vrbmarketing.com//ck//headlines//font//_novabold.ttf"; // Font usada para la letra de SKU
  var $font_time = "C://websites//www.vrbmarketing.com//ck//headlines//font//_BebasNeue.ttf"; // Font usada para la letra de SKU
  var $mainurl = BASE_URL . '/ck/headlines/';
  var $mainpath = "C://websites//www.vrbmarketing.com//ck//headlines//";

  var $control = false;

   function __construct(){
 /*
    $this->headlines[0]['max_base_heigth'] = 335;
    $this->headlines[0]['max_base_width'] = 1011;
    $this->headlines[0]['teamboard_heigth'] = 177;
    $this->headlines[0]['teamboard_width'] = 670;
    $this->headlines[0]['top_banner_heigth'] = 48;
    $this->headlines[0]['top_banner_width'] = 1030;
    $this->headlines[0]['join_button_heigth'] = 44;
    $this->headlines[0]['join_button_width'] = 135;
    $this->headlines[0]['join_position'] = 25;
    $this->headlines[0]['team_logo_heigth'] = 76;
    $this->headlines[0]['team_logo_width'] = 227;
    $this->headlines[0]['path'] = 'pph';

    sbo 1920x600:

teamboard  1280-335
register banner top 1920-91
join button 288-80
team logo 415-135
nfl network logo 288-55
nbc-tv logo 145-40



*/

    $this->headlines[1]['max_base_heigth'] = 600;
    $this->headlines[1]['max_base_width'] = 1920;
    $this->headlines[1]['teamboard_heigth'] = 335;
    $this->headlines[1]['teamboard_width'] = 1280;
    $this->headlines[1]['top_banner_heigth'] = 91;
    $this->headlines[1]['top_banner_width'] = 1920;
    $this->headlines[1]['join_button_heigth'] = 44;
    $this->headlines[1]['join_button_width'] = 135;
    $this->headlines[1]['join_position'] = 25;
    $this->headlines[1]['team_logo_heigth'] = 135;
    $this->headlines[1]['team_logo_width'] = 415;
    $this->headlines[1]['path'] = 'sbo';


/*
    $this->headlines[0]['max_base_heigth'] = 335;
    $this->headlines[0]['max_base_width'] = 1011;
    $this->headlines[0]['teamboard_heigth'] = 200;
    $this->headlines[0]['teamboard_width'] = 800;
    $this->headlines[0]['top_banner_heigth'] = 75;
    $this->headlines[0]['top_banner_width'] = 1030;
    $this->headlines[0]['join_button_heigth'] = 60;
    $this->headlines[0]['join_button_width'] = 150;
    $this->headlines[0]['top_banner_width'] = 1030;
    $this->headlines[0]['path'] = 'sbo';

    */

  /*
    $this->headlines[1]['max_base_heigth'] = 600;
    $this->headlines[1]['max_base_width'] = 1920;
    $this->headlines[1]['path'] = 'pph';

    $this->headlines[1]['max_base_heigth'] = 913;
    $this->headlines[1]['max_base_width'] = 800;
    $this->headlines[1]['path'] = 'pph';
  */

   }


  function image_base($data){

    
   foreach ($this->headlines as $hd) {

    $this->imgMain =    @imagecreatetruecolor($hd['max_base_width'],$hd['max_base_heigth']) // you want to create a truecolorimage here
    or die("Cannot Initialize new GD image stream");
     
     $bg_color = imagecolorallocate($this->imgMain,255,255,255); // Numeros son RBG del Fondo
     imagefill($this->imgMain, 0, 0, $bg_color);
     $base_path = trim($this->mainpath).'temp\base.png';
     $final_path = trim($this->mainpath)."final//";
     $base_path2 = trim($this->mainpath).'temp\base2.png';

     $this->control = false;  
     $img_away = $this->mainurl.'images/teams/'.$data['league'].'/NoPlayer/'.$data['away'].'.png';
     $img_home = $this->mainurl.'images/teams/'.$data['league'].'/NoPlayer/'.$data['home'].'.png';
     
     if (getimagesize($img_away) && getimagesize($img_home)) {
        $this->control = true;  
     } else {
       $this->control = false;  
     }


   if($this->control){ 


    // Load the second image you want to add
     $background = $this->mainurl.'images/backgrounds/'.$data['league'].'/NoPlayer/background.png';
     $this->resizedImage = imagecreatefrompng($background);

  // Get the dimensions of the original image
     $originalWidth = imagesx($this->imgMain);
     $originalHeight = imagesy($this->imgMain);

     // Get the dimensions of the second image
     $secondWidth = imagesx($this->resizedImage);
     $secondHeight = imagesy($this->resizedImage);

     
    // Calculate the position to center the second image on the original image
    $x = ($originalWidth - $secondWidth) / 2;
    $y = ($originalHeight - $secondHeight) / 2;

    // Add the second image to the original image (preserve the original size)
    imagecopy($this->imgMain, $this->resizedImage, $x, $y, 0, 0, $secondWidth, $secondHeight);

    // Free up memory
    //imagedestroy($this->imgMain);
    imagedestroy($this->resizedImage);
  
    
    // ADDING TOP BANNER 


    // Load the image you want to resize and add to the top
    $banner = $this->mainurl.'images/backgrounds/'.$data['league'].'/NoPlayer/top-banner.png';
    $this->resizedImage = imagecreatefrompng($banner);

    // Resize the image to 75 x 1011 pixels
    $newWidth = $hd['top_banner_width'];
    $newHeight = $hd['top_banner_heigth'];
    $this->resizedImage = imagescale($this->resizedImage, $newWidth, $newHeight);

    // Get the dimensions of the resized image
    $resizedWidth = imagesx($this->resizedImage);
    $resizedHeight = imagesy($this->resizedImage);

    // Calculate the position to add the resized image at the top of the original image
    $x = -10; // Start from the first corner
    $y = -5; // Start from the top

    // Add the resized image to the original image
    imagecopy($this->imgMain, $this->resizedImage, $x, $y, 0, 0, $resizedWidth, $resizedHeight);

    // Free up memory
     imagedestroy($this->resizedImage);


    // ADDING TABLE TEAMS

    // Load the third image you want to add starting from the center
    $table_teams = $this->mainurl.'images/backgrounds/'.$data['league'].'/NoPlayer/tableboard.png';
    $this->resizedImage = imagecreatefrompng($table_teams);

   
    // Resize the image 
    $newWidth = $hd['teamboard_width'];
    $newHeight = $hd['teamboard_heigth'];
    $this->resizedImage = imagescale($this->resizedImage, $newWidth, $newHeight);

    // Get the dimensions of the resized image
    $resizedWidth = imagesx($this->resizedImage);
    $resizedHeight = imagesy($this->resizedImage);

    // Calculate the position to add the resized image at the center of the original image
    $x = ($originalWidth - $resizedWidth) / 2;
    $y = ($originalHeight - $resizedHeight) / 2;

    // Add the resized image to the original image
    imagecopy($this->imgMain, $this->resizedImage, $x, $y, 0, 0, $resizedWidth, $resizedHeight);

    // Free up memory
     imagedestroy($this->resizedImage);



    // ADDING JOIN BUTTON


    // Load the original image
    //$this->imgMain = imagecreatefrompng($base_path2);

    // Load the image you want to resize and add to the center and 50 pixels from the bottom
    $join_button = $this->mainurl.'images/Logos/join.png';
    $this->resizedImage = imagecreatefrompng($join_button);

    
    $newWidth =$hd['join_button_width'];
    $newHeight = $hd['join_button_heigth'];
    $this->resizedImage = imagescale($this->resizedImage, $newWidth, $newHeight);

     // Get the dimensions of the resized image
    $resizedWidth = imagesx($this->resizedImage);
    $resizedHeight = imagesy($this->resizedImage);

    // Calculate the position to add the resized image at the center and 50 pixels from the bottom of the original image
    $x = ($originalWidth - $resizedWidth) / 2;
    $y = $originalHeight - $resizedHeight - $hd['join_position']; //  pixels from the bottom

    // Add the resized image to the original image
    imagecopy($this->imgMain, $this->resizedImage, $x, $y, 0, 0, $resizedWidth, $resizedHeight);

 
    // Free up memory
     imagedestroy($this->resizedImage);

    // ADD AWAY TEAM

    // Load the image you want to resize and add to coordinates (229, 114)
    $this->resizedImage = imagecreatefrompng($img_away);

    // Resize the image to 227x76 pixels
  
    $newWidth = $hd['team_away_width'];
    $newHeight = $hd['team_away_heigth'];
    $this->resizedImage = imagescale($this->resizedImage, $newWidth, $newHeight);

 
    // Get the dimensions of the resized image
    $resizedWidth = imagesx($this->resizedImage);
    $resizedHeight = imagesy($this->resizedImage);

    // Calculate the position to add the resized image at coordinates (229, 114) from the top-left corner of the original image
    $this->headlines[0]['team_away_heigth'] = 72;
    $this->headlines[0]['team_away_width'] = 227;
    $this->headlines[0]['team_away_pos_heigth'] = 229;
    $this->headlines[0]['team_away_pos_width'] = 110;


    $x = $hd["team_away_pos_heigth"]; //229;
    $y = $hd["team_away_pos_heigth"];//110;

    // Add the resized image to the original image
    imagecopy($this->imgMain, $this->resizedImage, $x, $y, 0, 0, $resizedWidth, $resizedHeight);

    // Free up memory
     imagedestroy($this->resizedImage);


     // ADD HOME TEAM

 
    // Load the image you want to resize and add to coordinates (229, 114)
    $this->resizedImage = imagecreatefrompng($img_home);

    $newWidth = 227;
    $newHeight = 72;
    $this->resizedImage = imagescale($this->resizedImage, $newWidth, $newHeight);

    // Get the dimensions of the resized image
    $resizedWidth = imagesx($this->resizedImage);
    $resizedHeight = imagesy($this->resizedImage);

    // Calculate the position to add the resized image at coordinates (229, 114) from the top-left corner of the original image
    $x = 575;
    $y = 110;

    // Add the resized image to the original image
    imagecopy($this->imgMain, $this->resizedImage, $x, $y, 0, 0, $resizedWidth, $resizedHeight);

    // Free up memory
    imagedestroy($this->resizedImage);


    // WRITE HOME TEAM NAME


    // Set the text color to white
    $textColor = imagecolorallocate($this->imgMain, 255, 255, 255);

    // Specify the font file path
    $fontFile = $this->font_teams; // Replace with the actual path to your font file
   
    

    // Font size
    $fontSize = 20;

    // Position to write the text
    $textX = 210;
    $textY = 210; //higth

    // Position to write the text
 
     $textX = ($originalWidth - $textWidth) / 2 + 100;
     $textY = 210; //higth

    // Write the text on the image
    imagettftext($this->imgMain, $fontSize, 0, $textX, $textY, $textColor, $fontFile, $data['home_name']);


     // Specify the font file path
    $fontFile = $this->font_time; // Replace with the actual path to your font file
   // echo $fontFile; exit;
    $text = $data['date']." ".$data['hour'];

    // Font size
    $fontSize = 20;

    // Position to write the text
    $textX = 287;
    $textY = 108; //higth

    // Write the text on the image
    imagettftext($this->imgMain, $fontSize, 0, $textX, $textY, $textColor, $fontFile, $text);

     ///**



    // Text to be written
    $text =  $data['away_name'];

    // Get the bounding box for the text
    $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
  

    $textWidth = $textBox[2] - $textBox[0]; // Text width
    $textHeight = $textBox[1] - $textBox[7]; // Text height

    $textX = ($originalWidth - $textWidth) / 2 - 200;
    $textY = 210;

    // Write the text on the image
    imagettftext($this->imgMain, $fontSize, 0, $textX, $textY, $textColor, $fontFile, $text);

   // ADD TV LOGO


  // Load the image you want to resize and add at position (602, 87)
  $tv = $this->mainurl.'images/Logos/'.$data['tv'].'.png';
  $this->resizedImage = imagecreatefrompng($tv);

  // Resize the image to 145 x 40 pixels
  $newWidth = 120;
  $newHeight = 23;
  $this->resizedImage = imagescale($this->resizedImage, $newWidth, $newHeight);

  // Get the dimensions of the resized image
  $resizedWidth = imagesx($this->resizedImage);
  $resizedHeight = imagesy($this->resizedImage);

  // Calculate the position to add the resized image at (602, 87) of the original image
  $x = 602;
  $y = 87;

  // Add the resized image to the original image
  imagecopy($this->imgMain, $this->resizedImage, $x, $y, 0, 0, $resizedWidth, $resizedHeight);

  
  // Save the final image on the server
  imagepng($this->imgMain, $final_path.$hd['path'].'.png');

  // Free up memory
  imagedestroy($this->imgMain);
  imagedestroy($this->resizedImage);


    


 } else {

     echo 'DOES NOT EXIST TEAM IMG';
   } 
   
   /*
      $background = $this->mainpath.'images/backgrounds/'.$data['league'].'/NoPlayer/background.png';
      $this->imgMain = imagecreatefrompng($background);
      $imgMainWidth  = $hd['max_base_width'];//imagesx($this->imgTeamAway);
      $imgMainAHeight = $hd['max_base_heigth']; // imagesy($this->imgTeamAway) ;
     // imagecopyresampled($this->imgMain, $this->imgTeamAway, $imgTeamAWidth, 0, 0, 0, $imgTeamAWidth, $imgTeamAHeight, $imgTeamAWidth, $imgTeamAHeight);
      imagecopyresampled($this->imgMain, $this->imgTeamAway, $imgMainWidth, 0, 0, 0, $imgMainWidth, 700, $imgMainWidth, $imgMainAHeight);
*/

    }
  }


/*
     
     $this->control = false;  
     $img_away = $this->mainpath.'images/teams/'.$data['league'].'/NoPlayer/'.$data['away'].'.png';
     $img_home = $this->mainpath.'images/teams/'.$data['league'].'/NoPlayer/'.$data['home'].'.png';
     
     if (getimagesize($img_away) && getimagesize($img_home)) {
        $this->control = true;  
     } else {
       $this->control = false;  
     }
   
     if($this->control){
   
      //PREPARE AWAY TEAM
      $this->imgTeamAway = imagecreatefrompng($img_away);
      $imgTeamAWidth  = imagesx($this->imgTeamAway);
      $imgTeamAHeight = imagesy($this->imgTeamAway) ;
     // imagecopyresampled($this->imgMain, $this->imgTeamAway, $imgTeamAWidth, 0, 0, 0, $imgTeamAWidth, $imgTeamAHeight, $imgTeamAWidth, $imgTeamAHeight);
      imagecopyresampled($this->imgMain, $this->imgTeamAway, $imgTeamAWidth, 0, 0, 0, $imgTeamAWidth, 700, $imgTeamAWidth, $imgTeamAHeight);



      //PREPARE HOME TEAM 
      $this->imgTeamHome = imagecreatefromjpeg($img_home);
      $imgTeamHWidth  = imagesx($this->imgTeamHome);
      $imgTeamHHeight = imagesy($this->imgTeamHome);
      $pos = $imgTeamAWidth + $imgTeamHWidth;
      //imagecopyresampled($this->imgMain, $this->imgTeamHome, $pos, 0, 0, 0, $imgTeamHWidth, $imgTeamHHeight, $imgTeamHWidth, $imgTeamHHeight);
      imagecopyresampled($this->imgMain, $this->imgTeamHome, $pos, 0, 0, 0, $imgTeamHWidth, 700, $imgTeamHWidth, $imgTeamHHeight);
      

       //PREPARE AWAY PLAYER
        $this->imgPlayerAway =  imagecreatefrompng($img_away_player);
        if($data['player_away_type'] != 'a'){
         imageflip($this->imgPlayerAway, IMG_FLIP_HORIZONTAL);
        }
        $imgPlayerAWidth  = imagesx($this->imgPlayerAway);
        $imgPlayerAHeight = imagesy($this->imgPlayerAway);
        $pos =  $imgTeamAWidth + ($imgTeamAWidth/2) - $imgPlayerAWidth/2;
        imagecopyresampled($this->imgMain, $this->imgPlayerAway, $pos, 60, 0, 0, $imgPlayerAWidth, $imgPlayerAHeight, $imgPlayerAWidth, $imgPlayerAHeight);
    




       //PREPARE HOME PLAYER
        $this->imgPlayerHome =  imagecreatefrompng($img_home_player);
        if($data['player_home_type'] != 'h'){
         imageflip($this->imgPlayerHome, IMG_FLIP_HORIZONTAL);
        }
        $imgPlayerHWidth  = imagesx($this->imgPlayerHome);
        $imgPlayerHHeight = imagesy($this->imgPlayerHome);
        //$pos =  $imgTeamHWidth *3 - $imgPlayerHWidth ;
         $pos =  $imgTeamAWidth * 2 + ($imgTeamHWidth/2) - $imgPlayerHWidth/2;
        imagecopyresampled($this->imgMain, $this->imgPlayerHome, $pos, 60, 0, 0, $imgPlayerHWidth, $imgPlayerHHeight, $imgPlayerHWidth, $imgPlayerHHeight);
    

      

       
      //PREPARE LOGO
       $img_logo = $this->mainpath.'images/Logos/bet_'.strtolower($data['league']).'.png';
       $this->imgLogo = imagecreatefrompng($img_logo); 
       $imgLogoWidth  = imagesx($this->imgLogo);
       $imgLogoHeight = imagesy($this->imgLogo);
       $realSpaceWidth = ($imgTeamAWidth - $imgLogoWidth) / 2 ;
       $realSpaceHeigth = ($imgTeamAHeight - $imgLogoHeight) / 3 ;
       imagecopyresampled($this->imgMain, $this->imgLogo, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgLogoWidth, $imgLogoHeight, $imgLogoWidth, $imgLogoHeight);
       

       // ADDING DATE TIME
       $realSpaceWidth = ($imgTeamAWidth   ) + (strlen($data['date']) /2 ) - strlen($data['date']) ; //strlen($data['date']) * 2; //($imgTeamAWidth ) - 50);
     
      // $realSpaceWidth= ((imagesx($imgTeamAWidth)/2)-(strlen($data['date'])));

       //Get the center of a the text
       $box = imagettfbbox(30, 0, $this->ffile, $data['date']);
       $txt_w = $box[4] - $box[0];
       $x = ($imgTeamAWidth - $txt_w) /2;
       
       $boxh = imagettfbbox(20, 0, $this->ffile, $data['hour']);
       $txt_wh = $boxh[4] - $boxh[0];
       $xh = ($imgTeamAWidth - $txt_wh) /2;
     
      // $x = $bbox[0] + (imagesx($imgTeamAWidth) / 2) - ($bbox[4] / 2) - 25;
       //$y = $bbox[1] + (imagesy($imgTeamAWidth) / 2) - ($bbox[5] / 2) - 5;

       $txt_color = imagecolorallocate($this->imgMain,255,255,255); // Numeros son RBG del color de texto
       //imagettftext($this->imgMain,30,0, $realSpaceWidth,($realSpaceHeigth+$imgLogoHeight+40),$txt_color,$this->ffile,$data['date']);
       imagettftext($this->imgMain,30,0, $x,($realSpaceHeigth+$imgLogoHeight+40),$txt_color,$this->ffile,$data['date']);
       $realSpaceWidth = $imgTeamAWidth / 2 ;
       imagettftext($this->imgMain,20,0, $xh ,($realSpaceHeigth+$imgLogoHeight+80),$txt_color,$this->ffile,$data['hour']);


       
       //PREPARE TV IMG
       $img_espn = $this->mainpath.'images/Logos/'.$data['tv'].'.png';
       $this->imgEspn= imagecreatefrompng($img_espn); 
       $imgEspnWidth  = imagesx($this->imgEspn);
       $imgEspnHeight = imagesy($this->imgEspn);
       $realSpaceWidth = (($imgTeamAWidth - $imgEspnWidth) / 2) ;
       $realSpaceHeigth = ($imgTeamAHeight - ($imgEspnHeight*2))  ;
       //imagecopyresampled($this->imgMain, $this->imgEspn, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgEspnWidth, $imgEspnHeight, $imgEspnWidth, $imgEspnHeight);
       imagecopyresampled($this->imgMain, $this->imgEspn, $realSpaceWidth,$realSpaceHeigth, 0, 0, $imgEspnWidth, $imgEspnHeight, $imgEspnWidth, $imgEspnHeight);

       //PREPARE VS IMG
       $img_vs = $this->mainpath.'images/Logos/vs_'.rand(1,3).'.png';
       $this->imgVs= imagecreatefrompng($img_vs); 
       $imgVsWidth  = imagesx($this->imgVs);
       $imgVsHeight = imagesy($this->imgVs);
       //$realSpaceWidth = ((($pos) - $imgVsWidth) / 2)+ $imgTeamAWidth;
      // $realSpaceWidth =   ($imgTeamAWidth * 1)- ( $imgVsWidth*2);
       $realSpaceWidth =   ($imgTeamAWidth *2) - ($imgVsWidth/2);
       $realSpaceHeigth = ($imgTeamAHeight - $imgVsHeight) / 2 ;
       imagecopyresampled($this->imgMain, $this->imgVs, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgVsWidth, $imgVsHeight, $imgVsWidth, $imgVsHeight);


         //PREPARE BETNOW IMG
       $img_bet = $this->mainpath.'images/Logos/bet-now.png';
       $this->imgBet= imagecreatefrompng($img_bet); 
       $imgBetWidth  = imagesx($this->imgBet);
       $imgBetHeight = imagesy($this->imgBet);
       //$realSpaceWidth = ((($pos) - $imgVsWidth) / 2)+ $imgTeamAWidth;
      // $realSpaceWidth =   ($imgTeamAWidth * 1)- ( $imgVsWidth*2);
       $realSpaceWidth =   ($imgTeamAWidth *2) - ($imgBetWidth/2);
       $realSpaceHeigth = ($imgTeamAHeight - $imgBetHeight) ;
       imagecopyresampled($this->imgMain, $this->imgBet, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgBetWidth, $imgBetHeight, $imgBetWidth, $imgBetHeight);


       
       

       //CREATE IMAGES   
       imagejpeg($this->imgMain, '../images/'.$hd['path'].'/sbo.jpg');
      // imagepng($this->imgMain, '../images/'.$hd['path'].'/base2.png');
     
     

     } else {
       echo 'DOES NOT EXIST TEAM IMG';
     }

   }
   //$this->imgMain = imagecreate($this->max_base_width,$this->max_base_heigth);
  // imagettftext($this->imgMain,$this->fsize, 0,($this->max_base_width-180),($this->max_base_heigth-50),$txt_color,$this->ffile,$text1);
   //imagestring($this->imgMain, 5, ($this->max_base_width-175),($this->max_base_heigth-45), $text2, $txt_color);
   //imagepng($this->imgMain, 'temp/base.png');

  */ 

//  }

/*
  function image_destroy(){

     @imagedestroy($this->imgResult);
     @imagedestroy($this->imgCheck);
     @imagedestroy($this->imgMain);
     @imagedestroy($this->imgProducto);
     @imagedestroy($this->imgResult);
     @imagedestroy($this->imgFinal);
     @imagedestroy($this->imgLogo);

  } 
*/
} 

 

?>