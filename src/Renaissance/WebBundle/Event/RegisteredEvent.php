<?php
namespace Renaissance\WebBundle\Event;
use Symfony\Component\EventDispatcher\Event;

class RegisteredEvent extends Event{
	
	private $email;
	private $activate_code;

	public function __construct($email,$activate_code){
		$this->email = $email;
		$this->activate_code = $activate_code;

	}

	public function getEmail(){
		return $this->email;
	}

	public function getActivateCode(){
		return $this->activate_code;
	}
}
