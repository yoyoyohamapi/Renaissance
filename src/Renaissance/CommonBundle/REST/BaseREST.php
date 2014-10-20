<?php
namespace Renaissance\CommonBundle\REST;

class BaseREST{
	protected $curlHelper;
	protected $api;
	
	public function __construct($curlHelper){
		$this->curlHelper = $curlHelper;
	}

	
}
