<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cep {
	
	public function __construct(){

    }
	
    public function busca_cep($cep){
		
		

		$cep = str_replace(".", "", $cep);	
		$cep = str_replace("-", "", $cep);	

		$url = 'http://api.postmon.com.br/v1/cep/'.$cep.'?format=xml';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($data);
				

		if($xml){
			$xmlCidadeArr = explode(":",$xml->cidade);
			$xmlBairroArr =  explode(":",$xml->bairro);
			$xmlLogradouroArr = explode(":",$xml->logradouro);
			$xmlEstadoArr = explode(":",$xml->estado);
			$obj['logradouro'] = $xmlLogradouroArr[0];
			$obj['bairro'] = $xmlBairroArr[0];
			$obj['cidade'] = $xmlCidadeArr[0];
			$obj['uf'] = $xmlEstadoArr[0];
		}else{
			$obj['logradouro'] = 'Cep não existe';
			$obj['bairro'] = '';
			$obj['cidade'] = '';
			$obj['uf'] = 0;
		}
		
				
			
		
				
		echo(json_encode($obj));
		
    }
}

/* End of file Someclass.php */