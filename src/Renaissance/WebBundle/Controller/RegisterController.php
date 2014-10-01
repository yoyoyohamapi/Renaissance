<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Renaissance\WebBundle\Controller\BaseController;
use Renaissance\CommonBundle\Entity\User;



class RegisterController extends BaseController
{
	public function indexAction(){
		return $this->render('RenaissanceWebBundle:Register:index.html.twig',array());
	}

	public function validateAction(Request $request){
		$email = $request->query->get('email');
		$user = $this->getDoctrine()->getRepository('RenaissanceCommonBundle:User')->findOneByEmail($email);
		if(empty($user))
			 return $this->createJsonResponse(array("validate_info"=>"accept"));
		else
			return $this->createJsonResponse(array("validate_info"=>"refuse"));
	}

	public function regUserAction(Request $request){
		$username = $request->request->get('username');
		$email = $request->request->get('email');
		$password = $request->request->get('password');
		$curlHelper = $this->get('curlHelper');
		$api = "accounts/2/users";
		$pseudonym['unique_id'] = $email;
		$pseudonym['password'] = $password;
		$user['name'] = $username;
		$post_field = array(
			"pseudonym" => $pseudonym,
			"user" => $user
		);
		
		$user_new = $curlHelper->curlCustom($api,$post_field,'POST');
		print_r($user_new);
		echo $user_new->name;
		if(!empty($user_new->id)){
			$user = new User();
			$user->setUsername($user_new->name);
			$user->setEmail($user_new->login_id);
			$user->setCanvasUserId($user_new->id);
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			return $this->createJsonResponse(array("toLogin"=>"ok"));
		}else {
			return $this->render('RenaissanceWebBundle:Register:index.html.twig',array("error"=>"注册失败"));
		}
	}
    
}
