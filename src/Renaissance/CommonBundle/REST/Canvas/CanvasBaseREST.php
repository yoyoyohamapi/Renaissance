<?php
namespace Renaissance\CommonBundle\REST\Canvas;
use Renaissance\CommonBundle\REST\BaseREST;

class CanvasBaseREST extends BaseREST{
	public function init(){
		//设定为canvas的api地址、口令、响应头
		$base_url = $this->container->getParameter('canvas_api_url');
		$access_token = $this->container->getParameter('canvas_api_token');
		$auth_head = $this->container->getParameter('canvas_api_auth_head');
		$this->curlHelper->init($base_url,$access_token,$auth_head);
	}
}
