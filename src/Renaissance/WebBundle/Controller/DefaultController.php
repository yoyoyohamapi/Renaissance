<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Renaissance\WebBundle\Controller\BaseController;

class DefaultController extends BaseController
{

    public function indexAction()
    {	
        $user = $this->getUser();
            return $this->render('RenaissanceWebBundle:Default:index.html.twig',array("content"=>"欢迎登录复兴教育"));
    }

    public function adminAction(){
    	$user = $this->getUser();
    	var_dump($user);
    }

    public function logoutAction(){
        if(!empty($this->getUser())){
    	$this->container->get('security.context')->setToken(NULL);
                return $this->redirect($this->container->getParameter('cas_logout_url'));
        }
        else
            return $this->redirect('/');
    }

    public function testAction(){
       $curlHelper = $this->get('curlHelper');
        $api = "courses/3/enrollments";
        $enrollment['user_id'] = 12;
        $enrollment['type'] = "StudentEnrollment";
        $post_field = array(
            "enrollment" => $enrollment,
        );
        $user_new = $curlHelper->curlCustom($api,$post_field,'POST');
    }
}
