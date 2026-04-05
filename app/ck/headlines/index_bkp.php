<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('image_customize_class.php');

$tallas[1] = "32,33,55";
$tallas[2] = "18,20,22";
$tallas[3] = "S,M,L,XL";


$productos[1] = "https://rcfacturas.com/TEST/Mario/images/1.PNG";
$productos[2] = "https://rcfacturas.com/TEST/Mario/images/2.PNG";
$productos[3] = "https://rcfacturas.com/TEST/Mario/images/3.PNG";
$productos[4] = "https://rcfacturas.com/TEST/Mario/images/4.PNG";
$productos[5] = "https://rcfacturas.com/TEST/Mario/images/5.PNG";
$productos[6] = "https://rcfacturas.com/TEST/Mario/images/6.PNG";
$productos[7] = "https://rcfacturas.com/TEST/Mario/images/7.PNG";
$productos[8] = "https://rcfacturas.com/TEST/Mario/images/8.jpg";
$productos[9] = "https://rcfacturas.com/TEST/Mario/images/9.PNG";
$productos[10] = "https://rcfacturas.com/TEST/Mario/images/10.png";
$productos[11] = "https://rcfacturas.com/TEST/Mario/images/11.png";
$productos[12] = "https://rcfacturas.com/TEST/Mario/images/12.png";


$logos[1] = "https://rcfacturas.com/TEST/Mario/images/L1.png";
$logos[2] = "https://rcfacturas.com/TEST/Mario/images/L2.png";
$logos[3] = "https://rcfacturas.com/TEST/Mario/images/L3.jpg";
$logos[4] = "https://rcfacturas.com/TEST/Mario/images/L4.png";
$logos[5] = "https://rcfacturas.com/TEST/Mario/images/L5.jpg";


for ($i=0;$i<10;$i++){

  $k = array_rand($logos);
  $url_logo = $logos[$k];
  $k = array_rand($productos);
  $url_producto  =  $productos[$k];
  $k = array_rand($tallas);
  $talla  =  $tallas[$k];
  $sku = rand(10000,99999);
  $name = "file_".$sku;

  echo "#".$i.")<BR>";
  echo "Producto: ".$url_producto."<BR>";
  echo "Logo: ".$url_logo."<BR>";
  echo "SKU: ".$sku."<BR>";
  echo "TALLAS: ".$talla."<BR>";
  echo "Nombre: ".$name."<BR><BR><BR>";


  // Proceso de Bucle

     // Se llama la clase
      $check_ext_logo = false;
      $check_ext_prd = false;
      $image = new _image_customize();
 
    // En este primer Proceso se revisa la Extension de las imagenes
    // Se revisa el tamaño de las mismas, si son mas grandes de la base se procede a hacer un resize segun los parametros maximos de la clase
    // La salida de las imagenes van a ser PNG sin importar si el principal es JPG
  
     //Process for Logo
     $check_ext_logo = $image->check_ext($url_logo,1); //1 for Logo 2 For Product
  
     if($check_ext_logo){
      $check_size = $image->check_size($url_logo,1);    
     } else   { 
      echo " Error de Locacion o Extension de Archivo LOGO, Solamente JPG, JPEG y PNG son Válidas <BR>";
     }
  
     //Process for Product
     $check_ext_prd = $image->check_ext($url_producto,2); //1 for Logo 2 For Product
    if($check_ext_prd){
      
     $check_size = $image->check_size($url_producto,2);  
    } else   { 
      echo " Error de Locacion o Extension de Archivo PRODUCTO, Solamente JPG, JPEG y PNG son Válidas <BR>";
    }

    // Si paso el control de Revision de Extensiones y Resize de imagen creamos la base
    if($check_ext_logo && $check_ext_prd){
      $image->image_base($sku,$talla);
      $image->image_create($name);
    }

    $image->image_destroy(); // Eliminamos de Memoria las imagenes GD creadas

  
}
?>