<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Renaissance\WebBundle\Controller\BaseController;
use Renaissance\CommonBundle\REST\CourseREST;


class DefaultController extends BaseController
{


    public function indexAction()
    {	
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
        $test_rest = $this->get('fileREST');
        $user = $this->getUser();
        var_dump($test_rest->getFileByPath('course',4,'cover/S.PNG'));
        exit();
    }
}
