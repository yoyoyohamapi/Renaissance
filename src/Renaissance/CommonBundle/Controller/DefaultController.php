<?php

namespace Renaissance\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	$curlHelper=$this->get('curlHelper');
    	$api="users/1/profile";
    	$courses=$curlHelper->curlGet($api);
    	$data=array('courses'=>$courses);
    	//var_dump($data);
    	return $this->render('RenaissanceCommonBundle:Default:index.html.twig', $data);
    }
}
