<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Renaissance\WebBundle\Controller\BaseController;
use Renaissance\CommonBundle\Entity\User;
use Renaissance\WebBundle\Listener\RegisterListener;
use Renaissance\WebBundle\Event\StoreEvents;
use Renaissance\WebBundle\Event\RegisteredEvent;

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
		//开始监听这里逻辑中的事件
		$mailerHelper = $this->get('mailerHelper');
		$listener = $this->get('registerListener');
		$listener->setMailerHelper($mailerHelper);
		$this->dispatcher->addListener(StoreEvents::REGISTER_COMPLETE,array($listener,'afterRegisteredAction'));
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
			$activate_code = $this->generateActivateCode($email);
			$user->setActivateCode($activate_code);
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			//调度事件，进行邮件发送
			$event = new RegisteredEvent($email,$activate_code);
			$this->dispatcher->dispatch(StoreEvents::REGISTER_COMPLETE,$event);
			$json_status = 1;
			$json_message = "";
		}else {
			return $this->render('RenaissanceWebBundle:Register:index.html.twig',array("error"=>"注册失败"));
		}
		return $this->createJsonResponse($json_data,$json_status,$json_message);
	}

	//用户激活
	public function activateAction(Request $request){
		$email = $request->query->get('email');
		$activate_code = $request->query->get('activate_code');
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('RenaissanceCommonBundle:User')->findOneByEmail($email);
		if( empty($user) )
       		return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"请求非法"));
        if( $user->getActivateCode() == $activate_code ){
			$user->setState(1);
			$em->flush();
			return $this->redirect('/');        	
        }
        else
       		return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"请求非法"));
	}

	//创建用户激活码
	public function generateActivateCode($email){
		$activate_code = $email;
		for($i=0;$i<13;$i++){
			$activate_code = sha1($activate_code);
		}
		return $activate_code;
	}
    
}
