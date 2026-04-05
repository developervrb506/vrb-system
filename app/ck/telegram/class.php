<?php 

class _GradingBot{
	private $btoken;private $website;
	private $data;private $update;
	private $nombre;private $apellido;
	private $chatID;private $chatType;
	private $message;

	function __construct($data){
		$this->btoken="6245470304:AAGDQlxmgVo6VF3W_BAW-ZjwiOTIZ3vyNCU";
		$this->website="https://api.telegram.org/bot".$this->btoken;
	}


//////////////////////////////////////////////////
//
//////////////////////////////////////////////////


public function explodeMensaje($msg){
	$dato=explode(" ", $msg);
	return $dato;
}


	public function checkUser($entrada){
		$mensaje=$this->fileGetContents($entrada);
		$dato=$this->explodeMensaje($mensaje["message"]);
		
		$correo=$dato[1];
		$comando=strtolower($dato[0]);

		return array("correo"=>$correo,"identificador"=>$mensaje["chatID"]);

		
	}

//////////////////////////////////////////////////
//
//////////////////////////////////////////////////

	public function envioMensaje($response,$fgc){
		$resultado=$this->fileGetContents($fgc);
		$params=['chat_id'=>$resultado["chatID"],'text'=>$response,];
		$ch = curl_init($this->website . '/sendMessage');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		return $result = curl_exec($ch);
		curl_close($ch);
	}
	
	
	public function envioMensajeProcesos($chatid,$response){

		$params=['chat_id'=>$chatid,'text'=>$response,];
		$ch = curl_init($this->website . '/sendMessage');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		return $result = curl_exec($ch);
		curl_close($ch);
	}

	
//////////////////////////////////////////////////
//
//////////////////////////////////////////////////

	public function fileGetContents($fgc){
		$var=file_get_contents($fgc);
		$var=json_decode($var, TRUE);

		$nombre=$var['message']['chat']['first_name'];
		$apellidos=$var['message']['chat']['last_name'];
		$chatID=$var['message']['chat']['id'];
		$chatType=$var['message']['chat']['type'];
		$message=$var['message']['text'];
		return array("chatID"=>$chatID,"chatType"=>$chatType,"message"=>$message);
	}
}



 ?>