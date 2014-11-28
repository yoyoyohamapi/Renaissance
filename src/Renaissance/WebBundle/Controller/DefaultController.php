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
        // 邮箱帮助服务使用示例ail
        $url=$_SERVER['HTTP_HOST'];
        $url = 'http://'.$url.'/register_activate';
        $mailerHelper = $this->get('mailerHelper');
        $subject = '验证您的邮箱';
        $sender = 'fuxingedu@gmail.com';
        $recipient = '472285740@163.com';
        $content = $this->renderView('RenaissanceWebBundle:Mail:regValidation.html.twig',array('validation_url'=>$url));
        $mailerHelper->send($subject,$sender,$recipient,$content);
        return $this->render('RenaissanceWebBundle:Default:test.html.twig');
    }

    public function mtAction(){
        return $this->render('RenaissanceWebBundle:Default:mt.html.twig',array());
    }

    //学习路线展示
    public function learningpathShowAction($learningpath_id){
        return $this->render('RenaissanceWebBundle:Static:learningpath-'.$learningpath_id.'.html.twig',array("lp_id"=>$learningpath_id));
    }

}
