<?php
namespace Renaissance\CommonBundle\REST;

class BaseREST{
	protected $curlHelper;
	protected $api;
	protected $data_field;//待提交数据数组
	protected $container;

	public function __construct($curlHelper,$container){
		$this->curlHelper = $curlHelper;
		$this->container = $container;
	}

	protected function execute($type=null){
		$args_num = func_num_args();//获得参数个数
		if($args_num == 0)
			return $this->executeGet();
		else if($args_num == 1)
			return $this->executeCustom($type);
		else
			return null;
	}

	private function executeGet(){
		if( strlen($this->api)==0 )
			return null;
		else
			return $this->curlHelper->curlGet($this->api);
	}

	private function executeCustom($type){
		if( strlen($this->api)==0 || empty($this->data_field) )
			return null;
		else
			return $this->curlHelper->curlCustom($this->api,$this->data_field,$type);
	}
}
