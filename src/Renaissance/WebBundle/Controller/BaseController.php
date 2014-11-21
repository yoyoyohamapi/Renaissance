<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends Controller
{
	/**现在JSON信息回调需要封装三个参数：
	* data:回调数据
	* status:回调状态，标示数据状态正确与否，1为成功，0为败
	* message:回调消息，反映错误原因
	*/
	protected function createJsonResponse($data,$status,$message)
	{			
				$response = array(
					'data'=>$data,
					'status'=>$status,
					'message'=>$message
				);
	        	return new JsonResponse($response);
	}

	protected function getCanvasConn(){
	    	$pg_host = $this->container->getParameter('canvas_db_host');
		$pg_port = $this->container->getParameter('canvas_db_port');
		$pg_name = $this->container->getParameter('canvas_db_name');
		$pg_user = $this->container->getParameter('canvas_db_user');
		$pg_password = $this->container->getParameter('canvas_db_password');
		$connect_string = "host=$pg_host port=$pg_port dbname=$pg_name user=$pg_user password=$pg_password";
		$dbconn =pg_connect($connect_string);
		return $dbconn;
	}
}
