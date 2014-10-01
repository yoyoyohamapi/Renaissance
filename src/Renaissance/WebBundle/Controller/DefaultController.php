<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends BaseController
{

    public function indexAction()
    {	$user = $this->getUser();
            return $this->render('RenaissanceWebBundle:Default:index.html.twig',array("content"=>"欢迎登录复兴教育"));
    }

}
