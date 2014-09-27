<?php 

namespace Renaissance\CommonBundle\Tools;

class CurlHelper {
	protected $access_token;
	protected $base_url;

	public function __construct( $access_token,$base_url){
		$this->access_token = $access_token;
		$this->base_url = $base_url;
	}

	public function curlGet($api){
		$api = $this->base_url.$api."?access_token=" . $this->access_token;
		$curl_handler = curl_init();
		curl_setopt($curl_handler,CURLOPT_URL,$api);
		curl_setopt ( $curl_handler, CURLOPT_RETURNTRANSFER, 1 );
		$response =curl_exec($curl_handler);
		curl_close($curl_handler);
		return json_decode($response);
	}

	public function curlPost($api,$post_field){
		$api = $this->base_url.$api."?access_token=" . $this->access_token;
		$post_field = json_encode($post_field);
		$curl_handler = curl_init();
		curl_setopt($curl_handler,CURLOPT_URL,$api);
		curl_setopt($curl_handler,CURLOPT_POST,1);
    		curl_setopt($curl_handler, CURLOPT_POSTFIELDS,$post_field);
    		curl_setopt($curl_handler, CURLOPT_HTTPHEADER, array(  
		            'Content-Type: application/json; charset=utf-8',  
		            'Content-Length: ' . strlen($post_field))  
		 );  
		curl_setopt ( $curl_handler, CURLOPT_RETURNTRANSFER, 1 );
		$response =curl_exec($curl_handler);
		curl_close($curl_handler);
		return json_decode($response);
	}

	public function curlPut($api,$post_field){
		$api = $this->base_url.$api."?access_token=" . $this->access_token;
		$post_field = json_encode($post_field);
		$curl_handler = curl_init();
		curl_setopt($curl_handler,CURLOPT_URL,$api);
		curl_setopt ( $curl_handler, CURLOPT_CUSTOMREQUEST, 'PUT' );
    		curl_setopt($curl_handler, CURLOPT_POSTFIELDS,$post_field);
    		curl_setopt($curl_handler, CURLOPT_HTTPHEADER, array(  
		            'Content-Type: application/json; charset=utf-8',  
		            'Content-Length: ' . strlen($post_field))  
		 );  
		curl_setopt ( $curl_handler, CURLOPT_RETURNTRANSFER, 1 );
		$response =curl_exec($curl_handler);
		curl_close($curl_handler);
		return json_decode($response);
	}

	public function curlDelete($api,$post_field){
		$api = $this->base_url.$api."?access_token=" . $this->access_token;
		$post_field = json_encode($post_field);
		$curl_handler = curl_init();
		curl_setopt($curl_handler,CURLOPT_URL,$api);
		curl_setopt ( $curl_handler, CURLOPT_CUSTOMREQUEST, 'DELETE' );
    		curl_setopt($curl_handler, CURLOPT_POSTFIELDS,$post_field);
    		curl_setopt($curl_handler, CURLOPT_HTTPHEADER, array(  
		            'Content-Type: application/json; charset=utf-8',  
		            'Content-Length: ' . strlen($post_field))  
		 );  
		curl_setopt ( $curl_handler, CURLOPT_RETURNTRANSFER, 1 );
		$response =curl_exec($curl_handler);
		curl_close($curl_handler);
		return json_decode($response);
	}
}