<? include(ROOT_PATH . "/ck/db/handler.php"); 
   
	ini_set('memory_limit', '-1');





echo getRealIP();

//puedes saber de donde viene con:
if (isset ($_SERVER["HTTP_X_FORWARDED_FOR"]) )
$for = $_SERVER["HTTP_X_FORWARDED_FOR"];
//la ip que reporta el cliente
if (isset ($_SERVER["HTTP_CLIENT_IP"]) ) 
$realip = "http client ip: " .$_SERVER["HTTP_CLIENT_IP"].",";
//La ip que el server detecta
if (isset ($_SERVER["REMOTE_ADDR"]) )
$realip1 .= "remote addr: " .$_SERVER["REMOTE_ADDR"].",";
//te da quien refirio al visitante
if (isset ($_SERVER["HTTP_REFERER"]) ) 
$realip .= "referer: " .$_SERVER['HTTP_REFERER'].",";


echo $for."  -- ".$realip;


function getRealIP()
{
 
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip = 
         ( !empty($_SERVER['REMOTE_ADDR']) ) ? 
            $_SERVER['REMOTE_ADDR'] 
            : 
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ? 
               $_ENV['REMOTE_ADDR'] 
               : 
               "unknown" );
 
      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar 
      // una dirección ip que no sea del rango privado. En caso de no 
      // encontrarse ninguna se toma como valor el REMOTE_ADDR
 
      $entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);
 
      reset($entries);
      //while (list(, $entry) = each($entries))
	  foreach($entries as $entry)
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./', 
                  '/^127\.0\.0\.1/', 
                  '/^192\.168\..*/', 
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', 
                  '/^10\..*/');
 
            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
 
            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip = 
         ( !empty($_SERVER['REMOTE_ADDR']) ) ? 
            $_SERVER['REMOTE_ADDR'] 
            : 
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ? 
               $_ENV['REMOTE_ADDR'] 
               : 
               "unknown" );
   }
 
   return $client_ip;
 
}


function obtenerIP() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif (isset($_SERVER['HTTP_VIA'])) {
       $ip = $_SERVER['HTTP_VIA'];
    }
    elseif (isset($_SERVER['REMOTE_ADDR'])) {
       $ip = $_SERVER['REMOTE_ADDR'];
    }
    else {
       $ip = "0.0.0.0";
    }
    return $ip;
}

//De esta forma llamamos a la funcion y obtenemos la IP

$ip=obtenerIP();

echo $ip;



	
?>
<script type="application/javascript">
function getip(data){
  document.write('Tu ip es ' + data.ip);
}
</script>
<script src="http://jsonip.appspot.com/?callback=getip" type="application/javascript">
</script>

<script language="JavaScript">
ip = new java.net.InetAddress.getLocalHost();
ipStr = new java.lang.String(ip);
dirip = ipStr.substring(ipStr.indexOf("/")+1);
document.write = dirip;
</script>



<script language="JavaScript">
/*
cordova.define("cordova/plugin/ipaddress", 
  function(require, exports, module) {
    var exec = require("cordova/exec");
    var IPAddress = function () {};
 
    var IPAddressError = function(code, message) {
        this.code = code || null;
        this.message = message || '';
    };
 
    IPAddressError.NO_IP_ADDRESS = 0;
 
    IPAddress.prototype.get = function(success,fail) {
        exec(success,fail,"ipAddress",
            "get",[]);
    };
 
    var ipAddress = new IPAddress();
    module.exports = ipAddress;
});*/

function myIPa(){ var vi="uses java to get the users local ip number"
    var yip2=java.net.InetAddress.getLocalHost();	
    var yip=yip2.getHostAddress();
  return yip;
}//end myIP

alert("your machine's local network IP is "+ myIPa());

</script>

<script type="application/javascript">
    function getip(json){
      alert(json.ip); // alerts the ip address
    }
</script>

<script type="application/javascript" src="http://jsonip.appspot.com/?callback=getip"></script>


<script language="javascript" src="http://j.maxmind.com/app/geoip.js"></script>
<script language="javascript">
mmjsCountryCode = geoip_country_code();
mmjsCountryName = geoip_country_name();

</script>