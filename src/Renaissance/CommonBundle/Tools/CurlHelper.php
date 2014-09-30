<?php 

namespace Renaissance\CommonBundle\Tools;

class CurlHelper {
	protected $access_token;
	protected $base_url;
	protected $authed;
	public function __construct( $access_token,$base_url,$authed){
		$this->access_token = $access_token;
		$this->base_url = $base_url;
		$this->authed = $authed;
		$this->curl_handler = curl_init();
		curl_setopt ( $this->curl_handler, CURLOPT_RETURNTRANSFER, 1 );
    		curl_setopt($this->curl_handler,CURLOPT_SSL_VERIFYPEER,$this->authed);
		curl_setopt($this->curl_handler,CURLOPT_SSL_VERIFYHOST,$this->authed);
		curl_setopt($this->curl_handler, CURLOPT_AUTOREFERER, true); //set referer on redirect
		curl_setopt($this->curl_handler, CURLOPT_CONNECTTIMEOUT, 120); //timeout on connect
		curl_setopt($this->curl_handler, CURLOPT_TIMEOUT, 30); //timeout on response
		curl_setopt($this->curl_handler, CURLOPT_MAXREDIRS, 10); //stop after 10 redirects
	}

	public function __destruct(){
		curl_close($this->curl_handler);
	}

	public function curlGet($api){
		$api = $this->base_url.$api."?access_token=" . $this->access_token;
		curl_setopt($this->curl_handler,CURLOPT_URL,$api);
		$response =curl_exec($this->curl_handler);
		if($response === false)
			return "Curl Error";
		return json_decode($response);
	}

	// $type = 'POST'|'PUT'|'DELETE'
	public function curlCustom($api,$post_field,$type){
		$api = $this->base_url.$api."?access_token=" . $this->access_token;
		$post_field = json_encode($post_field);
		curl_setopt($curl_handler,CURLOPT_URL,$api);
		curl_setopt ( $curl_handler, CURLOPT_CUSTOMREQUEST, $type);
    		curl_setopt($curl_handler, CURLOPT_HTTPHEADER, array(  
		            'Content-Type: application/json; charset=utf-8',  
		            'Content-Length: ' . strlen($post_field))  
		 );  
		$response =curl_exec($curl_handler);
		if($response === false)
			return "Curl Error";
		return json_decode($response);
	}
}