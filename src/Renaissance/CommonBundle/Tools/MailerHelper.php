<?php
namespace Renaissance\CommonBundle\Tools;

class MailerHelper{
	// 邮件服务对象
	protected $mailer;
	// 邮件操作句柄
	protected $mail_message;
	public function __construct($mailer){
		$this->mailer = $mailer;
		$this->mail_message = \Swift_Message::newInstance();
	}

	public function send($subject,$sender=null,$recipient,$content,$attachments=null){
		//如果发送人为空，则默认设置发送人为原始邮箱
		if(empty($sender))
			$sender = $this->container->getParameter('mailer_user');
        $this->mail_message->setSubject($subject)
            ->setFrom($sender)
            ->setTo($recipient)
            ->setBody($content,'text/html');
		$this->mailer->send($this->mail_message);
	}


}