<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Renaissance\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

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
<<<<<<< HEAD
        $test_rest = $this->get('communicationREST');
        $test_rest->deleteCalEvent(8,"课程取消");
        //var_dump($reports);
        return new Response("name");
=======
>>>>>>> f8d1a7bf64a870cb71cd1f8107b9e9a2925f0817
    }

    public function mtAction(){
        return $this->render('RenaissanceWebBundle:Default:mt.html.twig',array());
    }
}
