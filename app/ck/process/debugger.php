<?
class debugger{
	function test($var = "test"){
		if(isset($_GET["$var"])){$is = true;}
		else{$is = false;}
		return $is;
	}
	function print_test($txt = "xax",$var = "test"){
		if(isset($_GET["$var"])){echo $txt;}
	}
}
?>