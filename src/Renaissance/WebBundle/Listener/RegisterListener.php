<?php
namespace Renaissance\WebBundle\Listener;
use Renaissance\WebBundle\Listener\BaseListener as BaseListener;
use Symfony\Component\EventDispatcher\Event;

class RegisterListener extends BaseListener{

	private $mailerHelper;

	public function setMailerHelper($mailerHelper){
		$this->mailerHelper = $mailerHelper;
	}
	//监听注册完成后
	public function afterRegisteredAction(Event $event){
		$email = $event->getEmail();
		$activate_code = $event->getActivateCode();
        $url=$_SERVER['HTTP_HOST'];
        $url = 'http://'.$url.'/register/activate?email='.$email.'&activate_code='.$activate_code;
        $subject = '最后一步！完成您的您的邮箱验证';
        $sender = 'fuxingedu@gmail.com';
        $recipient = 'lcx.seima@gmail.com';
        $content = $this->container->get('templating')->render('RenaissanceWebBundle:Mail:regValidation.html.twig',array('validation_url'=>$url));
        $this->mailerHelper->send($subject,$sender,$recipient,$content);
	}
}
