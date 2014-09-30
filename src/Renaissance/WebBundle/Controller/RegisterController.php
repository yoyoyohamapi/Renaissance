<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegisterController extends Controller
{
	public function indexAction(){
		return $this->render('RenaissanceWebBundle:Register:index.html.twig',array());
	}

	public function validateAction(){

	}
    
}
