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
              $dbconn = $this->getCanvasConn();
              $sql ="SELECT password_salt from pseudonyms where user_id=1";
              if($dbconn){//别忘记是否连接成功
                            $result = pg_query($dbconn,$sql);
                            if(!empty($result)){
                                $alt = pg_fetch_array($result,0);
                                return new Response($alt[0]);
                            }else{
                                return new Response("No Data");
                            }
              }else{
                      return new Response("error");
             }
    }

    public function mtAction(){
        return $this->render('RenaissanceWebBundle:Default:mt.html.twig',array());
    }
}
