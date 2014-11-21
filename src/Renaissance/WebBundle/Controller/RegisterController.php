<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Renaissance\WebBundle\Controller\BaseController;
use Renaissance\CommonBundle\Entity\User;



class RegisterController extends BaseController
{
	public function indexAction(){
		if(!empty($this->getUser())){
			var_dump($this->getUser());
			return $this->redirect('/');

		}
		else
			return $this->render('RenaissanceWebBundle:Register:index.html.twig',array());
	}

	public function validateAction(Request $request){
		$email = $request->request->get('email');
		$user = $this->getDoctrine()->getRepository('RenaissanceCommonBundle:User')->findOneByEmail($email);
		$json_data = null;
		$json_status = 0;
		$json_message = "Sorry,something that refused to join us";
		if(empty($user)){
			$json_status = 1;
			$json_message = "";
		}
		else
			$status = 0;
		return $this->createJsonResponse($json_data,$json_status,$json_message);
	}

	public function regUserAction(Request $request){
		$username = $request->request->get('username');
		$email = $request->request->get('email');
		$password = $request->request->get('password');
		$userREST = $this->get('userREST');																																																				
		$pseudonym['unique_id'] = $email;
		$pseudonym['password'] = $password;
		$user['name'] = $username;
		$user_data = array(
			"pseudonym" => $pseudonym,
			"user" => $user
		);
		$user_new = $userREST->addUser($user_data);
		$json_data = null;
		$json_status = 0;
		$json_message = "Sorry,something that refused to join us";
		if(!empty($user_new->id)){
			$user = new User();
			$user->setUsername($user_new->name);
			$user->setEmail($user_new->login_id);
			$user->setCanvasUserId($user_new->id);
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			$json_status = 1;
			$json_message = "";
		}else {
			return $this->render('RenaissanceWebBundle:Register:index.html.twig',array("error"=>"注册失败"));
		}
		return $this->createJsonResponse($json_data,$json_status,$json_message);
	}
    
}
