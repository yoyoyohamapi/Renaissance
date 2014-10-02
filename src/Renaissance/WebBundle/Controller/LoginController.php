<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Renaissance\WebBundle\Controller\BaseController;
use Renaissance\CommonBundle\Entity\User;



class LoginController extends BaseController
{
	public function indexAction(){
		if(!empty($this->getUser()))
			return $this->redirect('/');
		else
			return $this->redirect($this->container->getParameter('cas_login_url'));
	}
    
}
