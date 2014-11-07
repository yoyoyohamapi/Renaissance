<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends Controller
{
	    protected function createJsonResponse($data)
	    {
	        return new JsonResponse($data);
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
