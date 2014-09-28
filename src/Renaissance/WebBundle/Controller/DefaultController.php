<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends BaseController
{

    public function indexAction()
    {	
    	$curl_helper = $this->get('CurlHelper');
    	$api = "users/1/profile";
    	$response = $curl_helper->curlGet($api);
    	var_dump($response);
            return $this->render('RenaissanceWebBundle:Default:index.html.twig');
    }

}
