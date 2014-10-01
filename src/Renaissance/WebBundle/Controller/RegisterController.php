<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Renaissance\CommonBundle\Entity\User;

class RegisterController extends Controller
{
	public function indexAction(){
		return $this->render('RenaissanceWebBundle:Register:index.html.twig',array());
	}

	public function validateAction(Request $request){
		$email = $request->request->get('email');
		$user = $this->getDoctrine()->getRepository('RenaissanceCommonBundle:User')->findOneByEmail($email);
		if(empty($user))
			return json_encode("accept");
		else
			return json_encode("refuse");
	}

	public function regUserAction(Request $request){
		$email = $request->request->get('email');
		$password = $request->request->get('password');
		$curlHelper = $this->get('curlHelper');
		$api = "accounts/1/users";
		$pseudonym['unique_id'] = $email;
		$pseudonym['password'] = $password;
		$user['name'] = "暂未设定姓名";
		$post_field = array(
			"pseudonym" => $pseudonym,
			"user" => $user
		);
		
		$user = $curlHelper->curlCustom($api,$post_field,'POST');
		var_dump($user);
	}
    
}
